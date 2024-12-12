<?php
include 'database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match!";
        header('Location: register.php');
        exit;
    }

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['register_error'] = "Username already exists!";
        header('Location: register.php');
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['register_success'] = "Registration successful! You can now log in.";
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['register_error'] = "Error registering user. Please try again.";
        header('Location: register.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Shopatcreme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #a7097a 0%, #0066ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .card {
            box-shadow: 0 20px 40px rgba(167, 9, 122, 0.2);
            border-radius: 20px;
            max-width: 400px;
            width: 100%;
            transition: all 0.5s ease;
            overflow: hidden;
            box-sizing: border-box;
        }
        .card:hover {
            transform: perspective(1000px) rotateX(-10deg);
            box-shadow: 0 30px 50px rgba(167, 9, 122, 0.3);
        }
        .card-header {
            background: linear-gradient(to right, #a7097a, #0066ff);
            color: white;
            padding: 1.5rem;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            text-align: center;
            font-size: 1.7rem;
            font-weight: bold;
            box-sizing: border-box;
        }
        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            padding: 12px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background-color: #a7097a;
            border-color: #a7097a;
            margin-bottom: 15px;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            color: white;
            width: 100%;
        }
        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(167, 9, 122, 0.3);
            background-color: #0066ff;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 10px;
        }
        .form-check-label {
            font-size: 0.9rem;
        }
        .card-body {
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Shopatcreme Register
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['register_error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['register_error']; ?>
                    </div>
                    <?php unset($_SESSION['register_error']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['register_success'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['register_success']; ?>
                    </div>
                    <?php unset($_SESSION['register_success']); ?>
                <?php endif; ?>

                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required placeholder="Choose a username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Choose a password">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="Confirm your password">
                    </div>
                    <button type="submit" class="btn">
                        <i class="bi bi-person-plus-fill"></i> Register
                    </button>
                </form>
                <div class="text-center mt-3">
                    <a href="index.php" class="text-decoration-none">Already have an account? Login</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
