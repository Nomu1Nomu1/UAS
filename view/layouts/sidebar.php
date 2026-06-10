<?php
$currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base        = trim(defined('BASE_URL') ? BASE_URL : '', '/');
$segment     = ltrim(str_replace($base, '', '/' . $currentPath), '/');
// e.g. "dashboard/index", "product/index", etc.
$parts       = explode('/', $segment);
$controller  = strtolower($parts[0] ?? '');

$role = strtolower($_SESSION['users']['role'] ?? 'kasir');

function navItem(string $href, string $icon, string $label, string $ctrl, string $active): string {
    $isActive = $ctrl === $active ? 'active' : '';
    return <<<HTML
    <li class="nav-item">
        <a href="{$href}" class="nav-link {$isActive}">
            <span class="nav-icon"><i class="bi {$icon}"></i></span>
            <span class="nav-label">{$label}</span>
        </a>
    </li>
    HTML;
}
?>

<aside class="sidebar" id="sidebar">
    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="brand-logo">
            <i class="bi bi-boxes"></i>
        </div>
        <div class="brand-text">
            <span class="brand-name">StokKu</span>
            <span class="brand-sub">Inventaris UMKM</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">

        <div class="nav-section-label">Menu Utama</div>
        <ul class="nav flex-column">
            <?= navItem(BASE_URL . '/dashboard/index', 'bi-grid-1x2', 'Dashboard',    'dashboard', $controller) ?>
            <?= navItem(BASE_URL . '/transaksi/kasir', 'bi-cart3',    'Kasir / POS',  'transaksi', $controller) ?>
        </ul>

        <div class="nav-section-label">Inventaris</div>
        <ul class="nav flex-column">
            <?= navItem(BASE_URL . '/product/index',     'bi-box-seam',       'Produk',      'product',     $controller) ?>
            <?= navItem(BASE_URL . '/kategori/index',    'bi-tag',            'Kategori',    'kategori',    $controller) ?>
            <?= navItem(BASE_URL . '/distributor/index', 'bi-truck',          'Distributor', 'distributor', $controller) ?>
            <?= navItem(BASE_URL . '/pengadaan/index',   'bi-clipboard-plus', 'Pengadaan',   'pengadaan',   $controller) ?>
        </ul>

        <div class="nav-section-label">Laporan & Transaksi</div>
        <ul class="nav flex-column">
            <?= navItem(BASE_URL . '/transaksi/index', 'bi-receipt',       'Riwayat Transaksi', 'transaksi', $controller) ?>
            <?= navItem(BASE_URL . '/laporan/index',   'bi-bar-chart-line','Laporan',           'laporan',   $controller) ?>
        </ul>

        <?php if ($role === 'owner'): ?>
        <div class="nav-section-label">Pengaturan</div>
        <ul class="nav flex-column">
            <?= navItem(BASE_URL . '/user/index', 'bi-people', 'Manajemen User', 'user', $controller) ?>
        </ul>
        <?php endif; ?>

    </nav>

    <!-- User Info at Bottom -->
    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">
                <?= strtoupper(substr($_SESSION['users']['nama'] ?? 'U', 0, 1)) ?>
            </div>
            <div class="user-info">
                <span class="user-name"><?= htmlspecialchars($_SESSION['users']['nama'] ?? '') ?></span>
                <span class="user-role badge-role-<?= $role ?>"><?= ucfirst($role) ?></span>
            </div>
        </div>
    </div>
</aside>