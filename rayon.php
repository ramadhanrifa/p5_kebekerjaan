<?php 
require_once 'config.php';
session_start();


if (isset($_SESSION['tipe']) ) {
    $rayon = $_SESSION['tipe']; 
}

$db_abseneskul = mysqli_query($conn, "SELECT * FROM datasiswa WHERE rayon = '$rayon' ");
// $rayon = mysqli_query($conn, "SELECT * FROM users WHERE status = 'rayon' AND rayon = '$rayon'" );  

if(!isset($_SESSION['username'])){
    header('location: index.php');
}
if (!isset($_SESSION['tipe']) || empty($_SESSION['tipe'])) {
    // Redirect ke halaman lain atau lakukan tindakan sesuai kebijakan aplikasi Anda.
    // Misalnya:
    header('location: index.php');
    exit;
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
    <title>Absen <?= $rayon?></title>
    <link rel="stylesheet" href="style/rayon.css">
</head>
<body>
<nav class="navbar bg-body-tertiary" class="atas">
  <div class="container-fluid">
  <div class="justify-content-center"><h1> Data Siswa <?= $rayon?></h1></div>
  <a href="logout.php">keluar</a>
  <a href="pesan.php">Pesan</a>
    <form class="d-flex" role="search" action="" method="post">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword"
      autofocus autocomplete="off">
      <button class="btn btn-outline-success" type="submit" name="cari">cari</button>
    </form>
  </div>
</nav>
    <br><br>
    
    <table border ="1">
        <!-- <form class="d-flex" role="search" action="" method="post">
      <input class="search" type="search" placeholder="Search" aria-label="Search" name="keyword"
      autofocus autocomplete="off">
      <button class="btn btn-outline-success" type="submit" name="cari">cari</button>
    </form> -->
        <tr>
            <th>NO</th>
            <th>NAMA</th>
            <th>NIS</th>
            <th>RAYON</th>
            <th>ESKUL</th>
            <th>ESKUL PRODUKTIF</th>
            <th>SENI BUDAYA</th>
            <th>KEHADIRAN ESKUL UMUM</th>
            <th>KEHADIRAN ESKUL PRODUKTIF</th>
            <th>KEHADIRAN SENI BUDAYA</th>
            
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
            <td><?= $eskull["kehadiranEskulUmum"]?></td>
            <td><?= $eskull["kehadiranEskulProduktif"]?></td>
            <td><?= $eskull["kehadiranaSeniBudaya"]?></td>
        
            
        </tr>
       <?php $i++;
       endforeach;
       ?>

    </table>
</body>
</html>


