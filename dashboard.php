<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit;
}

include 'database.php';

// Fetch user details from the database (Optional: customize as needed)
$user_id = $_SESSION['user_id'];
$query = "SELECT username FROM users WHERE id = '$user_id'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Shopatcreme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: white;
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background: linear-gradient(to right, #a7097a, #0066ff);
        }
        .navbar-brand img {
            width: 40px;
            height: auto;
            border-radius: 50%;
        }
        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
        }
        .navbar-nav .nav-link:hover {
            color: #ffb3e6 !important;
        }
        .container {
            margin-top: 50px;
            color: white;
        }
        .card {
            box-shadow: 0 20px 40px rgba(167, 9, 122, 0.2);
            border-radius: 20px;
            margin-top: 30px;
            background: #ffffff;
            color: #333;
        }
        .card-header {
            background: linear-gradient(to right, #a7097a, #0066ff);
            color: white;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }
        .card-body {
            padding: 30px;
        }
        .btn-custom {
            background-color: #a7097a;
            border-color: #a7097a;
            color: white;
            border-radius: 10px;
            width: 100%;
            font-size: 1.1rem;
        }
        .btn-custom:hover {
            background-color: #0066ff;
            border-color: #0066ff;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">
                <img src="logo.png" alt="Shopatcreme Logo"> <!-- Replace with your logo -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="account.php">
                            <i class="bi bi-person-circle"></i> <?= $user['username']; ?> <!-- Display the logged-in user's name -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container">
        <div class="card">
            <div class="card-header">
                Welcome, <?= $user['username']; ?>!
            </div>
            <div class="card-body">
                <h4 class="text-center">Your Dashboard</h4>
                <p class="text-center">This is your personal dashboard. You can manage your account, view your cart, and much more!</p>
                <div class="row">
                    <div class="col-md-4">
                        <a href="cart.php" class="btn btn-custom">
                            <i class="bi bi-box"></i> View Cart
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="catalog.php" class="btn btn-custom">
                            <i class="bi bi-shop"></i> Shop Now
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="help.php" class="btn btn-custom">
                            <i class="bi bi-question-circle"></i> Help & Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
