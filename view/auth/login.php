<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — StokKu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="<?= BASE_URL ?>/assets/css/custom.css" rel="stylesheet">
</head>
<body class="login-page">

<div class="login-card">

  <!-- Brand -->
  <div class="login-brand">
    <div class="login-logo">
      <i class="bi bi-boxes"></i>
    </div>
    <h4 class="fw-700 mb-1" style="font-size:20px">StokKu</h4>
    <p class="text-muted mb-0" style="font-size:13px">Sistem Inventaris UMKM</p>
  </div>

  <!-- Error Alert -->
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 mb-3" style="font-size:13px;border-radius:8px">
      <i class="bi bi-exclamation-circle-fill"></i>
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <!-- Form -->
  <form method="POST" action="<?= BASE_URL ?>/auth/login">

    <div class="mb-3">
      <label class="form-label">Username</label>
      <div class="input-group">
        <span class="input-group-text bg-white border-end-0" style="border-color:#E5E9F2">
          <i class="bi bi-person text-muted"></i>
        </span>
        <input
          type="text"
          name="username"
          class="form-control border-start-0"
          placeholder="Masukkan username"
          value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
          autocomplete="username"
          required
          style="border-color:#E5E9F2"
        >
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label">Password</label>
      <div class="input-group">
        <span class="input-group-text bg-white border-end-0" style="border-color:#E5E9F2">
          <i class="bi bi-lock text-muted"></i>
        </span>
        <input
          type="password"
          name="password"
          id="passwordInput"
          class="form-control border-start-0 border-end-0"
          placeholder="Masukkan password"
          autocomplete="current-password"
          required
          style="border-color:#E5E9F2"
        >
        <button
          type="button"
          class="input-group-text bg-white"
          onclick="togglePassword()"
          style="border-color:#E5E9F2;cursor:pointer"
          title="Tampilkan password"
        >
          <i class="bi bi-eye" id="eyeIcon"></i>
        </button>
      </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2" style="font-size:14px;font-weight:600">
      <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
    </button>

  </form>

  <p class="text-center text-muted mt-4 mb-0" style="font-size:11px">
    © <?= date('Y') ?> StokKu · Inventaris UMKM
  </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword() {
  const input = document.getElementById('passwordInput');
  const icon  = document.getElementById('eyeIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.className = 'bi bi-eye-slash';
  } else {
    input.type = 'password';
    icon.className = 'bi bi-eye';
  }
}
</script>
</body>
</html>