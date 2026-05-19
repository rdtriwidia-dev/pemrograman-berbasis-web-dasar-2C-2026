<?php
session_start();
include 'includes/db.php'; 

$id = $_GET['id'];
$query = "SELECT * FROM tickets WHERE id = '$id'";
$result = $conn->query($query);
$event = $result->fetch_assoc();

if (!$event) {
    echo "Event tidak ditemukan";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($event['concert_name'] ?? '') ?> - TiketKonser</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 font-sans text-white">

  <main class="max-w-6xl mx-auto px-4 py-10">
    <nav class="mb-8 flex items-center gap-2 text-sm font-medium text-white">
      <a href="dasboard-user.php" class="hover:text-blue-600">Beranda</a>
      <span>/</span>
      <span class="text-white"><?= htmlspecialchars($event['concert_name'] ?? '') ?></span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
      <div class="lg:col-span-2 space-y-8">
        <div class="bg-white rounded-3xl shadow-2xl">
          <img src="uploads/<?= $event['image'] ?>" class="w-full h-[400px] object-cover rounded-2xl">
        </div>

        <div class="bg-blue-950 rounded-3xl p-8 shadow-sm">
          <div class="flex mb-6">
            <button class="pb-4 border-b-2 border-blue-700 font-bold text-blue-100">Deskripsi</button>
          </div>
          <h2 class="text-2xl font-extrabold mb-4">Tentang Konser</h2>
          <div class="text-slate-50 space-y-4">
            <?= nl2br(htmlspecialchars($event['description'] ?? 'Deskripsi belum tersedia untuk event ini.')); ?>
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div class="bg-blue-950 rounded-3xl p-8 sticky top-10">
          <h1 class="text-2xl font-extrabold text-slate-100 mb-2"><?= htmlspecialchars($event['concert_name'] ?? '') ?></h1>
          <p class="text-sm text-slate-400 mb-6 flex items-center gap-2">
            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-[10px] font-bold uppercase">Musik</span>
            <span class="text-xs">Oleh <?= htmlspecialchars($event['organizer'] ?? '') ?></span>
          </p>

          <div class="space-y-5 mb-8">
            <div class="flex items-center gap-4">
              <div class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center">
                <img src="icon 4.jpg" class="w-6 h-6" alt="Tanggal">
              </div>
              <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase">Tanggal</p>
                <p class="text-sm font-bold text-white"><?= date('d F Y', strtotime($event['date'])) ?></p>
              </div>
            </div>

            <div class="flex items-center gap-4">
              <div class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center">
                <img src="icon 5.jpg" class="w-6 h-6" alt="Lokasi">
              </div>
              <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase">Lokasi</p>
                <p class="text-sm font-bold text-white"><?= htmlspecialchars($event['location'] ?? '') ?></p>
              </div>
            </div>
          </div>

          <div class="pt-6 border-t border-white/10">
            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Harga mulai dari</p>
            <p class="text-3xl font-black text-blue-500 mb-6">Rp<?= number_format($event['price'] ?? 0, 0, ',', '.') ?></p>
            <a href="checkout.php?id=<?= $event['id'] ?>" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-4 rounded-2xl font-bold uppercase shadow-lg shadow-blue-900/20">
              Beli Tiket Sekarang
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
