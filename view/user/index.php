<?php ob_start(); ?>

<div class="mb-4">
    <h1 class="fw-bold">Manajemen User</h1>
    <p class="text-secondary">Kelola semua user yang menggunakan aplikasi</p>
</div>

<div class="page-card">
    Halaman kategori dalam pengembangan
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>