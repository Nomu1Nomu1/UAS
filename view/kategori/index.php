<?php
// view/kategori/index.php
$role = strtolower($_SESSION['users']['role'] ?? 'kasir');
ob_start();
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Kategori Produk</h4>
    <p>Kelompokkan produk berdasarkan kategori</p>
  </div>
  <?php if (in_array($role, ['owner','admin'])): ?>
  <a href="<?= BASE_URL ?>/kategori/create" class="btn btn-primary">
    <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
  </a>
  <?php endif; ?>
</div>

<div class="card table-card">
  <div class="card-header">
    <span><i class="bi bi-tag me-2 text-muted"></i>Daftar Kategori
      <span class="badge bg-primary ms-1"><?= count($kategoris) ?></span>
    </span>
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Kategori</th>
          <th>Deskripsi</th>
          <th>Jumlah Produk</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($kategoris)): ?>
          <tr>
            <td colspan="5" class="text-center text-muted py-5">
              <i class="bi bi-tag d-block mb-2" style="font-size:32px;opacity:.2"></i>
              Belum ada kategori
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($kategoris as $i => $k): ?>
          <tr>
            <td class="text-muted"><?= $i + 1 ?></td>
            <td class="fw-600"><?= htmlspecialchars($k['nama_kategori']) ?></td>
            <td class="text-muted" style="font-size:12px"><?= htmlspecialchars($k['deskripsi'] ?? '—') ?></td>
            <td>
              <span class="badge" style="background:var(--primary-light);color:var(--primary)">
                <?= $k['jumlah_produk'] ?> produk
              </span>
            </td>
            <td>
              <?php if (in_array($role, ['owner','admin'])): ?>
              <div class="d-flex gap-1">
                <a href="<?= BASE_URL ?>/kategori/edit?id=<?= $k['id'] ?>" class="btn btn-icon btn-outline-primary" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                <a href="<?= BASE_URL ?>/kategori/delete?id=<?= $k['id'] ?>"
                   class="btn btn-icon btn-outline-danger" title="Hapus"
                   data-confirm="Yakin ingin menghapus kategori ini?">
                  <i class="bi bi-trash3"></i>
                </a>
              </div>
              <?php else: ?>
                <span class="text-muted" style="font-size:12px">—</span>
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