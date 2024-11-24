<?php
    require_once 'phpProcesses/functions.php';
    session_start();

    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
        exit();
    }

    if (isset($_POST['simpan'])) {
        // Assign default values if inputs are empty
        $nama = !empty($_POST['nama']) ? $_POST['nama'] : $_SESSION['nama_lengkap'];
        $kantin = !empty($_POST['kantin']) ? $_POST['kantin'] : $_SESSION['nama_kantin'];
        $telepon = !empty($_POST['telepon']) ? $_POST['telepon'] : $_SESSION['nomor_telepon'];
        $email = !empty($_POST['email']) ? $_POST['email'] : $_SESSION['email'];
        $passwordLama = $_POST['password_lama'];
        $passwordBaru = $_POST['password_baru'];
        $konfirmasiPassword = $_POST['konfirmasi_password'];

        // Validate password inputs
        if (!empty($passwordBaru) || !empty($konfirmasiPassword)) {
            if ($passwordBaru != $konfirmasiPassword) {
                echo 'Password baru dan konfirmasi password tidak sama';
            } else if (!password_verify($passwordLama, $_SESSION['password'])) {
                echo 'Password lama salah';
            } else if (password_verify($passwordBaru, $_SESSION['password'])) {
                echo 'Password baru tidak boleh sama dengan password lama';
            } else {
                $_SESSION['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT); // Update the session password
            }
        }

        // Update profile in the database
        $updatedData = [
            'nama' => $nama,
            'kantin' => $kantin,
            'telepon' => $telepon,
            'email' => $email,
            'password' => $_SESSION['password'],
        ];

        if (updatePenjual($updatedData)) {
            // Update session data
            $_SESSION['nama_lengkap'] = $nama;
            $_SESSION['nama_kantin'] = $kantin;
            $_SESSION['nomor_telepon'] = $telepon;
            $_SESSION['email'] = $email;

            echo '<script>
                alert("Data berhasil diubah");
                window.location.href = "berandaadmin.php";
            </script>';
            exit();
        } else {
            echo 'Update penjual gagal';
        }
    }

    if (isset($_POST['gantiFoto'])) {
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['foto']['tmp_name'];
            $foto_name = uniqid() . '_' . basename($_FILES['foto']['name']);
            $foto_path = 'img/' . $foto_name;

            if (move_uploaded_file($tmp_name, $foto_path)) {
                $id = $_SESSION['id'];
                $conn = connection();
                $query = "UPDATE penjual SET foto_profile = '$foto_name' WHERE id = '$id'";
                if (mysqli_query($conn, $query)) {
                    $_SESSION['foto'] = $foto_name;
                    echo '<script>alert("Foto berhasil diunggah!"); window.location.href = "profilpenjual.php";</script>';
                } else {
                    echo '<script>alert("Gagal mengupdate foto di database.");</script>';
                }
            } else {
                echo '<script>alert("Gagal mengunggah foto.");</script>';
            }
        }
    }
?>


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
                    <form action="profilpenjual.php" method="post" enctype="multipart/form-data">
                        <div class="preview-profile">
                            <img id="preview" src="assets/person-brown.png" alt="Preview">
                        </div>
                        <div class="upload-photo">
                            <button type="submit" name="gantiFoto">Ganti Photo Profile</button>
                        </div>  
                    </form>
                </div>

                <form action="profilpenjual.php" method="post">
                    <div class="tombol">
                        <button type="submit" name="simpan">Simpan Perubahan</button>
                        <a href="berandaadmin.php"class="beranda"><div><span>Beranda</span></div></a>
                        <a class="logout" href="logout.php" ><div><span>Keluar Akun</span></div></a>
                    </div>
                </div>
                <div class="kanan">
                    <div class="input">
                        <label for="nama">Nama Lengkap Penjual</label>
                        <input type="text" id="nama" name="nama" value="<?php echo $_SESSION['nama_lengkap']?>" placeholder="<?php echo $_SESSION['nama_lengkap']?>">
                    </div>
                    <div class="input">
                        <label for="kantin">Nama Kantin</label>
                        <input type="text" id="kantin" name="kantin" value="<?php echo $_SESSION['nama_kantin']?>" placeholder="<?php echo $_SESSION['nama_kantin']?>">
                    </div>
                    <div class="input">
                        <label for="telepon">Nomor Telepon</label> 
                        <input type="text" id="telepon" name="telepon" value="<?php echo $_SESSION['nomor_telepon']?>" placeholder="<?php echo $_SESSION['nomor_telepon']?>">
                    </div>
                    <div class="input">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']?>" placeholder="<?php echo $_SESSION['email']?>">
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
                </form>

            </div>
        </section>
    <section class="footer">
         <p>Copyright © 2024 KantinTeknik</p>
    </section>
</body>
</html>