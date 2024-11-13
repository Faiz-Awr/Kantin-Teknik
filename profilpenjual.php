<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Penjual</title>
    <link rel="stylesheet" href="styles/profilpenjual.css">
</head>
<body>
    <?php include("navbar.php")?>
    <section class="profil">
        <h1>Profile Penjual</h1>
        <div class="inputan">
            <div class="kiri">
                <div class="photo">
                    <div class="preview-profile">
                        <img id="preview" src="assets/person-brown.png" alt="Preview">
                    </div>
                    <br><hr><br>
                    <div class="upload-photo">
                        <img src="assets/profil.png" alt="">
                        <button>Ganti Photo Profile</button>
                    </div>  
                </div>
                <div class="tombol">
                    <button>Simpan Perubahan</button>
                    <a href="berandaadmin.php">Kembali Ke Beranda</a>
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
            <div class="kanan">
                <div class="input">
                    <label for="nama">Nama Lengkap Penjual</label><br>
                    <input type="text" id="nama" name="nama">
                </div>
                <div class="input">
                    <label for="kantin">Nama Kantin</label><br>
                    <input type="text" id="kantin" name="kantin">
                </div>
                <div class="input">
                    <label for="telepon">Nomor Telepon</label><br>
                    <input type="text" id="telepon" name="telepon">
                </div>
                <div class="input">
                    <label for="email">Email</label><br>
                    <input type="email" id="email" name="email">
                </div>
                <div class="input">
                    <label for="password_lama">Password lama</label><br>
                    <input type="password" id="password_lama" name="password_lama">
                </div>
                <div class="input">
                    <label for="password_baru">Password Baru</label><br>
                    <input type="password" id="password_baru" name="password_baru"><br>
                    <input type="password" id="confirm_password_baru" name="confirm_password_baru">
                </div>
            </div>
        </div>
    </section>
</body>
</html>