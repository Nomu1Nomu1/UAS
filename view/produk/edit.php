<?php
// view/produk/edit.php
ob_start();
$p = $product;
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Edit Produk</h4>
    <p>Perbarui data: <strong><?= htmlspecialchars($p['nama_barang']) ?></strong></p>
  </div>
  <a href="<?= BASE_URL ?>/product/index" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali
  </a>
</div>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger d-flex gap-2 align-items-center" style="font-size:13px;border-radius:10px">
    <i class="bi bi-exclamation-circle-fill"></i> <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<div class="card" style="max-width:720px">
  <div class="card-body">
    <form method="POST" action="<?= BASE_URL ?>/product/edit?id=<?= $p['id'] ?>">

      <div class="form-section-title">Identitas Produk</div>
      <div class="row g-3 mb-3">
        <div class="col-md-4">
          <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
          <input type="text" name="kode_barang" class="form-control"
                 value="<?= htmlspecialchars($_POST['kode_barang'] ?? $p['kode_barang']) ?>" required>
        </div>
        <div class="col-md-8">
          <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
          <input type="text" name="nama_barang" class="form-control"
                 value="<?= htmlspecialchars($_POST['nama_barang'] ?? $p['nama_barang']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Kategori <span class="text-danger">*</span></label>
          <select name="kategori_id" class="form-select" required>
            <option value="">Pilih Kategori</option>
            <?php foreach ($kategoris as $k): ?>
              <option value="<?= $k['id'] ?>"
                <?= ((int)($_POST['kategori_id'] ?? $p['kategori_id']) == $k['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($k['nama_kategori']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Distributor <span class="text-danger">*</span></label>
          <select name="distributor_id" class="form-select" required>
            <option value="">Pilih Distributor</option>
            <?php foreach ($distribs as $d): ?>
              <option value="<?= $d['id'] ?>"
                <?= ((int)($_POST['distributor_id'] ?? $p['distributor_id']) == $d['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($d['nama_distributor']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Satuan <span class="text-danger">*</span></label>
          <input type="text" name="satuan" class="form-control"
                 value="<?= htmlspecialchars($_POST['satuan'] ?? $p['satuan']) ?>" required>
        </div>
      </div>

      <div class="form-section-title">Stok</div>
      <div class="row g-3 mb-3">
        <div class="col-md-4">
          <label class="form-label">Stok Saat Ini</label>
          <input type="number" name="stock" class="form-control" min="0"
                 value="<?= (int)($_POST['stock'] ?? $p['stock']) ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label">Stok Minimum</label>
          <input type="number" name="stock_min" class="form-control" min="0"
                 value="<?= (int)($_POST['stock_min'] ?? $p['stock_min']) ?>">
        </div>
      </div>

      <div class="form-section-title">Harga</div>
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="form-label">Harga Beli (Rp)</label>
          <input type="number" name="harga_beli" class="form-control" min="0" step="100"
                 value="<?= (int)($_POST['harga_beli'] ?? $p['harga_beli']) ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
          <input type="number" name="harga_jual" class="form-control" min="0" step="100"
                 value="<?= (int)($_POST['harga_jual'] ?? $p['harga_jual']) ?>" required>
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($_POST['deskripsi'] ?? $p['deskripsi'] ?? '') ?></textarea>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4">
          <i class="bi bi-save me-1"></i> Simpan Perubahan
        </button>
        <a href="<?= BASE_URL ?>/product/index" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>