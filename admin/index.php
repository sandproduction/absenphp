<?php
session_start();

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    header('location:../index.php?message=Login Dulu Bro');
    exit;
}

if ($_SESSION['posisi'] != 'admin') {
    header('location:../index.php?message=Anda Bukan Admin');
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location:../index.php?message=Anda Telah Keluar");
    exit;
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
    <div class="container">
        <section>
            <div class="profil">
                <div class="profil-wrapper">
                    <?php
                    $gender = $_SESSION['jk'];
                    $profilePic = "../assets/" . ($gender == "L" ? "co" : "cw") . $_SESSION['profil'] . ".png";
                    echo "<img src='$profilePic'>";
                    ?>
                    <a href="../profil.php"><p>Lihat Profil</p></a>
                </div>
            </div>
            <header>
                <h3 class="nama-user">Hallo <?php echo htmlspecialchars($_SESSION['nama']); ?></h3>
                <p class="role">Anda Sebagai <?php echo htmlspecialchars($_SESSION['posisi']); ?></p>
            </header>
            <br><br><br>

            <div class="kategori">
                <form action="index.php" method="POST" class="form-cat">
                    <button type="submit" name="guru" class="btn-kategori">Guru</button>
                    <button type="submit" name="siswa" class="btn-kategori">Siswa</button>
                    <button type="submit" name="absen" class="btn-kategori">Absen</button>
                    <button type="submit" name="walmur" class="btn-kategori">Wali murid</button>
                </form>
            </div>

            <div class="search-box">
                <?php include("search.php"); ?>
            </div>

            <div class="tabel-wrapper">
                <p class="tgl-absen">Tanggal<br><?php echo htmlspecialchars($_SESSION['tgl']); ?></p>
                <?php
                if (isset($_GET['message'])) {
                    echo "<p class='msg'>" . htmlspecialchars($_GET['message']) . "</p>";
                }
                ?>
                <!-- TABEL ABSEN -->
                <?php include("absen.php"); ?>
            </div>
            <br>
        </section>
        <form action="" method="POST" class="logout-form">
            <button name="logout" type="submit" class="logout-btn">Log Out</button> 
        </form>
    </div>
</body>
</html>
