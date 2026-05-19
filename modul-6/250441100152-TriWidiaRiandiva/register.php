<?php
session_start();
include 'includes/db.php'; 

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Email sudah terdaftar, silakan login";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Registrasi gagal";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Registrasi - Tiket Konser Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex">

  <div class="w-1/2 bg-blue-950 flex flex-col justify-center text-white p-10">
    <h1 class="text-5xl font-extrabold mb-1 text-white">CONCER<span class="text-blue-600">TIVA</span></h1>
    <p class="text-justify">Buat akun baru dan mulai pesan tiket konser favoritmu!</p>
  </div>

  <div class="w-1/2 flex items-center justify-center bg-white">
    <div class="w-full max-w-md px-8">
      <p class="text-center text-gray-700 mb-6 text-lg font-semibold">
        Silakan isi data di bawah untuk membuat akun baru.
      </p>

      <?php if(isset($error)): ?>
        <p class="bg-red-100 text-red-600 p-2 rounded mb-4"><?= htmlspecialchars($error); ?></p>
      <?php endif; ?>

      <form action="" method="POST" class="space-y-4">
        <div>
          <label class="block text-gray-700">Username</label>
          <input type="text" name="username" required class="w-full px-4 py-2 border rounded">
        </div>
        <div>
          <label class="block text-gray-700">Email</label>
          <input type="email" name="email" required class="w-full px-4 py-2 border rounded">
        </div>
        <div>
          <label class="block text-gray-700">Password</label>
          <input type="password" name="password" required minlength="6" class="w-full px-4 py-2 border rounded">
        </div>
        <div>
          <label class="block text-gray-700">Role</label>
          <select name="role" required class="w-full px-4 py-2 border rounded">
            <option value="user">User</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <button type="submit" name="register" class="w-full bg-blue-950 text-white py-2 rounded hover:bg-blue-800">Daftar</button>
      </form>

      <p class="text-center text-gray-600 mt-4">
        Sudah punya akun? <a href="login.php" class="text-blue-950 hover:underline">Login di sini</a>
      </p>
    </div>
  </div>

</body>
</html>
