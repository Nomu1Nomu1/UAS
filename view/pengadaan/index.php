<?php
// view/pengadaan/index.php
$role = strtolower($_SESSION['users']['role'] ?? 'kasir');
ob_start();
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Data Pengadaan</h4>
    <p>Kelola pembelian stok dari distributor</p>
  </div>
  <?php if (in_array($role, ['owner','admin'])): ?>
  <a href="<?= BASE_URL ?>/pengadaan/create" class="btn btn-primary">
    <i class="bi bi-clipboard-plus me-1"></i> Buat Pengadaan
  </a>
  <?php endif; ?>
</div>

<!-- Filter -->
<form method="GET" action="<?= BASE_URL ?>/pengadaan/index" class="filter-bar">
  <input type="text" name="search" class="form-control"
         placeholder="Cari no. pengadaan / distributor..."
         value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
  <select name="status" class="form-select" style="max-width:160px">
    <option value="">Semua Status</option>
    <?php foreach (['Pending','Diterima','Dibatalkan'] as $s): ?>
      <option value="<?= $s ?>" <?= ($_GET['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i>Cari</button>
  <a href="<?= BASE_URL ?>/pengadaan/index" class="btn btn-outline-secondary">Reset</a>
</form>

<div class="card table-card">
  <div class="card-header">
    <span><i class="bi bi-clipboard-check me-2 text-muted"></i>Daftar Pengadaan
      <span class="badge bg-primary ms-1"><?= count($pengadaans) ?></span>
    </span>
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>No. Pengadaan</th>
          <th>Distributor</th>
          <th>Dibuat Oleh</th>
          <th>Tanggal</th>
          <th>Total</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($pengadaans)): ?>
          <tr>
            <td colspan="7" class="text-center text-muted py-5">
              <i class="bi bi-clipboard d-block mb-2" style="font-size:32px;opacity:.2"></i>
              Belum ada data pengadaan
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($pengadaans as $pg): ?>
          <tr>
            <td><span class="kode-text"><?= htmlspecialchars($pg['no_pengadaan']) ?></span></td>
            <td class="fw-600"><?= htmlspecialchars($pg['nama_distributor']) ?></td>
            <td class="text-muted" style="font-size:12px"><?= htmlspecialchars($pg['user_nama']) ?></td>
            <td class="text-muted" style="font-size:12px">
              <?= date('d/m/Y', strtotime($pg['tanggal_pengadaan'])) ?>
            </td>
            <td class="fw-600"><?= format_rupiah($pg['total_harga']) ?></td>
            <td>
              <?php
              $badgeClass = match($pg['status']) {
                'Diterima'   => 'badge-diterima',
                'Dibatalkan' => 'badge-dibatalkan',
                default      => 'badge-pending'
              };
              ?>
              <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($pg['status']) ?></span>
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="<?= BASE_URL ?>/pengadaan/detail?id=<?= $pg['id'] ?>" class="btn btn-icon btn-outline-secondary" title="Detail">
                  <i class="bi bi-eye"></i>
                </a>
                <?php if ($pg['status'] === 'Pending' && in_array($role, ['owner','admin'])): ?>
                <a href="<?= BASE_URL ?>/pengadaan/terima?id=<?= $pg['id'] ?>"
                   class="btn btn-icon btn-outline-success" title="Terima"
                   data-confirm="Terima pengadaan ini dan tambahkan stok?">
                  <i class="bi bi-check-lg"></i>
                </a>
                <a href="<?= BASE_URL ?>/pengadaan/batal?id=<?= $pg['id'] ?>"
                   class="btn btn-icon btn-outline-danger" title="Batalkan"
                   data-confirm="Batalkan pengadaan ini?">
                  <i class="bi bi-x-lg"></i>
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