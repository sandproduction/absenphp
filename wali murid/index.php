<?php

session_start();

if(!isset($_SESSION['status'])||$_SESSION['status'] != 'login'){
   header('location:../index.php?message=Login Dulu Bro');
}

if($_SESSION['posisi'] != 'wali murid'){
   header('location:../index.php?message=Anda Bukan Wali Murid');
}


if(isset($_POST['logout'])){
   session_destroy();
   header("location:../index.php?message=Anda Telah Keluar");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <title>Dashboard</title>
</head>
<body>
   <nav><a href="../profil.php">Lihat Profil</a></nav>
   <div class="container">
      <section>
         <header>
            <h3 class="nama-user">Hallo <?php echo $_SESSION['nama'];?></h3>
            <p class="role">Anda Sebagai <?php echo $_SESSION['posisi'];?></p>
         </header>
         <br>
         <br>
         <br>
         <div class="search-box">
            <p class="pesan">Carilah Absen Anak Anda</p>
            <form action="" method="POST" class="search-form">
               <div class="input-field">
                  <select name="kelas" class="kelas-option" required>
                     <option value="" disabled selected>Pilih Kelas</option>
                     <option value="1">1</option>
                     <option value="2">2</option>
                     <option value="3">3</option>
                     <option value="4">4</option>
                  </select>
                  <input type="date" name="tgl" class="date-chooser">
               </div>
               <button name="search" type="submit" class="btn-search">Cari</button>
            </form>
         </div>
         <div class="tabel-wrapper">
            <p class="tgl-absen">Absensi Pada Tanggal<br> <?php echo $_SESSION['tgl'];?></p>
            <!-- TABEL ABSEN -->
            <?php include("tabel.php"); ?>
         </div>
         <br>
         <form action="" method="POST" class="logout-form">
            <button name="logout" type="submit" class="logout-btn">Log Out</button> 
         </form>
      </section>
   </div>
</body>
</html>