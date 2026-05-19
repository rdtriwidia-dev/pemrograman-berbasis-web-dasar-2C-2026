<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$total_events = $conn->query("SELECT COUNT(*) as total FROM tickets")->fetch_assoc()['total'] ?? 0;
$total_tickets = $conn->query("SELECT SUM(stock) as total FROM tickets")->fetch_assoc()['total'] ?? 0;

$check_table = $conn->query("SHOW TABLES LIKE 'transactions'");
if($check_table->num_rows > 0) {
    $total_orders = $conn->query("SELECT COUNT(*) as total FROM transactions")->fetch_assoc()['total'] ?? 0;
} else {
    $total_orders = 0; 
}

$result = $conn->query("SELECT * FROM tickets ORDER BY date ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - TiketKonser</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50/50 font-sans min-h-screen text-slate-600">

    <header class="sticky w-full border-b border-slate-200/80 bg-blue-950 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-4">
           
                <div class="flex items-center gap-2">
                    <h1 class="text-lg font-bold text-white">CONCER</h1><span class="text-lg text-blue-700 font-bold">TIVA</span>
                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700">Admin</span>
                </div>

                <nav class="hidden md:flex items-center space-x-1">
                    <a href="dasboard-admin.php" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-slate-100 text-slate-900">Dashboard
                    </a>
                    <a href="events-manage.php" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white hover:text-blue-700">Kelola Event
                    </a>
                    <a href="manage-transactions.php" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white hover:text-blue-700">Transaksi
                    </a>
                </nav>

                <div class="flex items-center gap-2">
                    <a href="logout.php" class="inline-flex items-center gap-2 justify-center rounded-lg text-sm font-medium h-9 px-4 border border-slate-200 text-red-600 bg-white hover:bg-red-50 hover:border-red-200">Keluar
                    </a>
                </div>

            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8 border-b border-slate-200/60 pb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Ringkasan Dashboard</h1>
                <p class="text-sm text-slate-500 mt-1">Selamat datang. Berikut adalah performa data hari ini</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="relative overflow-hidden bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase">Total Event</p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-2"><?= number_format($total_events); ?></h3>
                </div>
            </div>

            <div class="relative overflow-hidden bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase">Sisa Tiket</p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-2"><?= number_format($total_tickets); ?></h3>
                </div>
            </div>

            <div class="relative overflow-hidden bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm flex items-start justify-between sm:col-span-2 lg:col-span-1">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase">Pesanan</p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-2"><?= number_format($total_orders); ?></h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="p-5 border-b border-slate-200/80 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-2">
                    <i data-lucide="list" class="w-4 h-4 text-slate-400"></i>
                    <h3 class="font-semibold text-slate-900 text-sm">Daftar Event</h3>
                </div>
                <a href="events-manage.php" class="inline-flex items-center gap-1 text-xs text-blue-600 font-semibold hover:text-blue-700">Lihat Semua
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white border-b border-slate-200/80">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase text-center w-24">Poster</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase">Detail Event</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase">Deskripsi</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase text-center w-36">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <?php $img = 'uploads/' . htmlspecialchars($row['image']); ?>
                                <img src="<?= $img ?>" class="w-10 h-14 object-cover rounded-md shadow-sm border border-slate-100 mx-auto">
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-900 mb-1"><?= htmlspecialchars($row['concert_name'] ?? '-'); ?></p>
                                <div class="flex items-center gap-1.5 text-xs text-slate-400 font-normal">
                                    <span><?= date('d M Y', strtotime($row['date'] ?? 'now')); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <p class="text-xs text-slate-500 line-clamp-2 max-w-sm leading-relaxed">
                                    <?= htmlspecialchars($row['description'] ?? 'Tidak ada deskripsi.'); ?>
                                </p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php 
                                    $stok = $row['stock'] ?? 0;
                                    $status_badge = $stok > 0 
                                        ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/20' 
                                        : 'bg-red-50 text-red-700 ring-red-600/20';
                                ?>
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset <?= $status_badge ?>">
                                    <?= number_format($stok); ?> Sisa
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</body>
</html>