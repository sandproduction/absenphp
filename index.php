<?php
session_start();
if(isset($_SESSION['status']) && $_SESSION['status'] == "login"){
   header("location:./dashboard/index.php");
}

?>

<?php
include("./connection.php");
include("Users.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <title>Login Page</title>
</head>
<body>
   <div class="container">
      <div class="logo">
         <img src="" alt="Logo">
      </div>
      <section class="wrapper">
         <div class="title-login">
            <h3 class="title">Login</h3>
         </div>
         <div class="login">
         <?php     
         if(isset($_GET['message'])){
            $msg = $_GET['message'];
            echo "<div class='alert-login'>$msg</div>";
         }
         ?>
            <form action="login.php" method="POST" class="form-login">
               <div class="no-induk">
                  <p>Nomor Induk/ID</p>
                  <input placeholder="nip" name="nip" type="number" class="input-login" required/>
               </div>
               <div class="pas-field">
                  <p>Password</p>
                  <input placeholder="*******" name="password" type="password" class="input-login" required/>
               </div>
               <button type="submit" class="btn-login" name="login">LOG IN</button>
            </form>
         </div>
      </section>
   </div>
</body>
</html>