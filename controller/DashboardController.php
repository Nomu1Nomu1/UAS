<?php
require_once __DIR__ . '/../model/Product.php';
require_once __DIR__ . '/../model/Transaksi.php';
require_once __DIR__ . '/../model/Pengadaan.php';

class DashboardController
{
    public function index()
    {
        $productModel = new Product();
        $transaksiModel = new Transaksi();
        $pengadaanModel = new Pengadaan();

        $totalProduk       = count($productModel->getAll());
        $stockMenipis      = count($productModel->getStokMenipis());
        $transaksiTerakhir = $transaksiModel->getAll('', date('Y-m-d')); // hari ini
        $pengadaanPending  = count(array_filter($pengadaanModel->getAll(), fn($p) => $p['status'] === 'Pending'));
        
        // Statistik hari ini
        $totalTRXHariIni   = count($transaksiTerakhir);
        $pendapatanHariIni = array_sum(array_column($transaksiTerakhir, 'total_harga'));
        $listStockMenipis  = $productModel->getStokMenipis();

        $pageTitle = 'Dashboard';
        
        // Load view
        require_once __DIR__ . '/../view/dashboard/index.php';
    }
}
