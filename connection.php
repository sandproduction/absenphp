<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$db_name = 'absensi_try';

$db = new mysqli($hostname, $username, $password, $db_name);

if($db->connect_error){
   echo "error connector";
}



?>