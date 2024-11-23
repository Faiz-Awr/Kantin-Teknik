<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Penjual</title>
    <link rel="stylesheet" href="styles/profilpenjual.css">
</head>
<body>
    <header class="navbar">
        <img src="assets/logo.png" alt="">
        <span>Kantin Teknik</span>
    </header>
    <section class="profil">
        <h1>Profile Penjual</h1>
        <div class="inputan">
            <div class="kiri">
                <div class="photo">
                    <div class="preview-profile">
                        <img id="preview" src="assets/person-brown.png" alt="Preview">
                    </div>
                    <div class="upload-photo">
                        <button>Ganti Photo Profile</button>
                    </div>  
                </div>
                <div class="tombol">
                    <button>Simpan Perubahan</button>
                    <a href="berandaadmin.php"class="beranda"><div><span>Beranda</span></div></a>
                    <a class="logout" href="logout.php" ><div><span>Keluar Akun</span></div></a>
                </div>
            </div>
            <div class="kanan">
                <div class="input">
                    <label for="nama">Nama Lengkap Penjual</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap">
                </div>
                <div class="input">
                    <label for="kantin">Nama Kantin</label>
                    <input type="text" id="kantin" name="kantin" placeholder="Masukkan nama kantin">
                </div>
                <div class="input">
                    <label for="telepon">Nomor Telepon</label>
                    <input type="text" id="telepon" name="telepon" placeholder="Masukkan nomor telepon">
                </div>
                <div class="input">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email">
                </div>
                <div class="input">
                    <label for="password_lama">Password lama</label>
                    <input type="password" id="password_lama" name="password_lama" placeholder="Masukkan password lama">
                </div>
                <div class="input">
                    <label for="password_baru">Password Baru</label>
                    <input type="password" id="password_baru" name="password_baru" placeholder="Masukkan password baru">
                </div>
                <div class="input">
                    <label for="konfirmasi_password">Konfirmasi Password</label>
                    <input type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Konfirmasi password baru">
                </div>
            </div>
        </div>
    </section>
    <section class="footer">
         <p>Copyright © 2024 KantinTeknik</p>
    </section>
</body>
</html>