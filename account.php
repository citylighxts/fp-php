<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

include 'database.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT username, password FROM users WHERE id = '$user_id'";
$result = mysqli_query($koneksi, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    die("User not found!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['update_profile'])) {
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);

        $update_query = "UPDATE users SET username='$username' WHERE id='$user_id'";

        if (mysqli_query($koneksi, $update_query)) {
            $success_msg = "Profile updated successfully!";
            $user['username'] = $username;
        } else {
            $error_msg = "Error updating profile!";
        }
    }

    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (password_verify($current_password, $user['password'])) {
            if ($new_password === $confirm_password) {
                $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $update_password_query = "UPDATE users SET password='$new_password_hashed' WHERE id='$user_id'";

                if (mysqli_query($koneksi, $update_password_query)) {
                    $success_msg = "Password changed successfully!";
                } else {
                    $error_msg = "Error changing password!";
                }
            } else {
                $error_msg = "New password and confirm password do not match!";
            }
        } else {
            $error_msg = "Current password is incorrect!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Shopatcreme</title>
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
            color: black;
        }
        .card {
            box-shadow: 0 20px 40px rgba(167, 9, 122, 0.2);
            border-radius: 20px;
            margin-top: 30px;
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
        .card-footer {
            background: #f8f9fa;
            padding: 20px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            display: flex;
            justify-content: center;
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
                Account Settings
            </div>
            <div class="card-body">
                <?php if (isset($success_msg)): ?>
                    <div class="alert alert-success"><?= $success_msg; ?></div>
                <?php endif; ?>
                <?php if (isset($error_msg)): ?>
                    <div class="alert alert-danger"><?= $error_msg; ?></div>
                <?php endif; ?>

                <h4 class="text-center">Your Profile</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" required>
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-custom">
                        <i class="bi bi-save"></i> Save Changes
                    </button>
                </form>

                <hr>

                <h4 class="text-center">Change Password</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" name="change_password" class="btn btn-custom">
                        <i class="bi bi-lock"></i> Change Password
                    </button>
                </form>
            </div>

            <div class="card-footer">
                <form action="delete_account.php" method="POST">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
