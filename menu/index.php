<?php
    require '../phpProcesses/functions.php';

    $data = getMenu();
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
        <img src="../assets/logo.png" alt="">
        <a href="https://www.google.com">
            <div>
                <span>Log Out</span>
            </div>
        </a>
    </header>
    <section class="judul">
        <div class="judul-content">
            <h1>Edit Menu</h1>
            <button><div>
                <span>Batalkan Perubahan</span>
            </div></button>
            <button><div>
                <span>Simpan Perubahan</span>
            </div></button>    
        </div>
        <hr>
    </section>
    <section class="edit">
        <a href="" class="tambah-menu">
            <div>
                <img src="../assets/plus-sm.png" alt="">
            </div>
        </a>
        <?php foreach($data as $menu) : ?>
        <div class="detail-menu">
            <div>
                <img src="../img/<?php echo $menu['foto']?>" alt="placeholder">
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