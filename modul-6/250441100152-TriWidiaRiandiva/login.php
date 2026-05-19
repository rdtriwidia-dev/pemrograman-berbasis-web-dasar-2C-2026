<?php
session_start();
include 'includes/db.php';

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result(); // ambil hasil query

    if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); //ambil datanya
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['role']       = $user['role'];
        $_SESSION['user_email'] = $user['email'];

        if ($_SESSION['role'] === 'admin') {
            header("Location: dasboard-admin.php");
            exit;
        } else {
            header("Location: dasboard-user.php");
            exit;
        }

    } else {
        $error = "Password salah!";
    }
} else {
    $error = "User tidak ditemukan!";
}

}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Tiket Konser Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex">

  <div class="w-1/2 bg-blue-950 flex flex-col justify-center text-white p-10">
    <h1 class="text-5xl font-extrabold mb-1 text-white">CONCER<span class="text-blue-600">TIVA</span></h1>
    <p class="text-justify">Nikmati pengalaman pesan tiket konser favoritmu dengan mudah dan cepat.</p>
  </div>

  <div class="w-1/2 flex items-center justify-center bg-white">
    <div class="w-full max-w-md px-8">
      <p class="text-center text-gray-700 mb-6 text-lg font-semibold">
        Selamat datang kembali! Silakan masuk untuk melanjutkan ke akun Anda.
      </p>

      <?php if(isset($error)): ?>
        <p class="bg-red-100 text-red-600 p-2 rounded mb-4"><?= htmlspecialchars($error); ?></p>
      <?php endif; ?>

      <form action="" method="POST" class="space-y-4">
        <div>
          <label class="block text-gray-700">Email</label>
          <input type="email" name="email" required class="w-full px-4 py-2 border rounded">
        </div>
        <div>
          <label class="block text-gray-700">Password</label>
          <input type="password" name="password" required class="w-full px-4 py-2 border rounded">
        </div>
        <button type="submit" name="login" class="w-full bg-blue-950 text-white py-2 rounded hover:bg-blue-800">Masuk</button>
      </form>

      <p class="text-center text-gray-600 mt-4">
        Belum punya akun? <a href="register.php" class="text-blue-950 hover:underline">Daftar di sini</a>
      </p>
    </div>
  </div>

</body>
</html>
