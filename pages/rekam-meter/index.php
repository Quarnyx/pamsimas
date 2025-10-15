<?php
$title = 'Rekam Meter Baru'; // set the variable before including
include 'partials/page-title.php';
$petugas_id = $_SESSION['user_id'];
$current_month = date('n');
$current_year = date('Y');
?>
<form id="formPerekamanMeter" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Rekam Meter</h5>
                <small>Petugas: <?php echo htmlspecialchars($_SESSION['username']); ?></small>
            </div>
            <div class="card-body">
                <div class="form-group col-md-6" style="position: relative;">
                    <label for="search_pelanggan" class="form-label">
                        Cari Pelanggan
                    </label>
                    <input class="form-control form-control-lg" type="text" id="searchPelanggan"
                        placeholder="Ketik kode atau nama pelanggan..." autocomplete="off">
                    <div id="searchResults" class="search-results"></div>
                </div>
            </div>
        </div>

    </div>
    <div class="row d-none" id="pelangganSection">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Pelanggan</h5>

            </div>
            <div class="card-body">
                <div class="alert alert-primary" role="alert">
                    <h6 class="alert-heading fw-bold mb-3">
                        <i class="bi bi-person-circle"></i> Data Pelanggan
                    </h6>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <strong>Kode:</strong> <span id="infoPelangganKode"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Nama:</strong> <span id="infoPelangganNama"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Kategori:</strong> <span id="infoPelangganKategori"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Meter Terakhir:</strong>
                            <span id="infoPelangganMeterTerakhir" class="badge bg-primary">0 m³</span>
                        </div>
                        <div class="col-12">
                            <strong>Alamat:</strong> <span id="infoPelangganAlamat"></span>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="pelangganId" name="pelanggan_id">

                <!-- Periode -->
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label for="periodeBulan" class="form-label fw-bold">
                            Bulan <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="periodeBulan" name="periode_bulan" required>
                            <option value="1" <?php echo $current_month == 1 ? 'selected' : ''; ?>>Januari</option>
                            <option value="2" <?php echo $current_month == 2 ? 'selected' : ''; ?>>Februari</option>
                            <option value="3" <?php echo $current_month == 3 ? 'selected' : ''; ?>>Maret</option>
                            <option value="4" <?php echo $current_month == 4 ? 'selected' : ''; ?>>April</option>
                            <option value="5" <?php echo $current_month == 5 ? 'selected' : ''; ?>>Mei</option>
                            <option value="6" <?php echo $current_month == 6 ? 'selected' : ''; ?>>Juni</option>
                            <option value="7" <?php echo $current_month == 7 ? 'selected' : ''; ?>>Juli</option>
                            <option value="8" <?php echo $current_month == 8 ? 'selected' : ''; ?>>Agustus</option>
                            <option value="9" <?php echo $current_month == 9 ? 'selected' : ''; ?>>September</option>
                            <option value="10" <?php echo $current_month == 10 ? 'selected' : ''; ?>>Oktober</option>
                            <option value="11" <?php echo $current_month == 11 ? 'selected' : ''; ?>>November</option>
                            <option value="12" <?php echo $current_month == 12 ? 'selected' : ''; ?>>Desember</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="periodeTahun" class="form-label fw-bold">
                            Tahun <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" id="periodeTahun" name="periode_tahun"
                            value="<?php echo $current_year; ?>" min="2020" max="2099" required>
                    </div>

                    <div class="col-md-4">
                        <label for="tanggalCatat" class="form-label fw-bold">
                            Tanggal Catat <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control" id="tanggalCatat" name="tanggal_catat"
                            value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>

                <!-- Meter Reading -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="meterAwal" class="form-label fw-bold">
                            <i class="bi bi-arrow-up-circle"></i> Meter Awal (m³)
                        </label>
                        <input type="number" class="form-control form-control-lg bg-light" id="meterAwal"
                            name="meter_awal" readonly>
                    </div>

                    <div class="col-md-6">
                        <label for="meterAkhir" class="form-label fw-bold">
                            <i class="bi bi-arrow-down-circle"></i> Meter Akhir (m³)
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control form-control-lg" id="meterAkhir" name="meter_akhir"
                            min="0" step="1" placeholder="Masukkan angka meter saat ini" required>
                    </div>
                </div>

                <!-- Display Pemakaian -->
                <div class="meter-display pemakaian-display">
                    <div class="display-label">Total Pemakaian</div>
                    <div class="display-value" id="displayPemakaian">0</div>
                    <div class="display-unit">meter kubik (m³)</div>
                </div>

                <!-- Upload Foto Meter -->
                <div class="mb-3">
                    <label for="fotoMeter" class="form-label fw-bold">
                        <i class="bi bi-camera"></i> Foto Meter
                    </label>
                    <input type="file" class="form-control" id="fotoMeter" name="foto_meter" accept="image/*"
                        capture="environment">
                    <div class="form-text">
                        <i class="bi bi-info-circle"></i> Format: JPG, PNG, JPEG (Max: 5MB)
                    </div>
                    <img id="previewFoto" class="preview-image d-none" alt="Preview">
                </div>

                <!-- Keterangan -->
                <div class="mb-4">
                    <label for="keterangan" class="form-label fw-bold">
                        <i class="bi bi-chat-left-text"></i> Keterangan
                    </label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                        placeholder="Catatan tambahan (opsional)"></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-outline-secondary btn-lg" onclick="resetForm()">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-save"></i> Simpan Data
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>
<div class="text-center text-white mt-3">
    <small>
        <i class="bi bi-info-circle"></i>
        Pastikan data yang diinput sudah benar sebelum menyimpan
    </small>
