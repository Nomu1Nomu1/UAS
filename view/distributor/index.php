<?php
// view/distributor/index.php
$role = strtolower($_SESSION['users']['role'] ?? 'kasir');
ob_start();
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Data Distributor</h4>
    <p>Kelola pemasok produk Anda</p>
  </div>
  <?php if (in_array($role, ['owner','admin'])): ?>
  <a href="<?= BASE_URL ?>/distributor/create" class="btn btn-primary">
    <i class="bi bi-plus-lg me-1"></i> Tambah Distributor
  </a>
  <?php endif; ?>
</div>

<!-- Filter -->
<form method="GET" action="<?= BASE_URL ?>/distributor/index" class="filter-bar">
  <input type="text" name="search" class="form-control"
         placeholder="Cari nama, alamat, no. HP..."
         value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
  <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i>Cari</button>
  <a href="<?= BASE_URL ?>/distributor/index" class="btn btn-outline-secondary">Reset</a>
</form>

<div class="card table-card">
  <div class="card-header">
    <span><i class="bi bi-truck me-2 text-muted"></i>Daftar Distributor
      <span class="badge bg-primary ms-1"><?= count($distributors) ?></span>
    </span>
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Distributor</th>
          <th>Alamat</th>
          <th>No. HP</th>
          <th>Email</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($distributors)): ?>
          <tr>
            <td colspan="6" class="text-center text-muted py-5">
              <i class="bi bi-truck d-block mb-2" style="font-size:32px;opacity:.2"></i>
              Belum ada distributor
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($distributors as $i => $d): ?>
          <tr>
            <td class="text-muted"><?= $i + 1 ?></td>
            <td class="fw-600"><?= htmlspecialchars($d['nama_distributor']) ?></td>
            <td class="text-muted" style="font-size:12px"><?= htmlspecialchars($d['alamat'] ?? '—') ?></td>
            <td style="font-size:12px"><?= htmlspecialchars($d['no_hp'] ?? '—') ?></td>
            <td class="text-muted" style="font-size:12px"><?= htmlspecialchars($d['email'] ?? '—') ?></td>
            <td>
              <?php if (in_array($role, ['owner','admin'])): ?>
              <div class="d-flex gap-1">
                <a href="<?= BASE_URL ?>/distributor/edit?id=<?= $d['id'] ?>" class="btn btn-icon btn-outline-primary" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                <a href="<?= BASE_URL ?>/distributor/delete?id=<?= $d['id'] ?>"
                   class="btn btn-icon btn-outline-danger" title="Hapus"
                   data-confirm="Yakin hapus distributor ini?">
                  <i class="bi bi-trash3"></i>
                </a>
              </div>
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