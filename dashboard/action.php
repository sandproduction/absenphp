<?php
include("../connection.php");
session_start(); 

date_default_timezone_set("Asia/Jakarta");
$nip = $_SESSION['nip'];
$kelas = $_SESSION['kelas'];
$tgl = date('Y-m-d');


$sql="SELECT * FROM siswa where kelas='$kelas'";
$result = $db->query($sql);

while($row = $result->fetch_assoc()){
   $nama_s[]= $row['nama'];
   $id_siswa[]= $row['id_siswa'];
}

if(isset($_POST['absen'])){
   
   $check_absensi="SELECT tgl FROM kehadiran WHERE kelas='$kelas' AND tgl='$tgl'";
   $check = $db->query($check_absensi);
   
   if($check->num_rows > 0){
      header("location:index.php?message=ANDA SUDAH ABSEN");
   }else{
      $i=0;
      foreach ($_POST['hadir'] as $key => $value) {
         # code...
         $sql = "INSERT INTO kehadiran VALUES(null,'$nama_s[$i]','$id_siswa[$i]','$kelas','$tgl','$value',$nip)";
         $result = $db->query($sql);
   
         if($result === true){
            header("location:index.php?message=Absen Berhasil");
            $i++;
         }else{
            header("location:index.php?message=Absen Gagal");
         }
      }

   }
}

?>