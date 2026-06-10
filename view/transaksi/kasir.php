<?php
// view/transaksi/kasir.php
ob_start();
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Kasir / POS</h4>
    <p>Proses transaksi penjualan</p>
  </div>
  <a href="<?= BASE_URL ?>/transaksi/index" class="btn btn-outline-secondary">
    <i class="bi bi-receipt me-1"></i> Riwayat
  </a>
</div>

<div class="kasir-grid">

  <!-- Product Grid -->
  <div>
    <div class="filter-bar mb-3" style="padding:10px 12px">
      <input type="text" id="productSearch" class="form-control" placeholder="Cari produk...">
    </div>
    <div class="product-grid" id="productGrid">
      <?php foreach ($products as $p): ?>
        <div class="product-tile"
             data-id="<?= $p['id'] ?>"
             data-nama="<?= htmlspecialchars($p['nama_barang']) ?>"
             data-harga="<?= $p['harga_jual'] ?>"
             data-stok="<?= $p['stock'] ?>"
             data-satuan="<?= htmlspecialchars($p['satuan']) ?>"
             data-search="<?= strtolower(htmlspecialchars($p['nama_barang'] . ' ' . $p['kode_barang'])) ?>">
          <div class="p-name"><?= htmlspecialchars($p['nama_barang']) ?></div>
          <div class="p-price"><?= format_rupiah($p['harga_jual']) ?></div>
          <div class="p-stock text-muted">Stok: <?= $p['stock'] ?> <?= htmlspecialchars($p['satuan']) ?></div>
        </div>
      <?php endforeach; ?>
      <?php if (empty($products)): ?>
        <div class="text-center text-muted py-5 w-100">
          <i class="bi bi-inbox d-block mb-2" style="font-size:32px;opacity:.2"></i>
          Tidak ada produk tersedia
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Cart Panel -->
  <div>
    <form id="kasirForm" method="POST" action="<?= BASE_URL ?>/transaksi/create">
      <input type="hidden" id="itemsHidden" name="_total">

      <div class="card" style="display:flex;flex-direction:column;height:100%">
        <!-- Cart Header -->
        <div class="card-header">
          <span><i class="bi bi-cart3 me-2"></i>Keranjang
            <span class="badge bg-primary" id="cartCount"></span>
          </span>
        </div>

        <!-- Cart Items -->
        <div class="cart-items" style="flex:1;overflow-y:auto;max-height:320px">
          <table class="table mb-0" style="font-size:13px">
            <tbody id="cartBody"></tbody>
          </table>
        </div>

        <!-- Summary -->
        <div class="card-body border-top py-3">
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Total</span>
            <span class="fw-700" style="font-size:16px;color:var(--primary)" id="cartTotal">Rp 0</span>
          </div>

          <div class="mb-3">
            <label class="form-label">Bayar (Rp)</label>
            <input type="number" name="bayar" id="bayarInput" class="form-control"
                   min="0" step="500" placeholder="0" required>
          </div>

          <div class="d-flex justify-content-between mb-3">
            <span class="text-muted" style="font-size:13px">Kembalian</span>
            <span class="fw-700" id="kembalianEl">Rp 0</span>
          </div>

          <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control form-control-sm"
                   placeholder="Catatan transaksi (opsional)">
          </div>

          <button type="submit" class="btn btn-primary w-100 py-2 fw-600">
            <i class="bi bi-cash-coin me-1"></i> Proses Transaksi
          </button>
        </div>
      </div>
    </form>
  </div>

</div>

<script>
// Live search filter for products
document.getElementById('productSearch')?.addEventListener('input', function () {
  const q = this.value.toLowerCase();
  document.querySelectorAll('.product-tile').forEach(tile => {
    tile.style.display = tile.dataset.search.includes(q) ? '' : 'none';
  });
});
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>