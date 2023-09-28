<?php 

require_once 'config.php';

session_start();
 
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
// $status = $_SESSION['status'];
$sql = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] ."'";
$result = mysqli_query($conn, $sql);

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

$link = null;
 
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
            <?php 
                if($result){
                    $row = mysqli_fetch_assoc($result);
                    $status = $row['status'];
                    $divisi = $row['divisi'];

                    if ($status === 'pembimbing') {
                        $link = 'datasiswa';
                    } elseif ($status === 'rayon') {
                        $link = 'rayon';
                    } elseif($status === 'produktif'){
                        $link = 'produktif';
                    }elseif($status== 'senbud'){
                        $link = 'senbud';
                    }
                    elseif($status === 'umum'){
                        $link = 'umum';
                    }
                    elseif($status === 'double'){
                        if(!isset($_POST['pilihan'])){
                            echo "<script>alert('silahkan pilih dulu pilihannya')</script>";
                        }
                        if(isset($_POST['pilihan'])){
                            echo "<script>alert('klik lanjutkan')</script>";
                        }
                        if (isset($_POST['pilihan'])) {
                            $pilihan = $_POST['pilih'];
                        
                            if ($pilihan === 'rayon') {
                                $link = 'rayon';
                            } elseif ($pilihan === 'produktif') {
                                $link = 'produktif';
                            }
                            elseif ($pilihan === 'umum') {
                                $link = 'umum';
                            }
                            elseif ($pilihan === 'senbud') {
                                $link = 'senbud';
                            }
                            elseif ($pilihan === 'pembimbing') {
                                $link = 'datasiswa';
                            }
                        }

                    }
                    
                     if($status === 'double'): ?>
                            <label for="">Masuk sebagai</label>
                            <select name="pilih" id="pilih">
                                <option value="rayon"><?=$_SESSION['rayon'] ?></option>
                                <?php if($divisi === 'produktif'): ?>
                                <option value="produktif"><?=$_SESSION['tipe'] ?></option>
                                <?php endif;?>
                                <?php if($divisi === 'pembimbing'): ?>
                                <option value="pembimbing"><?=$_SESSION['divisi'] ?></option>
                                <?php endif;?>
                                <?php if($divisi === 'umum'): ?>
                                <option value="umum"><?=$_SESSION['tipe'] ?></option>
                                <?php endif;?>
                                <?php if($divisi === 'senbud'): ?>
                                <option value="senbud"><?=$_SESSION['tipe'] ?></option>
                                <?php endif;?>
                            </select>
                            <input type="submit" name="pilihan" value="pilih">
                    <?php endif;?>
               <?php }else {
                    $link = 'logout'; 
                }
                ?>
                
            
            <div class="input-group">
                <a href="<?= $link ?>.php" class="btn">Lanjutkan</a>
                
            </div>
        </form>
    </div>
</body>
</html>