<?php
// view/pengadaan/detail.php
ob_start();
$pg   = $pengadaan;
$role = strtolower($_SESSION['users']['role'] ?? 'kasir');
$badgeClass = match($pg['status']) {
  'Diterima'   => 'badge-diterima',
  'Dibatalkan' => 'badge-dibatalkan',
  default      => 'badge-pending'
};
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Detail Pengadaan</h4>
    <p><span class="kode-text"><?= htmlspecialchars($pg['no_pengadaan']) ?></span></p>
  </div>
  <a href="<?= BASE_URL ?>/pengadaan/index" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali
  </a>
</div>

<div class="row g-3">
  <!-- Info Card -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">Informasi</div>
      <div class="card-body">
        <dl class="row g-0 mb-0" style="font-size:13px">
          <dt class="col-5 text-muted fw-500">No. Pengadaan</dt>
          <dd class="col-7"><span class="kode-text"><?= htmlspecialchars($pg['no_pengadaan']) ?></span></dd>

          <dt class="col-5 text-muted fw-500 mt-2">Status</dt>
          <dd class="col-7 mt-2"><span class="badge <?= $badgeClass ?>"><?= $pg['status'] ?></span></dd>

          <dt class="col-5 text-muted fw-500 mt-2">Distributor</dt>
          <dd class="col-7 mt-2 fw-600"><?= htmlspecialchars($pg['nama_distributor']) ?></dd>

          <dt class="col-5 text-muted fw-500 mt-2">No. HP Dist.</dt>
          <dd class="col-7 mt-2"><?= htmlspecialchars($pg['dist_no_hp'] ?? '—') ?></dd>

          <dt class="col-5 text-muted fw-500 mt-2">Dibuat Oleh</dt>
          <dd class="col-7 mt-2"><?= htmlspecialchars($pg['user_nama']) ?></dd>

          <dt class="col-5 text-muted fw-500 mt-2">Tanggal</dt>
          <dd class="col-7 mt-2"><?= date('d/m/Y H:i', strtotime($pg['tanggal_pengadaan'])) ?></dd>

          <?php if (!empty($pg['keterangan'])): ?>
          <dt class="col-5 text-muted fw-500 mt-2">Keterangan</dt>
          <dd class="col-7 mt-2"><?= htmlspecialchars($pg['keterangan']) ?></dd>
          <?php endif; ?>
        </dl>

        <?php if ($pg['status'] === 'Pending' && in_array($role, ['owner','admin'])): ?>
        <div class="d-flex gap-2 mt-4">
          <a href="<?= BASE_URL ?>/pengadaan/terima?id=<?= $pg['id'] ?>"
             class="btn btn-success flex-fill"
             data-confirm="Terima pengadaan dan update stok?">
            <i class="bi bi-check-circle me-1"></i> Terima
          </a>
          <a href="<?= BASE_URL ?>/pengadaan/batal?id=<?= $pg['id'] ?>"
             class="btn btn-outline-danger flex-fill"
             data-confirm="Batalkan pengadaan ini?">
            Batalkan
          </a>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Items Table -->
  <div class="col-lg-8">
    <div class="card table-card">
      <div class="card-header">Item Produk</div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Kode</th>
              <th>Nama Produk</th>
              <th>Satuan</th>
              <th class="text-end">Qty</th>
              <th class="text-end">Harga Satuan</th>
              <th class="text-end">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($details as $dt): ?>
            <tr>
              <td class="text-muted"><?= $no++ ?></td>
              <td><span class="kode-text"><?= htmlspecialchars($dt['kode_barang']) ?></span></td>
              <td class="fw-600"><?= htmlspecialchars($dt['nama_barang']) ?></td>
              <td class="text-muted"><?= htmlspecialchars($dt['satuan']) ?></td>
              <td class="text-end"><?= $dt['qty'] ?></td>
              <td class="text-end"><?= format_rupiah($dt['harga_satuan']) ?></td>
              <td class="text-end fw-600"><?= format_rupiah($dt['subtotal']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="6" class="text-end fw-700">Total</td>
              <td class="text-end fw-700" style="color:var(--primary)"><?= format_rupiah($pg['total_harga']) ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>