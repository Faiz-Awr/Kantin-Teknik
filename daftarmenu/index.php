<?php 
    require '../phpProcesses/functions.php';
    session_start();

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
            <div class="pesanan">
                <div class="isi-pesanan">
                    <div class="isimenu1">
                        <img src="../assets/naskun.jpg" alt="Nasi Kuning">
                        <div class="deskripsi-menu-pesanan">
                            <h3>Nasi Kuning</h3>
                            <p>Rp. 20.000</p>
                        </div>
                    </div>
                    <div class="isimenu2">
                        <div class="quantity">1</div>
                    </div>
                    <div class="isimenu3">
                        <p class="price">Rp. 20.000</p>
                    </div>
                </div>
                <div class="catatan">
                    <input type="text" placeholder="Catatan">
                    <button class="hapus-pesanan"><img src="../assets/sampah.png" alt=""></button>
                </div>
            </div>
            <div class="pesanan">
                <div class="isi-pesanan">
                    <div class="isimenu1">
                        <img src="../assets/esteh.png" alt="Nasi Kuning">
                        <div class="deskripsi-menu-pesanan">
                            <h3>Es Teh</h3>
                            <p>Rp. 5.000</p>
                        </div>
                    </div>
                    <div class="isimenu2">
                        <div class="quantity">2</div>
                    </div>
                    <div class="isimenu3">
                        <p class="price">Rp. 10.000</p>
                    </div>
                </div>
                <div class="catatan">
                    <input type="text" placeholder="Catatan">
                    <button class="hapus-pesanan"><img src="../assets/sampah.png" alt=""></button>
                </div>
            </div>
        </div>
        <div class="pembayaran">
            <hr>
            <div class="harga">
                <span>Harga</span>
                <span>Rp. 30.000</span>
            </div>
            <div class="pajak">
                <span>Pajak</span>
                <span>Rp. 3.000</span>
            </div>
            <hr>
            <div class="total">
                <span>Total Pembayaran</span>
                <span>Rp. 33.000</span>
            </div>
            <select name="jenis-pembayaran">
                <option value="tunai">Tunai</option>
                <option value="cashless">Cashless</option>
            </select>
            <a href="../checkout/struk-tunai.html" class="tombol-pembayaran">
                <div>
                    <span>
                        Lanjutkan Pembayaran
                    </span>
                </div>
            </a>
        </div>
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
                            <?php if ($menu['nama'] == 'Nasi Goreng') : ?>
                                <div class="tombol-aksi-menu">
                                    <button class="btn-aksi"><img src="../assets/minus-sm.png" alt=""></button>
                                </div>
                                <input type="number" value="1" class="jumlah-menu">
                                <div class="tombol-aksi-menu">
                                    <button class="btn-aksi"><img src="../assets/plus-sm.png" alt=""></button>
                                </div>
                            <?php else : ?>
                                <button class="btn-tambah">Tambah</button>
                            <?php endif; ?>
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
                            <?php if ($menu['nama'] == 'Nasi Goreng') : ?>
                                <div class="tombol-aksi-menu">
                                    <button class="btn-aksi"><img src="../assets/minus-sm.png" alt="Kurangi"></button>
                                </div>
                                <input type="number" value="1" class="jumlah-menu" readonly>
                                <div class="tombol-aksi-menu">
                                    <button class="btn-aksi"><img src="../assets/plus-sm.png" alt="Tambah"></button>
                                </div>
                            <?php else : ?>
                                <button class="btn-tambah">Tambah</button>
                            <?php endif; ?>
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
                            <?php if ($menu['nama'] == 'Nasi Goreng') : ?>
                                <div class="tombol-aksi-menu">
                                    <button class="btn-aksi"><img src="../assets/minus-sm.png" alt="Kurangi"></button>
                                </div>
                                <input type="number" value="1" class="jumlah-menu" readonly>
                                <div class="tombol-aksi-menu">
                                    <button class="btn-aksi"><img src="../assets/plus-sm.png" alt="Tambah"></button>
                                </div>
                            <?php else : ?>
                                <button class="btn-tambah">Tambah</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>                     
        </div>
    </section>
</body>
<script src="../scripts/daftarmenu.js"></script>
</html>
