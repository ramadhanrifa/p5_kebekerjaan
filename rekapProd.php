<?php 
require_once 'config.php';
session_start();

$sesi = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] ."'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $status = $row['status'];

    if ($status === 'pembimbing') {
        $link = 'datasiswa';
    } elseif ($status === 'rayon') {
        $link = 'rayon';
    } elseif($status === 'produktif'){
        $link = 'produktif';
    }elseif($status== 'senbud'){
        $link = 'senbud';
    }
    else{
        $link = 'umum';
    }
} else {

    $link = 'logout'; 
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_SESSION['data_siswa'])) {
        $data_siswa = $_SESSION['data_siswa'];
        $selected_data = null;

        foreach ($data_siswa as $eskull) {
            if ($eskull['id'] == $id) {
                $selected_data = $eskull;
                break;
            }
        }

        if ($selected_data) {
            $nama = $selected_data['nama'];
        } 
    } 
} else {
    echo "ID parameter not provided.";
    header("location: wellcome.php");
}

$sql = "SELECT * FROM rekapabsenproduktif WHERE nama = ?";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Ikat variabel ke placeholder
    mysqli_stmt_bind_param($stmt, "s", $nama);  

    mysqli_stmt_execute($stmt);

    $prod = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($conn);
}

if(isset($_POST['cari'])) {
    $prod = search($_POST['keyword']);
}

if(empty($prod)){
    echo "<script>alert('no data')</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <title>Rekap Absen</title>
    <link rel="stylesheet" href="style/rayon.css">
</head>
<body>
<nav class="navbar bg-body-tertiary" class="atas">
  <div class="container-fluid">
  <div class="justify-content-center"><h1> Absen <?= $nama?></h1></div>
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
            <th>ESKUL PRODUKTIF</th>
            <th>KEHADIRAN ESKUL PRODUKTIF</th>
            <th>TANGGAL KEHADIRAN</th>
            
        </tr>
        
     

    <?php $i =1;?>
            <?php foreach ($prod as $eskull):?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $eskull["nama"]?></td>
            <td><?= $eskull["nis"]?></td>
            <td><?= $eskull["rayon"]?></td>
            <td><?= $eskull["EskulProduktif"]?></td>
            <td><?= $eskull["absenEskulProduktif"]?></td>
            <td><?= $eskull["tanggalEP"]?></td>

        
            
        </tr>
       <?php $i++;
       endforeach;
       ?>

    </table>
    <a href="<?= $link?>.php">Kembali</a>
</body>
</html>


