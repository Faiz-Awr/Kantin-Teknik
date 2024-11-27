<?php
    function connection(){
        $conn = mysqli_connect('localhost','root','','dbspring');
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
                $_SESSION['foto'] = $data['foto_profile'];
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
    
    function reduceMenu($id) {
        foreach ($_SESSION['temp_menu_data'] as $key => $menu) {
            if ($menu['id'] == $id) {
                if ($_SESSION['temp_menu_data'][$key]['jumlah'] > 1) {
                    $_SESSION['temp_menu_data'][$key]['jumlah'] -= 1;
                } else {
                    unset($_SESSION['temp_menu_data'][$key]);
                }
                return true;
            }
        }
        return false;
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

    function deleteMenu($id, $foto) {
        foreach ($_SESSION['temp_menu_data'] as $key => $menu) {
            if ($menu['id'] == $id) {
                // Add the menu to deleted menu data for tracking
                $_SESSION['deleted_menu_data'][] = $menu;
                unset($_SESSION['temp_menu_data'][$key]);
    
                // Track the ID of the item to delete from the database
                if (!isset($_SESSION['menu_ids_to_delete'])) {
                    $_SESSION['menu_ids_to_delete'] = [];
                }
                $_SESSION['menu_ids_to_delete'][] = $id;
    
                // Handle file deletion tracking
                if (!empty($foto) && file_exists('../img/' . $foto)) {
                    if (!isset($_SESSION['files_to_delete'])) {
                        $_SESSION['files_to_delete'] = [];
                    }
                    $_SESSION['files_to_delete'][] = $foto;
                }
                return true; // Successfully deleted the menu item
            }
        }
        return false; // Menu item with the given id not found
    }

    function sendPayload() {
        $conn = connection();
    
        // Begin transaction
        mysqli_begin_transaction($conn);
    
        try {
            // Process deletions from the database
            if (isset($_SESSION['menu_ids_to_delete'])) {
                $deleteQuery = "DELETE FROM menu WHERE id = ?";
                $deleteStmt = mysqli_prepare($conn, $deleteQuery);
    
                foreach ($_SESSION['menu_ids_to_delete'] as $idToDelete) {
                    mysqli_stmt_bind_param($deleteStmt, 'i', $idToDelete);
                    if (!mysqli_stmt_execute($deleteStmt)) {
                        throw new Exception("Failed to delete menu with ID $idToDelete: " . mysqli_error($conn));
                    }
                }
                unset($_SESSION['menu_ids_to_delete']); // Clear the session variable after processing
            }
    
            // Insert or update remaining menu items
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
    
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    // Step 2: Update existing record
                    $updateQuery = "UPDATE menu SET nama = ?, harga = ?, kategori = ?, foto = ? WHERE id = ?";
                    $updateStmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($updateStmt, 'ssssi', $nama, $harga, $kategori, $foto, $id);
    
                    if (!mysqli_stmt_execute($updateStmt)) {
                        throw new Exception("Failed to update menu with ID $id: " . mysqli_error($conn));
                    }
                } else {
                    // Step 3: Insert new record
                    $insertQuery = "INSERT INTO menu (nama, harga, kategori, foto) VALUES (?, ?, ?, ?)";
                    $insertStmt = mysqli_prepare($conn, $insertQuery);
                    mysqli_stmt_bind_param($insertStmt, 'ssss', $nama, $harga, $kategori, $foto);
    
                    if (!mysqli_stmt_execute($insertStmt)) {
                        throw new Exception("Failed to insert menu: " . mysqli_error($conn));
                    }
                }
            }
    
            // Move files after successful database updates
            moveFiles();
    
            mysqli_commit($conn); // Commit transaction
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn); // Rollback on failure
            error_log($e->getMessage()); // Log the error for debugging
            return false;
        } finally {
            mysqli_close($conn); // Ensure connection is closed
        }
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

    function updatePenjual($data) {
        $conn = connection();
        $id = $_SESSION['id'];
        $nama_lengkap = $data['nama'];
        $nama_kantin = $data['kantin'];
        $nomor_telepon = $data['telepon'];
        $email = $data['email'];
        $password = $data['password'];
    
        // Update query
        $query = "
            UPDATE penjual 
            SET 
                nama_lengkap = '$nama_lengkap',
                nama_kantin = '$nama_kantin',
                nomor_telepon = '$nomor_telepon',
                email = '$email',
                password = '$password'
            WHERE id = '$id'
        ";
    
        if (mysqli_query($conn, $query)) {
            // Update session data
            $_SESSION['nama_lengkap'] = $nama_lengkap;
            $_SESSION['nama_kantin'] = $nama_kantin;
            $_SESSION['nomor_telepon'] = $nomor_telepon;
            $_SESSION['email'] = $email;
    
            return true;
        } else {
            return false;
        }
    }

    function getAntrian(){
        $conn = connection();
        $query = "  SELECT p.id as 'id_pesanan', p.nama_pemesan, p.no_tlp_pemesan, p.jumlah, p.total_harga, m.nama,
                    CASE
                        WHEN P.STATUS_PESANAN = 0 THEN 'PESANAN BELUM SELESAI' ELSE 'PESANAN SUDAH SELESAI'
                    END AS 'status'
                    FROM PESANAN P
                    JOIN MENU M
                    ON M.ID = P.ID_MENU
                    WHERE P.ID_PENJUAL = ".$_SESSION['id']." AND P.STATUS_PESANAN = 0
                 ";
        $result = mysqli_query($conn, $query);
        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }

    function selesaiAntrian($id){
        $conn = connection();
        $query = "UPDATE pesanan SET status_pesanan = 1 WHERE id = $id";
        if(mysqli_query($conn, $query)){
            return true;
        } else {
            return false;
        }
    }

    function addToCart($data){
        $id = $data['id'];
        $name = $data['name'];
        $price = $data['price'];
        $id_penjual = $data['id_penjual'];
        $foto = $data['foto'];
    
        // Check if the item is already in the cart
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $name,
                'price' => $price,
                'quantity' => 1,
                'id_penjual' => $id_penjual,
                'image' => $foto
            ];
        }
    }

    function removeFromCart($data) {
        $id = $data['id'];

        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    function clearCart() {
        unset($_SESSION['cart']);
        unset($_SESSION['total']);
    }

    function addToPesanan($cart, $customer_data) {
        $conn = connection();
    
        $nama_pemesan = $customer_data['nama_pemesan'];
        $no_tlp_pemesan = $customer_data['no_tlp_pemesan'];
    
        foreach ($cart as $menu_id => $item) {
            $id_penjual = $item['id_penjual']; // Use NULL if `id_penjual` is missing
            $jumlah = $item['quantity'];
            $total_harga = $item['price'] * $jumlah;
    
            $query = "INSERT INTO pesanan (id_penjual, id_menu, jumlah, total_harga, nama_pemesan, no_tlp_pemesan, status_pesanan)
                      VALUES ($id_penjual, $menu_id, $jumlah, $total_harga, '$nama_pemesan', '$no_tlp_pemesan', 0)";
    
            if (!mysqli_query($conn, $query)) {
                return false;
            }
        }
        return true;
    }

    function cekLogin(){
        if(!isset($_SESSION)){
            header('Location: logout.php');
            exit();
        }
    }
?>