<?php
// view/produk/index.php
$role = strtolower($_SESSION['users']['role'] ?? 'kasir');
ob_start();
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Data Produk</h4>
    <p>Kelola semua produk inventaris Anda</p>
  </div>
  <?php if (in_array($role, ['owner','admin'])): ?>
  <a href="<?= BASE_URL ?>/product/create" class="btn btn-primary">
    <i class="bi bi-plus-lg me-1"></i> Tambah Produk
  </a>
  <?php endif; ?>
</div>

<!-- Filter Bar -->
<form method="GET" action="<?= BASE_URL ?>/product/index" class="filter-bar">
  <input
    type="text"
    name="search"
    class="form-control"
    placeholder="Cari nama / kode produk..."
    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
  >
  <select name="kategori_id" class="form-select">
    <option value="">Semua Kategori</option>
    <?php foreach ($kategoris as $k): ?>
      <option value="<?= $k['id'] ?>" <?= ((int)($_GET['kategori_id'] ?? 0) === (int)$k['id']) ? 'selected' : '' ?>>
        <?= htmlspecialchars($k['nama_kategori']) ?>
      </option>
    <?php endforeach; ?>
  </select>
  <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i>Cari</button>
  <a href="<?= BASE_URL ?>/product/index" class="btn btn-outline-secondary">Reset</a>
</form>

<!-- Table -->
<div class="card table-card">
  <div class="card-header">
    <span><i class="bi bi-box-seam me-2 text-muted"></i>Daftar Produk
      <span class="badge bg-primary ms-1"><?= count($products) ?></span>
    </span>
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Kode</th>
          <th>Nama Produk</th>
          <th>Kategori</th>
          <th>Distributor</th>
          <th>Stok</th>
          <th>Harga Jual</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($products)): ?>
          <tr>
            <td colspan="8" class="text-center text-muted py-5">
              <i class="bi bi-inbox d-block mb-2" style="font-size:32px;opacity:.2"></i>
              Tidak ada produk ditemukan
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($products as $i => $p): ?>
          <tr>
            <td class="text-muted"><?= $i + 1 ?></td>
            <td><span class="kode-text"><?= htmlspecialchars($p['kode_barang']) ?></span></td>
            <td>
              <div class="fw-600"><?= htmlspecialchars($p['nama_barang']) ?></div>
              <div class="text-muted" style="font-size:11px"><?= htmlspecialchars($p['satuan']) ?></div>
            </td>
            <td><?= htmlspecialchars($p['nama_kategori']) ?></td>
            <td class="text-muted" style="font-size:12px"><?= htmlspecialchars($p['nama_distributor']) ?></td>
            <td>
              <?php
              $stok = (int)$p['stock'];
              $min  = (int)$p['stock_min'];
              $cls  = $stok == 0 ? 'stock-low' : ($stok <= $min ? 'stock-warn' : 'stock-ok');
              ?>
              <span class="<?= $cls ?>"><?= $stok ?></span>
              <span class="text-muted" style="font-size:11px">/ min <?= $min ?></span>
            </td>
            <td class="fw-600"><?= format_rupiah($p['harga_jual']) ?></td>
            <td>
              <div class="d-flex gap-1">
                <a href="<?= BASE_URL ?>/product/show?id=<?= $p['id'] ?>" class="btn btn-icon btn-outline-secondary" title="Detail">
                  <i class="bi bi-eye"></i>
                </a>
                <?php if (in_array($role, ['owner','admin'])): ?>
                <a href="<?= BASE_URL ?>/product/edit?id=<?= $p['id'] ?>" class="btn btn-icon btn-outline-primary" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                <a href="<?= BASE_URL ?>/product/delete?id=<?= $p['id'] ?>"
                   class="btn btn-icon btn-outline-danger" title="Hapus"
                   data-confirm="Yakin ingin menghapus produk ini?">
                  <i class="bi bi-trash3"></i>
                </a>
                <?php endif; ?>
              </div>
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