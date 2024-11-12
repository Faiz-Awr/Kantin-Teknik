<?php
    require '../phpProcesses/functions.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $menu = findMenu($id);
    }

    if(isset($_POST['ubah'])){
        if(updateMenu($_POST, $_FILES, $id)){
            header('Location: ../menu');
        } else {
            echo 'Ubah menu gagal';
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
            <div class="form-content">
                <div class="image-upload">
                    <button class="upload-icon">
                        <img src="../img/<?php echo $menu['foto']?>" alt="Image Preview" style="max-width: 100px; max-height: 100px;">
                    </button>
                </div>
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
                    
                    <button type="submit" class="add-button">Ubah</button>
                </div>
            </div>
            </form>
            <button type="button" class="back-button">Kembali</button>
        </div>
        <footer>Copyright &copy;  2024 KantinTeknik</footer>
    </section>
</body>
</html>