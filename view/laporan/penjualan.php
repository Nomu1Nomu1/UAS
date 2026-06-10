<?php
// view/laporan/penjualan.php
ob_start();
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Laporan Penjualan</h4>
    <p>Analisis penjualan berdasarkan periode</p>
  </div>
  <a href="<?= BASE_URL ?>/laporan/index" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali
  </a>
</div>

<!-- Date Filter -->
<form method="GET" action="<?= BASE_URL ?>/laporan/penjualan" class="filter-bar mb-4">
  <div class="d-flex align-items-center gap-2 flex-wrap w-100">
    <label class="text-muted fw-500" style="font-size:12px;white-space:nowrap">Dari</label>
    <input type="date" name="dari" class="form-control" style="max-width:160px"
           value="<?= htmlspecialchars($dari) ?>">
    <label class="text-muted fw-500" style="font-size:12px;white-space:nowrap">Sampai</label>
    <input type="date" name="sampai" class="form-control" style="max-width:160px"
           value="<?= htmlspecialchars($sampai) ?>">
    <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i>Filter</button>
  </div>
</form>

<!-- Summary Stats -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="stat-card">
      <div class="stat-icon green"><i class="bi bi-receipt"></i></div>
      <div>
        <div class="stat-value"><?= number_format($summary['total_trx']) ?></div>
        <div class="stat-label">Total Transaksi</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="stat-card">
      <div class="stat-icon indigo"><i class="bi bi-cash-coin"></i></div>
      <div>
        <div class="stat-value" style="font-size:16px"><?= format_rupiah($summary['grand_total']) ?></div>
        <div class="stat-label">Total Pendapatan</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="stat-card">
      <div class="stat-icon blue"><i class="bi bi-calendar-range"></i></div>
      <div>
        <div class="stat-value" style="font-size:14px"><?= count($penjualanHarian) ?> hari</div>
        <div class="stat-label">Hari Aktif</div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <!-- Penjualan Harian -->
  <div class="col-lg-6">
    <div class="card table-card">
      <div class="card-header">Penjualan Harian</div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th class="text-end">Transaksi</th>
              <th class="text-end">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($penjualanHarian)): ?>
              <tr>
                <td colspan="3" class="text-center text-muted py-4">Tidak ada data</td>
              </tr>
            <?php else: ?>
              <?php foreach ($penjualanHarian as $ph): ?>
              <tr>
                <td><?= date('d/m/Y', strtotime($ph['tgl'])) ?></td>
                <td class="text-end"><?= $ph['jumlah_trx'] ?></td>
                <td class="text-end fw-600"><?= format_rupiah($ph['total_penjualan']) ?></td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Produk Terlaris -->
  <div class="col-lg-6">
    <div class="card table-card">
      <div class="card-header">Produk Terlaris</div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Produk</th>
              <th class="text-end">Terjual</th>
              <th class="text-end">Pendapatan</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($produkTerlaris)): ?>
              <tr>
                <td colspan="4" class="text-center text-muted py-4">Tidak ada data</td>
              </tr>
            <?php else: ?>
              <?php foreach ($produkTerlaris as $i => $pt): ?>
              <tr>
                <td class="text-muted fw-700"><?= $i + 1 ?></td>
                <td>
                  <div class="fw-600" style="font-size:12px"><?= htmlspecialchars($pt['nama_barang']) ?></div>
                  <div class="text-muted" style="font-size:11px"><?= htmlspecialchars($pt['nama_kategori']) ?></div>
                </td>
                <td class="text-end fw-600"><?= $pt['total_terjual'] ?></td>
                <td class="text-end fw-600" style="font-size:12px"><?= format_rupiah($pt['total_pendapatan']) ?></td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>