<?php
// view/produk/show.php
ob_start();
$p    = $product;
$stok = (int)$p['stock'];
$min  = (int)$p['stock_min'];
$cls  = $stok == 0 ? 'stock-low' : ($stok <= $min ? 'stock-warn' : 'stock-ok');
$margin = $p['harga_beli'] > 0 ? round((($p['harga_jual'] - $p['harga_beli']) / $p['harga_beli']) * 100, 1) : 0;
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Detail Produk</h4>
    <p><span class="kode-text"><?= htmlspecialchars($p['kode_barang']) ?></span></p>
  </div>
  <div class="d-flex gap-2">
    <a href="<?= BASE_URL ?>/product/edit?id=<?= $p['id'] ?>" class="btn btn-outline-primary">
      <i class="bi bi-pencil me-1"></i> Edit
    </a>
    <a href="<?= BASE_URL ?>/product/index" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
  </div>
</div>

<div class="row g-3">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">Informasi Produk</div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-sm-6">
            <div class="text-muted" style="font-size:11px;font-weight:600;text-transform:uppercase">Nama Barang</div>
            <div class="fw-600 mt-1"><?= htmlspecialchars($p['nama_barang']) ?></div>
          </div>
          <div class="col-sm-6">
            <div class="text-muted" style="font-size:11px;font-weight:600;text-transform:uppercase">Kode</div>
            <div class="mt-1"><span class="kode-text"><?= htmlspecialchars($p['kode_barang']) ?></span></div>
          </div>
          <div class="col-sm-6">
            <div class="text-muted" style="font-size:11px;font-weight:600;text-transform:uppercase">Kategori</div>
            <div class="fw-600 mt-1"><?= htmlspecialchars($p['nama_kategori']) ?></div>
          </div>
          <div class="col-sm-6">
            <div class="text-muted" style="font-size:11px;font-weight:600;text-transform:uppercase">Distributor</div>
            <div class="fw-600 mt-1"><?= htmlspecialchars($p['nama_distributor']) ?></div>
          </div>
          <div class="col-sm-6">
            <div class="text-muted" style="font-size:11px;font-weight:600;text-transform:uppercase">Satuan</div>
            <div class="fw-600 mt-1"><?= htmlspecialchars($p['satuan']) ?></div>
          </div>
          <?php if (!empty($p['deskripsi'])): ?>
          <div class="col-12">
            <div class="text-muted" style="font-size:11px;font-weight:600;text-transform:uppercase">Deskripsi</div>
            <div class="mt-1" style="font-size:13px"><?= nl2br(htmlspecialchars($p['deskripsi'])) ?></div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <!-- Stok Card -->
    <div class="card mb-3">
      <div class="card-body text-center py-4">
        <div style="font-size:11px;font-weight:600;text-transform:uppercase;color:var(--text-muted)">Stok Saat Ini</div>
        <div class="<?= $cls ?>" style="font-size:42px;font-weight:700;line-height:1.1;margin:8px 0"><?= $stok ?></div>
        <div class="text-muted" style="font-size:12px"><?= htmlspecialchars($p['satuan']) ?> · Min: <?= $min ?></div>
        <?php if ($stok <= $min): ?>
          <div class="alert mb-0 mt-3 py-2" style="background:var(--warning-bg);border:0;font-size:12px;border-radius:8px;color:var(--warning-color)">
            <i class="bi bi-exclamation-triangle me-1"></i> Stok menipis
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Harga Card -->
    <div class="card">
      <div class="card-header">Harga</div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="text-muted" style="font-size:12px">Harga Beli</span>
          <span class="fw-600"><?= format_rupiah($p['harga_beli']) ?></span>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="text-muted" style="font-size:12px">Harga Jual</span>
          <span class="fw-700" style="color:var(--primary)"><?= format_rupiah($p['harga_jual']) ?></span>
        </div>
        <hr class="my-2">
        <div class="d-flex justify-content-between align-items-center">
          <span class="text-muted" style="font-size:12px">Margin</span>
          <span class="badge <?= $margin >= 0 ? 'badge-selesai' : 'badge-batal' ?>"><?= $margin ?>%</span>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>