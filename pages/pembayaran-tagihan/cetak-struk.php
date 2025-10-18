<?php
// Simple invoice generator - /d:/laragon/www/pamsimas/pages/pembayaran-tagihan/cetak-struk.php

// Accept basic overrides via GET for quick testing (e.g. ?no=INV-123&customer=Budi)
$invoiceNumber = htmlspecialchars($_GET['no'] ?? 'INV-001');
$date = htmlspecialchars($_GET['date'] ?? date('Y-m-d'));
$dueDate = htmlspecialchars($_GET['due'] ?? date('Y-m-d', strtotime('+7 days')));
$customer = htmlspecialchars($_GET['customer'] ?? 'Nama Pelanggan');
$address = htmlspecialchars($_GET['address'] ?? 'Alamat pelanggan, Kota');
$phone = htmlspecialchars($_GET['phone'] ?? '0812-3456-7890');
$notes = htmlspecialchars($_GET['notes'] ?? 'Terima kasih atas pembayaran Anda.');

// Sample line items (in a real app, fetch from DB)
$items = [
    ['desc' => 'Tagihan Air Bulan April', 'qty' => 1, 'unit' => 'bulan', 'price' => 150000],
    ['desc' => 'Biaya Administrasi', 'qty' => 1, 'unit' => 'pcs', 'price' => 5000],
    ['desc' => 'Denda Keterlambatan', 'qty' => 0, 'unit' => 'pcs', 'price' => 0],
];

$subtotal = 0;
foreach ($items as $it) {
    $subtotal += $it['qty'] * $it['price'];
}
$taxRate = 0; // set if applicable, e.g. 0.1 for 10%
$tax = round($subtotal * $taxRate);
$total = $subtotal + $tax;
$paid = floatval($_GET['paid'] ?? 0);
$balance = $total - $paid;

function rupiah($n)
{
    return 'Rp ' . number_format($n, 0, ',', '.');
}

include '../../modules/config.php';
$sql = "SELECT * FROM vw_struk WHERE id = '$_GET[id]'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cetak Struk - <?= $row['no_tagihan'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                -webkit-print-color-adjust: exact;
            }
        }

        .invoice-box {
            border: 1px solid #dee2e6;
            padding: 24px;
            border-radius: 6px;
            background: #fff;
        }

        .company-name {
            font-weight: 700;
            font-size: 1.25rem;
        }

        .muted {
            color: #6c757d;
        }
    </style>
</head>

<body class="bg-light py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-0">Cetak Struk</h4>
            </div>
            <div class="no-print">
                <button class="btn btn-primary" onclick="window.print()">Cetak</button>
                <a href="#" onclick="window.close()" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </div>

        <div class="invoice-box">
            <div class="row mb-4">
                <div class="col-6">
                    <div class="company-name">PAMSIMAS</div>
                    <div class="muted">Kendal</div>
                </div>
                <div class="col-6 text-end">
                    <h5 class="mb-0">No: <?= $row['no_tagihan'] ?></h5>
                    <div class="muted">Tanggal Tagihan: <?= $row['tanggal_tagihan'] ?></div>
                    <div class="muted">Jatuh Tempo: <?= $row['tanggal_jatuh_tempo'] ?></div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <strong>Tagihan Untuk:</strong>
                    <div><?= $row['nama_pelanggan'] ?></div>
                    <div class="muted"><?= $row['alamat'] ?></div>
                    <div class="muted">Kode Pelanggan: <?= $row['kode_pelanggan'] ?></div>
                </div>
                <div class="col-6 text-end">
                    <strong>Status:</strong>
                    <div class="badge bg-success">Lunas</div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Harga Satuan</th>
                        <th class="text-end">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Pemakaian Bulan
                            <?= date('F', strtotime($row['periode_tahun'] . '-' . $row['periode_bulan'] . '-01')); ?> -
                            <?= $row['periode_tahun'] ?>
                        </td>
                        <td>1</td>
                        <td class="text-end"><?= rupiah($row['biaya_pemakaian']) ?></td>
                        <td class="text-end"><?= rupiah($row['biaya_pemakaian']) ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Biaya Tetap</td>
                        <td>1</td>
                        <td class="text-end"><?= rupiah($row['beban_tetap']) ?></td>
                        <td class="text-end"><?= rupiah($row['beban_tetap']) ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <th colspan="4" class="text-end">Total</th>
                        <th class="text-end"><?= rupiah($row['total_tagihan']) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row mt-4">
            <div class="col-8">
                <small class="muted"><?= $notes ?></small>
            </div>
            <div class="col-4 text-center">
                <div class="muted">Hormat kami,</div>
                <div style="height:48px;"></div>
                <div><strong>PAMSIMAS</strong></div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>