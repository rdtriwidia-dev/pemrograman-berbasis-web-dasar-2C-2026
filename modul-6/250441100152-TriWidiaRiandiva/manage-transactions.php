<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'confirm') {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $trx_data = $conn->query("SELECT ticket_id, quantity FROM transactions WHERE id = '$id'")->fetch_assoc();
    $t_id = $trx_data['ticket_id'];
    $qty = $trx_data['quantity'];

    $conn->query("UPDATE transactions SET status = 'success' WHERE id = '$id'");
    
    $conn->query("UPDATE tickets SET stock = stock - $qty WHERE id = '$t_id'");

    header("Location: manage-transactions.php?msg=success");
    exit;
}

$query = "SELECT tr.*, u.username, t.concert_name 
          FROM transactions tr
          JOIN users u ON tr.user_id = u.id
          JOIN tickets t ON tr.ticket_id = t.id
          ORDER BY tr.created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Transaksi - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans p-8">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Kelola Transaksi</h1>
                <p class="text-slate-500 font-medium">Validasi pembayaran user di sini</p>
            </div>
            <a href="dasboard-admin.php" class="text-sm font-bold text-blue-600 hover:underline">Kembali ke Dashboard</a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-400">ID / Waktu</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-400">Pembeli</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-400">Event</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-400">Total</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-400">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-400 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800">#TRX-<?= $row['id'] ?></p>
                            <p class="text-[10px] text-slate-400"><?= $row['created_at'] ?></p>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-700"><?= htmlspecialchars($row['username'] ?? 'User') ?></td>
                        <td class="px-6 py-4 font-semibold text-slate-700"><?= htmlspecialchars($row['concert_name'] ?? 'Tiket') ?></td>
                        <td class="px-6 py-4 font-bold text-blue-600">Rp<?= number_format($row['total_price'], 0, ',', '.') ?></td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                                <?= $row['status'] == 'success' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if($row['status'] == 'pending'): ?>
                                <a href="manage-transactions.php?action=confirm&id=<?= $row['id'] ?>" 
                                   onclick="return confirm('Sudah cek mutasi rekening? Konfirmasi pesanan ini?')"
                                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm font-bold">
                                    Konfirmasi
                                </a>
                            <?php else: ?>
                                <span class="text-slate-300 text-sm font-bold">Tervalidasi</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>