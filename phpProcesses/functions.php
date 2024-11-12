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

    function upload($data, $files, $fotoLama = 'NULL'){
        $namaFile = $files['image']['name'];
        $ukuranFile = $files['image']['size'];
        $error = $files['image']['error'];
        $tmpName = $files['image']['tmp_name'];

        if($error === 4){
            echo "<script>alert('Pilih gambar terlebih dahulu')</script>";
            return false;
        }

        $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'webp'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));

        if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
            echo "<script>alert('File yang diupload bukan gambar')</script>";
            return false;
        }

        if($ukuranFile > 10000000){
            echo "<script>alert('Ukuran gambar terlalu besar')</script>";
            return false;
        }

        if (file_exists('img/' . $fotoLama)) {
            unlink('img/' . $fotoLama);
        }

        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        move_uploaded_file($tmpName, '../img/' . $namaFileBaru);
        return $namaFileBaru;
    }

    function addMenu($data, $files){
        $conn = connection();
        $nama_menu = $data['nama_menu'];
        $harga = $data['harga'];
        $kategori = $data['kategori'];
        $foto = upload($data, $files);

        if(!$foto){
            return false;
        }

        $query = "INSERT INTO menu (nama, harga, kategori, foto) VALUES ('$nama_menu', '$harga', '$kategori', '$foto')";
        if(mysqli_query($conn, $query)){
            return true;
        } else {
            return false;
        }
    }

    function listMenu(){
        $conn = connection();
        $query = "SELECT * FROM menu";
        $result = mysqli_query($conn, $query);
        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }
    
    function updateMenu($data, $files){
        $conn = connection();
        
        $id = $data['id'];
        $nama_menu = $data['nama_menu'];
        $harga = $data['harga'];
        $kategori = $data['kategori'];
        $foto = upload($data, $_FILES, $data['foto']);
        
        $query = "UPDATE menu SET nama_menu='$nama_menu', harga='$harga', kategori='$kategori', foto='$foto' WHERE id='$id'";
        
        if(mysqli_query($conn, $query)){
            return true;
        } else {
            return false;
        }
    }
?>