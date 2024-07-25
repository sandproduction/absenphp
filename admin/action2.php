
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <title>Document</title>
</head>
<body>
   <section>
      <div class="edit-container">
         <h1 class="edit-title">Form</h1>
         <form action='update.php' method='POST' class="edit-form">
            <table class="table-edit">
               <?php
                  include("../connection.php");
                  session_start(); 

                  if (!isset($_SESSION['nip'])) {
                     header("Location: login.php");
                     exit();
                  }
                  
                  date_default_timezone_set("Asia/Jakarta");
                  $nip = $_SESSION['nip'];
                  
                  $tgl = date('Y-m-d');
                  
                  if(isset($_POST['edit_absen'])){
                     
                     $sql="SELECT * FROM kehadiran where id_siswa=$_POST[edit_absen] and tgl='$_SESSION[tgl]'";
                     $result = $db->query($sql);
                     
                     if($result->num_rows > 0){
                  
                        echo "<tr><th>Data Awal</th>";
                        echo "<th>Data Diperbarui</th></tr>";
                        
                        while($row = $result->fetch_assoc()){
                           $_SESSION['id_absen'] = $row["id"];
                           echo "<tr>";
                              echo "<td>".$row['id_siswa']."</td>";
                              echo "</tr>";
                              
                              echo "<tr>";
                              echo "<td>".$row['nama']."</td>";
                              echo "</tr>";
                              
                              echo "<tr>";
                              echo "<td>".$row['kelas']."</td>";
                              echo "</tr>";
                              
                              $_SESSION['kelas']=$row['kelas'];
                  
                              echo "<tr>";
                              echo "<td>".$row['tgl']."</td>";
                              echo "<td><input type='date' class='tgl-edit' palceholder='tanggal absen' name='tgl'></td>";
                              echo "</tr>";
                              
                              echo "<tr>";
                              echo "<td>".$row['kehadiran']."</td>";
                              echo "<td><select name='hadir' class='edit-option' required>";
                              echo "<option value='' disable selected>Absen</option>";
                              echo "<option value='hadir' >Hadir</option>";
                              echo "<option value='tidak hadir' >Tidak Hadir</option>";
                              echo "</select></td>";
                              echo "</tr>";
                              
                              echo "<tr>";
                              echo "<td>".$row['nip']."</td>";
                              echo "<td><input type='number' class='pengabsen-field' palceholder='id pengabsen' name='nip'></td>";
                           echo "</tr>";
                           echo "</table>";
                           echo "<button name='update' type='submit' class='update-btn'>Update</button></form>";
                        }
                     }

                     $sql="SELECT * FROM siswa where kelas='$_SESSION[kelas]'";
                     $result = $db->query($sql);
                     
                     while($row = $result->fetch_assoc()){
                        $nama_s[]= $row['nama'];
                        $id_siswa[]= $row['id_siswa'];
                     }
                     
                     if(isset($_POST['absen'])){
                        
                        $check_absensi="SELECT tgl FROM kehadiran WHERE kelas='$_SESSION[kelas]' AND tgl='$_SESSION[tgl]'";
                        $check = $db->query($check_absensi);
                        
                        if($check->num_rows > 0){
                           header("location:index.php?message=ANDA SUDAH ABSEN");
                        }else{
                           $i=0;
                           foreach ($_POST['hadir'] as $key => $value) {
                              # code...
                              $sql = "INSERT INTO kehadiran VALUES(null,'$nama_s[$i]','$id_siswa[$i]','$_SESSION[kelas]','$tgl','$value',$nip)";
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

                  }else if(isset($_POST['edit_guru'])){

                  $sql="SELECT * FROM user where nip=$_POST[edit_guru]";
                  $result = $db->query($sql);
                  
                  if($result->num_rows > 0){
                  
                        echo "<tr><th colspan='2'>Data Awal</th></tr>";
                                               
                        while($row = $result->fetch_assoc()){
                           $_SESSION["nip_guru"] = $row["nip"];
                           echo "<tr>";
                              echo "<td>NIP</td>";
                              echo "<td><input type='number' class='txt-field' placeholder='NIP/ID' name='ID' value=".$row['nip']." required></td>";
                              echo "</tr>";
                              
                              echo "<tr>";
                              echo "<td>Nama</td>";
                              echo "<td><input type='text' class='txt-field' placeholder='Nama' name='Nama' value='".$row['nama']."' required></td>";
                              echo "</tr>";
                              
                              echo "<tr>";
                              echo "<td>Jenis Kelamin</td>";
                              echo "<td>
                                 <select name='jk' class='edit-option' required>
                                 <option value='' disable selected>jenis kelamin</option>";
                                 if($row['jk'] == "L"){
                                    echo "<option value='P'>P</option>
                                          <option value='L' selected>L</option>";
                                 }else{
                                    echo "<option value='P' selected>P</option>
                                          <option value='L'>L</option>";
                                 }

                              echo "</td></tr>";
                  
                              echo "<tr>";
                              echo "<td>Posisi</td>";
                              echo "<td><input type='text' class='txt-field' placeholder='posisi' name='posisi' value='".$row['posisi']."' required></td>";
                              echo "</tr>";

                              echo "<tr>";
                              echo "<td>Password</td>";
                              echo "<td><input type='text' class='txt-field' placeholder='password' name='pass' value='".$row['password']."' required></td>";
                              echo "</tr>";
                               
                           echo "</tr>";
                           echo "</table>";
                           echo "<button name='update-guru' type='submit' class='update-btn' value='$row[nip]'>Update</button></form>";
                        }
                  }
                   
                  }else if(isset($_POST['edit_siswa'])){

                  $sql="SELECT * FROM siswa where id_siswa=$_POST[edit_siswa]";
                  $result = $db->query($sql);
                  $_SESSION["id_siswa"] = $_POST['edit_siswa'];
                  if($result->num_rows > 0){
                  
                        echo "<tr><th>Data Awal</th>";
                        echo "<th>Data Diperbarui</th></tr>";
                        
                        while($row = $result->fetch_assoc()){
                          
                           echo "<tr>";
                              echo "<td>".$row['id_siswa']."</td>";
                              echo "<td><input type='number' class='txt-field' placeholder='NIP/ID' name='ID' required></td>";
                              echo "</tr>";
                              
                              echo "<tr>";
                              echo "<td>".$row['nama']."</td>";
                              echo "<td><input type='text' class='txt-field' placeholder='Nama' name='Nama' required></td>";
                              echo "</tr>";
                              
                              echo "<tr>";
                              echo "<td>".$row['jk']."</td>";
                              echo "<td>
                                 <select name='jk' class='edit-option' required>
                                    <option value='' disable selected>jenis kelamin</option>
                                    <option value='P'>P</option>
                                    <option value='L'>L</option>
                                 </td>";
                              echo "</tr>";
                  
                              echo "<tr>";
                              echo "<td>".$row['kelas']."</td>";
                              echo "<td><input type='text' class='txt-field' placeholder='Kelas' name='kelas' required></td>";
                              echo "</tr>";

                              echo "<tr>";
                              echo "<td>".$row['alamat']."</td>";
                              echo "<td><input type='text' class='txt-field' placeholder='alamat' name='alamat' required></td>";
                              echo "</tr>";
                               
                           echo "</tr>";
                           echo "</table>";
                           echo "<button name='update-siswa' type='submit' class='update-btn' value='$row[id_siswa]'>Update</button></form>";
                        }
                     }
                  }else if(isset($_POST['edit_wali'])){
                     $sql="SELECT * FROM user where nip=$_POST[edit_wali]";
                     $result = $db->query($sql);
                     
                     if($result->num_rows > 0){
                     
                           echo "<tr><th>Data Awal</th>";
                           echo "<th>Data Diperbarui</th></tr>";
                           
                           while($row = $result->fetch_assoc()){
                              $_SESSION["nip_walmur"] = $row["nip"];
                              echo "<tr>";
                                 echo "<td>".$row['nip']."</td>";
                                 echo "<td><input type='number' class='txt-field' placeholder='NIP/ID' name='ID' required></td>";
                                 echo "</tr>";
                                 
                                 echo "<tr>";
                                 echo "<td>".$row['nama']."</td>";
                                 echo "<td><input type='text' class='txt-field' placeholder='Nama' name='Nama' required></td>";
                                 echo "</tr>";
                                 
                                 echo "<tr>";
                                 echo "<td>".$row['jk']."</td>";
                                 echo "<td>
                                    <select name='jk' class='edit-option' required>
                                       <option value='' disable selected>jenis kelamin</option>
                                       <option value='P'>P</option>
                                       <option value='L'>L</option>
                                    </td>";
                                 echo "</tr>";
                     
                                 echo "<tr>";
                                 echo "<td>".$row['posisi']."</td>";
                                 echo "<td><input type='text' class='txt-field' placeholder='posisi' name='posisi' required></td>";
                                 echo "</tr>";
   
                                 echo "<tr>";
                                 echo "<td>".$row['password']."</td>";
                                 echo "<td><input type='text' class='txt-field' placeholder='password' name='pass' required></td>";
                                 echo "</tr>";
                                  
                              echo "</tr>";
                              echo "</table>";
                              echo "<button name='update-walmur' type='submit' class='update-btn' value='$row[nip]'>Update</button></form>";
                           }
                     }
                      
                  }else if(isset($_POST['btn_tambah']) && $_SESSION['kategori'] != 'siswa' ){
                     
                     echo "<tr><th colspan='2'>Tambah Data</th></tr>";
                     echo "<tr>";
                     echo "<td>ID</td>";
                     echo "<td><input type='number' class='txt-field' placeholder='NIP/ID' name='ID' required></td>";
                     echo "</tr>";
                        
                     echo "<td>Nama</td>";
                     echo "<td><input type='text' class='txt-field' placeholder='Nama' name='nama' required></td>";
                     echo "</tr>";
                     
                     echo "<td>Jenis Kelamin</td>";
                     echo "<td><select name='jk' class='edit-option' required>
                        <option value='' disable selected>jenis kelamin</option>
                        <option value='L'>L</option>
                        <option value='P'>P</option>
                     </select></td>";
                     echo "</tr>";

                     echo "<td>Posisi</td>";
                     echo "<td><select name='posisi' class='edit-option' required>";
                    
                     if($_SESSION['kategori'] === 'guru'){
                        echo "<option value='guru' selected>Guru</option>";
                     }else if($_SESSION['kategori'] ==='walmur'){
                        echo "<option value='wali murid' selected>Wali Murid</option>";
                     }
                     
                     echo "</select></td>";
                     echo "</tr>";
                     
                     echo "<td>Password</td>";
                     echo "<td><input type='text' class='txt-field' placeholder='Password' name='pass' required></td>";
                     echo "</tr>";

                     echo "</table>";
                     echo "<button name='tambah-user' type='submit' class='update-btn'>Tambah</button></form>";
                 
                  }else if(isset($_POST['btn_tambah']) && $_SESSION['kategori'] === 'siswa' ){
                     echo "<h1>Siswa</h1>";
                     echo "<tr colspan='2'><th>Tambah Data</th></tr>";
                     echo "<tr>";
                     echo "<td>ID</td>";
                     echo "<td><input type='number' class='txt-field' placeholder='NIP/ID' name='ID' required></td>";
                     echo "</tr>";
                        
                     echo "<td>Nama</td>";
                     echo "<td><input type='text' class='txt-field' placeholder='Nama' name='nama' required></td>";
                     echo "</tr>";
                     
                     echo "<td>Jenis Kelamin</td>";
                     echo "<td><select name='jk' class='edit-option' required>
                        <option value='' disable selected>jenis kelamin</option>
                        <option value='L'>L</option>
                        <option value='P'>P</option>
                     </select></td>";
                     echo "</tr>";

                     echo "<td>Kelas</td>";
                     echo "<td><input type='number' class='txt-field' placeholder='Kelas' name='kelas' required></td>";
                     echo "</tr>";
                     
                     echo "<td>Alamat</td>";
                     echo "<td><input type='text' class='txt-field' placeholder='Alamat' name='alamat' required></td>";
                     echo "</tr>";

                     echo "</table>";
                     echo "<button name='tambah-siswa' type='submit' class='update-btn'>Tambah</button></form>";
                  
                  }else if(isset($_POST['hapus_user']) ){
                     $sql="DELETE FROM user where nip=$_POST[hapus_user]";
                     $result = $db->query($sql);
                     if($result){
                        header("location:index.php?message=Hapus Data Berhasil");
                        $_SESSION['kategori'] = 'guru';
                        $_SESSION['form'] = '0';
                     }else{
                        header("location:index.php?message=Hapus Data Gagal");
                        $_SESSION['kategori'] = 'guru';
                     }
                  }else if(isset($_POST['hapus_siswa']) ){
                     $sql="DELETE FROM siswa where id_siswa=$_POST[hapus_siswa]";
                     $result = $db->query($sql);
                     if($result){
                        header("location:index.php?message=Hapus Data Berhasil");
                        $_SESSION['kategori'] = 'siswa';
                        $_SESSION['form'] = '0';
                     }else{
                        header("location:index.php?message=Hapus Data Gagal");
                        $_SESSION['kategori'] = 'siswa';
                     }
                  }else if(isset($_POST['absen'])){

                     $sql="SELECT * FROM siswa where kelas='$_SESSION[kelas]'";
                     $result = $db->query($sql);
                     
                     while($row = $result->fetch_assoc()){
                        $nama_s[]= $row['nama'];
                        $id_siswa[]= $row['id_siswa'];
                     }

                     $check_absensi="SELECT tgl FROM kehadiran WHERE kelas='$_SESSION[kelas]' AND tgl='$_SESSION[tgl]'";
                     $check = $db->query($check_absensi);
                     
                     if($check->num_rows > 0){
                        header("location:index.php?message=ANDA SUDAH ABSEN");
                        $_SESSION['form'] = "0";
                     }else{
                        $i=0;
                        foreach ($_POST['hadir'] as $key => $value) {
                           # code...
                           $sql = "INSERT INTO kehadiran VALUES(null,'$nama_s[$i]','$id_siswa[$i]','$_SESSION[kelas]','$tgl','$value',$nip)";
                           $result = $db->query($sql);
                     
                           if($result === true){
                              header("location:index.php?message=Absen Berhasil");
                              $_SESSION['form'] = "0";
                              $i++;
                           }else{
                              header("location:index.php?message=Absen Gagal");
                              $_SESSION['form'] = "0";
                           }
                        }
                  
                     }
                  }  
                  
               ?>
            </table>
         </form> 
         <form action='index.php' method="POST" class="cancel-form">
            <button name="cancel" type="submit" class="cancel-btn">Cancel</button>
         </form>
      </div>
   </section>
</body>
</html>

<?php
   if(isset($_POST['cancel'])){
      header("location:/index.php");
   }
?>