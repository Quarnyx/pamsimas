<?php
require_once('../modules/config.php');
header('Content-Type: application/json');
switch ($_GET['aksi'] ?? '') {
    case 'cari-pelanggan':
        $query = $_GET['q'] ?? '';

        if (strlen($query) < 2) {
            echo json_encode([]);
            exit;
        }

        try {
            // Query dengan prepared statement mysqli
            $sql = "SELECT 
                    p.id,
                    p.kode_pelanggan,
                    p.nama_pelanggan,
                    CONCAT(p.alamat, ' RT/RW ', w.rt, '/', w.rw) as alamat,
                    k.nama_kategori,
                    COALESCE(
                        (SELECT meter_akhir 
                         FROM pencatatan_meter 
                         WHERE pelanggan_id = p.id 
                         ORDER BY periode_tahun DESC, periode_bulan DESC 
                         LIMIT 1), 0
                    ) as meter_terakhir
                FROM pelanggan p
                LEFT JOIN wilayah w ON p.wilayah_id = w.id
                LEFT JOIN kategori_pelanggan k ON p.kategori_id = k.id
                WHERE p.status = 'aktif' 
                AND (p.kode_pelanggan LIKE ? OR p.nama_pelanggan LIKE ?)
                ORDER BY p.nama_pelanggan
                LIMIT 10";

            // Prepare statement
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            // Bind parameters
            $searchTerm = "%$query%";
            $stmt->bind_param("ss", $searchTerm, $searchTerm);

            // Execute
            $stmt->execute();

            // Get result
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $stmt->close();

            echo json_encode($data);

        } catch (Exception $e) {
            error_log("Error in search pelanggan: " . $e->getMessage());
            echo json_encode([]);
        }
        break;
    case 'simpan-perakaman-meter':
        try {
            $pelanggan_id = $_POST['pelanggan_id'] ?? null;
            $periode_bulan = $_POST['periode_bulan'] ?? null;
            $periode_tahun = $_POST['periode_tahun'] ?? null;
            $tanggal_catat = $_POST['tanggal_catat'] ?? null;
            $meter_awal = $_POST['meter_awal'] ?? 0;
            $meter_akhir = $_POST['meter_akhir'] ?? 0;
            $petugas_id = $_POST['petugas_id'] ?? $_SESSION['user_id'];
            $keterangan = $_POST['keterangan'] ?? '';

            // Validasi
            if (!$pelanggan_id || !$periode_bulan || !$periode_tahun || !$tanggal_catat) {
                throw new Exception('Data tidak lengkap');
            }

            if ($meter_akhir < $meter_awal) {
                throw new Exception('Meter akhir tidak boleh lebih kecil dari meter awal');
            }

            // Mulai Transaction
            $conn->begin_transaction();

            try {
                // Cek duplikat periode
                $sqlCheck = "SELECT id FROM pencatatan_meter 
                         WHERE pelanggan_id = ? AND periode_tahun = ? AND periode_bulan = ?";
                $stmtCheck = $conn->prepare($sqlCheck);
                $stmtCheck->bind_param("iii", $pelanggan_id, $periode_tahun, $periode_bulan);
                $stmtCheck->execute();
                $resultCheck = $stmtCheck->get_result();

                if ($resultCheck->num_rows > 0) {
                    throw new Exception('Data untuk periode ini sudah ada');
                }
                $stmtCheck->close();

                // Upload foto jika ada
                $foto_path = null;
                if (isset($_FILES['foto_meter']) && $_FILES['foto_meter']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = '../uploads/meter/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }

                    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
                    $file_type = $_FILES['foto_meter']['type'];

                    if (!in_array($file_type, $allowed_types)) {
                        throw new Exception('Format file harus JPG, JPEG, atau PNG');
                    }

                    if ($_FILES['foto_meter']['size'] > 5 * 1024 * 1024) {
                        throw new Exception('Ukuran file maksimal 5MB');
                    }

                    $file_ext = pathinfo($_FILES['foto_meter']['name'], PATHINFO_EXTENSION);
                    $file_name = 'meter_' . $pelanggan_id . '_' . time() . '.' . $file_ext;
                    $foto_path_full = $upload_dir . $file_name;

                    if (move_uploaded_file($_FILES['foto_meter']['tmp_name'], $foto_path_full)) {
                        $foto_path = 'uploads/meter/' . $file_name;
                    }
                }

                // 1. INSERT PENCATATAN METER
                $sqlInsert = "INSERT INTO pencatatan_meter 
                          (pelanggan_id, periode_tahun, periode_bulan, tanggal_catat, 
                           meter_awal, meter_akhir, petugas_id, foto_meter, keterangan, status)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'billed')";

                $stmtInsert = $conn->prepare($sqlInsert);
                if (!$stmtInsert) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }

                $stmtInsert->bind_param(
                    "iiisiiiss",
                    $pelanggan_id,
                    $periode_tahun,
                    $periode_bulan,
                    $tanggal_catat,
                    $meter_awal,
                    $meter_akhir,
                    $petugas_id,
                    $foto_path,
                    $keterangan
                );

                if (!$stmtInsert->execute()) {
                    throw new Exception("Execute failed: " . $stmtInsert->error);
                }

                $pencatatan_meter_id = $conn->insert_id;
                $stmtInsert->close();

                // 2. GET DATA PELANGGAN
                $sqlPelanggan = "SELECT p.*, k.beban_tetap 
                             FROM pelanggan p 
                             JOIN kategori_pelanggan k ON p.kategori_id = k.id 
                             WHERE p.id = ?";
                $stmtPelanggan = $conn->prepare($sqlPelanggan);
                $stmtPelanggan->bind_param("i", $pelanggan_id);
                $stmtPelanggan->execute();
                $pelangganData = $stmtPelanggan->get_result()->fetch_assoc();
                $stmtPelanggan->close();

                if (!$pelangganData) {
                    throw new Exception('Data pelanggan tidak ditemukan');
                }

                // 3. HITUNG BIAYA PEMAKAIAN
                $pemakaian = $meter_akhir - $meter_awal;
                $kategori_id = $pelangganData['kategori_id'];
                $beban_tetap = floatval($pelangganData['beban_tetap']);

                $biaya_pemakaian = hitungTarifBertingkat($conn, $kategori_id, $pemakaian);

                // 4. GENERATE NOMOR TAGIHAN
                $no_tagihan = generateNomorTagihan($conn, $periode_tahun, $periode_bulan);

                // 5. HITUNG TANGGAL (PERBAIKAN: Format sebelum digunakan)
                $tanggal_tagihan = date('Y-m-d');
                $tanggal_jatuh_tempo = date('Y-m-d', strtotime('+7 days'));

                // 6. HITUNG TOTAL
                $total_tagihan = $biaya_pemakaian + $beban_tetap;

                // 7. INSERT TAGIHAN (PERBAIKAN DI SINI)
                $sqlTagihan = "INSERT INTO tagihan 
               (no_tagihan, pelanggan_id, pencatatan_meter_id, periode_tahun, periode_bulan,
                tanggal_tagihan, tanggal_jatuh_tempo, pemakaian, biaya_pemakaian, 
                beban_tetap, denda, total_tagihan, status_pembayaran, created_by)
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmtTagihan = $conn->prepare($sqlTagihan);
                if (!$stmtTagihan) {
                    throw new Exception("Prepare tagihan failed: " . $conn->error);
                }

                // Variabel untuk denda dan status
                $denda = 0;
                $status_pembayaran = 'belum_bayar';
                error_log("Debug Tagihan:");
                error_log("no_tagihan: " . $no_tagihan);
                error_log("tanggal_tagihan: " . $tanggal_tagihan);
                error_log("tanggal_jatuh_tempo: " . $tanggal_jatuh_tempo);
                error_log("biaya_pemakaian: " . $biaya_pemakaian . " (type: " . gettype($biaya_pemakaian) . ")");
                // PERBAIKAN: bind_param dengan urutan yang benar
                $stmtTagihan->bind_param(
                    "siiisssiidddsi",
                    $no_tagihan,
                    $pelanggan_id,
                    $pencatatan_meter_id,
                    $periode_tahun,
                    $periode_bulan,
                    $tanggal_tagihan,
                    $tanggal_jatuh_tempo,
                    $pemakaian,
                    $biaya_pemakaian,
                    $beban_tetap,
                    $denda,
                    $total_tagihan,
                    $status_pembayaran,
                    $petugas_id
                );

                if (!$stmtTagihan->execute()) {
                    throw new Exception("Execute tagihan failed: " . $stmtTagihan->error);
                }

                $tagihan_id = $conn->insert_id;
                $stmtTagihan->close();

                // Commit transaction
                $conn->commit();

                echo json_encode([
                    'success' => true,
                    'message' => 'Data berhasil disimpan dan tagihan dibuat otomatis!',
                    'data' => [
                        'pencatatan_id' => $pencatatan_meter_id,
                        'tagihan_id' => $tagihan_id,
                        'no_tagihan' => $no_tagihan,
                        'pemakaian' => $pemakaian,
                        'biaya_pemakaian' => number_format($biaya_pemakaian, 0, ',', '.'),
                        'beban_tetap' => number_format($beban_tetap, 0, ',', '.'),
                        'total_tagihan' => number_format($total_tagihan, 0, ',', '.')
                    ]
                ]);

            } catch (Exception $e) {
                $conn->rollback();
                throw $e;
            }

        } catch (Exception $e) {
            error_log("Error in simpan perekaman: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        break;
}
// ===== HELPER FUNCTIONS =====

/**
 * Fungsi untuk menghitung tarif bertingkat
 * @param mysqli $conn - Koneksi database
 * @param int $kategori_id - ID kategori pelanggan
 * @param int $pemakaian - Total pemakaian dalam m3
 * @return float - Total biaya pemakaian
 */
function hitungTarifBertingkat($conn, $kategori_id, $pemakaian)
{
    // Ambil data tarif bertingkat untuk kategori ini
    $sqlTarif = "SELECT * FROM tarif_bertingkat 
                 WHERE kategori_id = ? 
                 ORDER BY tingkat ASC";

    $stmt = $conn->prepare($sqlTarif);
    $stmt->bind_param("i", $kategori_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $tarif_list = [];
    while ($row = $result->fetch_assoc()) {
        $tarif_list[] = $row;
    }
    $stmt->close();

    if (empty($tarif_list)) {
        // Jika tidak ada tarif bertingkat, return 0
        return 0;
    }

    $total_biaya = 0;
    $sisa_pemakaian = $pemakaian;

    // Hitung biaya per tingkat
    foreach ($tarif_list as $tarif) {
        if ($sisa_pemakaian <= 0) {
            break;
        }

        $batas_bawah = $tarif['batas_bawah'];
        $batas_atas = $tarif['batas_atas'] ? $tarif['batas_atas'] : PHP_INT_MAX;
        $harga_per_m3 = $tarif['harga_per_m3'];

        // Hitung range untuk tingkat ini
        $range = $batas_atas - $batas_bawah + 1;

        // Pemakaian yang akan dihitung di tingkat ini
        $pemakaian_tingkat = min($sisa_pemakaian, $range);

        // Hitung biaya untuk tingkat ini
        $biaya_tingkat = $pemakaian_tingkat * $harga_per_m3;
        $total_biaya += $biaya_tingkat;

        // Kurangi sisa pemakaian
        $sisa_pemakaian -= $pemakaian_tingkat;
    }

    return $total_biaya;
}

/**
 * Fungsi untuk generate nomor tagihan otomatis
 * Format: TAG/YYYY/MM/XXXX
 * @param mysqli $conn - Koneksi database
 * @param int $tahun - Tahun periode
 * @param int $bulan - Bulan periode
 * @return string - Nomor tagihan
 */
function generateNomorTagihan($conn, $tahun, $bulan)
{
    $prefix = "TAG/" . $tahun . "/" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "/";

    // Ambil nomor urut terakhir untuk periode ini
    $sql = "SELECT no_tagihan FROM tagihan 
            WHERE no_tagihan LIKE ? 
            ORDER BY id DESC 
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $search_pattern = $prefix . "%";
    $stmt->bind_param("s", $search_pattern);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_no = $row['no_tagihan'];

        // Extract nomor urut terakhir
        $parts = explode('/', $last_no);
        $last_number = intval(end($parts));
        $next_number = $last_number + 1;
    } else {
        $next_number = 1;
    }

    $stmt->close();

    // Format nomor urut dengan 4 digit
    $no_tagihan = $prefix . str_pad($next_number, 4, '0', STR_PAD_LEFT);

    return $no_tagihan;
}