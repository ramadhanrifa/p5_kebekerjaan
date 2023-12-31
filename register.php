<?php 
 
include 'config.php';
 
error_reporting(0);
 
session_start();
 
if (isset($_SESSION['username'])) {
    header("Location: index.php");
}
 
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $tipe = $_POST['tipe'];
    $rayon = $_POST['rayon'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
 
    if ($password == $cpassword) {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO users (username, email, password, status, divisi, tipe, rayon)
                    VALUES ('$username', '$email', '$password', '$status', '$divisi', '$tipe', '$rayon' )";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Selamat, registrasi berhasil!')</script>";
                $username = "";
                $email = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
            } else {
                echo "<script>alert('Woops! Terjadi kesalahan.')</script>";
            }
        } else {
            echo "<script>alert('Woops! Email Sudah Terdaftar.')</script>";
        }
         
    } else {
        echo "<script>alert('Password Tidak Sesuai')</script>";
    }
}
 
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <link rel="stylesheet" type="text/css" href="style/style.css">
 
    <title>Register</title>
</head>
<body>
    <div class="container">
        <form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
            <div class="input-group">
                <input type="text" placeholder="Username" name="username" value="<?= $username; ?>" required>
            </div>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" value="<?= $email; ?>" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" value="<?= $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Confirm Password" name="cpassword" value="<?= $_POST['cpassword']; ?>" required>
            </div>
            <div class="input-group">
                <select name="status" id="" >
                    <option value="produktif">produktif</option>
                    <option value="umum">umum</option>
                    <option value="senbud">senbud</option>
                    <option value="rayon">rayon</option>
                    <option value="double">double (jika ada 2 option)</option>
                </select>
            </div>
            <div class="input-group">
                <label for="">isi jika anda memilih double</label>
                <select name="divisi" id="" >
                    <option value="produktif">produktif</option>
                    <option value="umum">umum</option>
                    <option value="senbud">senbud</option>
                    <option value="rayon">rayon</option>
                </select>
            </div>
            <div class="input-group">
                <input type="text" placeholder="ngajar(kosongkan jika perlu)" name="tipe" value="<?= $_POST['tipe']; ?>" required>
                <input type="text" placeholder="rayon(kosongkan jika perlu)" name="rayon" value="<?= $_POST['tipe']; ?>" required><br>
            </div>
            <br><br>
            <div class="input-group">
                <button name="submit" class="btn">Register</button>
            </div>
            <p class="login-register-text">Anda sudah punya akun? <a href="index.php">Login </a></p>
        </form>
    </div>
</body>
</html>