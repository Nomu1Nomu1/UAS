<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Inventaris UMKM') ?> — StokKu</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= BASE_URL ?>/assets/css/custom.css" rel="stylesheet">
</head>
<body>

<div class="app-wrapper">
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="main-content" id="mainContent">
        <!-- Top Header -->
        <?php require_once __DIR__ . '/header.php'; ?>

        <!-- Page Body -->
        <div class="page-body">
            <!-- Flash Message -->
            <?php if (!empty($_SESSION['flash'])): ?>
                <div class="alert alert-info alert-dismissible fade show alert-flash" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <?= htmlspecialchars($_SESSION['flash']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <!-- Actual Page Content -->
            <?= $content ?? '' ?>
        </div>

        <!-- Footer -->
        <?php require_once __DIR__ . '/footer.php'; ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="<?= BASE_URL ?>/assets/js/script.js"></script>
</body>
</html>