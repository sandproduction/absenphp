<form action="action.php" method="POST" class="form-absen">
<table class="table">
   <tr>
      <th>Nama</th>
      <th>Id Siswa</th>
      <th>Kelas</th>
      <th>Absen</th>
      <th>Pengabsen</th>
   </tr>

<?php
include("../connection.php");

date_default_timezone_set("Asia/Jakarta");

$tgl = date('Y-m-d');
$i=0;

if(isset($_POST['search'])){
   $_SESSION['kelas']=$_POST['kelas'];

   if(!empty($_POST['tgl'])){
      $tanggal= date($_POST['tgl']);
      $_SESSION['tgl'] = $tanggal;
   }else{
      $_SESSION['tgl'] = $tgl;
   }
}

if(!empty($_SESSION['kelas'])){
   
   $sql="SELECT * FROM siswa where kelas='$_SESSION[kelas]'";
   $result = $db->query($sql);
   while($row = $result->fetch_assoc()){
     
      echo "<tr>";
      echo "<td>".$row['nama']."</td>";
      echo "<td>".$row['id_siswa']."</td>";
      echo "<td>".$row['kelas']."</td>";
      
      if(!empty($tanggal)){
         $cek = "SELECT * FROM kehadiran Where nama='$row[nama]' AND tgl='$tanggal'";
      }else{
         $cek = "SELECT * FROM kehadiran Where nama='$row[nama]' AND tgl='$tgl'";
      }
      $cek_absen = $db->query($cek);
      if($cek_absen->num_rows > 0){
         while($absen = $cek_absen->fetch_assoc()){
            echo "<td>".$absen['kehadiran']."</td>";        
            echo "<td>".$absen['nip']."</td>";        
         }
      }else if($_SESSION['tgl'] === $tgl){
         echo "<td><select name='hadir[]' class='absen-option' required>";
         echo "<option value='' disable selected>Absen</option>";
         echo "<option value='hadir' >Hadir</option>";
         echo "<option value='tidak hadir' >Tidak Hadir</option>";
         echo "</select></td>";
         echo "<td></td>";
         
      }else{
         echo "<td>Tidak Ada Absen</td>";
         echo "<td></td>";
      }
   }
}


?>

</table>
   <button name="absen" type="submit" class="absen-btn">Absen</button>
</form>

<?php
if(isset($_POST['keluar'])){
   $update = "UPDATE kehadiran SET jam_keluar='$jam' where nip=$nip and tgl='$tgl'";

   $jam_keluar = $db->query($update);
   if($jam_keluar === true){
      session_start();
      session_destroy();
      header("location:../index.php");
   }

}
?>



