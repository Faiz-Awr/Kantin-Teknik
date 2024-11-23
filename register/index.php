<?php
    require '../phpProcesses/functions.php';
    if(isset($_POST['register'])){
        if (strlen($_POST['password']) < 8) {
            echo '<script>
            alert("Password minimal 8 karakter");
            document.location.href = "../register";
            </script>';
        }

        if ($_POST['password'] != $_POST['konfirmasi_password']) {
            echo '<script>
            alert("Password tidak sama");
            document.location.href = "../register";
            </script>';
        }

        if(register($_POST) == 1){
            header('Location: ../login');
            exit();
        } else if (register($_POST) == -1) {
            echo '<script>
            alert("Email sudah terdaftar");
            document.location.href = "../register";
            </script>';
        } else {
            echo '<script>
            alert("Register gagal");
            document.location.href = "../register";
            </script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../styles/register.css">
</head>
<body>
    <form action="index.php" method="POST" class="form-regis">
        <div class="main-container">
            <img src="../assets/logo-login.png" class="logo">
            <div class="register-form">
                    <h1 class="header">Form Registrasi</h1>
                    <label for="nama_lengkap" class="nama-lengkap">Nama Lengkap</label>
                    <input type="text" placeholder="Nama Lengkap" name="nama_lengkap" id="nama_lengkap">
                <label for="nama_kantin" class="nama-kantin">Nama Kantin</label>
                <input type="text" placeholder="Nama Kantin" name="nama_kantin" id="nama_kantin">
                <div class="register-form-main">
                    <div class="register-form2">
                        <label for="nomor_telepon" class="nomor-telepon">Nomor Telepon</label>
                        <input type="tel" placeholder="Nomor Telepon" pattern="[0-9]{10,15}" name="nomor_telepon" id="nomor_telepon">
                        <label for="password" class="password">Password</label>
                        <input type="password" placeholder="Password" name="password" id="password">
                    </div>
                    <div class="register-form1">
                        <label for="email" class="email">E-mail</label>
                        <input type="email" placeholder="E-mail" name="email" id="email">
                        <label for="konfirmasi_password" class="password">Konfirmasi Password</label>
                        <input type="password" placeholder="Konfirmasi Password" name="konfirmasi_password" id="konfirmasi_password">
                    </div>
                </div>
                <div class="tombol">
                    <input type="submit" value="Daftar" name="register" class="btn-register">
                </div>
            </div>
            <p class="login">Anda sudah terdaftar sebagai penjual?  <a href="../login" style="text-decoration: none; color: black; font-weight: bolder;">Masuk</a></p>
            <p class="copyright">Copyright © 2024 KantinTeknik</p>
        </div>
    </form>
</body>
</html>