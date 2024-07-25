<form action="action.php" method="POST" class="form-absen">
<table class="table">
   <tr>
   <?php
  
      if(isset($_POST["guru"]) || $_SESSION['kategori'] == "guru" || isset($_POST["walmur"]) || $_SESSION['kategori'] == "walmur") {
         echo"<th>ID</th>";
         echo"<th>Nama</th>";
         echo"<th>Jenis Kelamin</th>";
         echo"<th>Posisi</th>";

      }else if(isset($_POST["siswa"]) || $_SESSION['kategori'] == "siswa"){
         echo"<th>ID</th>";
         echo"<th>Nama</th>";
         echo"<th>Jenis Kelamin</th>";
         echo"<th>Kelas</th>";
         echo"<th>Alamat</th>";

      }else if(isset($_POST["absen"]) || $_SESSION['kategori'] == "absen"){
         echo"<th>Nama</th>";
         echo"<th>Id Siswa</th>";
         echo"<th>Kelas</th>";
         echo"<th>Absen</th>";
         echo"<th>Pengabsen</th>";
      }
   ?>
      <th></th>
   </tr>

<?php
include("../connection.php");

date_default_timezone_set("Asia/Jakarta");

$tgl = date('Y-m-d');
$i=0;
$_SESSION['tgl'] = $tgl;

if(isset($_POST['search'])){
   if($_SESSION['kategori'] == 'absen'){
      $_SESSION['kelas']=$_POST['kelas'];
   }
   // header("location:index.php");
   if(!empty($_POST['tgl'])){
      $tanggal= date($_POST['tgl']);
      $_SESSION['tgl'] = $tanggal;
   }else{
      $_SESSION['tgl'] = $tgl;
   }

}

if($_SESSION['kategori'] === 'guru'){
   if(isset($_POST['search'])){
      $sql="SELECT * FROM user where posisi='guru' and nama='$_POST[nama]' or nip='$_POST[id]'";
   }else{
      $sql="SELECT * FROM user where posisi='guru'";
   }
      $result = $db->query($sql);
      while($row = $result->fetch_assoc()){
         echo "<tr>";
         echo "<td>".$row['nip']."</td>";
         echo "<td>".$row['nama']."</td>";
         echo "<td>".$row['jk']."</td>";
         echo "<td>".$row['posisi']."</td>";
         echo "<td><button name='edit_guru' type='submit' class='edit-btn' value='$row[nip]'>Edit</button> 
         <button name='hapus_user' type='submit' class='hapus-btn' value='$row[nip]'>Hapus</button>
         </td>";  

         echo "</tr>";
      }
      echo "</table><br>";
}else if($_SESSION['kategori'] === 'siswa'){
      if(isset($_POST['search'])){
         $sqlS="SELECT * FROM siswa where nama='$_POST[nama]' or id_siswa='$_POST[id]'";
      }else{
         $sqlS="SELECT * FROM siswa";
      }
      
      $resultS = $db->query($sqlS);
      while($rowS = $resultS->fetch_assoc()){
         echo "<tr>";
         echo "<td>".$rowS['id_siswa']."</td>";
         echo "<td>".$rowS['nama']."</td>";
         echo "<td>".$rowS['jk']."</td>";
         echo "<td>".$rowS['kelas']."</td>";
         echo "<td>".$rowS['alamat']."</td>";
         echo "<td><button name='edit_siswa' type='submit' class='edit-btn' value='$rowS[id_siswa]'>Edit</button>
         <button name='hapus_siswa' type='submit' class='hapus-btn' value='$rowS[id_siswa]'>Hapus</button></td>";  
         echo "</tr>";
      }
      echo "</table><br>";
}else if($_SESSION['kategori'] === "absen"){
   if(!empty($_SESSION['kelas']) ){
      $sql="SELECT * FROM siswa where kelas='$_SESSION[kelas]'";
      $result = $db->query($sql);
      $cek_absen = '';
      while($row = $result->fetch_assoc()){

         echo "<tr>";
         echo "<td>".$row['nama']."</td>";
         echo "<td name='".$row['id_siswa']."'>".$row['id_siswa']."</td>";
         echo "<td>".$row['kelas']."</td>";
      
         $cek = "SELECT * FROM kehadiran Where id_siswa='$row[id_siswa]' AND tgl='$_SESSION[tgl]'";
         $cek_absen = $db->query($cek);

         if($cek_absen->num_rows > 0){
            while($absen = $cek_absen->fetch_assoc()){
               echo "<td>".$absen['kehadiran']."</td>";        
               echo "<td>".$absen['nip']."</td>";     
               echo "<td><button name='edit_absen' type='submit' class='edit-btn' value='$row[id_siswa]'>Edit</button></td>";   
               echo "</tr>"; 
            }
         }else{
            echo "<td><select name='hadir[]' class='absen-option' required>";
            echo "<option value='' disable selected>Absen</option>";
            echo "<option value='hadir' >Hadir</option>";
            echo "<option value='tidak hadir' >Tidak Hadir</option>";
            echo "</select></td>";
            echo "<td></td>";
            echo "<td></td>"; 
            echo "</tr>";
         }    
      }
   
   echo "</table><br>";
   if($cek_absen->num_rows <= 0){
      echo "<button name='absen' type='submit' class='absen-btn'>Absen</button>";
   }
}
}else if($_SESSION['kategori'] === 'walmur'){
   $sql="SELECT * FROM user where posisi='wali murid'";
   $result = $db->query($sql);
   while($row = $result->fetch_assoc()){
      echo "<tr>";
      echo "<td>".$row['nip']."</td>";
      echo "<td>".$row['nama']."</td>";
      echo "<td>".$row['jk']."</td>";
      echo "<td>".$row['posisi']."</td>";
      echo "<td><button name='edit_wali' type='submit' class='edit-btn' value='$row[nip]'>Edit</button>
      <button name='hapus_user' type='submit' class='hapus-btn' value='$row[nip]'>Hapus</button></td>";  
      echo "</tr>";
   }
   echo "</table><br>";
}

if($_SESSION['kategori'] != 'absen'){
   echo"<button name='btn_tambah' type='submit' class='absen-btn'>Tambah Data</button>";
}




?>

</form>