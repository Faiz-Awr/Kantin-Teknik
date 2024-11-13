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
    <section class="menu-section">
        <header>
            <img src="../assets/logo.png" alt="Logo KantinTeknik" class="logo">
            <button class="logout-button">Log Out</button>
        </header>
        
        <div class="form-container">
        <h1>Tambah Menu</h1>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <div class="form-content">
                <div class="image-upload">
                    <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;">
                    <button type="button" class="upload-icon" onclick="document.getElementById('imageInput').click();">&#11014;</button>
                    <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 100px; max-height: 100px;">
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
                    <label><b>Nama Menu</b></label>
                    <input type="text" placeholder="placeholder" name="nama_menu">
                    
                    <label><b>Harga</b></label>
                    <input type="text" placeholder="placeholder" name="harga">
                    
                    <label><b>Kategori</b></label>
                    <select name="kategori">
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                    </select>
                    
                    <button type="submit" class="add-button" name="tambah">Tambah</button>
                </div>
            </form>
            </div>
            <button type="button" class="back-button">Kembali</button>
        <footer>Copyright &copy;  2024 KantinTeknik</footer>
    </section>

    <script>
        document.querySelector('.back-button').addEventListener('click', function() {
            window.location.href = '../menu';
        });
    </script>
</body>
</html>
