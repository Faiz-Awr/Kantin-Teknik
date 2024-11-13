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
                $_SESSION['id'] = $data['id'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['password'] = $data['password'];
                $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
                $_SESSION['nama_kantin'] = $data['nama_kantin'];
                $_SESSION['nomor_telepon'] = $data['nomor_telepon'];
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
            return -1;
        }

        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $query = "INSERT INTO penjual (email, password, nama_lengkap, nama_kantin, nomor_telepon) VALUES ('$email', '$password', '$nama_lengkap', '$nama_kantin', '$nomor_telepon')";
        if(mysqli_query($conn, $query)){
            return true;
        } else {
            return false;
        }
    }

    function upload($files, $fotoLama = null) {
        $namaFile = $files['image']['name'];
        $ukuranFile = $files['image']['size'];
        $error = $files['image']['error'];
        $tmpName = $files['image']['tmp_name'];
    
        if ($error === 4) {
            echo "<script>alert('Pilih gambar terlebih dahulu')</script>";
            return false;
        }
    
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'webp'];
        $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    
        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            echo "<script>alert('File yang diupload bukan gambar')</script>";
            return false;
        }
    
        if ($ukuranFile > 10000000) {
            echo "<script>alert('Ukuran gambar terlalu besar')</script>";
            return false;
        }
    
        // Generate a new unique name for the temporary image
        $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
    
        // Move the uploaded file to the temporary directory
        if (move_uploaded_file($tmpName, '../img_temp/' . $namaFileBaru)) {
            // If there's an old image and it's different from the new one, mark it for deletion
            if ($fotoLama && file_exists('../img/' . $fotoLama)) {
                if (!isset($_SESSION['files_to_delete'])) {
                    $_SESSION['files_to_delete'] = [];
                }
                $_SESSION['files_to_delete'][] = $fotoLama;
            }
            return $namaFileBaru; // Return the new temporary image name
        } else {
            echo "<script>alert('Gagal mengupload gambar')</script>";
            return false;
        }
    }

    function addMenu($data, $files){
        $conn = connection();
        $nama_menu = $data['nama_menu'];
        $harga = $data['harga'];
        $kategori = $data['kategori'];
        $foto = upload($files, 'NULL');

        if(!$foto){
            return false;
        }

        foreach ($_SESSION['temp_menu_data'] as $menu) {
            $id = $menu['id'];
        }

        $_SESSION['temp_menu_data'][] = [
            'id' => $id + 1,
            'nama' => $nama_menu,
            'harga' => $harga,
            'kategori' => $kategori,
            'foto' => $foto
        ];

        return true;
    }

    function getMenu(){
        $conn = connection();
        $query = "SELECT * FROM menu WHERE id_penjual=".$_SESSION['id'];
        $result = mysqli_query($conn, $query);
        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }

    function findMenu($id){
        $conn = connection();
        $query = "SELECT * FROM menu WHERE id='$id'";
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_assoc($result);
        return $data;
    }
    
    function updateMenu($data, $files, $id, $fotoLama) {
        $conn = connection();
        $nama_menu = $data['nama_menu'];
        $harga = $data['harga'];
        $kategori = $data['kategori'];

        if ($files['image']['error'] === 4) {
            $foto = $fotoLama;
        } else {
            $foto = upload($files, $fotoLama);
        }

        if ($foto === false) {
            return false;
        }

        foreach ($_SESSION['temp_menu_data'] as $key => $menu) {
            if ($menu['id'] == $id) {
                $_SESSION['temp_menu_data'][$key]['nama'] = $nama_menu;
                $_SESSION['temp_menu_data'][$key]['harga'] = $harga;
                $_SESSION['temp_menu_data'][$key]['kategori'] = $kategori;
                $_SESSION['temp_menu_data'][$key]['foto'] = "$foto";
                return true;
            }
        }
    
        return false; // Return false if the menu item with that id is not found
    }

    function sendPayload($data) {
        $conn = connection();

        foreach ($_SESSION['temp_menu_data'] as $menu) {
            $nama = $menu['nama'];
            $harga = $menu['harga'];
            $kategori = $menu['kategori'];
            $foto = $menu['foto'];
            $id = $menu['id'];

            // Step 1: Check if the record exists
            $checkQuery = "SELECT id FROM menu WHERE id = ?";
            $stmt = mysqli_prepare($conn, $checkQuery);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            // If the menu item with the given id exists, update it
            if (mysqli_stmt_num_rows($stmt) > 0) {
                // Step 2: Perform the update if the item exists
                $updateQuery = "UPDATE menu SET nama = ?, harga = ?, kategori = ?, foto = ? WHERE id = ?";
                $updateStmt = mysqli_prepare($conn, $updateQuery);
                mysqli_stmt_bind_param($updateStmt, 'ssssi', $nama, $harga, $kategori, $foto, $id); // Corrected to 'ssssi'

                if (!mysqli_stmt_execute($updateStmt)) {
                    return false; // Return false if the update fails
                }
            } else {
                // Step 3: If the item does not exist, insert it
                $insertQuery = "INSERT INTO menu (nama, harga, kategori, foto) VALUES (?, ?, ?, ?)";
                $insertStmt = mysqli_prepare($conn, $insertQuery);
                mysqli_stmt_bind_param($insertStmt, 'ssss', $nama, $harga, $kategori, $foto);

                if (!mysqli_stmt_execute($insertStmt)) {
                    return false; // Return false if the insert fails
                }
            }
        }

        moveFiles(); // Move the files from /img_temp/ to /img/
        return true;
    }

    function moveFiles() {
        if (!isset($_SESSION['temp_menu_data'])) {
            return;
        }
    
        $tempDir = '../img_temp/';
        $imgDir = '../img/';
    
        // Check if directories exist and are writable
        if (!is_dir($tempDir) || !is_writable($tempDir)) {
            echo "<script>alert('img_temp directory is missing or not writable.');</script>";
            return;
        }
    
        if (!is_dir($imgDir) || !is_writable($imgDir)) {
            echo "<script>alert('img directory is missing or not writable.');</script>";
            return;
        }
    
        foreach ($_SESSION['temp_menu_data'] as $menu) {
            $foto = $menu['foto'];
            $fotoLama = $menu['foto_lama'] ?? null;
    
            if ($foto && $foto !== $fotoLama) {
                $tempFilePath = $tempDir . $foto;
                $imgFilePath = $imgDir . $foto;
    
                if (file_exists($tempFilePath)) {
                    if (rename($tempFilePath, $imgFilePath)) {
                        echo "<script>console.log('Moved $foto from img_temp to img successfully.');</script>";
                    } else {
                        // Fallback to copy and unlink if rename fails
                        if (copy($tempFilePath, $imgFilePath) && unlink($tempFilePath)) {
                            echo "<script>console.log('Moved $foto using copy and delete.');</script>";
                        } else {
                            echo "<script>console.log('Failed to move $foto.');</script>";
                        }
                    }
                } else {
                    echo "<script>console.log('File $foto not found in img_temp.');</script>";
                }
            }
        }
    
        if (isset($_SESSION['files_to_delete'])) {
            foreach ($_SESSION['files_to_delete'] as $oldFoto) {
                $oldFilePath = $imgDir . $oldFoto;
                if (file_exists($oldFilePath) && unlink($oldFilePath)) {
                    echo "<script>console.log('Deleted old file: $oldFoto');</script>";
                }
            }
            unset($_SESSION['files_to_delete']);
        }
    }
?>