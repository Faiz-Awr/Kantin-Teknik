<?php
    require '../phpProcesses/functions.php';
    session_start();

    $id = isset($_GET['id']) ? $_GET['id'] : null;
    foreach ($_SESSION['temp_menu_data'] as  $menu) {
        if ($menu['id'] == $id) {
            $menu = $menu;
            break;
        }
    }
    
    if (isset($_POST['ubah'])) {
        $id = $_POST['id'] ?? $id;
        $fotoLama = $_POST['foto_lama'];

        if (updateMenu($_POST, $_FILES, $id, $fotoLama)) {
            header('Location: ../menu');
            exit;
        } else {
            echo
            '<script>alert("Ubah menu gagal")
            document.location.href = "index.php?id='.$id.'";
            </script>';
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Menu</title>
    <link rel="stylesheet" href="../styles/ubah.css">
</head>
<body>
    <section class="menu-section">
        <header>
            <img src="../assets/logo.png" alt="Logo KantinTeknik" class="logo">
            <button class="logout-button">Log Out</button>
        </header>
        
        <div class="form-container">
            <h1>Ubah Menu</h1>
            <form action="index.php" method="post" enctype="multipart/form-data">   
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="foto_lama" value="<?= $menu['foto'] ?>">
            <div class="form-content">
                <div class="image-upload">
                    <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;">
                    <button type="button" class="upload-icon" onclick="document.getElementById('imageInput').click();"></button>
                    <img id="imagePreview" src="../img/<?php echo $menu['foto']; ?>" alt="Image Preview" style="display: block; max-width: 100px; max-height: 100px;">
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
                    <input type="text" placeholder="<?php echo $menu['nama']?>" value="<?php echo $menu['nama']?>" name="nama_menu">
                    
                    <label><b>Harga</b></label>
                    <input type="text" placeholder="<?php echo $menu['harga']?>" value="<?php echo $menu['harga']?>" name="harga">
                    
                    <label><b>Kategori</b></label>
                    <select name="kategori">
                        <option value="makanan" <?php echo $menu['kategori'] == 'makanan' ? 'selected' : '';?>>Makanan</option>
                        <option value="minuman" <?php echo $menu['kategori'] == 'minuman' ? 'selected' : '';?>>Minuman</option>
                    </select>
                    
                    <button type="submit" class="add-button" name="ubah">Ubah</button>
                </div>
            </div>
            </form>
            <button type="button" class="back-button" >Kembali</button>
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