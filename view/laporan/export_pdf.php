<?php
require_once __DIR__ . '/../../config/db.php';

if (!is_logged_in()) {
    header('Location: ../auth/login.php');
    exit;
}

$db = getDB();

$periode = $_GET['periode'] ?? 'bulan_ini';

switch ($periode) {
    case 'hari_ini':
        $tgl_dari   = date('Y-m-d');
        $tgl_sampai = date('Y-m-d');
        $label      = 'Hari Ini (' . date('d M Y') . ')';
        break;
    case 'minggu_ini':
        $tgl_dari   = date('Y-m-d', strtotime('monday this week'));
        $tgl_sampai = date('Y-m-d', strtotime('sunday this week'));
        $label      = 'Minggu Ini';
        break;
    case 'tahun_ini':
        $tgl_dari   = date('Y-01-01');
        $tgl_sampai = date('Y-12-31');
        $label      = 'Tahun ' . date('Y');
        break;
    default:
        $tgl_dari   = date('Y-m-01');
        $tgl_sampai = date('Y-m-t');
        $label      = 'Bulan ' . date('F Y');
        break;
}

// Summary
$stmt = $db->prepare(
    "SELECT COALESCE(SUM(total_harga),0) AS total_penjualan,
            COUNT(*) AS total_transaksi,
            COALESCE(AVG(total_harga),0) AS rata_transaksi
     FROM transaksi
     WHERE status='Selesai'
       AND DATE(tanggal_transaksi) BETWEEN ? AND ?"
);
$stmt->bind_param('ss', $tgl_dari, $tgl_sampai);
$stmt->execute();
$summary = $stmt->get_result()->fetch_assoc();

// Produk Terlaris
$stmt2 = $db->prepare(
    "SELECT p.nama_barang, SUM(dt.qty) AS total_terjual, SUM(dt.subtotal) AS total_pendapatan
     FROM detail_transaksi dt
     JOIN transaksi t ON dt.id_trx = t.id
     JOIN product   p ON dt.produk_id = p.id
     WHERE t.status='Selesai'
       AND DATE(t.tanggal_transaksi) BETWEEN ? AND ?
     GROUP BY dt.produk_id
     ORDER BY total_terjual DESC
     LIMIT 10"
);
$stmt2->bind_param('ss', $tgl_dari, $tgl_sampai);
$stmt2->execute();
$produkTerlaris = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);

// Stok Menipis
$stokMenipis = $db->query(
    "SELECT p.kode_barang, p.nama_barang, p.stock, p.stock_min, k.nama_kategori
     FROM product p
     JOIN kategori_product k ON p.kategori_id = k.id
     WHERE p.stock <= p.stock_min
     ORDER BY p.stock ASC"
)->fetch_all(MYSQLI_ASSOC);

function fmt(float $n): string {
    return 'Rp ' . number_format($n, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Laporan - <?= $label ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #222; padding: 30px; }
        h1 { font-size: 22px; margin-bottom: 4px; }
        h2 { font-size: 16px; margin: 20px 0 10px; border-bottom: 2px solid #2563eb; padding-bottom: 5px; color: #2563eb; }
        .meta { color: #666; font-size: 12px; margin-bottom: 20px; }
        .stats { display: flex; gap: 20px; margin-bottom: 20px; }
        .stat-box { flex: 1; border: 1px solid #ddd; border-radius: 8px; padding: 14px; }
        .stat-box .label { color: #666; font-size: 11px; }
        .stat-box .value { font-size: 20px; font-weight: bold; color: #2563eb; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #f1f5f9; padding: 8px 10px; text-align: left; font-size: 12px; border: 1px solid #ddd; }
        td { padding: 7px 10px; border: 1px solid #ddd; }
        tr:nth-child(even) { background: #fafafa; }
        .badge-danger  { background: #fee2e2; color: #b91c1c; padding: 2px 8px; border-radius: 4px; }
        .badge-warning { background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 4px; }
        .badge-ok      { background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 4px; }
        .footer-txt { color: #888; font-size: 11px; margin-top: 30px; text-align: center; }
        @media print {
            body { padding: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom:20px">
        <button onclick="window.print()" style="padding:8px 20px;background:#2563eb;color:white;border:none;border-radius:6px;cursor:pointer;font-size:13px">
            🖨️ Cetak / Simpan PDF
        </button>
        <a href="index.php" style="margin-left:10px;color:#2563eb">← Kembali</a>
    </div>

    <h1>Laporan UMKM Inventory</h1>
    <p class="meta">Periode: <?= $label ?> &nbsp;|&nbsp; Dicetak: <?= date('d M Y H:i') ?></p>

    <!-- Stats -->
    <div class="stats">
        <div class="stat-box">
            <div class="label">Total Penjualan</div>
            <div class="value"><?= fmt((float)$summary['total_penjualan']) ?></div>
        </div>
        <div class="stat-box">
            <div class="label">Jumlah Transaksi</div>
            <div class="value"><?= number_format((int)$summary['total_transaksi']) ?></div>
        </div>
        <div class="stat-box">
            <div class="label">Rata-rata per Transaksi</div>
            <div class="value"><?= fmt((float)$summary['rata_transaksi']) ?></div>
        </div>
    </div>

    <!-- Produk Terlaris -->
    <h2>Produk Terlaris</h2>
    <?php if (!empty($produkTerlaris)): ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Total Terjual (unit)</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produkTerlaris as $i => $p): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($p['nama_barang']) ?></td>
                    <td><?= number_format($p['total_terjual']) ?></td>
                    <td><?= fmt((float)$p['total_pendapatan']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="color:#888">Tidak ada data penjualan pada periode ini.</p>
    <?php endif; ?>

    <!-- Stok Menipis -->
    <h2>Produk Stok Menipis / Habis</h2>
    <?php if (!empty($stokMenipis)): ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok Min</th>
                <th>Stok Saat Ini</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stokMenipis as $i => $p): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($p['kode_barang']) ?></td>
                    <td><?= htmlspecialchars($p['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($p['nama_kategori']) ?></td>
                    <td><?= $p['stock_min'] ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td>
                        <?php if ($p['stock'] == 0): ?>
                            <span class="badge-danger">Habis</span>
                        <?php else: ?>
                            <span class="badge-warning">Menipis</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="color:#16a34a">✓ Semua produk memiliki stok yang cukup.</p>
    <?php endif; ?>

    <p class="footer-txt">— Laporan ini digenerate otomatis oleh sistem UMKM Inventory —</p>

</body>
</html>