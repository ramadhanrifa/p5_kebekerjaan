<?php

require_once 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('location: index.php');
    exit(); 
}

$from = $_SESSION['username'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $hasil = mysqli_query($conn, "SELECT * FROM pesan WHERE id = $id");

    if ($hasil && mysqli_num_rows($hasil) > 0) {
        $message = mysqli_fetch_assoc($hasil);
    }

}

if(isset($_POST['submit'])){
    $pesan = $_POST['pesan'];


        // $d = $dari_values[$dari];
        $sql = "UPDATE pesan SET balas = '$pesan' WHERE id = '$id' ";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Pesan anda sudah dikirim')</script>";
            header('location: pesan.php');
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
    <style>
        html{
    height: 100%;
 }

body, h1, h2, p, ul, li {
    margin: 0;
    padding: 0;
    background: linear-gradient(#096096B4 ,#93BFCF);
}

body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}


.contain {
    max-width: 800px;
    margin: 0 auto;
    padding: 50px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}


.table {
    margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid #ccc;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}


.form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"], textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Define styles for links */
a {
    text-decoration: none;
    color: #007bff;
}

a:hover {
    text-decoration: underline;
}

    </style>
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
                </tr>
                
                    <?php $i= 1;?>
                    <?php foreach($hasil as $m){ 
                        
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
        <div class="form">
            <label for="">dari - </label>
            <input type="text" value="<?= $from ?>" disabled>  <br>
            <label for="">tuliskan Pesan anda</label><br>
            <textarea name="pesan" id="" cols="30" rows="10"></textarea><br>

            

            <center><input type="submit" name="submit"></center>
        </div>

    </form>
    <!-- <a href="pertanyaan.php">Kirim Pesan anda</a> -->
    <br><br>
    <a href="pesan.php">Kembali ke halaman sebelumnya</a>



    </div>
    
</body>
</html>