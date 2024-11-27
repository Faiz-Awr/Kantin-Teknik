<?php
    require_once '../phpProcesses/functions.php';
    session_start();
    cekLogin();
    $antrian = getAntrian();

    if(isset($_POST['selesai'])){
        $id = $_POST['id'];
        selesaiAntrian($id);
        header('Location: lihatantrian.php');
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Antrian</title>
    <link rel="stylesheet" href="../styles/lihatantrian.css">
</head>
<body>
    <?php include('../navbar.php')?>
    <section class="judul">
        <h1>Antrian Pesanan</h1>
        <a href="berandaadmin.php">
            <div class = "kembali" >
                <span>Kembali</span>
            </div>
        </a>
    </section>
    <hr>
    <section class="antrian">
        <!-- antrian pesanan -->
        <div class="antrian-content">
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nama Pemesan</th>
                    <th>Nomor Telepon Pemesan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                <?php
                    $i = 1;
                    foreach($antrian as $pesanan){
                        echo '<tr>';
                        echo '<td>'.$i.'</td>';
                        echo '<td>'.$pesanan['nama'].'</td>';
                        echo '<td>'.$pesanan['nama_pemesan'].'</td>';
                        echo '<td>'.$pesanan['no_tlp_pemesan'].'</td>';
                        echo '<td>'.$pesanan['status'].'</td>';
                        echo '<td>';
                        echo '<form action="lihatantrian.php" method="post">';
                        echo '<input type="hidden" name="id" value="'.$pesanan['id_pesanan'].'">';
                        echo '<button type="submit" name="selesai" class="selesai" ><div>';
                        echo '<span>Selesai</span>';
                        echo '</div></button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                        $i++;
                    }
                ?>
            </table>
    </section>
    <section class="footer">
        <hr>
        <div class="footer-content">
            <p>Copyright © 2024 KantinTeknik</p>
        </div>
    </section>
</body>
</html>