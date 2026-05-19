<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$result = $conn->query("SELECT * FROM tickets ORDER BY date ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Kelola Event</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
      <div>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kelola Event</h1>
        <p class="text-slate-500 mt-1">Manajemen konten konser dan ketersediaan tiket</p>
      </div>
      <button onclick="document.getElementById('addEventForm').classList.toggle('hidden')" 
              class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg shadow-sm hover:bg-indigo-700">Tambah Event Baru
      </button>
    </div>

    <div id="addEventForm" class="hidden mb-10 transition-all duration-300">
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
          <h3 class="font-bold text-lg">Detail Event Baru</h3>
        </div>
        <form method="POST" action="addevent.php" enctype="multipart/form-data" class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Event</label>
                <input type="text" name="concert_name" placeholder="Contoh: Coldpaly Live in Jakarta" class="w-full border-slate-200 rounded-lg p-2.5 border" required>
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal</label>
                  <input type="date" name="date" class="w-full border-slate-200 rounded-lg p-2.5 border" required>
                </div>
                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi</label>
                  <input type="text" name="location" placeholder="Stadion GBK" class="w-full border-slate-200 rounded-lg p-2.5 border" required>
                </div>
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp)</label>
                  <input type="number" name="price" placeholder="0" class="w-full border-slate-200 rounded-lg p-2.5 border" required>
                </div>
                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1">Stok Tiket</label>
                  <input type="number" name="stock" placeholder="100" class="w-full border-slate-200 rounded-lg p-2.5 border" required>
                </div>
              </div>
            </div>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="4" placeholder="Tuliskan detail acara..." class="w-full border-slate-200 rounded-lg p-2.5 border"></textarea>
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Poster Event</label>
                <input type="file" name="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
              </div>
            </div>
          </div>
          <div class="mt-6 flex justify-end space-x-3">
            <button type="button" onclick="document.getElementById('addEventForm').classList.add('hidden')" class="px-4 py-2 text-slate-600 hover:text-slate-800 font-medium">Batal</button>
            <button type="submit" name="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 shadow-md">Simpan Event</button>
          </div>
        </form>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-slate-50 border-b border-slate-200">
              <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Event</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Info Detail</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Harga & Stok</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
              <?php while($row = $result->fetch_assoc()): ?>
              <tr>
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <img src="uploads/<?= htmlspecialchars($row['image']); ?>" class="w-14 h-14 object-cover rounded-lg shadow-sm border border-slate-200">
                    <div class="ml-4">
                      <div class="text-sm font-bold text-slate-900"><?= htmlspecialchars($row['concert_name']); ?></div>
                      <div class="text-xs text-slate-500 mt-1 flex items-center">
                        <?= htmlspecialchars($row['location']); ?>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                    <?= date('d M Y', strtotime($row['date'])); ?>
                  </span>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm font-semibold text-slate-900">Rp <?= number_format($row['price'],0,',','.'); ?></div>
                  <div class="text-xs <?= $row['stock'] < 10 ? 'text-red-500' : 'text-green-600' ?> font-medium mt-1">
                    <?= htmlspecialchars($row['stock']); ?> tiket tersedia
                  </div>
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                  <a href="editevent.php?id=<?= $row['id']; ?>" class="inline-flex items-center px-3 py-1.5 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-md hover:bg-slate-50 shadow-sm"> Edit
                  </a>
                  <a href="deleteevent.php?id=<?= $row['id']; ?>" 
                     onclick="return confirm('Apakah Anda yakin ingin menghapus event ini? Data tidak bisa dikembalikan.')" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 text-xs font-semibold rounded-md hover:bg-red-100 transition-all">Hapus
                  </a>
                </td>
              </tr>
              <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>
</html>