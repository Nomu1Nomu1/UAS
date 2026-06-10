<?php
// view/transaksi/detail.php
ob_start();
$t = $transaksi;
$badgeClass = match($t['status']) {
  'Selesai' => 'badge-selesai',
  'Batal'   => 'badge-batal',
  default   => 'badge-pending'
};
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Detail Transaksi</h4>
    <p><span class="kode-text"><?= htmlspecialchars($t['no_trx']) ?></span></p>
  </div>
  <a href="<?= BASE_URL ?>/transaksi/index" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali
  </a>
</div>

<div class="row g-3">
  <!-- Info -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">Informasi Transaksi</div>
      <div class="card-body">
        <dl class="row g-0 mb-0" style="font-size:13px">
          <dt class="col-5 text-muted">No. Transaksi</dt>
          <dd class="col-7"><span class="kode-text" style="font-size:10px"><?= htmlspecialchars($t['no_trx']) ?></span></dd>

          <dt class="col-5 text-muted mt-2">Status</dt>
          <dd class="col-7 mt-2"><span class="badge <?= $badgeClass ?>"><?= $t['status'] ?></span></dd>

          <dt class="col-5 text-muted mt-2">Kasir</dt>
          <dd class="col-7 mt-2 fw-600"><?= htmlspecialchars($t['kasir']) ?></dd>

          <dt class="col-5 text-muted mt-2">Tanggal</dt>
          <dd class="col-7 mt-2"><?= date('d/m/Y H:i', strtotime($t['tanggal_transaksi'])) ?></dd>

          <?php if (!empty($t['keterangan'])): ?>
          <dt class="col-5 text-muted mt-2">Keterangan</dt>
          <dd class="col-7 mt-2"><?= htmlspecialchars($t['keterangan']) ?></dd>
          <?php endif; ?>
        </dl>

        <hr class="my-3">

        <div class="d-flex justify-content-between mb-2" style="font-size:13px">
          <span class="text-muted">Total Belanja</span>
          <span class="fw-700"><?= format_rupiah($t['total_harga']) ?></span>
        </div>
        <div class="d-flex justify-content-between mb-2" style="font-size:13px">
          <span class="text-muted">Bayar</span>
          <span><?= format_rupiah($t['bayar']) ?></span>
        </div>
        <div class="d-flex justify-content-between" style="font-size:14px">
          <span class="fw-600">Kembalian</span>
          <span class="fw-700" style="color:var(--success-color)"><?= format_rupiah($t['kembalian']) ?></span>
        </div>
      </div>
    </div>
  </div>

  <!-- Items -->
  <div class="col-lg-8">
    <div class="card table-card">
      <div class="card-header">Item Pembelian</div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Produk</th>
              <th>Satuan</th>
              <th class="text-end">Qty</th>
              <th class="text-end">Harga</th>
              <th class="text-end">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($details as $dt): ?>
            <tr>
              <td class="text-muted"><?= $no++ ?></td>
              <td>
                <div class="fw-600"><?= htmlspecialchars($dt['nama_barang']) ?></div>
                <div class="text-muted" style="font-size:11px"><?= htmlspecialchars($dt['kode_barang']) ?></div>
              </td>
              <td class="text-muted"><?= htmlspecialchars($dt['satuan']) ?></td>
              <td class="text-end"><?= $dt['qty'] ?></td>
              <td class="text-end"><?= format_rupiah($dt['harga_satuan']) ?></td>
              <td class="text-end fw-600"><?= format_rupiah($dt['subtotal']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5" class="text-end fw-700">Total</td>
              <td class="text-end fw-700" style="color:var(--primary)"><?= format_rupiah($t['total_harga']) ?></td>
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