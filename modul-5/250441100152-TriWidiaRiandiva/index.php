<html>
<head>
    <title>Profil Interaktif Developer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-500/50 p-8">
    <div class="text-center mb-10">
        <h2 class="text-4xl font-bold text-black">Profil Interaktif <span  class="text-4xl font-bold text-blue-900">Developer Pemula</span></h2>
    </div>

    <div class="w-full max-w-5xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden mb-10 border border-blue-200">
        <div class="bg-blue-800 text-center text-black p-4">
            <h3 class="text-xl text-blue-100 font-bold">Data Profil</h3>
        </div>
        <table class="table-auto w-full">
            <tr class="border-b">
                <th class="text-left px-6 py-3 bg-blue-50">Nama</th>
                <td class="px-6 py-3">T.W. Riandiva</td>
            </tr> 
            <tr class="border-b">
                <th class="text-left px-6 py-3 bg-blue-50">ID Developer</th>
                <td class="px-6 py-3">250-152</td>
            </tr>
            <tr class="border-b">
                <th class="text-left px-6 py-3 bg-blue-50">Kota/Tgl Lahir</th>
                <td class="px-6 py-3">Bangkalan, 22 November 2006</td>
            </tr>
            <tr class="border-b">
                <th class="text-left px-6 py-3 bg-blue-50">Email</th>
                <td class="px-6 py-3">250441100152@student.trunojoyo.ac.id</td>
            </tr>
            <tr>
                <th class="text-left px-6 py-3 bg-blue-50">WhatsApp</th>
                <td class="px-6 py-3">+62 895378596677</td>
            </tr>
        </table>
    </div>

    <div class="max-w-5xl mx-auto bg-blue-50 shadow-lg rounded-lg p-8 border border-blue-200">
        <h3 class="text-3xl font-bold text-center text-blue-800 mb-6">Form Isian</h3>
        <form method="POST" class="space-y-6">
            <div>
                <label class="font-medium text-blue-700 mb-1">Framework/Tools :</label>
                <input type="text" name="frameworks" required 
                       class="w-full border border-blue-300 rounded px-4 py-2">
            </div>
            
            <div>
                <label class="font-medium text-blue-700 mb-1">Cerita Pengalaman:</label>
                <textarea name="cerita" required 
                          class="w-full border border-blue-300 rounded px-4 py-2"></textarea>
            </div>
            
            <div>
                <label class="font-medium text-blue-700 mb-1">Tools Penunjang:</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="flex items-center space-x-2"><input type="checkbox" name="tools" value="VS Code"> <span>VS Code</span></label>
                    <label class="flex items-center space-x-2"><input type="checkbox" name="tools" value="GitHub"> <span>GitHub</span></label>
                    <label class="flex items-center space-x-2"><input type="checkbox" name="tools" value="Figma"> <span>Figma</span></label>
                    <label class="flex items-center space-x-2"><input type="checkbox" name="tools" value="Postman"> <span>Postman</span></label>
                </div>
            </div>

            <div>
                <label class="font-medium text-blue-700 mb-1">Minat Bidang:</label>
                <div class="flex space-x-4">
                    <label><input type="radio" name="minat" value="Frontend"> Frontend</label>
                    <label><input type="radio" name="minat" value="Backend"> Backend</label>
                    <label><input type="radio" name="minat" value="Fullstack"> Fullstack</label>
                </div>
            </div>
            
            <div>
                <label class="font-medium text-blue-700 mb-1">Tingkat Skill:</label>
                <select name="level" class="w-full border border-blue-300 rounded px-4 py-2">
                    <option value="Dasar">Dasar</option>
                    <option value="Cukup">Cukup</option>
                    <option value="Profesional">Profesional</option>
                </select>
            </div>
            
            <button type="submit" name="submit" 
                    class="w-full bg-blue-800 text-white font-semibold py-2 rounded hover:bg-blue-600">
                Kirim
            </button>
        </form>
    </div>

    <?php
    function tampilkanBaris($label, $data) {
        if (is_array($data)) {
            $data = implode(", ", $data); 
        }
         return "<tr><td class='border px-4 py-2 font-medium text-blue-700'>$label</td><td class='border px-4 py-2'>$data</td></tr>";
    }

        if (!empty($_POST['frameworks']) && !empty($_POST['cerita']) 
        && !empty($_POST['minat']) && !empty($_POST['level']) 
        && !empty($_POST['tools'])) {


            $fwInput = $_POST['frameworks'];
            $fwArray = explode(",", $fwInput);

            echo "<div class='max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-6 border border-blue-200'>";
            echo "<h3 class='text-lg font-semibold text-blue-700 mb-4'>Hasil Input Data:</h3>";

            if (count($fwArray) > 2) {
                echo "<p class='text-black font-medium mb-3'>Skill Anda cukup luas di bidang development!</p>";
            }

            echo "<table class='table-auto w-full border border-blue-300 mb-4'>";
            echo "<tr class='bg-blue-100'><th class='px-4 py-2 text-left'>Kategori</th><th class='px-4 py-2 text-left'>Detail</th></tr>";
            echo tampilkanBaris("Frameworks", $fwArray);
            echo tampilkanBaris("Tools", ['tools']);
            echo tampilkanBaris("Minat", ['minat']);
            echo tampilkanBaris("Level", ['level']);
            echo "</table>";

            echo "<p><b>Pengalaman:</b><br>" . $_POST['cerita'] . "</p>";
            echo "</div>";
        } else {
            echo "<script>alert('Semua input wajib diisi!');</script>";
        }
    
    ?>

    <div class="flex justify-center items-center mt-12 space-x-4">
    <a href="blog.php" 
       class="bg-blue-800 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">Menuju Blog Developer
    </a>
    <a href="timeline.php" 
       class="bg-blue-800 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">
        Kembali ke Timeline
    </a>
    </div>


</body>
</html>
