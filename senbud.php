<?php 
require_once 'config.php';
session_start();


if (isset($_SESSION['tipe']) ) {
    $senbud = $_SESSION['tipe']; 

}

$db_abseneskul = mysqli_query($conn, "SELECT * FROM datasiswa WHERE senbud = '$senbud' ");

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
            $kehadiran = $kehadiran_values[$id];
            $sql = "UPDATE datasiswa SET kehadiranS = '$kehadiran' WHERE id = $id";

            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Kehadiran sudah diupdate')</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Tidak dapat terhubung ke database.";
    }
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
    <title>Absen <?= $senbud?></title>
    <link rel="stylesheet" href="style/data.css">
</head>
<body>
<nav class="navbar bg-body-tertiary" class="atas">
  <div class="container-fluid">
  <div class="justify-content-center"><h1> Data Siswa <?= $senbud?></h1></div>
    <form class="d-flex" role="search" action="" method="post">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword"
      autofocus autocomplete="off">
      <button class="btn btn-outline-success" type="submit" name="cari">cari</button>
    </form>
  </div>
</nav>
    <br><br>
    <form action="" method="post">
    <table border ="1">
        
        <tr>
            <th>NO</th>
            <th>NAMA</th>
            <th>NIS</th>
            <th>RAYON</th>
            <th>ESKUL</th>
            <th>ESKUL PRODUKTIF</th>
            <th>SENI BUDAYA</th>
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
            <td><?= $eskull["eskulproduktif"]?></td>
            <td><?= $eskull["senbud"]?></td>
            <td>
            <input type="hidden" name="id[]" value="<?= $eskull['id'] ?>">
            <input type="radio" id="hadir<?= $eskull['id'] ?>" name="kehadiran[<?= $eskull['id'] ?>]" value="hadir">
            <label for="hadir<?= $eskull['id'] ?>">hadir</label><br>
            <input type="radio" id="sakit<?= $eskull['id'] ?>" name="kehadiran[<?= $eskull['id'] ?>]" value="sakit">
            <label for="sakit<?= $eskull['id'] ?>">sakit</label><br>
            <input type="radio" id="izin<?= $eskull['id'] ?>" name="kehadiran[<?= $eskull['id'] ?>]" value="izin">
            <label for="izin<?= $eskull['id'] ?>">izin</label>
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
    <button><a href="logout.php">keluar</a></button>
</body>
</html>


