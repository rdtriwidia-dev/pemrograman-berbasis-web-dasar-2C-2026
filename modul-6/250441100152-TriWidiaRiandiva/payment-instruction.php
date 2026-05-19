<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['trx_id'])) {
    header("Location: dashboard-user.php");
    exit;
}

$trx_id = $_GET['trx_id'];
$query = "SELECT tr.*, t.concert_name, t.image 
          FROM transactions tr 
          JOIN tickets t ON tr.ticket_id = t.id 
          WHERE tr.id = '$trx_id'";
$result = $conn->query($query);
$data = $result->fetch_assoc();

if (!$data) {
    echo "Transaksi tidak ditemukan";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran - CONCERTIVA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 font-sans text-slate-200">

    <div class="max-w-xl mx-auto px-6 py-20 text-center">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-white">Pesanan Berhasil Dilakukan!</h1>
            <p class="text-slate-400 mt-3 font-medium text-sm">Silakan selesaikan pembayaran untuk mengamankan tiket Anda</p>
        </div>

        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-10 text-left mb-10 relative overflow-hidden">
            <div class="flex justify-between items-center mb-8 border-b border-white/5 pb-6">
                <div>
                    <span class="text-[10px] font-black text-slate-500 uppercase block mb-1">Total Bayar</span>
                    <span class="text-3xl font-black text-blue-500">Rp<?= number_format($data['total_price'], 0, ',', '.') ?></span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-black text-slate-500 uppercase block mb-1">ID Transaksi</span>
                    <span class="text-sm font-bold text-white bg-white/5 px-3 py-1 rounded-lg border border-white/10">#TRX-<?= $data['id'] ?></span>
                </div>
            </div>

            <div class="space-y-6">
                <p class="text-[10px] text-slate-400 font-bold uppercase">Metode Transfer:</p>
                
                <div class="bg-white/5 backdrop-blur-sm rounded-3xl p-6 flex items-center justify-between border border-white/10 group hover:border-blue-500/30">
                    <div>
                        <p class="text-[10px] font-bold text-blue-400 uppercase mb-1">Bank Central Asia (BCA)</p>
                        <p class="text-2xl font-black text-white tracking-wider">123 456 7890</p>
                        <p class="text-xs text-slate-500 font-medium mt-1 italic">a.n. PT Concertiva Indonesia</p>
                    </div>
                </div>

                <div class="p-5 bg-amber-500/5 backdrop-blur-sm rounded-2xl border border-amber-500/20">
                    <p class="text-[11px] text-amber-200/80  font-medium">
                        <b class="text-amber-400 uppercase text-[9px] tracking-widest block mb-1">PENTING:</b> 
                        Cantumkan ID Transaksi <span class="text-white font-bold">#TRX-<?= $data['id'] ?></span> pada berita transfer agar admin dapat memverifikasi pesanan
                    </p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <a href="mytickets.php" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-5 rounded-2xl font-bold uppercase shadow-lg shadow-blue-600/20">Cek Status Tiket Saya</a>
            <a href="dasboard-user.php" class="block w-full text-slate-500 py-2 text-xs font-bold uppercase hover:text-white">Kembali ke Beranda</a>
        </div>

        <p class="text-sm text-white mt-12 font-bold">
            Pusat Bantuan: support@concertiva.id
        </p>
    </div>

</body>
</html>
