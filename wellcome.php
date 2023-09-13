<?php 

require_once 'config.php';

session_start();
 
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
// $status = $_SESSION['status'];
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
    // Handle error jika query gagal
    $link = 'logout'; // Atau sesuaikan dengan tindakan yang sesuai
}

 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>Berhasil Login</title>
</head>
<body>
    <div class="container-logout">
        <form action="" method="POST" class="login-email">
            <?php echo "<h1>Selamat Datang, " . $_SESSION['username'] ."!". "</h1>"; ?>

            
            <div class="input-group">
                <a href="<?= $link ?>.php" class="btn">Lanjutkan</a>
                
            </div>
        </form>
    </div>
</body>
</html>