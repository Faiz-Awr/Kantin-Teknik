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

// Ambil semua radio button
const radios = document.querySelectorAll('input[type="radio"]');

// Tambahkan event listener untuk setiap radio button
radios.forEach(radio => {
    radio.addEventListener('change', () => {
        // Hapus kelas 'selected' dari semua elemen
        document.querySelectorAll('.label-berat, .label-ringan, .label-minum').forEach(label => {
            label.classList.remove('selected');
        });

        // Tambahkan kelas 'selected' pada elemen yang dipilih dan ubah background color
        if (radio.id === 'berat') {
            const label = document.querySelector('.label-berat');
            label.classList.add('selected');
            label.style.transition = 'background-color 0.3s, color 0.3s';
            label.style.backgroundColor = '#D24511';
            label.style.color = '#ECCDC2';
            document.location.href = '#makanan-berat';
        } else {
            const label = document.querySelector('.label-berat');
            label.style.transition = 'background-color 0.3s, color 0.3s';
            label.style.backgroundColor = '';
            label.style.color = '#42251A';
        }

        if (radio.id === 'ringan') {
            const label = document.querySelector('.label-ringan');
            label.classList.add('selected');
            label.style.transition = 'background-color 0.3s, color 0.3s';
            label.style.backgroundColor = '#D24511';
            label.style.color = '#ECCDC2';
            document.location.href = '#makanan-ringan';
        } else {
            const label = document.querySelector('.label-ringan');
            label.style.transition = 'background-color 0.3s, color 0.3s';
            label.style.backgroundColor = '';
            label.style.color = '#42251A';
        }

        if (radio.id === 'minuman') {
            const label = document.querySelector('.label-minum');
            label.classList.add('selected');
            label.style.transition = 'background-color 0.3s, color 0.3s';
            label.style.backgroundColor = '#D24511';
            label.style.color = '#ECCDC2';
            document.location.href = '#minuman1';
        } else {
            const label = document.querySelector('.label-minum');
            label.style.transition = 'background-color 0.3s, color 0.3s';
            label.style.backgroundColor = '';
            label.style.color = '#42251A';
        }
    });
});