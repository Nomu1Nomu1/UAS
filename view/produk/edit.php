<?php ob_start(); ?>

<div class="mb-4">
    <a href="/UAS/?page=product&action=index"
       class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left"></i>
        Kembali ke Data Produk
    </a>

    <h1 class="fw-bold mt-2">Edit Produk</h1>
    <p class="text-secondary mb-0">
        Perbarui data produk inventaris
    </p>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4">
        <i class="bi bi-exclamation-circle me-2"></i>
        <?= htmlspecialchars($error) ?>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card-section">

    <form method="POST">

        <div class="row g-3">

            <div class="col-md-4">
                <label class="form-label fw-semibold small">
                    Kode Barang
                    <span class="text-danger">*</span>
                </label>

                <input type="text"
                       name="kode_barang"
                       class="form-control"
                       style="border-radius:12px;"
                       value="<?= htmlspecialchars($_POST['kode_barang'] ?? $product['kode_barang']) ?>"
                       required>
            </div>

            <div class="col-md-8">
                <label class="form-label fw-semibold small">
                    Nama Barang
                    <span class="text-danger">*</span>
                </label>

                <input type="text"
                       name="nama_barang"
                       class="form-control"
                       style="border-radius:12px;"
                       value="<?= htmlspecialchars($_POST['nama_barang'] ?? $product['nama_barang']) ?>"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">
                    Kategori
                    <span class="text-danger">*</span>
                </label>

                <select name="kategori_id"
                        class="form-select"
                        style="border-radius:12px;"
                        required>

                    <?php foreach ($kategoris as $k): ?>
                        <option value="<?= $k['id'] ?>"
                            <?= (($product['kategori_id'] ?? 0) == $k['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($k['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">
                    Distributor
                    <span class="text-danger">*</span>
                </label>

                <select name="distributor_id"
                        class="form-select"
                        style="border-radius:12px;"
                        required>

                    <?php foreach ($distribs as $d): ?>
                        <option value="<?= $d['id'] ?>"
                            <?= (($product['distributor_id'] ?? 0) == $d['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d['nama_distributor']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold small">
                    Stok
                </label>

                <input type="number"
                       name="stock"
                       class="form-control"
                       style="border-radius:12px;"
                       value="<?= htmlspecialchars($_POST['stock'] ?? $product['stock']) ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold small">
                    Stok Minimum
                </label>

                <input type="number"
                       name="stock_min"
                       class="form-control"
                       style="border-radius:12px;"
                       value="<?= htmlspecialchars($_POST['stock_min'] ?? $product['stock_min']) ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold small">
                    Harga Beli
                </label>

                <input type="number"
                       name="harga_beli"
                       class="form-control"
                       style="border-radius:12px;"
                       value="<?= htmlspecialchars($_POST['harga_beli'] ?? $product['harga_beli']) ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold small">
                    Harga Jual
                </label>

                <input type="number"
                       name="harga_jual"
                       class="form-control"
                       style="border-radius:12px;"
                       value="<?= htmlspecialchars($_POST['harga_jual'] ?? $product['harga_jual']) ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold small">
                    Satuan
                    <span class="text-danger">*</span>
                </label>

                <input type="text"
                       name="satuan"
                       class="form-control"
                       style="border-radius:12px;"
                       value="<?= htmlspecialchars($_POST['satuan'] ?? $product['satuan']) ?>"
                       required>
            </div>

            <div class="col-md-8">
                <label class="form-label fw-semibold small">
                    Deskripsi
                </label>

                <textarea name="deskripsi"
                          rows="3"
                          class="form-control"
                          style="border-radius:12px;"><?= htmlspecialchars($_POST['deskripsi'] ?? $product['deskripsi']) ?></textarea>
            </div>

        </div>

        <div class="mt-4 d-flex gap-2">

            <button type="submit"
                    class="btn btn-warning px-4"
                    style="border-radius:12px; font-weight:600;">
                <i class="bi bi-pencil-square me-2"></i>
                Update Produk
            </button>

            <a href="/UAS/?page=product&action=index"
               class="btn btn-outline-secondary px-4"
               style="border-radius:12px;">
                Batal
            </a>

        </div>

    </form>

</div>

<?php
$content = ob_get_clean();
$title = 'Edit Produk';
$pageTitle = 'Edit Produk';
require_once __DIR__ . '/../layouts/main.php';
?>