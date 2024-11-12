<?php
    function connection(){
        $conn = mysqli_connect('localhost:3307','root','','dbspring');
        if(!$conn){
            die('Connection failed'.mysqli_connect_error());
        }
        return $conn;
    }

    function login($data){
        $conn = connection();
        $email = $data['email'];
        $password = $data['password'];

        $query = "SELECT * FROM penjual WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        
        if($data = mysqli_fetch_assoc($result)){
            if(password_verify($password, $data['password'])){
                session_start();
                $_SESSION['email'] = $data['email'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function register($data){
        $conn = connection();
        $email = $data['email'];
        $password = $data['password'];
        $nama_lengkap = $data['nama_lengkap'];
        $nama_kantin = $data['nama_kantin'];
        $nomor_telepon = $data['nomor_telepon'];

        $check = "SELECT * FROM penjual WHERE email='$email'";
        $result = mysqli_query($conn, $check);
        
        if(mysqli_num_rows($result) > 0){
            return false;
        }

        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $query = "INSERT INTO penjual (email, password, nama_lengkap, nama_kantin, nomor_telepon) VALUES ('$email', '$password', '$nama_lengkap', '$nama_kantin', '$nomor_telepon')";
        if(mysqli_query($conn, $query)){
            return true;
        } else {
            return false;
        }
    }
?>