<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['user_email'];
$initial = strtoupper(substr($user_email, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Temukan Konser Impianmu - TiketKonser</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 font-sans text-slate-800">

<nav class="fixed top-0 left-0 w-full z-[100] px-6 py-4 bg-slate-900/60 backdrop-blur-lg border-b border-white/5 flex items-center justify-between">
  <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
    
    <div class="flex items-center">
      <h1 class="text-2xl font-bold text-white">
        CONCER<span class="text-blue-500">TIVA</span>
      </h1>
    </div>

    <div class="hidden md:block">
      <ul class="flex items-center gap-8 font-bold uppercase text-slate-300">
        <li><a href="dasboard-user.php" class="hover:text-blue-400">Beranda</a></li>
        <li><a href="#events" class="hover:text-blue-400">Jelajah</a></li>
        <li><a href="#footer" class="hover:text-blue-400">Bantuan</a></li>
      </ul>
    </div>

    <div class="relative">
      <div class="group relative inline-block">
        <button class="flex items-center gap-3 bg-white/10 p-1.5 pr-4 rounded-full border border-white/10 hover:bg-white/20">
          <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg">
            <?= $initial ?>
          </div>
          <span class="text-xs font-bold text-white hidden sm:block"><?= explode('@', $user_email)[0]; ?></span>
        </button>

        <div class="absolute right-0 mt-3 w-56 bg-slate-900 border border-white/10 rounded-2xl shadow-2xl opacity-0 group-hover:visible group-hover:opacity-100">
          <div class="px-4 py-3 border-b border-white/5 text-[10px] font-black text-slate-500 uppercase">Menu Akun
          </div>
          <a href="mytickets.php" class="block px-4 py-3 text-sm font-bold text-white hover:bg-blue-600 ">Tiket Saya</a>
          <a href="logout.php" class="block px-4 py-3 text-sm font-bold text-red-500 hover:bg-red-500/10 uppercase">Keluar</a>
        </div>
      </div>
    </div>

  </div>
</nav>

<section class="relative h-screen flex items-center justify-center text-center">
  <div class="absolute inset-0">
    <img src="uploads/gitar.jpg" 
         class="w-full h-full object-cover" alt="Background konser">
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-transparent"></div>
  </div>

  <div class="px-4 z-10">
    <h2 class="text-3xl md:text-6xl font-black text-white mb-6">UNLEASH THE ENERGY OF LIVE MUSIC</h2>
    <p class="text-slate-200 md:text-lg max-w-2xl mx-auto font-medium mb-8">Bikin Cerita di Setiap Nada. Temukan Penawaran Terbaik dan Wujudkan Konser Impianmu Hari Ini
    </p>
    <a href="#events" 
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-full shadow-lg transform hover:scale-105">
       Jelajahi Event
    </a>
  </div>
</section>


<main id="events" class="max-w-7xl mx-auto px-6 py-16">
  <div class="flex justify-between items-end mb-10">
    <div>
      <span class="text-blue-600 font-bold uppercase text-xs">Explore Events</span>
      <h3 class="text-4xl font-black text-slate-900 mt-2">Event Terpopuler</h3>
    </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
    <?php
    $stmt = $conn->prepare("SELECT * FROM tickets ORDER BY date ASC LIMIT 20");
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0): ?>
      <div class="col-span-full py-20 text-center">
        <div class="bg-slate-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl"></div>
        <p class="text-slate-500 font-medium italic text-lg">Belum ada konser terjadwal. Cek lagi nanti</p>
      </div>
    <?php endif;

    while($row = $result->fetch_assoc()): ?>  
    <a href="read.php?id=<?= $row['id']; ?>" 
       class="event-card group bg-white rounded-3xl shadow-sm hover:shadow-2xl overflow-hidden border border-slate-100 flex flex-col">
      
      <div class="relative overflow-hidden h-60">
        <img src="uploads/<?= htmlspecialchars($row['image']); ?>" 
             class="w-full h-full object-cover group-hover:scale-110">
        <span class="absolute top-4 left-4 bg-blue-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-full uppercase">
          <?= htmlspecialchars($row['location']); ?>
        </span>
      </div>

      <div class="p-6 flex-1 flex flex-col justify-between">
        <div>
          <h4 class="text-xl font-extrabold text-slate-800 mb-2">
            <?= htmlspecialchars($row['concert_name']); ?>
          </h4>
          <p class="text-[10px] font-bold uppercase text-blue-300">Organizer</p>
          <p><?= htmlspecialchars($row['organizer']); ?></p>
          <div class="mt-4 flex items-center gap-2 text-slate-500 text-sm font-medium">
            <?= date('d M Y', strtotime($row['date'])); ?>
          </div>
        </div>
        <div class="pt-4 flex items-center justify-between">
          <div class="flex flex-col">
            <span class="text-[10px] font-extrabold text-slate-800 uppercase">Mulai Dari</span>
            <span class="text-xl font-extrabold text-blue-600">
              Rp<?= number_format($row['price'],0,',','.'); ?>
            </span>
          </div>
        </div>
      </div>
    </a>
    <?php endwhile; ?>
  </div>
</main>

<footer id="footer" class="bg-slate-950 border-t border-white/5 pt-10 pb-6">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            
            <div class="md:col-span-2 flex flex-col justify-center items-start text-left">
                <h1 class="text-3xl font-extrabold text-white mb-4">
                    CONCER<span class="text-blue-500">TIVA</span>
                </h1>
                <p class="text-slate-400 font-medium text-sm max-w-md">
                    Platform ticketing konser musik terbesar dan terpercaya di Indonesia.Dapatkan akses eksklusif ke berbagai event musik kelas dunia.
                </p>
            </div>

            <div class="flex flex-col items-start text-left">
                <h5 class="font-bold text-white mb-6 uppercase text-xs tracking-widest">Layanan</h5>
                <ul class="text-sm text-slate-400 space-y-4 font-medium">
                    <li><a href="#" class="hover:text-blue-500 transition-colors">Tiket Konser</a></li>
                    <li><a href="#" class="hover:text-blue-500 transition-colors">Tiket Festival</a></li>
                    <li><a href="#" class="hover:text-blue-500 transition-colors">E-Ticket Check</a></li>
                </ul>
            </div>

            <div class="flex flex-col items-start text-left">
                <h5 class="font-bold text-white mb-6 uppercase text-xs tracking-widest">Hubungi Kami</h5>
                <ul class="text-sm text-slate-400 space-y-4 font-medium">
                    <li>support@concertiva.id</li>
                    <li>Madura, Indonesia</li>
                </ul>
            </div>
        </div>

        <div class="pt-6 border-t border-white/5 text-center">
            <p class="text-[10px] font-bold text-slate-600">
                © 2026 CONCERTIVA PROJECT. ALL RIGHTS RESERVED
            </p>
        </div>
  </div>
</footer>
</body>
</html>
