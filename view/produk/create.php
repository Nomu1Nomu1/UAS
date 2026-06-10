<?php
// view/produk/create.php
ob_start();
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Tambah Produk</h4>
    <p>Isi data produk baru untuk inventaris</p>
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
    <form method="POST" action="<?= BASE_URL ?>/product/create">

      <div class="form-section-title">Identitas Produk</div>
      <div class="row g-3 mb-3">
        <div class="col-md-4">
          <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
          <input type="text" name="kode_barang" class="form-control"
                 placeholder="cth: PRD-001"
                 value="<?= htmlspecialchars($_POST['kode_barang'] ?? '') ?>" required>
        </div>
        <div class="col-md-8">
          <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
          <input type="text" name="nama_barang" class="form-control"
                 placeholder="Nama produk"
                 value="<?= htmlspecialchars($_POST['nama_barang'] ?? '') ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Kategori <span class="text-danger">*</span></label>
          <select name="kategori_id" class="form-select" required>
            <option value="">Pilih Kategori</option>
            <?php foreach ($kategoris as $k): ?>
              <option value="<?= $k['id'] ?>" <?= ((int)($_POST['kategori_id'] ?? 0) == $k['id']) ? 'selected' : '' ?>>
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
              <option value="<?= $d['id'] ?>" <?= ((int)($_POST['distributor_id'] ?? 0) == $d['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($d['nama_distributor']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Satuan <span class="text-danger">*</span></label>
          <input type="text" name="satuan" class="form-control"
                 placeholder="pcs / kg / ltr"
                 value="<?= htmlspecialchars($_POST['satuan'] ?? '') ?>" required>
        </div>
      </div>

      <div class="form-section-title">Stok</div>
      <div class="row g-3 mb-3">
        <div class="col-md-4">
          <label class="form-label">Stok Awal</label>
          <input type="number" name="stock" class="form-control" min="0"
                 value="<?= htmlspecialchars($_POST['stock'] ?? 0) ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label">Stok Minimum <span class="text-danger">*</span></label>
          <input type="number" name="stock_min" class="form-control" min="0"
                 value="<?= htmlspecialchars($_POST['stock_min'] ?? 5) ?>" required>
          <div class="form-text">Peringatan stok menipis jika di bawah nilai ini</div>
        </div>
      </div>

      <div class="form-section-title">Harga</div>
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="form-label">Harga Beli (Rp)</label>
          <input type="number" name="harga_beli" class="form-control" min="0" step="100"
                 value="<?= htmlspecialchars($_POST['harga_beli'] ?? 0) ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
          <input type="number" name="harga_jual" class="form-control" min="0" step="100"
                 value="<?= htmlspecialchars($_POST['harga_jual'] ?? 0) ?>" required>
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="3"
                  placeholder="Keterangan tambahan (opsional)"><?= htmlspecialchars($_POST['deskripsi'] ?? '') ?></textarea>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4">
          <i class="bi bi-save me-1"></i> Simpan Produk
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