<?php
include 'database.php';

$id = $_GET['id'];

$query_foto = "SELECT foto FROM siswa WHERE id_siswa = $id";
$result_foto = mysqli_query($koneksi, $query_foto);
$siswa = mysqli_fetch_assoc($result_foto);

unlink('upload/' . $siswa['foto']);

$query = "DELETE FROM siswa WHERE id_siswa = $id";
mysqli_query($koneksi, $query);

header("Location: daftar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Hapus Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff0f5;
        }
        .card-header {
            background: linear-gradient(to right, #a7097a, #8a0662) !important;
            color: white;
        }
        .btn-danger {
            background-color: #a7097a !important;
            border-color: #a7097a !important;
        }
        .btn-secondary {
            background-color: #8a0662 !important;
            border-color: #8a0662 !important;
        }
        .alert-danger {
            background-color: #ffeaf0;
            border-color: #a7097a;
            color: #a7097a;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white d-flex align-items-center">
                <i class="bi bi-exclamation-triangle me-3 fs-4"></i>
                <h2 class="mb-0">Konfirmasi Hapus Data Siswa</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="upload/<?= $siswa['foto'] ?>" class="img-fluid rounded-circle mb-3" style="max-width: 250px;">
                    </div>
                    <div class="col-md-8">
                        <div class="alert alert-danger" role="alert">
                            <strong>Peringatan!</strong> Anda yakin ingin menghapus data siswa berikut?
                        </div>
                        <table class="table">
                            <tr>
                                <th>ID Siswa</th>
                                <td><?= $siswa['id_siswa'] ?></td>
                            </tr>
                            <tr>
                                <th>Nama Siswa</th>
                                <td><?= $siswa['nama_siswa'] ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= $siswa['email'] ?></td>
                            </tr>
                        </table>
                        <form method="POST">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="daftar_siswa.php" class="btn btn-secondary me-md-2">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                                <button type="submit" name="konfirmasi" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Hapus Permanen
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
