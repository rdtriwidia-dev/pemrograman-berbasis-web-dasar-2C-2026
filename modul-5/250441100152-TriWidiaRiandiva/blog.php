<?php
$artikel = [
    "html" => ["judul" => "Belajar HTML Pertama Kali",
     "tanggal" => "10-02-2026", 
     "konten" => "Belajar HTML pertama kali bagi saya adalah pengalaman dasar untuk memahami bagaimana sebuah halaman web dibentuk. Awalnya saya hanya melihat tag‑tag sederhana h1, p, dan a, namun dari situ saya mulai memahami bagaimana struktur sebuah halaman dibentuk. Meski tampilan awalnya masih polos, pengalaman ini memberi kesadaran bahwa setiap elemen kecil punya peran penting dalam menyusun informasi agar lebih teratur",  
     "gambar" => "img/html.png", 
     "referensi" => "https://www.w3schools.com/html/" ],

    "error" => ["judul" => "Error Pertama",
    "tanggal" => "20-02-2026", 
    "konten" => "Eror pertama saat belajar HTML saya alami ketika menulis atribut yang salah ketik. Waktu itu saya menulis herf pada tag <a> bukannya href, sehingga tautan tidak bisa diklik. Dari kesalahan kecil itu saya sadar pentingnya ketelitian dalam penulisan kode, karena satu huruf saja bisa membuat fungsi tidak berjalan. Sejak itu saya terbiasa memeriksa ulang setiap baris dan mencoba hasilnya di browser untuk memastikan tidak ada typo", 
    "gambar" => "img/error.png", 
    "referensi" => "https://www.w3schools.com/html/"],
];

$quotes = [
    "Teknologi terus berubah, belajar harus terus berjalan.",
    "Belajar konsisten lebih penting daripada cepat."
];

$randomQuote = $quotes[array_rand($quotes)];
?>

<html>
<head>
    <title>Blog Reflektif Developer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-500/50 p-8">

    <div class="text-center mb-8">
        <h2 class="text-4xl font-bold text-gray-800">
            Blog Reflektif <span class="text-blue-800">Developer</span>
        </h2>
        <p class="text-gray-800 mt-2">
            Catatan perjalanan, dan pembelajaran coding.
        </p>
    </div>

    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <a href="?id=html" class="bg-blue-50 border border-blue-200 rounded-lg shadow-lg p-4 text-center text-blue-900 font-semibold transform duration-300 hover:scale-105 hover:shadow-xl">Belajar HTML Pertama Kali
        </a>
        <a href="?id=error" class="bg-blue-50 border border-blue-200 rounded-lg shadow-lg p-4 text-center text-blue-900 font-semibold transform duration-300 hover:scale-105 hover:shadow-xl">Error Pertama
        </a>
    </div>


    <div class="max-w-5xl mx-auto">
    <?php
    if (!empty($_GET['id']) && isset($artikel[$_GET['id']])) {
        $hasil = $artikel[$_GET['id']];
  
    echo '<div class="bg-blue-50 shadow-lg rounded-lg p-6 border border-blue-200 ">';

    echo "<h3 class='text-2xl text-center font-bold text-blue-700 mb-2'>{$hasil['judul']}</h3>";

    echo "<p class='text-sm text-gray-700 mb-4'><i>Tanggal: {$hasil['tanggal']}</i></p>";

    echo "<p class='text-gray-700 mb-4'>{$hasil['konten']}</p>";

    echo "<img src='{$hasil['gambar']}' class='mx-auto rounded-md shadow-md mb-4 w-72'>";

    echo "<blockquote class='border-l-4 border-blue-500 pl-4 italic text-gray-600 mb-4'>$randomQuote</blockquote>";
    
    echo "<p class='text-sm'>Referensi: <a href='{$hasil['referensi']}' class='text-blue-600 hover:underline'>{$hasil['referensi']}</a></p>";
    echo "</div>";
}
?>
    </div>

    <div class="flex justify-center items-center mt-12 space-x-4">
    <a href="index.php" 
       class="bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">
        Kembali ke Profil
    </a>
    <a href="timeline.php" 
       class="bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">
        Kembali ke Timeline
    </a>
</div>


</body>
</html>




