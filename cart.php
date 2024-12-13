<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$queryCanva = "SELECT * FROM canvaOrders WHERE user_id = '$user_id'";
$queryGpt = "SELECT * FROM gptOrders WHERE user_id = '$user_id'";
$queryAppleMusic = "SELECT * FROM appleMusicOrders WHERE user_id = '$user_id'";

$resultCanva = mysqli_query($koneksi, $queryCanva);
$resultGpt = mysqli_query($koneksi, $queryGpt);
$resultAppleMusic = mysqli_query($koneksi, $queryAppleMusic);

$queryUser = "SELECT username FROM users WHERE id = '$user_id'";
$resultUser = mysqli_query($koneksi, $queryUser);
$user = mysqli_fetch_assoc($resultUser);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Shopatcreme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
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
        }
        .btn-custom:hover {
            background-color: #0066ff;
            border-color: #0066ff;
        }
        .btn-edit {
            background-color: #0066ff;
            border-color: #0066ff;
            color: white;
            border-radius: 10px;
        }
        .btn-edit:hover {
            background-color: #0047b3;
            border-color: #0047b3;
        }
        .btn-export {
            background-color: #a7097a;
            border-color: #a7097a;
            color: white;
            border-radius: 10px;
            width: 100%;
            font-size: 1.1rem;
            margin-top: 10px;
        }
        .btn-export:hover {
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

    <!-- Cart Content -->
    <div class="container">
        <h2>Your Cart</h2>

        <!-- Display Canva Orders -->
        <?php if (mysqli_num_rows($resultCanva) > 0): ?>
            <div class="card">
                <div class="card-header">
                    Canva Orders
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Email</th>
                                <th>Transaction Proof</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($resultCanva)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['plan_name']); ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                    <td><img src="upload/<?= htmlspecialchars($row['proof_photo']); ?>" alt="Proof" width="100"></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <!-- Display GPT Orders -->
        <?php if (mysqli_num_rows($resultGpt) > 0): ?>
            <div class="card">
                <div class="card-header">
                    ChatGPT Orders
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Email</th>
                                <th>Transaction Proof</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($resultGpt)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['plan_name']); ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                    <td><img src="upload/<?= htmlspecialchars($row['proof_photo']); ?>" alt="Proof" width="100"></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <!-- Display Apple Music Orders -->
        <?php if (mysqli_num_rows($resultAppleMusic) > 0): ?>
            <div class="card">
                <div class="card-header">
                    Apple Music Orders
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Email</th>
                                <th>Transaction Proof</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($resultAppleMusic)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['plan_name']); ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                    <td><img src="upload/<?= htmlspecialchars($row['proof_photo']); ?>" alt="Proof" width="100"></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <?php if (mysqli_num_rows($resultCanva) > 0): ?>
            <a href="export.php?order_type=canva&user_id=<?= $user_id ?>" class="btn btn-export">
                <i class="bi bi-file-earmark"></i> Export to PDF
            </a>
        <?php endif; ?>
        <?php if (mysqli_num_rows($resultGpt) > 0): ?>
            <a href="export.php?order_type=gpt&user_id=<?= $user_id ?>" class="btn btn-export">
                <i class="bi bi-file-earmark"></i> Export to PDF
            </a>
        <?php endif; ?>
        <?php if (mysqli_num_rows($resultAppleMusic) > 0): ?>
            <a href="export.php?order_type=appleMusic&user_id=<?= $user_id ?>" class="btn btn-export">
                <i class="bi bi-file-earmark"></i> Export to PDF
            </a>
        <?php endif; ?>

        <!-- If no orders, display a message -->
        <?php if (mysqli_num_rows($resultCanva) == 0 && mysqli_num_rows($resultGpt) == 0 && mysqli_num_rows($resultAppleMusic) == 0): ?>
            <p>Your cart is empty. Start shopping now!</p>
            <a href="catalog.php" class="btn btn-custom">
                Go to Catalog
            </a>
        <?php endif; ?>

        <?php
            if (isset($_GET['edit_id'])) {
                echo "Edit ID: " . $_GET['edit_id'];  // Debugging, lihat apakah ID muncul
            }
        ?>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
