<?php
include("../connection.php");
session_start(); 

   if(isset($_POST["update"])){
      if(empty($_POST['tgl'])){
         $tgl = $_SESSION['tgl'];
      }else{
         $tgl= $_POST['tgl'];
      }
      $update = "UPDATE kehadiran SET tgl='$tgl', kehadiran='$_POST[hadir]' where id=$_SESSION[id_absen]";
      $up = $db->query($update);
      
      if($up){
         header("location:index.php?message=Update Berhasil");
         $_SESSION['kategori'] = 'absen';
         $_SESSION['form'] = '0';
      }else{
         header("location:index.php?message=Update Gagal");
         $_SESSION['kategori'] = 'absen';
      }
   }

   if(isset($_POST["update_guru"])){
      
      $update_guru = "UPDATE user SET nip=$_POST[update_guru], nama='$_POST[Nama]', jk='$_POST[jk]', posisi='$_POST[posisi]',password=$_POST[pass] where nip=$_SESSION[nip_guru]";
      $up_guru = $db->query($update_guru);
      
      if($up_guru){
         header("location:index.php?message=Update Berhasil");
         $_SESSION['kategori'] = 'guru';
         $_SESSION['form'] = '0';
      }else{
         header("location:index.php?message=Update Gagal");
         $_SESSION['kategori'] = 'guru';
      }
   }
   
   if(isset($_POST["update_siswa"])){
      
      $update_siswa = "UPDATE siswa SET id_siswa=$_POST[update_siswa], nama='$_POST[Nama]', jk='$_POST[jk]', kelas='$_POST[kelas]', alamat='$_POST[alamat]' where id_siswa=$_SESSION[id_siswa]";
      $up_siswa = $db->query($update_siswa);
      
      if($up_siswa){
         header("location:index.php?message=Update Berhasil");
         $_SESSION['kategori'] = 'siswa';
         $_SESSION['form'] = '0';
      }else{
         header("location:index.php?message=Update Gagal");
         $_SESSION['kategori'] = 'siswa';
      }
   }
   
   if(isset($_POST["update_walmur"])){
      
      $update_walmur = "UPDATE `user` SET nip=$_POST[update_walmur], nama='$_POST[Nama]', jk='$_POST[jk]', posisi='$_POST[posisi]',password=$_POST[pass] where nip=$_SESSION[nip_walmur]";
      $up_walmur = $db->query($update_walmur);
      
      if($up_walmur){
         header("location:index.php?message=Update Berhasil");
         $_SESSION['kategori'] = 'walmur';
         $_SESSION['form'] = '0';
      }else{
         header("location:index.php?message=Update Gagal");
         $_SESSION['kategori'] = 'walmur';
      }
   }

   if(isset($_POST["tambah-user"])){
      
      $tambah = "INSERT INTO `user` Values(null,'$_POST[ID]','$_POST[nama]','$_POST[jk]','$_POST[posisi]','$_POST[pass]')";
      $result = $db->query($tambah);
      
      if($result){
         header("location:index.php?message=Tambah data berhasil");
         $_SESSIOn['kategori'] = 'walmur';
         $_SESSION['form'] = '0';
      }else{
         header("location:index.php?message=tambah data gagal");
         $_SESSIOn['kategori'] = 'walmur';
      }
   }

   if(isset($_POST["tambah-siswa"])){
      
      $tambah = "INSERT INTO `siswa` Values(null,'$_POST[ID]','$_POST[nama]','$_POST[jk]','$_POST[kelas]','$_POST[alamat]')";
      $result = $db->query($tambah);
      
      if($result){
         header("location:index.php?message=Tambah data berhasil");
         $_SESSION["kategori"] = "siswa";
         $_SESSION['form'] = '0';
      }else{
         header("location:index.php?message=tambah data gagal");
         $_SESSION["kategori"] = "siswa";
      }
   }
?>