<?php
    require '../phpProcesses/functions.php';
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $inputCaptcha = isset($_POST['captcha_input']) ? str_replace(' ', '', $_POST['captcha_input']) : '';
        $generatedCaptcha = isset($_POST['captcha_hidden']) ? str_replace(' ', '', $_POST['captcha_hidden']) : '';
    
        if ($inputCaptcha != $generatedCaptcha) {
            echo '<script>
                    alert("Captcha salah");
                    document.location.href = "../login";
                  </script>';
            exit();
        }

        if(isset($_POST['Login'])){
            if(login($_POST)){
                header('Location: ../admin/berandaadmin.php');
                exit();
            } else {
                echo '<script>
                        alert("Login gagal");
                        document.location.href = "../login";
                    </script>';
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Kantin Teknik</title>
    <link rel="stylesheet" href="../styles/login.css">
</head>
<body>
    <form action="index.php" method="POST">
        <div class="main-container">   
            <div class="container-foto">
                <img src="../assets/foto-login.png">
                <p>Copyright © 2024 KantinTeknik</p>
            </div>
            <div class="container-form">
                <a href="../landingpage.html" class="back">Kembali</a>
                <img src="../assets/logo-login.png" class="logo">
                    <div class="form">
                        <h1 class="head">Masuk</h1>
                        <label class="email" for="email">Email</label>    
                        <input type="email" id="email" placeholder="Email" name="email"> 
                        <label class="password" for="password">Password</label>   
                        <input type="password" id="password" placeholder="Password" name="password">
                        <div class="captcha-area">
                            <div class="captcha-image">
                                <img src="../assets/captcha-background.jpg" class="gambar-captcha">
                                <span class="captcha-text"></span>
                            </div>
                            <label class="captcha" for="captcha_input">Captcha</label>
                            <input type="text" id="captcha_input" placeholder="Masukkan captcha..." name="captcha_input" required> 
                            <input type="hidden" name="captcha_hidden" class="captcha-hidden">
                        </div>
                        <div class="tombol">
                        <input class="captcha-input" type="submit" value="Masuk" name="Login" class="btn-login">
                        </div>
                    </div>
                    <div class="register">
                        <p>Anda belum terdaftar sebagai penjual?
                            <br>
                        <a href="../register" style="text-decoration: none; color: black; font-weight: bolder;">Daftar</a>
                        </p>
                    </div>
            </div>
        </div> 
    </form>
<script src="../scripts/login.js"></script>
</body>
</html>