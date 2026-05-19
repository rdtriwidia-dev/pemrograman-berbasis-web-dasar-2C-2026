<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin' || !isset($_POST['update'])) {
    header("Location: events-manage.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_POST['id']);
$name = mysqli_real_escape_string($conn, $_POST['concert_name']);
$date = $_POST['date'];
$location = mysqli_real_escape_string($conn, $_POST['location']);
$price = $_POST['price'];
$stock = $_POST['stock'];
$organizer = mysqli_real_escape_string($conn, $_POST['organizer']);

$description = mysqli_real_escape_string($conn, $_POST['description']);

if ($_FILES['image']['name'] != "") {
   
    $res = $conn->query("SELECT image FROM tickets WHERE id = '$id'");
    $old_data = $res->fetch_assoc();
    
    if ($old_data && file_exists("uploads/" . $old_data['image'])) {
        unlink("uploads/" . $old_data['image']);
    }

    $image_name = $_FILES['image']['name'];
    $extension = pathinfo($image_name, PATHINFO_EXTENSION);
    $new_image_name = time() . '_' . rand(100, 999) . '.' . $extension; 
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $new_image_name);

    $query = "UPDATE tickets SET 
              concert_name='$name', 
              date='$date', 
              location='$location', 
              price='$price', 
              stock='$stock', 
              description='$description', 
              organizer='$organizer', 
              image='$new_image_name' 
              WHERE id='$id'";
} else {
   
    $query = "UPDATE tickets SET 
              concert_name='$name', 
              date='$date', 
              location='$location', 
              price='$price', 
              stock='$stock', 
              description='$description', 
              organizer='$organizer' 
              WHERE id='$id'";
}

if ($conn->query($query)) {
 
    header("Location: events-manage.php?status=success&msg=Event berhasil diperbarui!");
} else {

    header("Location: events-manage.php?status=error&msg=Gagal memperbarui database.");
}
exit;