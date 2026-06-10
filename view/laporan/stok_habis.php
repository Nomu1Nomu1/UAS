<?php
// view/laporan/stok_habis.php
ob_start();
$habis   = array_filter($produkStokHabis, fn($p) => (int)$p['stock'] === 0);
$menipis = array_filter($produkStokHabis, fn($p) => (int)$p['stock'] > 0);
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Laporan Stok Menipis / Habis</h4>
    <p>Produk yang perlu segera diisi ulang</p>
  </div>
  <div class="d-flex gap-2">
    <a href="<?= BASE_URL ?>/pengadaan/create" class="btn btn-primary">
      <i class="bi bi-clipboard-plus me-1"></i> Buat Pengadaan
    </a>
    <a href="<?= BASE_URL ?>/laporan/index" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
  </div>
</div>

<!-- Summary -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="stat-card">
      <div class="stat-icon red"><i class="bi bi-x-circle"></i></div>
      <div>
        <div class="stat-value"><?= count($habis) ?></div>
        <div class="stat-label">Stok Habis</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="stat-card">
      <div class="stat-icon yellow"><i class="bi bi-exclamation-triangle"></i></div>
      <div>
        <div class="stat-value"><?= count($menipis) ?></div>
        <div class="stat-label">Stok Menipis</div>
      </div>
    </div>
  </div>
</div>

<div class="card table-card">
  <div class="card-header">
    <span><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Daftar Produk
      <span class="badge bg-danger ms-1"><?= count($produkStokHabis) ?></span>
    </span>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Kode</th>
          <th>Nama Produk</th>
          <th>Kategori</th>
          <th>Distributor</th>
          <th>No. HP</th>
          <th class="text-end">Stok</th>
          <th class="text-end">Min</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($produkStokHabis)): ?>
          <tr>
            <td colspan="9" class="text-center py-5">
              <i class="bi bi-check-circle d-block mb-2 text-success" style="font-size:32px;opacity:.5"></i>
              <span class="text-muted">Semua stok dalam kondisi aman 🎉</span>
            </td>
          </tr>
        <?php else: ?>
          <?php $no = 1; foreach ($produkStokHabis as $p): ?>
          <tr>
            <td class="text-muted"><?= $no++ ?></td>
            <td><span class="kode-text"><?= htmlspecialchars($p['kode_barang']) ?></span></td>
            <td class="fw-600"><?= htmlspecialchars($p['nama_barang']) ?></td>
            <td class="text-muted" style="font-size:12px"><?= htmlspecialchars($p['nama_kategori']) ?></td>
            <td style="font-size:12px"><?= htmlspecialchars($p['nama_distributor']) ?></td>
            <td style="font-size:12px"><?= htmlspecialchars($p['dist_no_hp'] ?? '—') ?></td>
            <td class="text-end <?= (int)$p['stock'] === 0 ? 'stock-low' : 'stock-warn' ?>">
              <?= $p['stock'] ?> <?= htmlspecialchars($p['satuan']) ?>
            </td>
            <td class="text-end text-muted"><?= $p['stock_min'] ?></td>
            <td>
              <?php if ((int)$p['stock'] === 0): ?>
                <span class="badge badge-batal">Habis</span>
              <?php else: ?>
                <span class="badge badge-pending">Menipis</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>