<?php
require_once 'config.php';
session_start();

$user = mysqli_query($conn, "SELECT * FROM users ");

$from = $_SESSION['username'];

$pengirim = mysqli_query($conn, "SELECT * FROM pesan WHERE nama = '$from' " );

$sql = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] ."'";

$result = mysqli_query($conn, $sql);







if(!isset($_SESSION['username'])){
    header('location: index.php');
}


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





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pertanyaan</title>
    <link rel="stylesheet" href="style/pesan.css">
</head>
<body>
    <center><h1>form Pesan</h1><br></center>
    <div class="contain">

        <div class="table" border = 1> 
            <table>
                <tr>
                    <th>No</th>
                    <th>untuk</th>
                    <th>Pesan</th>
                    <th>Dari</th>
                    <th>balasan</th>
                    <th>Aksi</th>
                </tr>
                
                    <?php $i= 1;?>
                    <?php foreach($pengirim as $m){ 
                        
                        ?>
                <tr>
                    
                    <td><?= $i ?></td>
                    <td><?= $m['nama'] ?></td>
                    <td><?= $m['pesan'] ?></td>
                    <td><?= $m['dari'] ?></td>
                    <td><?= $m['balas'] ?></td>
                    <td><a href="balas.php?id=<?= $m['id']?>">Balas Pesan</a></td>
                    
                </tr>
                <?php $i++; ?>
                <?php }?>
            </table>
        </div>


    <br><br>

    </form>
    <div class="link">
    <a href="pertanyaan.php">Kirim Pesan anda</a>
    <br><br><br>
    <a href="<?= $link?>.php">Kembali ke halaman sebelumnya</a>
    </div>



    </div>
    
</body>
</html>