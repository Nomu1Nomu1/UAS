<?php ob_start(); ?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Tambah Distributor</h4>
    <p>Daftarkan pemasok / supplier baru</p>
  </div>
  <a href="<?= BASE_URL ?>/distributor/index" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali
  </a>
</div>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger d-flex gap-2 align-items-center" style="font-size:13px;border-radius:10px">
    <i class="bi bi-exclamation-circle-fill"></i> <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<div class="card" style="max-width:560px">
  <div class="card-body">
    <form method="POST" action="<?= BASE_URL ?>/distributor/create">
      <div class="mb-3">
        <label class="form-label">Nama Distributor <span class="text-danger">*</span></label>
        <input type="text" name="nama_distributor" class="form-control"
               placeholder="PT / CV / nama toko pemasok"
               value="<?= htmlspecialchars($_POST['nama_distributor'] ?? '') ?>" required autofocus>
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat <span class="text-danger">*</span></label>
        <textarea name="alamat" class="form-control" rows="2"
                  placeholder="Alamat lengkap distributor" required><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
      </div>
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="form-label">No. HP / WhatsApp <span class="text-danger">*</span></label>
          <input type="text" name="no_hp" class="form-control"
                 placeholder="08xx-xxxx-xxxx"
                 value="<?= htmlspecialchars($_POST['no_hp'] ?? '') ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control"
                 placeholder="email@distributor.com"
                 value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
      </div>
      <div class="mb-4">
        <label class="form-label">Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="2"
                  placeholder="Catatan tambahan (opsional)"><?= htmlspecialchars($_POST['keterangan'] ?? '') ?></textarea>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4">
          <i class="bi bi-save me-1"></i> Simpan
        </button>
        <a href="<?= BASE_URL ?>/distributor/index" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>