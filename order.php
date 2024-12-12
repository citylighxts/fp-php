<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['submit'])) {
    $product = $_GET['product'];
    $plan_name = $_POST['plan_name'];
    $email = $_POST['email'];
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    $fotoPath = 'upload/' . basename($foto);
    if (move_uploaded_file($tmp, $fotoPath)) {
        echo "File berhasil diupload!";
    } else {
        echo "Terjadi kesalahan saat mengupload file.";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    
    if ($product == 'apple_music') {
        $query = "INSERT INTO appleMusicOrders (user_id, plan_name, email, proof_photo) 
                  VALUES ('$user_id', '$plan_name', '$email', '$foto')";
    } elseif ($product == 'canva') {
        $query = "INSERT INTO canvaOrders (user_id, plan_name, email, proof_photo) 
                  VALUES ('$user_id', '$plan_name', '$email', '$foto')";
    } elseif ($product == 'gpt') {
        $query = "INSERT INTO gptOrders (user_id, plan_name, email, proof_photo) 
                  VALUES ('$user_id', '$plan_name', '$email', '$foto')";
    }

    if (mysqli_query($koneksi, $query)) {
        echo "Order berhasil dilakukan!";
        header("Location: catalog.php");
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
    <title>Order - Subscription Plan</title>
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
    <h2>Order Subscription Plan</h2>
    <form action="order.php?product=<?= $_GET['product'] ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="plan_name" class="form-label">Select Plan</label>
            <select name="plan_name" class="form-control" required>
                <?php
                if ($_GET['product'] == 'apple_music') {
                    echo '<option value="1 Month: 20k">1 Month: 20k</option>';
                    echo '<option value="2 Months: 25k">2 Months: 25k</option>';
                    echo '<option value="3 Months: 30k">3 Months: 30k</option>';
                } elseif ($_GET['product'] == 'canva') {
                    echo '<option value="1 Day: 1k">1 Day: 1k</option>';
                    echo '<option value="7 Days: 4k">7 Days: 4k</option>';
                    echo '<option value="1 Month: 10k">1 Month: 10k</option>';
                    echo '<option value="3 Months: 12k">3 Months: 12k</option>';
                    echo '<option value="6 Months: 14k">6 Months: 14k</option>';
                    echo '<option value="1 Year (6 months warranty): 16k">1 Year (6 months warranty): 16k</option>';
                    echo '<option value="1 Year (Full warranty): 18k">1 Year (Full warranty): 18k</option>';
                    echo '<option value="Lifetime (1 Year Warranty): 25k">Lifetime (1 Year Warranty): 25k</option>';
                    echo '<option value="Lifetime (6 Month Warranty): 15k">Lifetime (6 Month Warranty): 15k</option>';
                } elseif ($_GET['product'] == 'chatgpt') {
                    echo '<option value="1 Month (Sharing Plan, No warranty): 35k">1 Month (Sharing Plan, No warranty): 35k</option>';
                    echo '<option value="1 Month (Private Plan, No warranty): 120k">1 Month (Private Plan, No warranty): 120k</option>';
                    echo '<option value="1 Month (Sharing Plan, Full warranty): 45k">1 Month (Sharing Plan, Full warranty): 45k</option>';
                    echo '<option value="1 Month (Private Plan, Full warranty, Max 8 devices): 205k">1 Month (Private Plan, Full warranty, Max 8 devices): 205k</option>';
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Upload Proof of Transaction (Photo)</label>
            <input type="file" name="foto" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" name="submit" class="btn btn-custom">Submit Order</button>

        <a href="catalog.php" class="btn btn-secondary">Back to Catalog</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
