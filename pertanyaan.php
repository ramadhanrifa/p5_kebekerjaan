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
        <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(#096096B4 ,#93BFCF);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }
        a{
            text-decoration:none ;
            text-align: right;
            background:blue;
            }
            input[type="submit"] {
        background-color: #007bff; /* Blue color */
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 18px;
        cursor: pointer;
        display: block;
        margin: 0 auto;
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
   <a href="wellcome.php">Kembali</a> 
    </div>
   
</body>
</html>