<?php
// view/transaksi/index.php
$role = strtolower($_SESSION['users']['role'] ?? 'kasir');
ob_start();
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Riwayat Transaksi</h4>
    <p>Semua riwayat penjualan</p>
  </div>
  <a href="<?= BASE_URL ?>/transaksi/kasir" class="btn btn-primary">
    <i class="bi bi-cart3 me-1"></i> Buka Kasir
  </a>
</div>

<!-- Filter -->
<form method="GET" action="<?= BASE_URL ?>/transaksi/index" class="filter-bar">
  <input type="text" name="search" class="form-control"
         placeholder="Cari no. transaksi / kasir..."
         value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
  <input type="date" name="tanggal" class="form-control" style="max-width:160px"
         value="<?= htmlspecialchars($_GET['tanggal'] ?? '') ?>">
  <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i>Cari</button>
  <a href="<?= BASE_URL ?>/transaksi/index" class="btn btn-outline-secondary">Reset</a>
</form>

<div class="card table-card">
  <div class="card-header">
    <span><i class="bi bi-receipt me-2 text-muted"></i>Transaksi
      <span class="badge bg-primary ms-1"><?= count($transaksis) ?></span>
    </span>
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>No. Transaksi</th>
          <th>Kasir</th>
          <th>Tanggal</th>
          <th class="text-end">Total</th>
          <th class="text-end">Bayar</th>
          <th class="text-end">Kembalian</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($transaksis)): ?>
          <tr>
            <td colspan="8" class="text-center text-muted py-5">
              <i class="bi bi-receipt d-block mb-2" style="font-size:32px;opacity:.2"></i>
              Tidak ada transaksi ditemukan
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($transaksis as $t): ?>
          <tr>
            <td><span class="kode-text"><?= htmlspecialchars($t['no_trx']) ?></span></td>
            <td><?= htmlspecialchars($t['kasir']) ?></td>
            <td class="text-muted" style="font-size:12px">
              <?= date('d/m/Y H:i', strtotime($t['tanggal_transaksi'])) ?>
            </td>
            <td class="text-end fw-600"><?= format_rupiah($t['total_harga']) ?></td>
            <td class="text-end"><?= format_rupiah($t['bayar']) ?></td>
            <td class="text-end"><?= format_rupiah($t['kembalian']) ?></td>
            <td>
              <?php
              $badgeClass = match($t['status']) {
                'Selesai' => 'badge-selesai',
                'Batal'   => 'badge-batal',
                default   => 'badge-pending'
              };
              ?>
              <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($t['status']) ?></span>
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="<?= BASE_URL ?>/transaksi/detail?id=<?= $t['id'] ?>" class="btn btn-icon btn-outline-secondary" title="Detail">
                  <i class="bi bi-eye"></i>
                </a>
                <?php if ($t['status'] === 'Selesai' && in_array($role, ['owner','admin'])): ?>
                <a href="<?= BASE_URL ?>/transaksi/batal?id=<?= $t['id'] ?>"
                   class="btn btn-icon btn-outline-danger" title="Batalkan"
                   data-confirm="Batalkan transaksi dan kembalikan stok?">
                  <i class="bi bi-x-circle"></i>
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