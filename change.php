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
   <article>
      <h1>Change Password</h1>
      <?php
         if(isset($_GET['message'])){
            $msg = $_GET['message'];
            echo "<p class='message'>$msg</p>";
         }
      ?>
      <form action="" method="POST" class="box">
         <label>Masukkan Password Baru</label>
         <input type="password" name="pass1" class="input" required>
         <label>Ulangi Password Baru</label>
         <input type="password" name="pass2" class="input" required>
         <button type="submit" name="btn-change" class="btn-change">Change</button>
      </form>
      
   </article>
   <a href="profil.php" class="kembali">Kembali</a>
</body>
</html>

<?php

if(isset($_POST["btn-change"])){
   if($_POST['pass1'] === $_POST['pass2']){
      $sql = "UPDATE user set password = '$_POST[pass2]' where nip=$_SESSION[nip]";
      $result = $db->query($sql);

      if($result){
         header("location:profil.php?message=alert('Berhasil')");
      }else{
         header("location:change.php?message=Gagal");
      }
   }else{
      header("location:change.php?message=Password Tidak Sama");
   }
}

?>