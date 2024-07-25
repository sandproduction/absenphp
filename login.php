<?php
include("connection.php");
include("Users.php");
session_start();
$user = new Users();

if(isset($_POST['login'])){

   if(strlen($_POST['nip']) <= 2 || strlen($_POST['password']) <= 2){
      header("location:index.php?message=Data Tidak Valid");
   }else{
      $user->set_login_data($_POST['nip'], $_POST['password']);
      
      $id = $user->get_nip();
      $pass = $user->get_password();

      $sql = "SELECT * FROM user WHERE nip=$id AND password='$pass'";
      $result = $db->query($sql);

      if($result->num_rows > 0){ 
         //data yang akan masuk ke bagian dashboard
         while($row = $result->fetch_assoc()){
            $_SESSION['status'] = "login";
            $_SESSION['nip'] = $row['nip'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['posisi'] = $row['posisi'];
            $_SESSION['jk'] = $row['jk'];
            $_SESSION['tgl'] = "0";
         }
         if($_SESSION['posisi'] === "guru"){
            header("location:dashboard/index.php");
         }else if($_SESSION['posisi'] === "wali murid"){
            header("location:wali murid/index.php");
         }else if($_SESSION['posisi'] === "admin"){
            header("location:admin/index.php");
            $_SESSION['indi']="a";
            $_SESSION['form'] = "1";
            $_SESSION['profil'] = rand(1,4);
         }
      }else{
         header("location:index.php?message=NIP atau Password salah");
      }

}
}

?>