<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: login');
        exit();
    }

    if(isset($_SESSION['temp_menu_data'])){
        unset($_SESSION['temp_menu_data']);
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="styles/berandaadmin.css">
</head>
<body>
    <header class="navbar">
        <img src="assets/logo.png" alt="">
        <a href="berandaadmin.php">
            <div>
                <span>Log Out</span>
            </div>
        </a>
    </header>
    <section class="judul">
        <h2>Selamat Datang <?php echo $_SESSION['nama_lengkap']?></h2>
        <h1><?php echo $_SESSION['nama_kantin']?></h1>
    </section>
    <section class="menu">
        <div class="menu-admin">
            <a href="profilpenjual.php" class="link-menu-admin">
                <div class="list-menu-admin">
                    <div class="icon-menu-admin">
                        <img src="assets/person.png" alt="">
                    </div>
                    <h2>Profil Penjual</h2>
                </div> 
            </a>
            <a href="menu" class="link-menu-admin">
                <div class="list-menu-admin">
                    <div class="icon-menu-admin">
                        <img src="assets/pencil-square.png" alt="">
                    </div>
                    <h2>Edit Menu</h2>
                </div>
            </a>
            <a href="lihatantrian.php" class="link-menu-admin">
                <div class="list-menu-admin">
                    <div class="icon-menu-admin">
                        <img src="assets/receipt-cutoff.png" alt="">
                    </div>
                    <h2>Lihat Antrian</h2>
                </div>
            </a>
        </div>
        <a href="profilpenjual.php" class="keluar-button">
            <div>
                <span>Keluar</span>
            </div>
        </a>
    </section>
    <section class="footer">
        <div class="kontak">
            <p>Hubungi E-mail berikut jika ada kendala!</p>
            <p>kantinteknik@kantinteknik.co.id</p>
        </div>
        <p>Copyright © 2024 KantinTeknik</p>
    </section>
</body>
</html>