<?php
    require '../phpProcesses/functions.php';
    session_start();
    
    if(!isset($_SESSION['temp_menu_data'])){
        $data = getMenu();
        $_SESSION['temp_menu_data'] = $data;
    }

    foreach ($_SESSION['temp_menu_data'] as &$menu) {
        if (!isset($menu['foto_lama'])) {
            $menu['foto_lama'] = $menu['foto'] ?? ''; // Assign current 'foto' or an empty string as default
        }
    }
    unset($menu); // break reference with the last element

    if(isset($_POST['save_changes'])){
        if (sendPayload($_SESSION['temp_menu_data'])) {
            unset($_SESSION['temp_menu_data']);
            header('Location: ../berandaadmin.php');
            exit();
        } else {
            echo 'Simpan perubahan gagal';
        }
    }

    if(isset($_POST['cancel_changes'])){
        $tempDir = '../img_temp/';
    
        // Check if the directory exists
        if (is_dir($tempDir)) {
            // Get all files in the directory
            $files = glob($tempDir . '*'); // Grabs all files in the directory

            // Loop through each file and delete it
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        unset($_SESSION['temp_menu_data']);
        header('Location: ../berandaadmin.php');
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <link rel="stylesheet" href="../styles/editmenu.css">
</head>
<body>
    <header class="navbar">
        <img src="assets/logo.png" alt="">
        <a href="https://www.google.com">
            <div>
                <span>Log Out</span>
            </div>
        </a>
    </header>
    <section class="judul">
        <div class="judul-content">
            <h1>Edit Menu</h1>
            <form action="index.php" method="post">
                <button type="submit" name="cancel_changes"><div>
                    <span>Batalkan Perubahan</span>
                </div></button>
                <button type="submit" name="save_changes"><div>
                    <span>Simpan Perubahan</span>
                </div></button>    
            </form>
        </div>
        <hr>
    </section>
    <section class="edit">
        <a href="../tambah/" class="tambah-menu">
            <div>
                <img src="../assets/plus-sm.png" alt="">
            </div>
        </a>

        <?php foreach($_SESSION['temp_menu_data'] as $menu) : ?>
        <div class="detail-menu">
            <div>
                <img src="<?php echo file_exists("../img/".$menu['foto']) ? '../img/'.$menu['foto'] : '../img_temp/'.$menu['foto']?>" alt="placeholder">
                <span><?php echo $menu['nama']?></span>
                <p><?php $menu['kategori']?></p>
                <p><?php $menu['harga']?></p>
            </div>
            <a href="../ubah/index.php?id=<?php echo $menu['id']?>" class="tombol-edit">
                <span>Ubah</span>
            </a>
            <a href="" class="tombol-edit">
                <span>Hapus</span>
            </a>
        </div>
        <?php endforeach; ?>

    </section>
    <section class="footer">
        <hr>
        <div class="footer-content">
            <p>Copyright © 2024 KantinTeknik</p>
            <a href="../berandaadmin.php">
                <div>
                    <span>Kembali</span>
                </div>
            </a>
        </div>
    </section>
</body>
</html>
