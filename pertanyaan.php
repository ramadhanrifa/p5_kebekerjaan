<?php
require_once 'config.php';
session_start();

$user = mysqli_query($conn, "SELECT * FROM users ");

if(!isset($_SESSION['username'])){
    header('location: index.php');
}

$from = $_SESSION['username'];

if(isset($_POST['submit'])){
    $pesan = $_POST['pesan'];
    $nama = $_POST['nama'];


        // $d = $dari_values[$dari];
        $sql = "INSERT INTO pesan (nama, pesan, dari) VALUES ('$nama', '$pesan', '$from') ";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Pesan anda sudah dikirim')</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    

   
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pertanyaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="contain">
        <form action="" method="post">
        <h1>form Pesan</h1><br>
        <div class="form">
            <label for="">Kirim ke - </label>
            <select name="nama" id="">
                <?php foreach($user as $u) :?>
                <option value="<?= $u['username']?>"><?=$u['username'] ?></option>
                <?php endforeach;?>
            </select><br>
            <label for="">tuliskan Pesan anda</label><br>
            <textarea name="pesan" id="" cols="30" rows="10"></textarea><br>

            

            <center><input type="submit" name="submit"></center>
        </div>

    </form>
    <a href="datasiswa.php">Kembali</a>
    </div>
    
</body>
</html>