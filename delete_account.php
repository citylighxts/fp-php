<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];

mysqli_begin_transaction($koneksi);

try {
    $delete_orders_query = "DELETE FROM appleMusicOrders WHERE user_id = '$user_id'";
    mysqli_query($koneksi, $delete_orders_query);

    $delete_orders_query = "DELETE FROM canvaOrders WHERE user_id = '$user_id'";
    mysqli_query($koneksi, $delete_orders_query);

    $delete_orders_query = "DELETE FROM gptOrders WHERE user_id = '$user_id'";
    mysqli_query($koneksi, $delete_orders_query);

    $delete_user_query = "DELETE FROM users WHERE id = '$user_id'";
    mysqli_query($koneksi, $delete_user_query);

    mysqli_commit($koneksi);

    session_destroy();
    header('Location: index.php');
    exit;

} catch (Exception $e) {
    mysqli_roll_back($koneksi);
    echo "Error deleting account: " . $e->getMessage();
    exit;
}
?>
