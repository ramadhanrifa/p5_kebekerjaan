<?php
require_once 'config.php';
session_start();

$user = mysqli_query($conn, "SELECT * FROM users ");

// $sesi = $_SESSION['username'];
// $sql = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] ."'";
// $result = mysqli_query($conn, $sql);

// if ($result) {
//     $row = mysqli_fetch_assoc($result);
//     $status = $row['status'];

//     if ($status === 'pembimbing') {
//         $link = 'datasiswa';
//     } elseif ($status === 'rayon') {
//         $link = 'rayon';
//     } elseif($status === 'produktif'){
//         $link = 'produktif';
//     }elseif($status== 'senbud'){
//         $link = 'senbud';
//     }
//     else{
//         $link = 'umum';
//     }
// } else {

//     $link = 'logout'; 
// }


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
            header('location: wellcome.php');

        } else {
            echo "Error: " . mysqli_error($conn);
        }
    

   
}
if ($user) {
    $row = mysqli_fetch_assoc($user);
    $status = $row['status'];

    if ($status === 'pembimbing') {
        $link = 'datasiswa';
    } elseif ($status === 'rayon') {
        $link = 'rayon';
    } elseif($status === 'produktif'){
        $link = 'produktif';
    }elseif($status=== 'senbud'){
        $link = 'senbud';
    }elseif($status === 'umum'){
        $link = 'umum';
    }
    else{
        $link = 'pesan';
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
        <style>
        /* Reset some default styles */
body, html {
    height: 100%;
    margin: 0;
    padding: 0;
    background: linear-gradient(#096096B4 ,#93BFCF);
}

/* Style for the container */
.contain {
    background-color: #f2f2f2;
    padding: 20px;
    margin: 20px;
    border-radius: 5px;
}

/* Style for the form */
form {
    text-align: center;
}

h1 {
    font-size: 24px;
}

/* Style for labels and select */
label, select {
    display: block;
    margin-bottom: 10px;
}

select {
    width: 100%;
    padding: 5px;
}

/* Style for textarea */
textarea {
    width: 100%;
    height: 150px;
    padding: 5px;
    resize: none;
}

/* Style for the submit button */
input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
}

/* Style for the "Kembali" link */
a {
    text-decoration: none;
    color: #007bff;
    display: block;
    margin-top: 20px;
}

a:hover {
    text-decoration: underline;
}

</style> 

</head>

<body>
    <div class="contain">
        <form action="" method="post">
        <h1>form Pesan</h1><br>
        <div class="form">
            <center>
            <label for="">Kirim ke - </label>
            <select name="nama" id="">
                <?php foreach($user as $u) :?>
                <option value="<?= $u['username']?>"><?=$u['username'] ?></option>
                <?php endforeach;?>
            </select><br>
            <label for="">tuliskan Pesan anda</label><br>
            <textarea name="pesan" id="" cols="30" rows="10"></textarea><br>
            </center>


            <input type="submit" name="submit">
        </div>

    </form>
   <a href="<?= $link?>.php">Kembali</a> 
    </div>
   
</body>
</html>