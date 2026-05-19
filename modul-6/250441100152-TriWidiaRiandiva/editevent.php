<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: events-manage.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$result = $conn->query("SELECT * FROM tickets WHERE id = '$id'");
$event = $result->fetch_assoc();

if (!$event) {
    header("Location: events-manage.php?status=error&msg=Event tidak ditemukan");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 p-4 md:p-10">

    <div class="max-w-4xl mx-auto"> <a href="events-manage.php" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 mb-6">Kembali ke Daftar Event</a>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-xl font-bold">Edit Informasi Event</h2>
                <p class="text-sm text-slate-500 italic"><?= htmlspecialchars($event['concert_name']) ?></p>
            </div>

            <form action="updateevent_process.php" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                <input type="hidden" name="id" value="<?= $event['id'] ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold mb-1">Nama Konser</label>
                            <input type="text" name="concert_name" value="<?= htmlspecialchars($event['concert_name']) ?>" class="w-full border-slate-200 rounded-lg p-2.5 border" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-1">Penyelenggara</label>
                            <input type="text" name="organizer" value="<?= htmlspecialchars($event['organizer']) ?>" class="w-full border-slate-200 rounded-lg p-2.5 border" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold mb-1">Tanggal</label>
                                <input type="date" name="date" value="<?= $event['date'] ?>" class="w-full border-slate-200 rounded-lg p-2.5 border" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-1">Stok Tiket</label>
                                <input type="number" name="stock" value="<?= $event['stock'] ?>" class="w-full border-slate-200 rounded-lg p-2.5 border" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-1">Lokasi</label>
                            <input type="text" name="location" value="<?= htmlspecialchars($event['location']) ?>" class="w-full border-slate-200 rounded-lg p-2.5 border" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-1">Harga (Rp)</label>
                            <input type="number" name="price" value="<?= $event['price'] ?>" class="w-full border-slate-200 rounded-lg p-2.5 border" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-1">Deskripsi Event</label>
                            <textarea name="description" rows="5" class="w-full border-slate-200 rounded-lg p-2.5 border text-sm" placeholder="Masukkan detail acara..."><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-sm font-bold mb-1">Poster Event</label>
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center bg-slate-50/30">
                            <p class="text-xs text-slate-400 mb-3 uppercase font-bold">Preview Saat Ini</p>
                            <img src="uploads/<?= $event['image'] ?>" class="w-full h-64 object-cover rounded-xl shadow-sm mb-4 border border-white">
                            <input type="file" name="image" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                            <p class="text-[10px] text-slate-400 mt-2">*Biarkan kosong jika tidak ingin mengganti gambar</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="submit" name="update" class="bg-indigo-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>