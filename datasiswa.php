<?php 
require_once 'config.php';
$db_abseneskul = mysqli_query($conn, "SELECT * FROM datasiswa");

// $akun = mysqli_query($conn, "SELECT * FROM users where status = pembimbing");


session_start();    

if(!isset($_SESSION['username'])){
    header('location: index.php');
}



if(isset($_POST['cari'])) {
    $db_abseneskul = search($_POST['keyword']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="style/data.css">
</head>
<body>
<nav class="navbar bg-body-tertiary" class="atas">
  <div class="container-fluid">
  <div class="justify-content-center"><h1> Data Siswa</h1></div>
  </div>
</nav>
<br>
<form class="d-flex" role="search" action=""  method="post">
      <input class="form-control me-2" type="text" placeholder="Search" aria-label="Search" name="keyword"
      autofocus autocomplete="off">
      <button class="btn btn-outline-success" type="submit" name="cari">cari</button>
    </form>
    <br><br>
    <div class="cari">
    <a href="logout.php">keluar</a>
    <a href="pertanyaan.php">Beri Pertanyaan?</a>
    </div>
  <br>
    <table border ="1">
        
        <tr>
            <th>NO</th>
            <th>NAMA</th>
            <th>NIS</th>
            <th>RAYON</th>
            <th>ESKUL</th>
            <th>ESKUL PRODUKTIF</th>
            <th>SENI BUDAYA</th>
            <th>KEHADIRAN eskul umum</th>
            <th>KEHADIRAN eskul produktif</th>
            <th>KEHADIRAN senbud</th>
            
        </tr>
        
        <?php $i =1;?>
            <?php foreach ($db_abseneskul as $eskull):?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $eskull["nama"]?></td>
            <td><?= $eskull["nis"]?></td>
            <td><?= $eskull["rayon"]?></td>
            <td><?= $eskull["eskul"]?></td>
            <td><?= $eskull["eskulproduktif"]?></td>
            <td><?= $eskull["senbud"]?></td>
            <td><?= $eskull["kehadiranEskulUmum"]?> <br>
                <a href="rekapUmum.php?id=<?= $eskull['id']?>"> Lihat lebih lengkap</a>
            </td>
            <td><?= $eskull["kehadiranEskulProduktif"]?><br>
                <a href="rekapProd.php?id=<?= $eskull['id']?>"> Lihat lebih lengkap</a>
            </td>
            <td><?= $eskull["kehadiranaSeniBudaya"]?><br>
                <a href="rekapSenbud.php?id=<?= $eskull['id']?>"> Lihat lebih lengkap</a>
            </td>
            <td hidden><?= $eskull['id']?></td>
        </tr>
       <?php endforeach;?>
    </table>
</body>
</html>