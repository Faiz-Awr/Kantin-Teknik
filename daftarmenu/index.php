<?php 
    require '../phpProcesses/functions.php';
    session_start();

    if (!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['total'])){
        $_SESSION['total'] = 0;
    }
    
    if (!isset($total)){
        $total = 0;
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $conn = connection();
        $query = "SELECT * FROM menu WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
    
    }

    $conn = connection();
    $query = "SELECT * FROM menu";
    $result = mysqli_query($conn, $query);
    $data = [];
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    
    $makanan_berat = array_filter($data, function($menu) {
        return $menu['kategori'] == 'makanan';
    });

    $makanan_ringan = array_filter($data, function($menu) {
        return $menu['kategori'] == 'makanan ringan';
    });

    $minuman = array_filter($data, function($menu) {
        return $menu['kategori'] == 'minuman';
    });

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['tambah'])) {
            addToCart($_POST);
    
            // Recalculate the total after adding to the cart
            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            $_SESSION['total'] = $total; // Update the session value
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } elseif (isset($_POST['hapus'])) {
            removeFromCart($_POST);
    
            // Recalculate the total after removing from the cart
            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            $_SESSION['total'] = $total; // Update the session value
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } elseif (isset($_POST['submit-pembayaran'])) {
            $jenis_pembayaran = $_POST['jenis-pembayaran'] ?? '';
    
            if ($jenis_pembayaran === 'tunai') {
                header('Location: ../checkout/struk-tunai.php');
                exit();
            } elseif ($jenis_pembayaran === 'cashless') {
                header('Location: ../checkout/struk-qr.php');
                exit();
            } else {
                echo '<script>alert("Invalid payment method selected.");</script>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <link rel="stylesheet" href="../styles/daftarmenu.css">
</head>
<body>
    <header class="navbar">
        <a href="../landingpage.html">Kantin Teknik</a>
        <div class="navbar-search">
            <img src="../assets/search.png" alt="">
            <input type="search" name="search" placeholder="Search Bar" id="">
        </div>
        <div class="navbar-keranjang" id="navbar-keranjang">
            <img src="../assets/basket.png" alt="">
            <span>Keranjang Anda</span>
        </div>
    </header>

    <div id="keranjang" class="keranjang">
        <div class="header-keranjang">
            <div class="keranjang-judul">
                <h2>Keranjang Anda</h2>
                <button id="close-keranjang" class="close-keranjang"><img src="../assets/tombolx.png" alt=""></button>
            </div>
            <h2>Tipe Pemesanan</h2>
            <div class="tipe-pemesanan">
                <div>
                    <input type="radio" id="dine-in" name="tipe-pemesanan" value="dine-in">
                    <label for="dine-in">Dine In</label>
                </div>
                <div>
                    <input type="radio" id="takeout" name="tipe-pemesanan" value="takeout">
                    <label for="takeout">Takeout</label>
                </div>
            </div>
            <div class="kepala-pesanan">
                <span class="kepala1">Pesanan</span>
                <span class="kepala2">Jml</span>
                <span class="kepala3">Total</span>
            </div>
            <hr>
        </div>
        <div class="isi-keranjang">
            <!-- perulangan pesanan -->
            <div class="isi-keranjang">
                <?php if (!empty($_SESSION['cart'])): ?>
                    <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                        <div class="pesanan">
                            <div class="isi-pesanan">
                                <div class="isimenu1">
                                    <img src="../img/<?php echo $item['image'] ?? 'default.jpg'; ?>" alt="<?php echo $item['name']; ?>">
                                    <div class="deskripsi-menu-pesanan">
                                        <h3><?php echo $item['name']; ?></h3>
                                        <p>Rp. <?php echo number_format($item['price'], 0, ',', '.'); ?></p>
                                    </div>
                                </div>
                                <div class="isimenu2">
                                    <div class="quantity"><?php echo $item['quantity']; ?></div>
                                </div>
                                <div class="isimenu3">
                                    <p class="price">Rp. <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></p>
                                </div>
                            </div>
                            <div class="catatan">
                                <form method="POST" action="index.php">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="id_penjual" value="<?php echo $id_penjual; ?>">
                                    <button type="submit" class="hapus-pesanan" name="hapus"><img src="../assets/sampah.png" alt=""></button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Keranjang Anda kosong.</p>
                <?php endif; ?>
            </div>
            <!-- end perulangan -->
        </div>
        <form method="POST" action="">
            <div class="pembayaran">
                <hr>
                <div class="harga">
                    <span>Harga</span>
                    <span>Rp. <?php echo number_format($_SESSION['total'] ?? 0, 0, ',', '.'); ?></span>
                </div>
                <div class="pajak">
                    <span>Pajak</span>
                    <span>Rp. <?php echo number_format(isset($_SESSION['total']) ? $_SESSION['total'] * 0.01 : 0, 0, ',', '.') ?></span>
                </div>
                <hr>
                <div class="total">
                    <span>Total Pembayaran</span>
                    <span>Rp. <?php echo number_format(isset($_SESSION['total']) ? $_SESSION['total'] + $_SESSION['total'] * 0.01 : 0, 0, ',', '.'); ?></span>
                </div>
                <select name="jenis-pembayaran" required>
                    <option value="" disabled selected>Pilih jenis pembayaran</option>
                    <option value="tunai">Tunai</option>
                    <option value="cashless">Cashless</option>
                </select>
                <button type="submit" name="submit-pembayaran" class="tombol-pembayaran">
                    <div>
                        <span>
                            Lanjutkan Pembayaran
                        </span>
                    </div>
                </button>
            </div>
        </form>
    </div>

    <section class="kategori-bar">
        <form id="kategori" method="POST" action="" class="kategori-radio">
            <div class="label-berat">
                <input type="radio" id="berat" name="tag" value="berat">
                <label for="berat">Makanan Berat</label>
            </div>
            <div class="label-ringan">
                <input type="radio" id="ringan" name="tag" value="ringan">
                <label for="ringan">Makanan Ringan</label>
            </div>
            <div class="label-minum">
                <input type="radio" id="minuman" name="tag" value="minuman">
                <label for="minuman">Minuman</label>
            </div>
        </form>
    </section>
    <section class="daftar-menu">
        <div class="kategori-menu">
            <h2 id = "makanan-berat" >Makanan Berat</h2>
            <hr>
            <div class="menu">
                <?php foreach ($makanan_berat as $menu) : ?>
                    <div class="detail-menu">
                        <div class="deskripsi-menu">
                            <img src="<?php echo file_exists("../img/" . $menu['foto']) ? '../img/' . $menu['foto'] : '../img_temp/' . $menu['foto'] ?>" alt="">
                            <div class="info-menu">
                                <span class="nama-menu"><?php echo $menu['nama'] ?></span>
                                <p class="harga-menu">Rp. <?php echo number_format($menu['harga'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                        <div class="aksi-menu">
                            <form method="POST" action="index.php">
                                <input type="hidden" name="id" value="<?php echo $menu['id']; ?>">
                                <input type="hidden" name="name" value="<?php echo $menu['nama']; ?>">
                                <input type="hidden" name="price" value="<?php echo $menu['harga']; ?>">
                                <input type="hidden" name="id_penjual" value="<?php echo $menu['id_penjual']?>">
                                <button type="submit" class="btn-tambah" name="tambah">Tambah</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <h2 id="makanan-ringan">Makanan Ringan</h2>
            <hr>
            <div class="menu">
                <?php foreach ($makanan_ringan as $menu) : ?>
                    <div class="detail-menu">
                        <div class="deskripsi-menu">
                            <img src="<?php echo file_exists("../img/" . $menu['foto']) ? '../img/' . $menu['foto'] : '../img_temp/' . $menu['foto'] ?>" alt="">
                            <div class="info-menu">
                                <span class="nama-menu"><?php echo $menu['nama'] ?></span>
                                <p class="harga-menu">Rp. <?php echo number_format($menu['harga'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                        <div class="aksi-menu">
                            <form method="POST" action="index.php">
                                <input type="hidden" name="id" value="<?php echo $menu['id']; ?>">
                                <input type="hidden" name="name" value="<?php echo $menu['nama']; ?>">
                                <input type="hidden" name="price" value="<?php echo $menu['harga']; ?>">
                                <input type="hidden" name="id_penjual" value="<?php echo $menu['id_penjual']?>">
                                <button type="submit" class="btn-tambah" name="tambah">Tambah</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>  
            <h2 id="minuman1">Minuman</h2>
            <hr>
            <div class="menu">
                <?php foreach ($minuman as $menu) : ?>
                    <div class="detail-menu">
                        <div class="deskripsi-menu">
                            <img src="<?php echo file_exists("../img/" . $menu['foto']) ? '../img/' . $menu['foto'] : '../img_temp/' . $menu['foto'] ?>" alt="">
                            <div class="info-menu">
                                <span class="nama-menu"><?php echo $menu['nama'] ?></span>
                                <p class="harga-menu">Rp. <?php echo number_format($menu['harga'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                        <div class="aksi-menu">
                            <form method="POST" action="index.php">
                                <input type="hidden" name="id" value="<?php echo $menu['id']; ?>">
                                <input type="hidden" name="name" value="<?php echo $menu['nama']; ?>">
                                <input type="hidden" name="price" value="<?php echo $menu['harga']; ?>">
                                <input type="hidden" name="id_penjual" value="<?php echo $menu['id_penjual']?>">
                                <button type="submit" class="btn-tambah" name="tambah">Tambah</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>                     
        </div>
    </section>
</body>
<script src="../scripts/daftarmenu.js"></script>
</html>
