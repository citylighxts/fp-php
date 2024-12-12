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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog - Shopatcreme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
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
        }
        .card {
            box-shadow: 0 20px 40px rgba(167, 9, 122, 0.2);
            border-radius: 20px;
            margin-top: 30px;
            background: white;
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
            margin-top: 10px;
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
                        <a class="nav-link" href="dashboard.php">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
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
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        🖌️ Canva
                    </div>
                    <div class="card-body">
                        <h5>Member (Design +1k):</h5>
                        <ul>
                            <li>1 Day: 1k</li>
                            <li>7 Days: 4k</li>
                            <li>1 Month: 10k</li>
                            <li>3 Months: 12k</li>
                            <li>6 Months: 14k</li>
                            <li>1 Year (6 months warranty): 16k</li>
                            <li>1 Year (Full warranty): 18k</li>
                        </ul>
                        <h5>Lifetime:</h5>
                        <ul>
                            <li>1 Year Warranty: 25k</li>
                            <li>6 Month Warranty: 15k</li>
                        </ul>
                        <p>Note: Designers can add fonts and templates. Members and Lifetime plans cannot.</p>
                        <a href="order.php?product=canva" class="btn btn-custom">
                            Order Now
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        🤖 ChatGPT
                    </div>
                    <div class="card-body">
                        <h5>1 Month (No warranty):</h5>
                        <ul>
                            <li>Sharing Plan: 35k</li>
                            <li>Private Plan: 120k</li>
                        </ul>
                        <h5>1 Month (Full warranty):</h5>
                        <ul>
                            <li>Sharing Plan: 45k</li>
                            <li>Private Plan (Max 8 devices): 205k</li>
                        </ul>
                        <a href="order.php?product=chatgpt" class="btn btn-custom">
                            Order Now
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        🎶 Apple Music
                    </div>
                    <div class="card-body">
                        <h5>Subscription Plans:</h5>
                        <ul>
                            <li>1 Month: 20k</li>
                            <li>2 Months: 25k</li>
                            <li>3 Months: 30k</li>
                        </ul>
                        <h5>1 Year:</h5>
                        <p>Only available through Family Plan join (Max 2 times, not 2 months, but 2 joins).</p>
                        <a href="order.php?product=apple_music" class="btn btn-custom">
                            Order Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
