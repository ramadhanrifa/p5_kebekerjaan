<?php 
require_once 'config.php';
session_start();


if (isset($_SESSION['tipe']) ) {
    $rayon = $_SESSION['tipe']; 
}

$db_abseneskul = mysqli_query($conn, "SELECT * FROM datasiswa WHERE rayon = '$rayon' ");

if ($db_abseneskul) {
    // Initialize an empty array to store the data
    $data_siswa = [];

    // Fetch each row and store it in the data_siswa array
    while ($row = mysqli_fetch_assoc($db_abseneskul)) {
        $data_siswa[] = $row;
    }

    // Store the data_siswa array in a session variable
    $_SESSION['data_siswa'] = $data_siswa;
    

} else {
    // Handle the case where the database query fails
    echo "Error fetching data from the database.";
}

if(!isset($_SESSION['username'])){
    header('location: index.php');
}
if (!isset($_SESSION['tipe']) || empty($_SESSION['tipe'])) {

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
    <title>Absen Rayon</title>
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
            <?php foreach ($_SESSION['data_siswa'] as $eskull):?>
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
       <?php $i++;
       endforeach;
       ?>

    </table>
</body>
</html>


