<?php ob_start(); ?>

<div class="mb-4">
    <h1 class="fw-bold">Dashboard</h1>
    <p class="text-secondary">Ringkasan sistem inventaris UMKM</p>
</div>

<div class="page-card">
    Halaman kategori dalam pengembangan
</div>

<?php
$content = ob_get_clean();
require_once '../layouts/main.php';
?>