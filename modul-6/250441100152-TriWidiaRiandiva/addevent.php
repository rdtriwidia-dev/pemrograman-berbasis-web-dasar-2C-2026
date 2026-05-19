<?php
session_start();
include 'includes/db.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['concert_name']);
    $date = $_POST['date'];
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $organizer = mysqli_real_escape_string($conn, $_POST['organizer']);
    
    $image_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $extension = pathinfo($image_name, PATHINFO_EXTENSION);
    $new_image_name = time() . '.' . $extension; 
    $path = "uploads/" . $new_image_name;

    if (move_uploaded_file($tmp_name, $path)) {
        $query = "INSERT INTO tickets (concert_name, date, location, price, stock, organizer, image) 
                  VALUES ('$name', '$date', '$location', '$price', '$stock', '$organizer', '$new_image_name')";
        
        if ($conn->query($query)) {
            header("Location: events-manage.php?status=success&msg=Event berhasil ditambahkan!");
        } else {
            header("Location: events-manage.php?status=error&msg=Gagal menyimpan ke database");
        }
    } else {
        header("Location: events-manage.php?status=error&msg=Gagal upload gambar.");
    }
}
?>