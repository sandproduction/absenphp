<?php
include("./connection.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="profil.css">
   <title>Document</title>
</head>
<body>
   <div class="container">
      <section>
         <header>Profil Anda</header>
         <form action="change.php" method="POST" class="profil">
            <div class="img">
               <?php 
                  if($_SESSION['jk'] == "L"){
                     echo "<img src='./assets/co".$_SESSION['profil'].".png'>";
                  }else if($_SESSION['jk'] == "P"){
                     echo "<img src='./assets/cw".$_SESSION['profil'].".png'>";
                  }
               ?>
            </div>
            <div class="table-wrapper"> 
               <table class="table">   
                  <?php
                     $sql="SELECT * from user Where nip=$_SESSION[nip]";
                     $result = $db->query($sql);
         
                     if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                                    
                           echo "<tr>";
                           echo "<td>ID</td>";
                           echo "<td>:</td>";
                           echo "<td>$row[nip]</td>";
                           echo "</tr>";
                           echo "<tr>";
                           echo "<td>Nama</td>";
                           echo "<td>:</td>";
                           echo "<td>$row[nama]</td>";
                           echo "</tr>";
                           echo "<tr>";
                           echo "<td>Posisi</td>";
                           echo "<td>:</td>";
                           echo "<td>$row[posisi]</td>";
                           echo "</tr>";
                           echo "<tr>";
                           echo "<td>Jenis Kelamin</td>";
                           echo "<td>:</td>";
                           echo "<td>$row[jk]</td>";
                           echo "</tr>";
                           echo "<tr>";
                           echo "<td>Password</td>";
                           echo "<td>:</td>";
                           echo "<td>********</td>";
                           echo "</tr>"; 
                                 
                        }            
                     }
                        
                  ?>
               </table>
               <button type='submit' name='change' class='btn-change'>Change Password</button>
            </div>
         </form>
         <form action='' method="POST" class="back">
            <button name="back-btn" type="submit" class="back-btn">Kembali</button>
         </form>
      </section>
   </div>
</body>
</html>

<?php

if(isset($_POST["back-btn"])){
   if($_SESSION['posisi'] === "admin"){
      header("location:admin/index.php");
      $_SESSION['kategori'] = 'guru';
      
   }else if($_SESSION['posisi'] === "guru"){
      header("location:dashboard/index.php");
   }else if($_SESSION['posisi'] === "wali murid"){
      header("location:wali murid/index.php");
   }
}

?>