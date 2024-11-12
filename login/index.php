<?php
    require '../phpProcesses/functions.php';
    session_start();

    if(isset($_POST['Login'])){
        if(login($_POST)){
            header('Location: ../berandaadmin.php');
        } else {
            echo '<script>alert("Login gagal")
            document.location.href = "#";
            </script>';
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kantin Teknik</title>
    <link rel="stylesheet" href="../styles/login.css">
</head>
<body>
    <form action="login.php" method="POST">
    <div class="main-container">   
        <div class="container-foto">
                <img src="../assets/foto-login.png" width="100%">
            </div>
            <div class="container-form">
            <img src="../assets/logo-login.png" class="logo">
            <div class="form">
                <p class="head">Login</p>
                <p class="email">Email</p>    
                <input type="email" placeholder="Email" name="email"> 
                <p class="password">Password</p>   
                <input type="password" placeholder="Password" name="password">
                <div class="captcha-area">
                    <div class="captcha-image">
                        <img src="../assets/captcha-background.jpg" class="gambar-captcha">
                        <span class="captcha-text"></span>
                    </div>
                    <p class="captcha">Captcha</p>
                    <input type="text" placeholder="Masukkan captcha...">    
                </div>
                <input class="captcha-input" type="submit" value="Login" name="Login" class="btn-login">
            </div>
            <p class="register">Anda belum terdaftar sebagai penjual?<a href="register.php" style="text-decoration: none; color: black; font-weight: bolder;"><br>Register</a> </p>
        </div>
    </div>
    </form>
<script src="../scripts/login.js"></script>
</body>
</html>