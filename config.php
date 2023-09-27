<?php 
 
$server = "localhost";
$user = "root";
$pass = "";
$database = "db_p5abseneskuldansenbud";
 
$conn = mysqli_connect($server, $user, $pass, $database);
 
if (!$conn) {
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result) ){
        $rows[] = $row;
    }
return $rows;
}


function search($keyword){
    $query = "SELECT * FROM datasiswa WHERE
    nis LIKE '%$keyword%' OR
    nama LIKE '%$keyword%' OR
    rayon LIKE '%$keyword%' OR
    eskul LIKE '%$keyword%' OR
    senbud LIKE '%$keyword%' OR
    eskulproduktif LIKE '%$keyword%' OR
    kehadiranEskulUmum LIKE '%$keyword%'OR
    kehadiranEskulProduktif LIKE '%$keyword%'OR
    kehadiranaSeniBudaya LIKE '%$keyword%'
    
    ";
    return query ($query);
}

?>