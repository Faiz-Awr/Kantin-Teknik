const navbarkeranjang = document.getElementById('navbar-keranjang');
if (navbarkeranjang) {
    navbarkeranjang.addEventListener('click', function() {
        document.getElementById('keranjang').style.width = '300px';
    });
}
const closekeranjang = document.getElementById('close-keranjang');
if (closekeranjang) {
    closekeranjang.addEventListener('click', function() {
        document.getElementById('keranjang').style.width = '0';
    });
}