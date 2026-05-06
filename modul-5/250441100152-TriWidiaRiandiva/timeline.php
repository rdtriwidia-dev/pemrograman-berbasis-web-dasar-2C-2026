<?php
$riwayat_belajar = [
    ["waktu" => "Agustus 2025", "event" => "Masuk Sistem Informasi UTM", "isi" => "Pada bulan Agustus 2025, saya resmi masuk ke jurusan Sistem Informasi di Universitas Trunojoyo Madura. Momen ini menjadi awal perjalanan saya sebagai mahasiswa yang ingin mendalami dunia teknologi. Dengan semangat baru, saya mulai mengenal lingkungan kampus, dosen, dan teman‑teman yang sama‑sama punya minat di bidang IT."],
    ["waktu" => "Februari 2026", "event" => "Mulai mengenal dan belajar HTML", "isi" => "Memasuki Februari 2026, saya mulai mengenal dan belajar HTML. Dari sinilah saya memahami bagaimana sebuah halaman web dibentuk menggunakan tag sederhana seperti h1, p, dan a. Meski tampilan awal masih polos, pengalaman ini membuka wawasan bahwa setiap elemen kecil punya peran penting dalam menyusun informasi agar lebih teratur."],
    ["waktu" => "Maret 2026", "event" => "Belajar JavaScript", "isi" =>"Pada Maret 2026, saya melanjutkan perjalanan dengan belajar JavaScript. Bahasa ini membuat halaman web menjadi lebih interaktif dan dinamis. Dari sekadar tampilan statis, saya mulai bisa menambahkan logika, efek, dan interaksi yang membuat website terasa hidup. Proses belajar ini menantang, tetapi juga menyenangkan karena saya bisa melihat hasil langsung di browser."],
    ["waktu" => "April 2026", "event" => "Mengenal PHP", "isi" => "Kemudian di bulan April 2026, saya mulai mengenal PHP. Bahasa ini membuka pintu untuk memahami bagaimana server bekerja dan bagaimana data bisa diproses di balik layar. Dengan PHP, saya belajar membuat halaman web yang tidak hanya menampilkan informasi, tetapi juga bisa menerima input dari pengguna dan menyimpannya."]
];

function highlight($waktu, $event) {
    if ($waktu == "Agustus 2025") {
        return "<span class='font-bold text-blue-900'>$event</span>";
    } else {
        return $event;
    }
}
?>

<html>
<head>
    <title>Timeline Belajar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-500/30 p-8">

    <h2 class="text-4xl font-bold text-black text-center mb-8">Timeline Belajar <span class="text-4xl font-bold text-blue-700">Coding</span></h2>

    <div class="max-w-4xl mx-auto space-y-6">
        <?php foreach ($riwayat_belajar as $data) { ?>
            <div class="bg-blue-50 shadow-md rounded-lg p-6 border border-blue-200  transform duration-300 hover:scale-105 hover:shadow-xl">
                <h3 class="text-xl font-bold text-blue-700 mb-2">
                    <?php echo $data['waktu']; ?>
                </h3>
                <p class="text-lg mb-2">
                    <?php echo highlight($data['waktu'], $data['event']); ?>
                </p>
                <p class="text-gray-700">
                    <?php echo $data['isi']; ?>
                </p>
            </div>
        <?php } ?>
    </div>

    <div class="flex justify-center items-center mt-12 space-x-4">
    <a href="index.php" 
       class="bg-blue-800 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">Kembali ke Profil
    </a>
    <a href="blog.php" 
       class="bg-blue-800 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">Menuju Blog Developer
    </a>
    </div>

</body>
</html>
