<?php
session_start();
include 'includes/db.php';

if (!isset($_GET['id'])) { 
  header("Location: mytickets.php"); 
  exit; 
}

$trx_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$query = "SELECT tr.*, t.concert_name, t.date, t.location, t.organizer, t.image, u.username 
          FROM transactions tr
          JOIN tickets t ON tr.ticket_id = t.id
          JOIN users u ON tr.user_id = u.id
          WHERE tr.id = '$trx_id' AND tr.user_id = '$user_id' AND tr.status = 'success'";

$result = $conn->query($query);
$data = $result->fetch_assoc();

if (!$data) { 
  echo "Tiket tidak valid atau belum lunas"; 
  exit; 
}

$poster = 'uploads/' . $data['image'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>E-Ticket - <?= htmlspecialchars($data['concert_name']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-slate-900 p-4 md:p-12 min-h-screen flex flex-col items-center">

  <div class="max-w-5xl w-full mx-auto">
    <div class="mb-8 flex justify-between items-center bg-white/5 p-4 rounded-3xl border border-white/5">
      <a href="mytickets.php" class="text-xs font-bold uppercase text-slate-400 hover:text-blue-400 flex items-center gap-2 pl-2">Kembali</a>

      <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-2xl text-xs font-bold uppercase flex items-center gap-2 shadow-lg shadow-blue-600/20">Cetak Tiket</button>
    </div>

    <div class="ticket-main bg-white rounded-[40px] shadow-2xl overflow-hidden flex flex-col md:flex-row border-[8px] border-white relative">
      
     
      <div class="flex-1 p-10 md:p-14 text-white flex flex-col justify-between min-h-[480px] relative">
        
        <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('<?= $poster ?>');"></div>
       
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 via-slate-900/40 to-slate-900/20"></div>
        
        <div class="relative z-10 flex flex-col justify-between h-full">
          <div>
            <div class="flex items-center gap-3 mb-6">
              <div class="h-6 w-1 bg-blue-500 rounded-full"></div>
              <p class="text-[10px] font-bold uppercase  text-blue-400">Official Concertiva Ticket</p>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold">
              <?= strtoupper(htmlspecialchars($data['concert_name'])) ?>
            </h1>
            <p class="text-lg font-bold text-slate-300">Organized by <?= htmlspecialchars($data['organizer']) ?></p>
          </div>

          <div class="grid grid-cols-2 gap-10 border-t border-white/10 pt-10">
            <div>
              <p class="text-[9px] uppercase text-white mb-2">Tanggal</p>
              <p class="text-xl font-extrabold uppercase"><?= date('d F Y', strtotime($data['date'])) ?></p>
            </div>
            <div>
              <p class="text-[9px] uppercase text-white mb-2">Lokasi Venue</p>
              <p class="text-xl font-extrabold uppercase"><?= htmlspecialchars($data['location']) ?></p>
            </div>
          </div>
        </div>
      </div>

     
      <div class="w-full md:w-80 p-10 bg-slate-800 text-white flex flex-col items-center justify-between">
        
        <div class="text-center w-full">
          <p class="text-[10px] font-bold text-slate-500 uppercase mb-3">Pemegang Tiket</p>
          <div class="bg-white/5 py-3 px-4 rounded-2xl border border-white/5">
            <p class="text-lg font-black text-blue-400 uppercase"><?= htmlspecialchars($data['username']) ?></p>
          </div>
        </div>

        <div class="flex flex-col items-center my-8">
          <div class="bg-white p-4 rounded-3xl shadow-2xl">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=TRX:<?= $data['id'] ?>-<?= urlencode($data['username']) ?>" class="w-36 h-36">
          </div>
          <p class="text-[9px] font-bold text-slate-500 mt-6 uppercase">Scan saat Masuk</p>
        </div>

        <div class="w-full">
          <div class="bg-blue-600 py-3 rounded-2xl text-center shadow-lg shadow-blue-600/20">
            <p class="text-xs font-bold"><?= $data['quantity'] ?> PERSON</p>
          </div>
          <p class="text-[8px] text-slate-600 font-bold text-center mt-4 uppercase">
            Concertiva Project<br>Validated Digital Pass
          </p>
        </div>
      </div>
    </div>

    <div class="mt-12 text-center">
      <p class="text-slate-600 text-[10px] font-bold uppercase">
        Jangan tunjukkan QR Code ini kepada siapapun.<br>Panitia tidak bertanggung jawab atas penyalahgunaan tiket.
      </p>
    </div>
  </div>

</body>
</html>