</div>
<script>



    function resetForm() {
        document.getElementById('formPerekamanMeter').reset();
        document.getElementById('searchPelanggan').value = '';
        pelangganSection.classList.add('d-none');
        searchResults.classList.remove('show');
        previewFoto.classList.add('d-none');
        document.getElementById('displayPemakaian').textContent = '0';
        meterAkhirInput.classList.remove('is-valid', 'is-invalid');
    }
    function selectPelanggan(pelanggan) {
        document.getElementById('pelangganId').value = pelanggan.id;
        document.getElementById('infoPelangganKode').textContent = pelanggan.kode_pelanggan;
        document.getElementById('infoPelangganNama').textContent = pelanggan.nama_pelanggan;
        document.getElementById('infoPelangganAlamat').textContent = pelanggan.alamat;
        document.getElementById('infoPelangganKategori').textContent = pelanggan.nama_kategori;
        document.getElementById('infoPelangganMeterTerakhir').textContent = (pelanggan.meter_terakhir || 0) + ' m³';
        document.getElementById('meterAwal').value = pelanggan.meter_terakhir || 0;

        document.getElementById('searchPelanggan').value = pelanggan.kode_pelanggan + ' - ' + pelanggan.nama_pelanggan;
        document.getElementById('searchResults').classList.remove('show');
        document.getElementById('pelangganSection').classList.remove('d-none');

        // Auto-focus ke meter akhir
        setTimeout(() => {
            document.getElementById('meterAkhir').focus();
        }, 100);
    }
    document.addEventListener('DOMContentLoaded', function () {
        console.log('✅ DOM loaded, initializing...');

        // Ambil semua elemen
        const searchInput = document.getElementById('searchPelanggan');
        const searchResults = document.getElementById('searchResults');
        const pelangganSection = document.getElementById('pelangganSection');

        // Debug: Cek apakah elemen ditemukan
        console.log('searchInput:', searchInput);
        console.log('searchResults:', searchResults);

        // Validasi
        if (!searchInput) {
            console.error('❌ searchPelanggan tidak ditemukan!');
            return;
        }
        let searchTimeout;
        const meterAkhirInput = document.getElementById('meterAkhir');
        const fotoMeterInput = document.getElementById('fotoMeter');
        const previewFoto = document.getElementById('previewFoto');

        // Search Pelanggan dengan debouncing
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                searchResults.classList.remove('show');
                return;
            }

            searchTimeout = setTimeout(() => {
                searchPelanggan(query);
            }, 300);
        });

        function searchPelanggan(query) {
            searchResults.innerHTML = '<div class="loading-spinner"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div> Mencari...</div>';
            searchResults.classList.add('show');

            // Ubah URL dengan parameter aksi
            fetch(`../../modules/proses-rekam-meter.php?aksi=cari-pelanggan&q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        searchResults.innerHTML = '<div class="loading-spinner text-muted">Tidak ada hasil ditemukan</div>';
                        return;
                    }

                    let html = '';
                    data.forEach(pelanggan => {
                        html += `
                    <div class="search-item" onclick='selectPelanggan(${JSON.stringify(pelanggan)})'>
                        <div class="fw-bold text-primary">${pelanggan.kode_pelanggan}</div>
                        <small class="text-muted">${pelanggan.nama_pelanggan} - ${pelanggan.alamat}</small>
                    </div>
                `;
                    });
                    searchResults.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    searchResults.innerHTML = '<div class="loading-spinner text-danger"><i class="bi bi-exclamation-triangle"></i> Terjadi kesalahan</div>';
                });
        }



        // Calculate Pemakaian secara real-time
        meterAkhirInput.addEventListener('input', function () {
            const meterAwal = parseInt(document.getElementById('meterAwal').value) || 0;
            const meterAkhir = parseInt(this.value) || 0;
            const pemakaian = meterAkhir - meterAwal;

            document.getElementById('displayPemakaian').textContent = pemakaian >= 0 ? pemakaian : 0;

            // Validasi HTML5
            if (meterAkhir < meterAwal) {
                this.setCustomValidity('Meter akhir tidak boleh lebih kecil dari meter awal');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });

        // Preview Foto dengan validasi ukuran
        fotoMeterInput.addEventListener('change', function (e) {
            const file = e.target.files[0];

            if (file) {
                // Validasi ukuran file (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alertify.error('Ukuran file tidak boleh lebih dari 5MB');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    previewFoto.src = e.target.result;
                    previewFoto.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });

        // Submit Form dengan AJAX
        document.getElementById('formPerekamanMeter').addEventListener('submit', function (e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

            const formData = new FormData(this);
            formData.append('petugas_id', <?php echo $_SESSION['user_id']; ?>);

            // Ubah URL dengan parameter aksi
            fetch('../../modules/proses-rekam-meter.php?aksi=simpan-perakaman-meter', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    alertify.success(data.message);

                    if (data.success) {
                        setTimeout(() => {
                            resetForm();
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alertify.error('Terjadi kesalahan saat menyimpan data');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
        });


        // Close search results ketika klik di luar
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.remove('show');
            }
        });
    });
</script>