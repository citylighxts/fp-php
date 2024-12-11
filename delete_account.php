<?php
session_start();

// Enable error reporting to see issues clearly
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection
include 'database.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit;
}

$user_id = $_SESSION['user_id'];

// Begin transaction to ensure data integrity
mysqli_begin_transaction($koneksi);

try {
    // Delete orders associated with the user (you can add more tables if needed)
    $delete_orders_query = "DELETE FROM appleMusicOrders WHERE user_id = '$user_id'";
    mysqli_query($koneksi, $delete_orders_query);

    $delete_orders_query = "DELETE FROM canvaOrders WHERE user_id = '$user_id'";
    mysqli_query($koneksi, $delete_orders_query);

    $delete_orders_query = "DELETE FROM gptOrders WHERE user_id = '$user_id'";
    mysqli_query($koneksi, $delete_orders_query);

    // Delete the user account from the 'users' table
    $delete_user_query = "DELETE FROM users WHERE id = '$user_id'";
    mysqli_query($koneksi, $delete_user_query);

    // Commit the transaction
    mysqli_commit($koneksi);

    // Destroy the session and redirect to the login page
    session_destroy();
    header('Location: index.php'); // Redirect to login page after account deletion
    exit;

} catch (Exception $e) {
    // Rollback the transaction in case of error
    mysqli_roll_back($koneksi);
    echo "Error deleting account: " . $e->getMessage();
    exit;
}
?>
