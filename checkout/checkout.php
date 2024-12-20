<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Daftar Menu dan Checkout</title>
    <script>
        function tambahKeKeranjang(nama, harga, gambar, catatan) {
            let pesanan = JSON.parse(localStorage.getItem('pesanan')) || [];
            let item = pesanan.find(i => i.nama === nama);
            if (item) {
                item.jumlah++;
            } else {
                pesanan.push({ nama: nama, harga: harga, jumlah: 1, gambar: gambar, catatan: catatan });
            }
            localStorage.setItem('pesanan', JSON.stringify(pesanan));
            tampilkanPesanan();
        }

        function tampilkanPesanan() {
            let pesanan = JSON.parse(localStorage.getItem('pesanan')) || [];
            let daftarPesananDiv = document.getElementById('daftar-pesanan');
            daftarPesananDiv.innerHTML = '';
            pesanan.forEach((item, index) => {
                daftarPesananDiv.innerHTML += `
                    <div class="order-item" style="display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #ddd;">
                        <div style="flex: 2; display: flex; align-items: center;">
                            <img src="${item.gambar}" alt="${item.nama}" style="width: 50px; height: 50px; border-radius: 5px; margin-right: 15px;">
                            <div>
                                <p style="margin: 0; font-weight: bold;">${item.nama}</p>
                                <p style="margin: 0;">Rp. ${item.harga}</p>
                            </div>
                        </div>
                        <div class="quantity" style="flex: 1; text-align: center;">${item.jumlah}</div>
                        <div class="total" style="flex: 1; text-align: right;">Rp. ${item.harga * item.jumlah}</div>
                    </div>
                `;
            });
            document.getElementById('harga-total').innerText = pesanan.reduce((acc, item) => acc + (item.harga * item.jumlah), 0);
        }

        function konfirmasiPesanan() {
            let namaPemesan = document.getElementById('nama-pemesan').value;
            let nomorTelepon = document.getElementById('nomor-telepon').value;
            if (namaPemesan && nomorTelepon) {
                alert('Pesanan berhasil dikonfirmasi atas nama ' + namaPemesan);
                localStorage.removeItem('pesanan');
                tampilkanPesanan();
            } else {
                alert('Harap isi semua informasi.');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            tampilkanPesanan();
        });
    </script>
</head>
<body>
    <div class="header">
        <h1>Daftar Menu</h1>
        <input class="search-bar" placeholder="Search Bar" type="text"/>
        <button class="cart-button" onclick="tampilkanPesanan()">
            <i class="fas fa-shopping-cart"></i> Keranjang Anda
        </button>
    </div>
    
    <div class="container">
        <div class="order-section">
            <h2>Pesanan Anda</h2>
            <div id="daftar-pesanan" class="order-list"></div>
            <div class="order-summary">
                <p>Harga Total</p>
                <p>Rp. <span id="harga-total">0</span></p>
            </div>
        </div>

        <div class="checkout-section">
            <h2>Checkout</h2>
            <input placeholder="Nama Pemesan" id="nama-pemesan" type="text"/>
            <input placeholder="Nomor Telepon" id="nomor-telepon" type="text"/>
            <div class="payment-section">
                <h3>Pembayaran Tunai</h3>
                <p>Konfirmasi jika setuju kemudian lanjutkan pembayaran ke kasir.</p>
                <button onclick="konfirmasiPesanan()">Konfirmasi</button>
                <button onclick="tampilkanPesanan()">Batal</button>
            </div>
        </div>
    </div>

    <div class="footer">
        Copyright &copy; 2024 KantinTeknik
    </div>
</body>
</html>
