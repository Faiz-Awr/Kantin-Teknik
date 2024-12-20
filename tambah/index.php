<?php
    require '../phpProcesses/functions.php';
    session_start();

    if(isset($_POST['tambah'])){
        if(addMenu($_POST, $_FILES)){
            header('Location: ../menu');
            exit();
        } else {
            echo 'Tambah menu gagal';
        }
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu</title>
    <link rel="stylesheet" href="../styles/tambah.css">
</head>
<body>
    <header class="navbar">
        <img src="../assets/logo.png" alt="">
        <span class="nav-judul">Kantin Teknik</span>
        <a href="berandaadmin.php">
            <a href="logout.php">
                <div>
                    <span>Keluar Akun</span>
                </div>
            </a>
        </a>
    </header>
    <section class="menu-section">
        <div class="form-container">
            <h1>Tambah Menu</h1>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <div class="form-content">
                    <div class="image-upload">
                        <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;">
                        <button type="button" class="upload-icon" onclick="document.getElementById('imageInput').click();">&#11014;</button>
                        <img id="imagePreview" src="#" alt="Image Preview" >
                    </div>
                    <script>
                        document.getElementById('imageInput').addEventListener('change', function(event) {
                            var reader = new FileReader();
                            reader.onload = function() {
                                var preview = document.getElementById('imagePreview');
                                preview.src = reader.result;
                                preview.style.display = 'block';
                                document.querySelector('.upload-icon').style.display = 'none';
                            }
                            reader.readAsDataURL(event.target.files[0]);
                        });

                        document.getElementById('imagePreview').addEventListener('click', function() {
                            document.getElementById('imageInput').click();
                        });
                    </script>

                    <div class="menu-form">
                        <div>
                            <label>Nama Menu</label>
                            <input type="text" placeholder="placeholder" name="nama_menu">
                        </div>
                        <div>
                            <label>Harga</label>
                            <input type="text" placeholder="placeholder" name="harga">
                        </div>
                        <div>
                            <label>Kategori</label>
                            <select name="kategori">
                                <option value="makanan berat">Makanan Ringan</option>
                                <option value="makanan ringan">Makanan Berat</option>
                                <option value="minuman">Minuman</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tombol-form">
                    <button type="button" class="back-button">Kembali</button>
                    <button type="submit" class="add-button" name="tambah">Tambah</button>
                </div>
            </form>
        </div>
        <footer>Copyright &copy;  2024 KantinTeknik</footer>
    </section>

    <script>
        document.querySelector('.back-button').addEventListener('click', function() {
            window.location.href = '../menu';
        });
    </script>
</body>
</html>
