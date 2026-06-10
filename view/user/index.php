<?php
// view/user/index.php
ob_start();
$currentUserId = (int)$_SESSION['users']['id'];
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Manajemen User</h4>
    <p>Kelola akun pengguna aplikasi</p>
  </div>
  <a href="<?= BASE_URL ?>/user/create" class="btn btn-primary">
    <i class="bi bi-person-plus me-1"></i> Tambah User
  </a>
</div>

<div class="card table-card">
  <div class="card-header">
    <span><i class="bi bi-people me-2 text-muted"></i>Daftar User
      <span class="badge bg-primary ms-1"><?= count($users) ?></span>
    </span>
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Role</th>
          <th>Email</th>
          <th>No. HP</th>
          <th>Status</th>
          <th>Terdaftar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($users)): ?>
          <tr>
            <td colspan="9" class="text-center text-muted py-5">Belum ada user</td>
          </tr>
        <?php else: ?>
          <?php foreach ($users as $i => $u): ?>
          <?php $isSelf = (int)$u['user_id'] === $currentUserId; ?>
          <tr>
            <td class="text-muted"><?= $i + 1 ?></td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <div class="user-avatar" style="width:28px;height:28px;font-size:11px">
                  <?= strtoupper(substr($u['nama'], 0, 1)) ?>
                </div>
                <span class="fw-600"><?= htmlspecialchars($u['nama']) ?></span>
                <?php if ($isSelf): ?>
                  <span class="badge" style="background:#E0E7FF;color:#4F46E5;font-size:9px">Anda</span>
                <?php endif; ?>
              </div>
            </td>
            <td class="text-muted" style="font-size:12px"><?= htmlspecialchars($u['username']) ?></td>
            <td>
              <span class="badge user-role badge-role-<?= strtolower($u['role']) ?>">
                <?= ucfirst($u['role']) ?>
              </span>
            </td>
            <td class="text-muted" style="font-size:12px"><?= htmlspecialchars($u['email'] ?? '—') ?></td>
            <td style="font-size:12px"><?= htmlspecialchars($u['no_hp'] ?? '—') ?></td>
            <td>
              <?php if ($u['is_active'] === 'Y'): ?>
                <span class="badge badge-selesai">Aktif</span>
              <?php else: ?>
                <span class="badge badge-batal">Nonaktif</span>
              <?php endif; ?>
            </td>
            <td class="text-muted" style="font-size:12px">
              <?= date('d/m/Y', strtotime($u['createdAt'])) ?>
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="<?= BASE_URL ?>/user/edit?id=<?= $u['user_id'] ?>" class="btn btn-icon btn-outline-primary" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                <?php if (!$isSelf): ?>
                <a href="<?= BASE_URL ?>/user/toggleAktif?id=<?= $u['user_id'] ?>"
                   class="btn btn-icon btn-outline-warning"
                   title="<?= $u['is_active'] === 'Y' ? 'Nonaktifkan' : 'Aktifkan' ?>"
                   data-confirm="<?= $u['is_active'] === 'Y' ? 'Nonaktifkan' : 'Aktifkan' ?> user ini?">
                  <i class="bi bi-<?= $u['is_active'] === 'Y' ? 'toggle-on' : 'toggle-off' ?>"></i>
                </a>
                <a href="<?= BASE_URL ?>/user/delete?id=<?= $u['user_id'] ?>"
                   class="btn btn-icon btn-outline-danger" title="Hapus"
                   data-confirm="Yakin hapus user <?= htmlspecialchars($u['nama']) ?>?">
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