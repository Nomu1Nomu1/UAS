<?php
// view/pengadaan/create.php
ob_start();
?>

<div class="page-header">
  <div class="page-header-left">
    <h4>Buat Pengadaan</h4>
    <p>Tambah order pembelian stok baru</p>
  </div>
  <a href="<?= BASE_URL ?>/pengadaan/index" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali
  </a>
</div>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger d-flex gap-2 align-items-center" style="font-size:13px;border-radius:10px">
    <i class="bi bi-exclamation-circle-fill"></i> <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<form method="POST" action="<?= BASE_URL ?>/pengadaan/create">
<div class="row g-3">

  <!-- Left: info -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">Informasi Pengadaan</div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label">Distributor <span class="text-danger">*</span></label>
          <select name="distributor_id" class="form-select" required>
            <option value="">Pilih Distributor</option>
            <?php foreach ($distribs as $d): ?>
              <option value="<?= $d['id'] ?>" <?= ((int)($_POST['distributor_id'] ?? 0) == $d['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($d['nama_distributor']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Keterangan</label>
          <textarea name="keterangan" class="form-control" rows="3"
                    placeholder="Catatan pesanan (opsional)"><?= htmlspecialchars($_POST['keterangan'] ?? '') ?></textarea>
        </div>
        <!-- Grand Total -->
        <div class="p-3 rounded-2 text-center" style="background:var(--primary-light)">
          <div style="font-size:11px;font-weight:600;text-transform:uppercase;color:var(--text-muted)">Total Pengadaan</div>
          <div class="fw-700" style="font-size:22px;color:var(--primary);margin-top:4px" id="grandTotal">Rp 0</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Right: items -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <span>Item Produk</span>
        <button type="button" class="btn btn-sm btn-outline-primary" id="addItemBtn">
          <i class="bi bi-plus me-1"></i> Tambah Item
        </button>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th style="width:30px">#</th>
                <th>Produk</th>
                <th style="width:80px">Qty</th>
                <th style="width:140px">Harga Satuan</th>
                <th style="width:120px">Subtotal</th>
                <th style="width:36px"></th>
              </tr>
            </thead>
            <tbody id="itemContainer">
              <!-- Row 1 (default) -->
              <tr class="item-row">
                <td class="text-muted row-num">1</td>
                <td>
                  <select name="items[0][produk_id]" class="form-select form-select-sm item-produk" required>
                    <option value="">Pilih Produk</option>
                    <?php foreach ($products as $p): ?>
                      <option value="<?= $p['id'] ?>" data-harga="<?= $p['harga_beli'] ?>">
                        <?= htmlspecialchars($p['nama_barang'] . ' (' . $p['kode_barang'] . ')') ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </td>
                <td>
                  <input type="number" name="items[0][qty]" class="form-control form-control-sm item-qty"
                         min="1" value="1" required>
                </td>
                <td>
                  <input type="number" name="items[0][harga_satuan]" class="form-control form-control-sm item-harga"
                         min="0" step="100" value="0" required>
                </td>
                <td class="fw-600 item-subtotal text-end" style="font-size:12px">Rp 0</td>
                <td>
                  <button type="button" class="btn btn-icon btn-sm btn-outline-danger remove-row" title="Hapus baris">
                    <i class="bi bi-trash3"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-body pt-3 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary px-4">
          <i class="bi bi-send me-1"></i> Kirim Pengadaan
        </button>
      </div>
    </div>
  </div>

</div>
</form>

<!-- Row Template -->
<template id="itemRowTemplate">
  <tr class="item-row">
    <td class="text-muted row-num"></td>
    <td>
      <select data-name="items[__IDX__][produk_id]" class="form-select form-select-sm item-produk" required>
        <option value="">Pilih Produk</option>
        <?php foreach ($products as $p): ?>
          <option value="<?= $p['id'] ?>" data-harga="<?= $p['harga_beli'] ?>">
            <?= htmlspecialchars($p['nama_barang'] . ' (' . $p['kode_barang'] . ')') ?>
          </option>
        <?php endforeach; ?>
      </select>
    </td>
    <td>
      <input type="number" data-name="items[__IDX__][qty]" class="form-control form-control-sm item-qty"
             min="1" value="1" required>
    </td>
    <td>
      <input type="number" data-name="items[__IDX__][harga_satuan]" class="form-control form-control-sm item-harga"
             min="0" step="100" value="0" required>
    </td>
    <td class="fw-600 item-subtotal text-end" style="font-size:12px">Rp 0</td>
    <td>
      <button type="button" class="btn btn-icon btn-sm btn-outline-danger remove-row">
        <i class="bi bi-trash3"></i>
      </button>
    </td>
  </tr>
</template>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>