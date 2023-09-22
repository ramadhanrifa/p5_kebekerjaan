<?php 
require_once 'config.php';
session_start();


if (isset($_SESSION['tipe']) ) {
    $umum = $_SESSION['tipe']; 

}

$db_abseneskul = mysqli_query($conn, "SELECT * FROM datasiswa WHERE eskul = '$umum' ");

if(!isset($_SESSION['username'])){
    header('location: index.php');
}
if (!isset($_SESSION['tipe']) || empty($_SESSION['tipe'])) {
    // Redirect ke halaman lain atau lakukan tindakan sesuai kebijakan aplikasi Anda.
    // Misalnya:
    header('location: index.php');
    exit;
}

if (isset($_POST['submit'])) {
    $kehadiran_values = $_POST['kehadiran'];
    $ids = $_POST['id'];

    if ($conn) {
        foreach ($ids as $id) {
            $kehadiran = mysqli_real_escape_string($conn, $kehadiran_values[$id]);
            $sqlUpdate = "UPDATE datasiswa SET kehadiranEskulUmum = ? WHERE id = ?";
            
            // Persiapkan pernyataan SQL UPDATE
            $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);
            mysqli_stmt_bind_param($stmtUpdate, 'si', $kehadiran, $id);
            
            if (mysqli_stmt_execute($stmtUpdate)) {
                $result = mysqli_query($conn, "SELECT * FROM datasiswa WHERE id = $id");
                $siswa = mysqli_fetch_array($result);
                $nama = $siswa['nama'];
                $nis = $siswa['nis'];
                $rayon = $siswa['rayon'];
                $eskulProduktif = $siswa['eskul'];
                $tanggal = date("d-m-y");
    
                // Buat pernyataan SQL INSERT INTO ... SELECT
                $sqlInsert = "INSERT INTO rekapabsenumum (nama, nis, rayon, EskulUmum, absenEskulUmum, tanggalEU)
                              SELECT ?, ?, ?, ?, ?, ? FROM datasiswa WHERE id = ?";
                $stmtInsert = mysqli_prepare($conn, $sqlInsert);
                mysqli_stmt_bind_param($stmtInsert, 'sissssi', $nama, $nis, $rayon, $eskulProduktif, $kehadiran, $tanggal, $id);
                
                if (mysqli_stmt_execute($stmtInsert)) {
                    echo "<script>alert('Kehadiran sudah diupdate dan ditambahkan ke dalam database')</script>";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            // if(!$kehadiran){
            //     echo "<script>alert('Silahkan pilih kehadiran')</script>";
            //     header("location: produktif.php");
            //     die;
            // }
        }
    } else {
        echo "Tidak dapat terhubung ke database.";
    }
}

if(isset($_POST['cari'])) {
    $db_abseneskul = search($_POST['keyword']);
}
$tanggal = date("d-m-y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <title>Absen Eskul Umum</title>
    <link rel="stylesheet" href="style/produktif.css">
</head>
<body>
<nav class="navbar bg-body-tertiary" class="atas">
  <div class="container-fluid">
  <div class="justify-content-center"><h1> Data Siswa <?= $umum?></h1></div>
  <h2><?= $tanggal?></h2>
  </div>
</nav>
<form class="d-flex" role="search" action="" method="post">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword"
      autofocus autocomplete="off">
      <button class="btn btn-outline-success" type="submit" name="cari">cari</button>
    </form>
    <br><br>
    <a href="logout.php">keluar</a>
    <form action="" method="post">
    <table border ="1">
        
        <tr>
            <th>NO</th>
            <th>NAMA</th>
            <th>NIS</th>
            <th>RAYON</th>
            <th>ESKUL</th>
            <th>KEHADIRAN</th>
            
        </tr>
        
        <?php $i =1;?>
            <?php foreach ($db_abseneskul as $eskull):?>
        <tr>
            
            <td><?= $i?></td>
            <td><?= $eskull["nama"]?></td>
            <td><?= $eskull["nis"]?></td>
            <td><?= $eskull["rayon"]?></td>
            <td><?= $eskull["eskul"]?></td>
            <td>
            <input type="hidden" name="id[]" value="<?= $eskull['id'] ?>">
            <input type="radio" id="hadir<?= $eskull['id'] ?>" name="kehadiran[<?= $eskull['id'] ?>]" value="hadir">
            <label for="hadir<?= $eskull['id'] ?>">hadir</label><br>
            <input type="radio" id="sakit<?= $eskull['id'] ?>" name="kehadiran[<?= $eskull['id'] ?>]" value="sakit">
            <label for="sakit<?= $eskull['id'] ?>">sakit</label><br>
            <input type="radio" id="izin<?= $eskull['id'] ?>" name="kehadiran[<?= $eskull['id'] ?>]" value="izin">
            <label for="izin<?= $eskull['id'] ?>">izin</label><br>
            <input type="radio" id="alpa<?= $eskull['id'] ?>" name="kehadiran[<?= $eskull['id'] ?>]" value="alpa">
            <label for="alpa<?= $eskull['id'] ?>">alpa</label>
            </td>
          
            
        </tr>
       <?php $i++;
       endforeach;
       ?>
       
    </table>
    <input type="submit" name="submit">
    </form>
    <!-- <button><a href="logout.php">keluar</a></button> -->
</body>
</html>


