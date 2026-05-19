<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CONCERTIVA</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans">

  <nav class="fixed top-6 left-1/2 -translate-x-1/2 w-[90%] max-w-5xl">
    <div class="bg-blue-900 px-8 py-3 rounded-full flex justify-between items-center shadow-2xl">
      <h1 class="text-xl font-extrabold text-white">
        CONCER<span class="text-blue-400">TIVA</span>
      </h1>

      <ul class="hidden md:flex items-center gap-2">
        <li><a href="index.php" class="px-5 py-2 rounded-full hover:bg-white/10 text-white">Beranda</a></li>
        <li><a href="login.php" class="px-5 py-2 rounded-full hover:bg-white/10 text-white">Jelajah</a></li>
        <li><a href="#" class="px-5 py-2 rounded-full hover:bg-white/10 text-white">Tentang</a></li>
      </ul>

      <div class="flex items-center gap-3">
        <a href="login.php" class="bg-white text-blue-900 px-6 py-2 rounded-full font-bold text-[10px] uppercase hover:bg-blue-100">Login</a>
      </div>
    </div>
  </nav>

  <section class="h-screen flex items-center justify-center bg-slate-900">
    <div class="bg-slate-900"></div>

    <div class="text-center px-6 max-w-4xl">
      <h2 class="text-5xl md:text-7xl font-extrabold text-white mb-6">
        Rasakan Sensasi <br> <span class="text-blue-300">Konser Impianmu</span>
      </h2>
      <p class="text-slate-300 text-lg md:text-xl mb-10 max-w-2xl mx-auto">
        Platform ticketing nomor satu untuk akses eksklusif konser dan festival musik terbesar di Indonesia.
      </p>
      <div class="flex flex-col md:flex-row justify-center">
        <a href="#event" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-full font-bold shadow-xl shadow-blue-600/20">
          Cek Tiket Sekarang
        </a>
      </div>
    </div>
  </section>

  <section class="py-24 px-6 bg-white" id="event">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
      <div>
        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-6">
          <img src="icon 1.png" class="w-10 h-10">
        </div>
        <h4 class="text-xl font-bold mb-2">Keamanan Terjamin</h4>
        <p class="text-slate-500 text-sm">Tiket menggunakan QR Code unik yang terenkripsi untuk mencegah duplikasi.</p>
      </div>
      <div>
        <div class="w-16 h-16 bg-blue-50 text-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-6">
          <img src="icon 2.png" class="w-10 h-10">
        </div>
        <h4 class="text-xl font-bold mb-2">Instan E-Tiket</h4>
        <p class="text-slate-500 text-sm">Setelah pembayaran dikonfirmasi, tiket langsung masuk ke dashboard kamu.</p>
      </div>
      <div>
        <div class="w-16 h-16 bg-blue-50 text-purple-600 rounded-3xl flex items-center justify-center mx-auto mb-6">
          <img src="icon.png" class="w-10 h-13 object-cover">
        </div>
        <h4 class="text-xl font-bold mb-2">Harga Kompetitif</h4>
        <p class="text-slate-500 text-sm">Tidak ada biaya admin tersembunyi. Harga jujur sesuai kategori tiket.</p>
      </div>
    </div>
  </section>

  <footer class="bg-blue-950 p-8 border-t border-slate-100 text-center">
    <h2 class="text-2xl font-extrabold mb-6 text-white">CONCER<span class="text-blue-600">TIVA</span></h2>
    <p class="text-white text-sm">&copy; 2026 TiketKonser Project.All rights reserved</p>
  </footer>

</body>
</html>
