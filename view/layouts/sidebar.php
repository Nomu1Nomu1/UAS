<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil data user dari session
$sessionUser  = $_SESSION['users'] ?? [];
$namaUser     = htmlspecialchars($sessionUser['nama']     ?? 'User');
$emailUser    = htmlspecialchars($sessionUser['email']    ?? '');
$usernameUser = htmlspecialchars($sessionUser['username'] ?? '');
$roleUser     = strtolower($sessionUser['role']           ?? 'kasir');

// Label role yang tampil di sidebar
$roleLabelMap = [
    'admin' => 'Admin',
    'kasir' => 'Kasir',
];
$roleLabel = $roleLabelMap[$roleUser] ?? ucfirst($roleUser);

// Folder aktif saat ini (untuk highlight menu)
$currentPage = $_GET['page'] ?? '';

$menuItems = [
    [
        'folder' => 'dashboard',
        'href'   => '/UAS/?page=dashboard&action=index',
        'icon'   => 'bi-grid',
        'label'  => 'Dashboard',
        'roles'  => ['admin', 'kasir'],
    ],
    [
        'folder' => 'product',
        'href'   => '/UAS/?page=product&action=index',
        'icon'   => 'bi-box',
        'label'  => 'Produk',
        'roles'  => ['admin', 'kasir'],
    ],
    [
        'folder' => 'kategori',
        'href'   => '/UAS/?page=kategori&action=index',
        'icon'   => 'bi-tag',
        'label'  => 'Kategori',
        'roles'  => ['admin', 'kasir'],
    ],
    [
        'folder' => 'distributor',
        'href'   => '/UAS/?page=distributor&action=index',
        'icon'   => 'bi-truck',
        'label'  => 'Distributor',
        'roles'  => ['admin', 'kasir'],
    ],
    [
        'folder' => 'transaksi',
        'href'   => '/UAS/?page=transaksi&action=kasir',
        'icon'   => 'bi-credit-card',
        'label'  => 'Transaksi',
        'roles'  => ['admin', 'kasir'],
    ],
    [
        'folder' => 'pengadaan',
        'href'   => '/UAS/?page=pengadaan&action=index',
        'icon'   => 'bi-cart',
        'label'  => 'Pengadaan',
        'roles'  => ['admin'],          // kasir TIDAK bisa akses
    ],
    [
        'folder' => 'laporan',
        'href'   => '/UAS/?page=laporan&action=index',
        'icon'   => 'bi-file-earmark-text',
        'label'  => 'Laporan',
        'roles'  => ['admin'],          // kasir TIDAK bisa akses
    ],
    [
        'folder' => 'user',
        'href'   => '/UAS/?page=user&action=index',
        'icon'   => 'bi-people',
        'label'  => 'Manajemen User',
        'roles'  => ['admin'],          // kasir TIDAK bisa akses
    ],
];

// Warna badge role
$roleBadgeClass = match ($roleUser) {
    'admin' => 'bg-primary',
    'kasir' => 'bg-success',
    default => 'bg-secondary',
};

$words    = explode(' ', $namaUser);
$initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
?>

<aside class="sidebar" id="sidebar">

    <div class="sidebar-logo">
        <h3>UMKM Inventory</h3>
    </div>

    <ul class="sidebar-menu">

        <?php foreach ($menuItems as $item): ?>

            <?php
            // Tampilkan menu hanya jika role user ada di daftar roles menu
            if (!in_array($roleUser, $item['roles'], true)) {
                continue;
            }
            $isActive = ($currentPage === $item['folder']) ? 'active' : '';
            ?>

            <li>
                <a href="<?= $item['href'] ?>" class="<?= $isActive ?>">
                    <i class="bi <?= $item['icon'] ?>"></i>
                    <?= $item['label'] ?>
                </a>
            </li>

        <?php endforeach; ?>

    </ul>

    <div class="sidebar-footer">
        <div class="sidebar-user">

        <div class="avatar" title="<?= $namaUser ?>">
            <?= $initials ?>
        </div>

        <div class="sidebar-user-info">
            <strong class="d-block text-truncate" style="max-width:130px;" title="<?= $namaUser ?>">
                <?= $namaUser ?>
            </strong>

            <?php if (!empty($emailUser)): ?>
                <small class="text-muted d-block text-truncate" style="max-width:130px;" title="<?= $emailUser ?>">
                    <?= $emailUser ?>
                </small>
            <?php else: ?>
                <small class="text-muted">@<?= $usernameUser ?></small>
            <?php endif; ?>

            <span class="badge <?= $roleBadgeClass ?> mt-1" style="font-size:.65rem;">
                <?= $roleLabel ?>
            </span>
        </div>

    </div>

    <a href="/UAS/?page=auth&action=logout" class="logout-btn">
        <i class="bi bi-box-arrow-right"></i>
        Logout
    </a>
    </div>

</aside>