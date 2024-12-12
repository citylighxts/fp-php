<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

include 'database.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT username FROM users WHERE id = '$user_id'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die('User not found.');
}

$total_items = 0;

$query_last_purchase = "
    SELECT created_at FROM (
        SELECT created_at FROM canvaOrders WHERE user_id = '$user_id'
        UNION ALL
        SELECT created_at FROM gptOrders WHERE user_id = '$user_id'
        UNION ALL
        SELECT created_at FROM appleMusicOrders WHERE user_id = '$user_id'
    ) AS all_orders
    ORDER BY created_at DESC LIMIT 1
";
$result_last_purchase = mysqli_query($koneksi, $query_last_purchase);
$last_purchase = mysqli_fetch_assoc($result_last_purchase);
$last_purchase_date = $last_purchase ? $last_purchase['created_at'] : 'No purchases yet';

session_regenerate_id(true);
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

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">
                <img src="logo.png" alt="Shopatcreme Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="account.php">
                            <i class="bi bi-person-circle"></i> <?= $user['username']; ?>
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

    <div class="container">
        <div class="card">
            <div class="card-header">
                Welcome, <?= $user['username']; ?>!
            </div>

            <div class="card-body">
                <h4 class="text-center">Your Dashboard</h4>
                <p class="text-center">Welcome back, <strong><?= htmlspecialchars($user['username']); ?></strong>! We're glad to have you here.</p>
                <p class="text-center">From here, you can easily manage your account, check your cart, or start shopping for new items!</p>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Your Cart</h5>
                                <p class="card-text">Manage your items in the cart and proceed to checkout.</p>
                                <a href="cart.php" class="btn btn-custom">
                                    <i class="bi bi-box"></i> View Cart (<?= $total_items; ?> items)
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Shop Now</h5>
                                <p class="card-text">Explore our catalog and start shopping for new products.</p>
                                <a href="catalog.php" class="btn btn-custom">
                                    <i class="bi bi-shop"></i> Shop Now
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Need Help?</h5>
                                <p class="card-text">If you have any questions or need assistance, we're here to help!</p>
                                <a href="https://instagram.com/shopatcreme" class="btn btn-custom" target="_blank">
                                    <i class="bi bi-question-circle"></i> Help & Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h5 class="text-center">Quick Overview</h5>
                    <p class="text-center">Here’s a quick look at your recent activity:</p>
                    <ul class="list-group">
                        <li class="list-group-item">Total items in cart: <strong><?= $total_items; ?></strong></li>
                        <li class="list-group-item">Last purchase: <strong><?= $last_purchase_date; ?></strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
