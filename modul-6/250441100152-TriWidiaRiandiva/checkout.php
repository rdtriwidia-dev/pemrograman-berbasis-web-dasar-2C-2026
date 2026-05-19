<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: dashboard-user.php");
    exit;
}

$ticket_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$user_query = "SELECT username, email FROM users WHERE id = '$user_id'";
$user_data = $conn->query($user_query)->fetch_assoc();
$ticket_query = "SELECT * FROM tickets WHERE id = '$ticket_id'";
$ticket = $conn->query($ticket_query)->fetch_assoc();

if (!$ticket) {
    echo "Tiket tidak ditemukan";
    exit;
}

if (isset($_POST['confirm_purchase'])) {
    $qty = mysqli_real_escape_string($conn, $_POST['quantity']);
    $total_price = $ticket['price'] * $qty;

    $insert = "INSERT INTO transactions (user_id, ticket_id, quantity, total_price, status) 
               VALUES ('$user_id', '$ticket_id', '$qty', '$total_price', 'pending')";

    if ($conn->query($insert)) {
        $last_id = $conn->insert_id;
        header("Location: payment-instruction.php?trx_id=" . $last_id);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - CONCERTIVA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 font-sans text-slate-200">

<nav class="bg-slate-500/30 backdrop-blur-md px-6 py-4 fixed w-full z-50">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
        <h1 class="text-xl font-black text-white uppercase">CONCER<span class="text-blue-500">TIVA</span></h1>
        <a href="dasboard-user.php" class="font-bold text-slate-400 hover:text-white">Kembali</a>
    </div>
</nav>

<div class="max-w-6xl mx-auto px-6 pt-28 pb-20">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-white tracking-tight mb-2">Konfirmasi Pesanan</h1>
        <p class="text-slate-400">Tinggal selangkah lagi menuju konser impianmu.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-8">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 bg-blue-600/20 text-blue-400 rounded-2xl flex items-center justify-center font-bold">1</div>
                    <h3 class="text-xl font-bold text-white">Informasi Pembeli</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <p class="text-sm font-bold text-slate-500 mb-2 font-black">NAMA LENGKAP</p>
                        <div class="bg-white/5 border border-white/10 px-6 py-4 rounded-2xl text-white font-semibold">
                            <?= htmlspecialchars($user_data['username'] ?? 'User') ?>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-500 mb-2 font-black">ALAMAT EMAIL</p>
                        <div class="bg-white/5 border border-white/10 px-6 py-4 rounded-2xl text-white font-semibold">
                            <?= htmlspecialchars($user_data['email'] ?? '-') ?>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 p-5 bg-blue-600/10 rounded-2xl border border-blue-600/20 flex gap-4 items-start">
                    <p class="text-xs text-slate-400">
                        E-Ticket akan dikirimkan secara digital dan dikaitkan dengan akun ini. Pastikan data sudah benar.
                    </p>
                </div>
            </div>

            <div class="glass-card rounded-xl p-8">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 bg-blue-600/20 text-blue-400 rounded-2xl flex items-center justify-center font-bold">2</div>
                    <h3 class="text-xl font-bold text-white">Jumlah Tiket</h3>
                </div>
                
                <form method="POST" id="checkoutForm">
                    <div class="flex flex-col md:flex-row items-stretch gap-6">
                        <div class="flex-1">
                            <label class="text-sm font-bold text-slate-500 block mb-2 font-black uppercase tracking-wider">Masukkan Jumlah</label>
                            <input type="number" name="quantity" id="qty" value="1" min="1" max="<?= $ticket['stock'] ?>" class="w-full bg-white/5 px-8 py-5 rounded-2xl border border-white/10 text-2xl font-black text-white h-[84px]"onchange="updateSummary()">
                            <p class="text-sm text-slate-500 mt-3 font-bold">STOK TERSEDIA: <span class="text-blue-400"><?= $ticket['stock'] ?></span>
                            </p>
                        </div>
                        <div class="md:w-64">
                            <label class="text-sm font-bold text-slate-500 block mb-2 font-black uppercase text-right">Harga Satuan</label>
                            <div class="bg-white/5 border border-white/10 px-6 rounded-2xl h-[84px] flex flex-col justify-center text-right">
                                <p class="text-2xl font-black text-white">Rp <?= number_format($ticket['price'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="confirm_purchase" class="hidden" id="realSubmitBtn"></button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="glass-card rounded-[2.5rem] p-8 sticky top-28 shadow-2xl">  
                <h3 class="text-lg font-bold text-white mb-8 border-b border-white/5 pb-4">Ringkasan Pembayaran</h3>
                
                <div class="flex gap-4 mb-8">
                    <img src="uploads/<?= $ticket['image'] ?>" class="w-20 h-20 object-cover rounded-2xl shadow-lg border border-white/10">
                    <div class="flex flex-col justify-center">
                        <h4 class="font-bold text-white"><?= htmlspecialchars($ticket['concert_name']) ?></h4>
                        <p class="text-sm text-slate-500 font-bold uppercase mt-1"><?= htmlspecialchars($ticket['location']) ?></p>
                    </div>
                </div>

                <div class="space-y-4 mb-10">
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-400 font-medium">Harga Tiket</span>
                        <span class="font-bold text-white">Rp <?= number_format($ticket['price'], 0, ',', '.') ?></span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-400 font-medium">Kuantitas</span>
                        <span class="font-bold text-blue-400" id="summaryQty">1x</span>
                    </div>
                    <div class="flex justify-between pt-6 border-t border-white/5">
                        <span class="text-sm font-bold text-slate-300">Total Bayar</span>
                        <span class="text-2xl font-black text-white" id="summaryTotal">Rp <?= number_format($ticket['price'], 0, ',', '.') ?></span>
                    </div>
                </div>

                <button type="button" onclick="document.getElementById('realSubmitBtn').click()" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-5 rounded-xl font-bold text-[13px shadow-xl flex items-center justify-center gap-3">Konfirmasi & Bayar
                </button>
                
                <p class="text-[10px] text-center text-slate-500 mt-6 font-bold uppercase">
                    Selesaikan pembayaran untuk mengamankan tiket Anda secara permanen.
                </p>
            </div>
        </div>

    </div>
</div>

<script>
    const unitPrice = <?= $ticket['price'] ?>;
    function updateSummary() {
        const qtyInput = document.getElementById('qty');
        let qty = parseInt(qtyInput.value);
        
        if (isNaN(qty) || qty < 1) qty = 1;
        
        const total = unitPrice * qty;
        
        const formatted = total.toLocaleString('id-ID');

        document.getElementById('summaryQty').innerText = qty + 'x';
        document.getElementById('summaryTotal').innerText = "Rp " + formatted;
    }
</script>
</body>
</html>