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
    <form action="index.php" method="POST">
    <div class="main-container">
        <img src="../assets/logo-login.png" width="100px" class="logo">
        <div class="register-form">
                <p class="header">Form Registrasi</p>
                <p class="nama-lengkap">Nama Lengkap</p>
                <input type="text" placeholder="Nama Lengkap" name="nama_lengkap">
            <p class="nama-kantin">Nama Kantin</p>
            <input type="text" placeholder="Nama Kantin" name="nama_kantin">
            <div class="register-form-main">
                <div class="register-form2">
                    <p class="nomor-telepon">Nomor Telepon</p>
                    <input type="tel" placeholder="Nomor Telepon" pattern="[0-9]{10,15}" name="nomor_telepon">
                    <p class="password">Password</p>
                    <input type="password" placeholder=" Password" name="password">
                </div>
                <div class="register-form1">
                    <p class="email">E-mail</p>
                    <input type="email" placeholder="E-mail" class="email" name="email">
                    <p class="password">Konfirmasi Password</p>
                    <input type="password" placeholder="Konfirmasi Password" name="konfirmasi_password">
                </div>
            </div>
            <input type="submit" value="Register" name="register" class="btn-register">
        </div>
        <p class="login">Anda sudah terdaftar sebagai penjual?  <a href="../login" style="text-decoration: none; color: black; font-weight: bolder;">Login</a></p>
        <p class="copyright">Copyright © 2024 KantinTeknik</p>
    </div>
    </form>
</body>
</html>