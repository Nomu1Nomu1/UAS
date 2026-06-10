<?php
// view/user/create.php
ob_start();
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Tambah User</h4>
    <p>Buat akun pengguna baru</p>
  </div>
  <a href="<?= BASE_URL ?>/user/index" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali
  </a>
</div>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger d-flex gap-2 align-items-center" style="font-size:13px;border-radius:10px">
    <i class="bi bi-exclamation-circle-fill"></i> <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<div class="card" style="max-width:520px">
  <div class="card-body">
    <form method="POST" action="<?= BASE_URL ?>/user/create">

      <div class="form-section-title">Akun Login</div>
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="form-label">Username <span class="text-danger">*</span></label>
          <input type="text" name="username" class="form-control"
                 placeholder="username unik"
                 value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autofocus>
        </div>
        <div class="col-md-6">
          <label class="form-label">Password <span class="text-danger">*</span></label>
          <input type="password" name="password" class="form-control"
                 placeholder="Min. 6 karakter" minlength="6" required>
        </div>
      </div>

      <div class="form-section-title">Identitas</div>
      <div class="row g-3 mb-3">
        <div class="col-md-8">
          <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
          <input type="text" name="nama" class="form-control"
                 placeholder="Nama tampilan"
                 value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Role <span class="text-danger">*</span></label>
          <select name="role" class="form-select" required>
            <option value="">Pilih</option>
            <?php foreach (['owner','admin','kasir'] as $r): ?>
              <option value="<?= $r ?>" <?= ($_POST['role'] ?? '') === $r ? 'selected' : '' ?>>
                <?= ucfirst($r) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control"
                 placeholder="email@example.com"
                 value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">No. HP</label>
          <input type="text" name="no_hp" class="form-control"
                 placeholder="08xx-xxxx-xxxx"
                 value="<?= htmlspecialchars($_POST['no_hp'] ?? '') ?>">
        </div>
      </div>

      <!-- Role descriptions -->
      <div class="mb-4 p-3 rounded-2" style="background:#F8FAFC;font-size:12px;line-height:1.7">
        <strong>Panduan Role:</strong><br>
        <span style="color:#4F46E5">Owner</span> — akses penuh termasuk manajemen user<br>
        <span style="color:#2563EB">Admin</span> — kelola produk, pengadaan, dan laporan<br>
        <span style="color:#059669">Kasir</span> — hanya proses transaksi penjualan
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4">
          <i class="bi bi-person-plus me-1"></i> Buat Akun
        </button>
        <a href="<?= BASE_URL ?>/user/index" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>