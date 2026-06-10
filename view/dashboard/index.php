<?php require_once __DIR__ . '/../layouts/main.php'; ?>
<?php ob_start(); ?>

<!-- Page Header -->
<div class="page-header">
  <div class="page-header-left">
    <h4>Dashboard</h4>
    <p>Selamat datang, <strong><?= htmlspecialchars($_SESSION['users']['nama'] ?? '') ?></strong> 👋</p>
  </div>
  <a href="<?= BASE_URL ?>/transaksi/kasir" class="btn btn-primary">
    <i class="bi bi-cart3 me-1"></i> Buka Kasir
  </a>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
  <div class="col-6 col-lg-3">
    <div class="stat-card">
      <div class="stat-icon blue"><i class="bi bi-box-seam"></i></div>
      <div>
        <div class="stat-value"><?= number_format($totalProduk) ?></div>
        <div class="stat-label">Total Produk</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="stat-card">
      <div class="stat-icon green"><i class="bi bi-receipt"></i></div>
      <div>
        <div class="stat-value"><?= number_format($totalTRXHariIni) ?></div>
        <div class="stat-label">Transaksi Hari Ini</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="stat-card">
      <div class="stat-icon indigo"><i class="bi bi-cash-coin"></i></div>
      <div>
        <div class="stat-value" style="font-size:16px"><?= format_rupiah($pendapatanHariIni) ?></div>
        <div class="stat-label">Pendapatan Hari Ini</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="stat-card">
      <div class="stat-icon <?= $stockMenipis > 0 ? 'red' : 'green' ?>">
        <i class="bi bi-<?= $stockMenipis > 0 ? 'exclamation-triangle' : 'check-circle' ?>"></i>
      </div>
      <div>
        <div class="stat-value"><?= number_format($stockMenipis) ?></div>
        <div class="stat-label">Stok Menipis</div>
      </div>
    </div>
  </div>
</div>

<!-- Second row: Pengadaan Pending -->
<?php if ($pengadaanPending > 0): ?>
<div class="alert d-flex align-items-center gap-2 mb-4" style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:10px;font-size:13px">
  <i class="bi bi-clock-history text-warning fs-5"></i>
  <div>
    Ada <strong><?= $pengadaanPending ?> pengadaan</strong> menunggu konfirmasi.
    <a href="<?= BASE_URL ?>/pengadaan/index?status=Pending" class="ms-2 fw-600">Lihat Sekarang →</a>
  </div>
</div>
<?php endif; ?>

<div class="row g-3">

  <!-- Transaksi Terakhir -->
  <div class="col-12 col-lg-7">
    <div class="card table-card">
      <div class="card-header">
        <span><i class="bi bi-clock-history me-2 text-muted"></i>Transaksi Terakhir</span>
        <a href="<?= BASE_URL ?>/transaksi/index" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>No. Transaksi</th>
              <th>Kasir</th>
              <th>Total</th>
              <th>Status</th>
              <th>Waktu</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($transaksiTerakhir)): ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="bi bi-receipt d-block mb-1 fs-4 opacity-25"></i>
                  Belum ada transaksi hari ini
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($transaksiTerakhir as $trx): ?>
              <tr>
                <td><span class="kode-text"><?= htmlspecialchars($trx['no_trx']) ?></span></td>
                <td><?= htmlspecialchars($trx['kasir']) ?></td>
                <td class="fw-600"><?= format_rupiah($trx['total_harga']) ?></td>
                <td>
                  <?php
                  $st = $trx['status'];
                  $badgeClass = match($st) {
                    'Selesai' => 'badge-selesai',
                    'Batal'   => 'badge-batal',
                    default   => 'badge-pending'
                  };
                  ?>
                  <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($st) ?></span>
                </td>
                <td class="text-muted" style="font-size:12px">
                  <?= date('H:i', strtotime($trx['tanggal_transaksi'])) ?>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Stok Menipis -->
  <div class="col-12 col-lg-5">
    <div class="card table-card">
      <div class="card-header">
        <span><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Stok Menipis</span>
        <a href="<?= BASE_URL ?>/laporan/stokHabis" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Produk</th>
              <th>Stok</th>
              <th>Min</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($listStockMenipis)): ?>
              <tr>
                <td colspan="3" class="text-center text-muted py-4">
                  <i class="bi bi-check-circle d-block mb-1 fs-4 text-success opacity-50"></i>
                  Semua stok aman
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($listStockMenipis as $item): ?>
              <tr>
                <td>
                  <div class="fw-600" style="font-size:12px"><?= htmlspecialchars($item['nama_barang']) ?></div>
                  <div class="text-muted" style="font-size:11px"><?= htmlspecialchars($item['nama_kategori']) ?></div>
                </td>
                <td>
                  <span class="<?= $item['stock'] == 0 ? 'stock-low' : 'stock-warn' ?>">
                    <?= $item['stock'] ?>
                  </span>
                </td>
                <td class="text-muted"><?= $item['stock_min'] ?></td>
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
// main.php sudah di-require di atas, tapi karena arsitektur controller
// yang merender view langsung dengan require_once, kita pakai output buffer.
// Ubah pola ini ke: ob_start() di sini → set $content → include main.php
// Untuk sekarang, pastikan main.php menerima $content dari ob.
?>