<?php ob_start(); ?>

<div class="mb-4">
    <h1 class="fw-bold">Laporan</h1>
    <p class="text-secondary">Analisis penjualan dan inventaris</p>
</div>

<div class="page-card">
    Halaman kategori dalam pengembangan
</div>

<?php
$content = ob_get_clean();
require_once '../layouts/main.php';
?>