<?php
// view/kategori/create.php
ob_start();
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Tambah Kategori</h4>
    <p>Buat kategori baru untuk mengelompokkan produk</p>
  </div>
  <a href="<?= BASE_URL ?>/kategori/index" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali
  </a>
</div>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger d-flex gap-2 align-items-center" style="font-size:13px;border-radius:10px">
    <i class="bi bi-exclamation-circle-fill"></i> <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<div class="card" style="max-width:480px">
  <div class="card-body">
    <form method="POST" action="<?= BASE_URL ?>/kategori/create">
      <div class="mb-3">
        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
        <input type="text" name="nama_kategori" class="form-control"
               placeholder="cth: Sembako, Minuman, ATK..."
               value="<?= htmlspecialchars($_POST['nama_kategori'] ?? '') ?>" required autofocus>
      </div>
      <div class="mb-4">
        <label class="form-label">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="3"
                  placeholder="Keterangan singkat (opsional)"><?= htmlspecialchars($_POST['deskripsi'] ?? '') ?></textarea>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4">
          <i class="bi bi-save me-1"></i> Simpan
        </button>
        <a href="<?= BASE_URL ?>/kategori/index" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>