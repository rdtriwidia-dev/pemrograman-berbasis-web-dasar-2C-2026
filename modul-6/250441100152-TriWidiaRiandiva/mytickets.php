<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT tr.id as trx_id, tr.quantity, tr.total_price, tr.status, tr.created_at, t.concert_name, t.date as concert_date, t.location, t.image
          FROM transactions tr
          JOIN tickets t ON tr.ticket_id = t.id
          WHERE tr.user_id = '$user_id'
          ORDER BY tr.created_at DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tiket Saya - CONCERTIVA</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="text-slate-200 p-6 bg-slate-900">

  <div class="max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-12">
      <div>
        <h1 class="text-3xl font-black text-white">Tiket Saya</h1>
        <p class="text-slate-500 text-sm font-medium mt-1">Halo, Cek status tiketmu di sini.</p>
      </div>
      <a href="dasboard-user.php" class="font-bold text-slate-400 hover:text-blue-400 flex items-center gap-2">Kembali ke Beranda
      </a>
    </div>

    <?php if ($result && $result->num_rows > 0): ?>
      <div class="space-y-6">
        <?php while($row = $result->fetch_assoc()): ?>
          <div class="bg-white/5 backdrop-blur-md border border-white/10 p-6 md:p-8 rounded-2xl flex flex-col md:flex-row justify-between items-center gap-6 hover:border-white/20 hover:scale-105">
            
            <div class="flex items-center gap-6 w-full">
              <img src="uploads/<?= $row['image'] ?>" class="w-20 h-20 md:w-24 md:h-24 object-cover rounded-xl shadow-lg border border-white/10">
              <div class="overflow-hidden">
                <p class="text-sm font-bold text-blue-500 mb-1">#TRX-<?= $row['trx_id'] ?></p>

                <h2 class="text-lg md:text-xl font-bold text-white"><?= htmlspecialchars($row['concert_name'] ?? 'Konser') ?></h2>
k
                <div class="flex flex-col gap-1 mt-2">
                  <p class="text-xs text-slate-400 font-medium flex items-center gap-2">
                    <img src="icon 5.jpg" class="rounded-full w-5 h-5"><?= htmlspecialchars($row['location'] ?? 'Stadion GBK')?>
                  </p>

                  <p class="text-sm text-slate-200 font-bold">
                    <?= date('d M Y', strtotime($row['concert_date'])) ?>
                  </p>
                </div>
              </div>
            </div>

            <div class="flex flex-row md:flex-col items-center md:items-end justify-between w-full md:w-auto gap-4 border-t md:border-t-0 border-white/5 pt-4 md:pt-0">
              <span class="px-4 py-1.5 rounded-xl text-sm font-bold uppercase
                <?= $row['status'] == 'success' 
                  ? 'bg-green-500/10 text-green-400 border border-green-500/20' 
                  : 'bg-amber-500/10 text-amber-400 border border-amber-500/20' ?>">
                <?= $row['status'] ?>
              </span>
              
              <div class="flex items-center gap-4">
                <?php if($row['status'] == 'success'): ?>
                  <a href="print-ticket.php?id=<?= $row['trx_id'] ?>" 
                     class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold text-[10px] uppercase shadow-lg shadow-blue-600/20 active:scale-95 flex items-center gap-2"> E-Ticket
                  </a>
                <?php else: ?>
                  <a href="payment-instruction.php?trx_id=<?= $row['trx_id'] ?>" 
                     class="text-amber-400 font-black text-[10px] uppercase hover:text-amber-300">
                     Cara Bayar
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <div class="bg-white/5 backdrop-blur-md border-2 border-dashed border-white/10 p-24 rounded-2xl text-center shadow-2xl relative overflow-hidden">
        <div class="absolute inset-0 bg-blue-600/5 blur-[80px] -z-10"></div>
        <h3 class="text-xl font-bold text-white">Belum ada transaksi</h3>
        <p class="text-slate-500 text-sm mt-2 max-w-xs mx-auto font-medium">Tiket konser impianmu belum ada di sini. Yuk, cari tiket sekarang!</p>
        <a href="dasboard-user.php" class="mt-8 inline-block bg-white text-slate-950 px-8 py-4 rounded-2xl font-bold text-[10px] uppercase hover:bg-blue-500 hover:text-white shadow-xl shadow-white/5">Explore Konser</a>
      </div>
    <?php endif; ?>
  </div>

</body>
</html>
