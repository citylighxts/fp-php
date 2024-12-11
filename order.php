<?php
session_start();
include 'database.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit;
}

// Process form submission
if (isset($_POST['submit'])) {
    $product = $_GET['product']; // Get the product type (apple_music)
    $plan_name = $_POST['plan_name']; // Get the selected plan
    $email = $_POST['email']; // Get the user's email
    $foto = $_FILES['foto']['name']; // Get the uploaded photo
    $tmp = $_FILES['foto']['tmp_name']; // Temporary file location

    // Ensure the photo is uploaded
    $fotoPath = 'upload/' . basename($foto);
    if (move_uploaded_file($tmp, $fotoPath)) {
        echo "File berhasil diupload!";
    } else {
        echo "Terjadi kesalahan saat mengupload file.";
        exit;
    }

    // Prepare data for database insertion
    $user_id = $_SESSION['user_id'];
    $query = "INSERT INTO appleMusicOrders (user_id, plan_name, email, proof_photo) 
              VALUES ('$user_id', '$plan_name', '$email', '$foto')";
    
    if (mysqli_query($koneksi, $query)) {
        echo "Order berhasil dilakukan!";
        header("Location: catalog.php"); // Redirect after successful order
        exit;
    } else {
        echo "Terjadi kesalahan saat memproses pesanan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order - Apple Music Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            color: white;
        }
        .btn-secondary {
            background-color: #0066ff;
            border-color: #0066ff;
            color: white;
            border-radius: 10px;
            width: 100%;
            font-size: 1.1rem;
            margin-top: 10px;
        }
        .btn-secondary:hover {
            background-color: #a7097a;
            border-color: #a7097a;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Order Apple Music Plan</h2>
    <form action="order.php?product=apple_music" method="post" enctype="multipart/form-data">
        <!-- Plan Selection -->
        <div class="mb-3">
            <label for="plan_name" class="form-label">Select Plan</label>
            <select name="plan_name" class="form-control" required>
                <option value="1 Month: 20k">1 Month: 20k</option>
                <option value="2 Months: 25k">2 Months: 25k</option>
                <option value="3 Months: 30k">3 Months: 30k</option>
                <option value="1 Year (Family Plan Join): Contact Us">1 Year (Family Plan Join): Contact Us</option>
            </select>
        </div>

        <!-- Email Input -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <!-- File Upload (Proof of Transaction) -->
        <div class="mb-3">
            <label for="foto" class="form-label">Upload Proof of Transaction (Photo)</label>
            <input type="file" name="foto" class="form-control" accept="image/*" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="submit" class="btn btn-custom">Submit Order</button>

        <!-- Back Button -->
        <a href="catalog.php" class="btn btn-secondary">Back to Catalog</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
