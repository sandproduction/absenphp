<?php
if (!isset($_SESSION['indi']) || $_SESSION['indi'] == "a") {
    $_SESSION['kategori'] = "guru";
    $_SESSION['indi'] = "a";
}

function searchBox() {
    if (in_array($_SESSION['kategori'], ["guru", "siswa", "walmur"])) {
        echo "<input type='number' name='id' class='kelas-option' placeholder='ID'>";
        echo "<input type='text' name='nama' class='kelas-option' placeholder='Nama'>";
    } else {
        echo "<select name='kelas' class='kelas-option' required>";
        echo "<option value='' selected>Pilih Kelas</option>";
        echo "<option value='1'>1</option>";
        echo "<option value='2'>2</option>";
        echo "<option value='3'>3</option>";
        echo "<option value='4'>4</option>";
        echo "</select>";
        echo "<input type='date' name='tgl' class='date-chooser'>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['guru'])) {
        $_SESSION['indi'] = "b";
        $_SESSION['kategori'] = "guru";
    } elseif (isset($_POST['siswa'])) {
        $_SESSION['indi'] = "b";
        $_SESSION['kategori'] = "siswa";
    } elseif (isset($_POST['absen'])) {
        $_SESSION['indi'] = "b";
        $_SESSION['kategori'] = "absen";
        $_SESSION['kelas'] = "";
    } elseif (isset($_POST['walmur'])) {
        $_SESSION['indi'] = "b";
        $_SESSION['kategori'] = "walmur";
    } elseif (isset($_POST['search'])) {
        $_SESSION['kelas'] = $_POST['kelas'] ?? '';
        $_SESSION['indi'] = "b";
    }
}
?>

<form action="" method="POST" class="search-form">
    <div class="input-field">
        <?php searchBox(); ?>
    </div>
    <button name="search" type="submit" class="btn-search">Cari</button>
</form>
