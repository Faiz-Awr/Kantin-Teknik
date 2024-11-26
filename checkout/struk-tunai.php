<?php
    require_once '../phpProcesses/functions.php';
    session_start();

    // Check for POST submission.
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Determine the action: confirm or cancel.
        if (isset($_POST['confirm'])) {
            // Redirect to confirmation page (e.g., go back to the menu after placing the order).
            if (addToPesanan($_SESSION['cart'], $_POST)){
                clearCart();
                header('Location: ../daftarmenu/');
                exit;
            } else {
                echo "<script>alert('Gagal menambahkan pesanan. Silakan coba lagi.')</script>";
            }
        } elseif (isset($_POST['cancel'])) {
            // Clear the session cart or any temporary data if the order is canceled.
            clearCart();
            header('Location: ../daftarmenu/');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="struk.css">
</head>
<body>
    <header class="navbar">
        <a href="">Kantin Teknik</a>
    </header>

    <div class="container-checkout">
        <div class="container-kiri">
            <h2>Pesanan Anda</h2>
            <div class="pesanan">
                <div class="header-pesanan">
                    <div class="kepala-pesanan">
                        <span class="kepala1">Pesanan</span>
                        <span class="kepala2">Jml</span>
                        <span class="kepala3">Total</span>
                    </div>
                    <hr>
                </div>
                <div class="isi-keranjang">
                    <!-- Loop through the cart items stored in the session -->
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <div class="menu-pesanan">
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
                                    <input type="text" placeholder="Catatan" readonly>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Keranjang Anda kosong.</p>
                    <?php endif; ?>
                </div>
                
                <div class="pembayaran">
                    <hr>
                    <div class="harga">
                        <span>Harga</span>
                        <span>Rp. <?php echo number_format(($_SESSION['total'] ?? 0) - 3000, 0, ',', '.'); ?></span>
                    </div>
                    <div class="pajak">
                        <span>Pajak</span>
                        <span>Rp. 3.000</span>
                    </div>
                    <hr>
                    <div class="total">
                        <span>Total Pembayaran</span>
                        <span>Rp. <?php echo number_format($_SESSION['total'] ?? 0, 0, ',', '.'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-kanan">
            <form method="POST" action="">
                <h2>Checkout</h2>
                <div class="pemesan">
                    <div class="nama-pemesan">
                        <label for="nama-pemesan">Nama Pemesan</label>
                        <input type="text" id="nama-pemesan" placeholder="Nama Pemesan" name="nama_pemesan" required>
                    </div>
                    <div class="nomor-pemesan">
                        <label for="nomor-telepon">Nomor Telepon</label>
                        <input type="text" id="nomor-telepon" placeholder="Nomor Telepon" name="no_tlp_pemesan" required>
                    </div>
                </div>


                <div class="pembayaran-struk">
                    <h3>Pembayaran Tunai</h3>
                    <p>Konfirmasi jika setuju kemudian lanjutkan pembayaran ke kasir.</p>
                    <div class="button-pembayaran">
                        <button type="submit" name="confirm" class="button">Konfirmasi</button>
                        <button type="submit" name="cancel" class="button">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>