<?php
require_once 'config.php';
session_start();

$user = mysqli_query($conn, "SELECT * FROM users ");

$from = $_SESSION['username'];

$pengirim = mysqli_query($conn, "SELECT * FROM pesan WHERE nama = '$from' " );

if(!isset($_SESSION['username'])){
    header('location: index.php');
}



if(isset($_POST['submit'])){
    $pesan = $_POST['pesan'];


        // $d = $dari_values[$dari];
        $sql = "UPDATE pesan SET balas = '$pesan' WHERE nama = '$from' ";

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

        <div class="table" border = 1> 
            <table>
                <tr>
                    <th>No</th>
                    <th>untuk</th>
                    <th>Pesan</th>
                    <th>Dari</th>
                    <th>balasan</th>
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
                    
                </tr>
                <?php $i++; ?>
                <?php }?>
            </table>
        </div>


        <form action="" method="post">
        <h1>form Pesan</h1><br>
        <div class="form">
            <label for="">dari - </label>
            <input type="text" value="<?= $from ?>">  <br>
            <label for="">tuliskan Pesan anda</label><br>
            <textarea name="pesan" id="" cols="30" rows="10"></textarea><br>

            

            <center><input type="submit" name="submit"></center>
        </div>

    </form>
    <?php
if (isset($_SERVER['HTTP_REFERER'])) {
    $previousPage = $_SERVER['HTTP_REFERER'];
    echo "<a href='$previousPage'>Kembali ke halaman sebelumnya</a>";
} else {
    // Handle the case where the HTTP_REFERER is not set (e.g., user typed the URL directly)
    // You can redirect to a default page or display an error message.
    echo "No previous page found.";
}
?>

    </div>
    
</body>
</html>