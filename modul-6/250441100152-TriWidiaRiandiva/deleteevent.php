<?php
session_start();
include 'includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    

    $check = $conn->query("SELECT image FROM tickets WHERE id = $id");
    $data = $check->fetch_assoc();
    
    if ($data) {
        $image_path = "uploads/" . $data['image'];
        if (file_exists($image_path)) {
            unlink($image_path); 
        }
        
        $delete = $conn->query("DELETE FROM tickets WHERE id = $id");
        if ($delete) {
            header("Location: events-manage.php?status=success&msg=Event berhasil dihapus.");
        } else {
            header("Location: events-manage.php?status=error&msg=Gagal menghapus data.");
        }
    }
} else {
    header("Location: events-manage.php");
}
?>