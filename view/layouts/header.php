<?php
$today = date('l, d F Y');
?>
<header class="top-header">
    <!-- Sidebar toggle (mobile) -->
    <button class="btn btn-link sidebar-toggle" id="sidebarToggle" type="button" title="Toggle Sidebar">
        <i class="bi bi-list"></i>
    </button>

    <!-- Page Title / Breadcrumb -->
    <div class="header-title">
        <h5 class="mb-0"><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?></h5>
        <small class="text-muted"><?= $today ?></small>
    </div>

    <!-- Right Actions -->
    <div class="header-actions ms-auto d-flex align-items-center gap-3">

        <!-- Stock alert badge -->
        <?php
        // Quick stock warning — only shown if there are items low on stock
        // We reuse $stockMenipis if it's been set by the controller
        if (!empty($stockMenipis) && (int)$stockMenipis > 0):
        ?>
        <a href="<?= BASE_URL ?>/laporan/stokHabis" class="header-badge" title="Stok menipis">
            <i class="bi bi-exclamation-triangle"></i>
            <span class="badge-count"><?= (int)$stockMenipis ?></span>
        </a>
        <?php endif; ?>

        <!-- Notifications placeholder -->
        <button class="btn btn-link header-icon-btn" type="button" title="Notifikasi">
            <i class="bi bi-bell"></i>
        </button>

        <!-- User dropdown -->
        <div class="dropdown">
            <button class="btn btn-link header-icon-btn d-flex align-items-center gap-2 dropdown-toggle"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="header-avatar">
                    <?= strtoupper(substr($_SESSION['users']['nama'] ?? 'U', 0, 1)) ?>
                </span>
                <span class="d-none d-sm-inline text-body fw-medium">
                    <?= htmlspecialchars($_SESSION['users']['nama'] ?? '') ?>
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li>
                    <span class="dropdown-item-text small text-muted">
                        Role: <strong><?= ucfirst($_SESSION['users']['role'] ?? '') ?></strong>
                    </span>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="<?= BASE_URL ?>/auth/logout">
                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>