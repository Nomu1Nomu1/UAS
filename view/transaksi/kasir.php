<?php ob_start(); ?>

<style>
    /* ===== KASIR PAGE ===== */
    .kasir-layout {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
        align-items: start;
    }

    /* Search */
    .search-box {
        position: relative;
        margin-bottom: 24px;
    }

    .search-box i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
    }

    .search-box input {
        width: 100%;
        padding: 14px 18px 14px 48px;
        border: 1.5px solid #e5e7eb;
        border-radius: 16px;
        font-size: 15px;
        background: #fff;
        color: #1e293b;
        outline: none;
        transition: border-color .2s;
    }

    .search-box input:focus {
        border-color: #2563eb;
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .product-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
        border: 2px solid transparent;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(37, 99, 235, .12);
        border-color: #2563eb;
    }

    .product-card.out-of-stock {
        opacity: .5;
        cursor: not-allowed;
        pointer-events: none;
    }

    .product-img {
        height: 140px;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-img i {
        font-size: 48px;
        color: #2563eb;
    }

    .product-info {
        padding: 14px;
    }

    .product-name {
        font-weight: 600;
        font-size: 14px;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .product-code {
        font-size: 12px;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-price {
        font-weight: 700;
        color: #2563eb;
        font-size: 15px;
    }

    .product-stock {
        font-size: 12px;
        color: #64748b;
    }

    /* Cart */
    .cart-panel {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        position: sticky;
        top: 20px;
        overflow: hidden;
    }

    .cart-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cart-header i {
        font-size: 20px;
        color: #1e293b;
    }

    .cart-header h5 {
        margin: 0;
        font-weight: 700;
        font-size: 16px;
    }

    .cart-badge {
        background: #2563eb;
        color: #fff;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        padding: 2px 8px;
        margin-left: auto;
    }

    .cart-empty {
        padding: 60px 24px;
        text-align: center;
        color: #94a3b8;
    }

    .cart-empty i {
        font-size: 48px;
        display: block;
        margin-bottom: 10px;
        opacity: .4;
    }

    .cart-items {
        padding: 16px;
        max-height: 320px;
        overflow-y: auto;
    }

    .cart-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        background: #f8fafc;
        border-radius: 14px;
        margin-bottom: 8px;
    }

    .cart-item-name {
        flex: 1;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }

    .cart-item-price {
        font-size: 12px;
        color: #64748b;
        display: block;
        margin-top: 2px;
    }

    .qty-control {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .qty-btn {
        width: 28px;
        height: 28px;
        border: none;
        border-radius: 8px;
        background: #e8f0ff;
        color: #2563eb;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .15s;
    }

    .qty-btn:hover {
        background: #2563eb;
        color: #fff;
    }

    .qty-num {
        font-weight: 700;
        font-size: 14px;
        min-width: 22px;
        text-align: center;
    }

    .cart-item-del {
        color: #ef4444;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        padding: 0 4px;
    }

    /* Summary */
    .cart-summary {
        padding: 16px 24px;
        border-top: 1px solid #f1f5f9;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .summary-row.total {
        font-weight: 700;
        font-size: 16px;
        color: #1e293b;
        border-top: 1px dashed #e5e7eb;
        padding-top: 12px;
        margin-top: 4px;
        margin-bottom: 16px;
    }

    /* Payment */
    .cart-payment {
        padding: 0 24px 24px;
    }

    .payment-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 6px;
        display: block;
    }

    .payment-input {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        outline: none;
        transition: border-color .2s;
    }

    .payment-input:focus {
        border-color: #2563eb;
    }

    .kembalian-box {
        background: #f0fdf4;
        border-radius: 12px;
        padding: 10px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }

    .kembalian-label {
        font-size: 13px;
        color: #16a34a;
        font-weight: 600;
    }

    .kembalian-val {
        font-size: 15px;
        font-weight: 700;
        color: #16a34a;
    }

    .keterangan-input {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        font-size: 13px;
        color: #64748b;
        resize: none;
        outline: none;
        margin-bottom: 14px;
        transition: border-color .2s;
    }

    .keterangan-input:focus {
        border-color: #2563eb;
    }

    .btn-bayar {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
    }

    .btn-bayar:hover {
        opacity: .9;
        transform: translateY(-1px);
    }

    .btn-bayar:disabled {
        opacity: .5;
        cursor: not-allowed;
        transform: none;
    }

    .product-card.hidden {
        display: none;
    }

    @media (max-width: 1100px) {
        .kasir-layout {
            grid-template-columns: 1fr 320px;
        }

        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<?php
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
?>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="fw-bold">Kasir / Transaksi</h1>
        <p class="text-secondary">Point of Sale sistem</p>
    </div>
    <a href="/UAS/?page=transaksi&action=index" class="btn btn-outline-secondary" style="border-radius:12px;">
        <i class="bi bi-list-ul me-1"></i> Riwayat Transaksi
    </a>
</div>

<?php if ($flash): ?>
    <div class="alert alert-info alert-dismissible fade show rounded-4 mb-4" role="alert">
        <i class="bi bi-info-circle me-2"></i><?= htmlspecialchars($flash) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="kasir-layout">
    <!-- PRODUK PANEL -->
    <div>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari produk atau scan barcode...">
        </div>

        <div class="product-grid" id="productGrid">
            <?php foreach ($products as $p): ?>
                <div class="product-card <?= $p['stock'] <= 0 ? 'out-of-stock' : '' ?>" data-id="<?= $p['id'] ?>"
                    data-name="<?= htmlspecialchars($p['nama_barang']) ?>"
                    data-code="<?= htmlspecialchars($p['kode_barang']) ?>" data-price="<?= $p['harga_jual'] ?>"
                    data-stock="<?= $p['stock'] ?>" data-satuan="<?= htmlspecialchars($p['satuan']) ?>"
                    data-search="<?= strtolower(htmlspecialchars($p['nama_barang'] . ' ' . $p['kode_barang'])) ?>"
                    onclick="addToCart(this)">
                    <div class="product-img">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <div class="product-info">
                        <div class="product-name"><?= htmlspecialchars($p['nama_barang']) ?></div>
                        <div class="product-code"><?= htmlspecialchars($p['kode_barang']) ?></div>
                        <div class="product-footer">
                            <span class="product-price">
                                Rp <?= number_format($p['harga_jual'] / 1000, 0, ',', '.') ?>k
                            </span>
                            <span class="product-stock">Stok: <?= $p['stock'] ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- CART PANEL -->
    <div class="cart-panel">
        <div class="cart-header">
            <i class="bi bi-cart3"></i>
            <h5>Keranjang</h5>
            <span class="cart-badge" id="cartCount">0</span>
        </div>

        <div id="cartEmpty" class="cart-empty">
            <i class="bi bi-cart3"></i>
            <p>Keranjang kosong</p>
        </div>

        <div id="cartItems" class="cart-items" style="display:none;"></div>

        <div id="cartSummary" class="cart-summary" style="display:none;">
            <div class="summary-row"><span>Subtotal</span><span id="summarySubtotal">Rp 0</span></div>
            <div class="summary-row total"><span>Total</span><span id="summaryTotal">Rp 0</span></div>
        </div>

        <div id="cartPayment" class="cart-payment" style="display:none;">
            <span class="payment-label">Jumlah Bayar</span>
            <input type="number" class="payment-input" id="bayarInput" placeholder="Masukkan nominal..." min="0"
                oninput="hitungKembalian()">

            <div class="kembalian-box">
                <span class="kembalian-label"><i class="bi bi-arrow-left-right me-1"></i>Kembalian</span>
                <span class="kembalian-val" id="kembalianVal">Rp 0</span>
            </div>

            <textarea class="keterangan-input" id="keteranganInput" rows="2"
                placeholder="Keterangan (opsional)..."></textarea>

            <button class="btn-bayar" id="btnBayar" onclick="submitTransaksi()" disabled>
                <i class="bi bi-bag-check me-2"></i>Proses Pembayaran
            </button>
        </div>
    </div>
</div>

<!-- Hidden form for submit -->
<form id="trxForm" action="/UAS/?page=transaksi&action=create" method="POST" style="display:none;">
    <input type="hidden" name="bayar" id="formBayar">
    <input type="hidden" name="keterangan" id="formKeterangan">
    <div id="formItems"></div>
</form>

<script>
    const cart = {};

    function formatRp(num) {
        return 'Rp ' + parseInt(num).toLocaleString('id-ID');
    }

    function addToCart(card) {
        const id = card.dataset.id;
        const name = card.dataset.name;
        const price = parseFloat(card.dataset.price);
        const stock = parseInt(card.dataset.stock);
        const code = card.dataset.code;

        if (cart[id]) {
            if (cart[id].qty >= stock) {
                alert('Stok tidak cukup!');
                return;
            }
            cart[id].qty++;
        } else {
            cart[id] = { id, name, price, stock, code, qty: 1 };
        }
        renderCart();
    }

    function changeQty(id, delta) {
        if (!cart[id]) return;
        cart[id].qty += delta;
        if (cart[id].qty <= 0) delete cart[id];
        else if (cart[id].qty > cart[id].stock) cart[id].qty = cart[id].stock;
        renderCart();
    }

    function removeFromCart(id) {
        delete cart[id];
        renderCart();
    }

    function renderCart() {
        const keys = Object.keys(cart);
        const count = keys.reduce((s, k) => s + cart[k].qty, 0);
        const total = keys.reduce((s, k) => s + cart[k].qty * cart[k].price, 0);

        document.getElementById('cartCount').textContent = count;

        if (keys.length === 0) {
            document.getElementById('cartEmpty').style.display = '';
            document.getElementById('cartItems').style.display = 'none';
            document.getElementById('cartSummary').style.display = 'none';
            document.getElementById('cartPayment').style.display = 'none';
            return;
        }

        document.getElementById('cartEmpty').style.display = 'none';
        document.getElementById('cartItems').style.display = '';
        document.getElementById('cartSummary').style.display = '';
        document.getElementById('cartPayment').style.display = '';

        let html = '';
        keys.forEach(id => {
            const item = cart[id];
            html += `
        <div class="cart-item">
            <div style="flex:1">
                <div class="cart-item-name">${item.name}</div>
                <span class="cart-item-price">${formatRp(item.price)} / satuan</span>
            </div>
            <div class="qty-control">
                <button class="qty-btn" onclick="changeQty('${id}', -1)">−</button>
                <span class="qty-num">${item.qty}</span>
                <button class="qty-btn" onclick="changeQty('${id}', 1)">+</button>
            </div>
            <button class="cart-item-del" onclick="removeFromCart('${id}')">
                <i class="bi bi-trash3"></i>
            </button>
        </div>`;
        });
        document.getElementById('cartItems').innerHTML = html;

        document.getElementById('summarySubtotal').textContent = formatRp(total);
        document.getElementById('summaryTotal').textContent = formatRp(total);

        hitungKembalian();
    }

    function hitungKembalian() {
        const total = Object.keys(cart).reduce((s, k) => s + cart[k].qty * cart[k].price, 0);
        const bayar = parseFloat(document.getElementById('bayarInput').value) || 0;
        const kembalian = bayar - total;
        const el = document.getElementById('kembalianVal');

        if (bayar >= total && total > 0) {
            el.textContent = formatRp(kembalian);
            el.style.color = '#16a34a';
            document.getElementById('btnBayar').disabled = false;
        } else {
            el.textContent = 'Rp 0';
            el.style.color = '#ef4444';
            document.getElementById('btnBayar').disabled = true;
        }
    }

    function submitTransaksi() {
        const bayar = parseFloat(document.getElementById('bayarInput').value) || 0;
        const keterangan = document.getElementById('keteranganInput').value;

        document.getElementById('formBayar').value = bayar;
        document.getElementById('formKeterangan').value = keterangan;

        let itemsHtml = '';
        Object.keys(cart).forEach((id, i) => {
            const item = cart[id];
            itemsHtml += `
            <input type="hidden" name="items[${i}][produk_id]"    value="${item.id}">
            <input type="hidden" name="items[${i}][qty]"          value="${item.qty}">
            <input type="hidden" name="items[${i}][harga_satuan]" value="${item.price}">
        `;
        });
        document.getElementById('formItems').innerHTML = itemsHtml;
        document.getElementById('trxForm').submit();
    }

    // Search
    document.getElementById('searchInput').addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('.product-card').forEach(card => {
            card.classList.toggle('hidden', q !== '' && !card.dataset.search.includes(q));
        });
    });
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>