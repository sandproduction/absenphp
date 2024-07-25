
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
                  
                  if (isset($_POST['edit_absen'])) {
                     $id_siswa = $_POST['edit_absen'];
                     $tgl = $_SESSION['tgl'];

                     // Prepare and execute the SELECT query
                     $stmt = $db->prepare("SELECT * FROM kehadiran WHERE id_siswa = ? AND tgl = ?");
                     $stmt->bind_param("is", $id_siswa, $tgl);
                     $stmt->execute();
                     $result = $stmt->get_result();

                     if ($result->num_rows > 0) {
                        echo "<tr><th>Data Awal</th><th>Data Diperbarui</th></tr>";

                        while ($row = $result->fetch_assoc()) {
                              $_SESSION['id_absen'] = $row["id"];
                              $_SESSION['kelas'] = $row['kelas'];

                              echo "<tr><td>{$row['id_siswa']}</td></tr>";
                              echo "<tr><td>{$row['nama']}</td></tr>";
                              echo "<tr><td>{$row['kelas']}</td></tr>";
                              echo "<tr>
                                    <td>{$row['tgl']}</td>
                                    <td><input type='date' class='tgl-edit' name='tgl'></td>
                                    </tr>";
                              echo "<tr>
                                    <td>{$row['kehadiran']}</td>
                                    <td>
                                       <select name='hadir' class='edit-option' required>
                                          <option value='' disabled selected>Absen</option>
                                          <option value='hadir'>Hadir</option>
                                          <option value='tidak hadir'>Tidak Hadir</option>
                                       </select>
                                    </td>
                                    </tr>";
                              echo "<tr>
                                    <td>{$row['nip']}</td>
                                    <td><input type='number' class='pengabsen-field' name='nip'></td>
                                    </tr>";
                              echo "</table>";
                              echo "<button name='update' type='submit' class='update-btn'>Update</button></form>";
                        }
                     }
                     
                     // Prepare and execute the SELECT query for siswa
                     $stmt = $db->prepare("SELECT * FROM siswa WHERE kelas = ?");
                     $stmt->bind_param("s", $_SESSION['kelas']);
                     $stmt->execute();
                     $result = $stmt->get_result();
                     
                     $nama_s = [];
                     $id_siswa = [];
                     
                     while ($row = $result->fetch_assoc()) {
                        $nama_s[] = $row['nama'];
                        $id_siswa[] = $row['id_siswa'];
                     }
                     
                     // Handle the absen POST request
                     if (isset($_POST['absen'])) {
                        // Prepare and execute the check query
                        $stmt = $db->prepare("SELECT tgl FROM kehadiran WHERE kelas = ? AND tgl = ?");
                        $stmt->bind_param("ss", $_SESSION['kelas'], $_SESSION['tgl']);
                        $stmt->execute();
                        $check = $stmt->get_result();
                        
                        if ($check->num_rows > 0) {
                              header("Location: index.php?message=ANDA SUDAH ABSEN");
                        } else {
                              $i = 0;
                              foreach ($_POST['hadir'] as $key => $value) {
                                 // Prepare and execute the INSERT query
                                 $stmt = $db->prepare("INSERT INTO kehadiran (nama, id_siswa, kelas, tgl, kehadiran, nip) VALUES (?, ?, ?, ?, ?, ?)");
                                 $stmt->bind_param("sisssi", $nama_s[$i], $id_siswa[$i], $_SESSION['kelas'], $_SESSION['tgl'], $value, $_POST['nip']);
                                 
                                 if ($stmt->execute()) {
                                    header("Location: index.php?message=Absen Berhasil");
                                    $i++;
                                 } else {
                                    header("Location: index.php?message=Absen Gagal");
                                 }
                              }
                        }
                     }
                  }else if (isset($_POST['edit_guru'])) {
                     $nip_guru = intval($_POST['edit_guru']);

                     // Prepare and execute the SELECT query
                     $stmt = $db->prepare("SELECT * FROM user WHERE nip = ?");
                     $stmt->bind_param("i", $nip_guru);
                     $stmt->execute();
                     $result = $stmt->get_result();

                     if ($result->num_rows > 0) {
                        echo "<tr><th colspan='2'>Data Awal</th></tr>";

                        while ($row = $result->fetch_assoc()) {
                              $_SESSION['nip_guru'] = intval($row['nip']);

                              echo '<tr>
                                    <td>NIP</td>
                                    </tr>';
                              echo '<tr>
                                    <td>Nama</td>
                                    <td><input type="text" class="txt-field" placeholder="Nama" name="Nama" value="' . htmlspecialchars($row['nama']) . '" required></td>
                                    </tr>';
                              echo '<tr>
                                    <td>Jenis Kelamin</td>
                                    <td>
                                       <select name="jk" class="edit-option" required>
                                          <option value="" disabled selected>Jenis Kelamin</option>';
                              if ($row['jk'] == 'L') {
                                 echo '<option value="P">P</option>
                                       <option value="L" selected>L</option>';
                              } else {
                                 echo '<option value="P" selected>P</option>
                                       <option value="L">L</option>';
                              }
                              echo '      </select>
                                    </td>
                                    </tr>';
                              echo '<tr>
                                    <td>Posisi</td>
                                    <td><input type="text" class="txt-field" placeholder="Posisi" name="posisi" value="' . htmlspecialchars($row['posisi']) . '" required></td>
                                    </tr>';
                              echo '<tr>
                                    <td>Password</td>
                                    <td><input type="text" class="txt-field" placeholder="Password" name="pass" value="' . htmlspecialchars($row['password']) . '" required></td>
                                    </tr>';
                              echo '</table>';
                              echo '<button name="update_guru" type="submit" class="update-btn" value="' . htmlspecialchars($row['nip']) . '">Update</button></form>';
                        }
                     } else {
                        echo 'No records found.';
                     }
                  }else if (isset($_POST['edit_siswa'])) {
                     $id_siswa = intval($_POST['edit_siswa']);

                     // Prepare and execute the SELECT query
                     $stmt = $db->prepare("SELECT * FROM siswa WHERE id_siswa = ?");
                     $stmt->bind_param("i", $id_siswa);
                     $stmt->execute();
                     $result = $stmt->get_result();
                     $_SESSION["id_siswa"] = $id_siswa;

                     if ($result->num_rows > 0) {
                        echo "<tr><th>Data Awal</th><th>Data Diperbarui</th></tr>";

                        while ($row = $result->fetch_assoc()) {
                              echo '<tr>
                                    <td>' . htmlspecialchars($row['id_siswa']) . '</td>
                                    </tr>';
                              echo '<tr>
                                    <td>' . htmlspecialchars($row['nama']) . '</td>
                                    <td><input type="text" class="txt-field" placeholder="Nama" name="Nama" value="'. htmlspecialchars($row['nama']) .'"  required></td>
                                    </tr>';
                              echo '<tr>
                                    <td>' . htmlspecialchars($row['jk']) . '</td>
                                    <td>
                                    <select name="jk" class="edit-option" required>
                                       <option value="" disabled selected>Jenis Kelamin</option>';
                                       if ($row['jk'] == 'L') {
                                       echo '<option value="P">P</option>
                                             <option value="L" selected>L</option>';
                                       } else {
                                       echo '<option value="P" selected>P</option>
                                             <option value="L">L</option>';
                                       }
                                       echo '
                                    </select>
                                    </td>
                                    </tr>';
                              echo '<tr>
                                    <td>' . htmlspecialchars($row['kelas']) . '</td>
                                    <td><input type="text" class="txt-field" placeholder="Kelas" name="kelas" value="' . htmlspecialchars($row['kelas']) . '" required></td>
                                    </tr>';
                              echo '<tr>
                                    <td>' . htmlspecialchars($row['alamat']) . '</td>
                                    <td><input type="text" class="txt-field" placeholder="Alamat" name="alamat" value="' . htmlspecialchars($row['alamat']) . '" required></td>
                                    </tr>';
                              echo '</table>';
                              echo '<button name="update_siswa" type="submit" class="update-btn" value="' . htmlspecialchars($row['id_siswa']) . '">Update</button></form>';
                        }
                     } else {
                        echo 'No records found.';
                     }
                  }else if (isset($_POST['edit_wali'])) {
                     $nip_wali = intval($_POST['edit_wali']);

                     // Prepare and execute the SELECT query
                     $stmt = $db->prepare("SELECT * FROM user WHERE nip = ?");
                     $stmt->bind_param("i", $nip_wali);
                     $stmt->execute();
                     $result = $stmt->get_result();

                     if ($result->num_rows > 0) {
                        echo "<tr><th>Data Awal</th><th>Data Diperbarui</th></tr>";

                        while ($row = $result->fetch_assoc()) {
                              $_SESSION["nip_walmur"] = $row["nip"];

                              echo '<tr>
                                    <td>' . htmlspecialchars($row['nip']) . '</td>
                                    
                                    </tr>';
                              echo '<tr>
                                    <td>' . htmlspecialchars($row['nama']) . '</td>
                                    <td><input type="text" class="txt-field" placeholder="Nama" name="Nama" value="' . htmlspecialchars($row['nama']) . '" required></td>
                                    </tr>';
                              echo '<tr>
                                    <td>' . htmlspecialchars($row['jk']) . '</td>
                                    <td>
                                       <select name="jk" class="edit-option" required>
                                          <option value="" disabled selected>Jenis Kelamin</option>';
                              if ($row['jk'] == 'L') {
                                 echo '<option value="P">P</option>
                                       <option value="L" selected>L</option>';
                              } else {
                                 echo '<option value="P" selected>P</option>
                                       <option value="L">L</option>';
                              }
                              echo '      </select>
                                    </td>
                                    </tr>';
                              echo '<tr>
                                    <td>' . htmlspecialchars($row['posisi']) . '</td>
                                    <td><input type="text" class="txt-field" placeholder="Posisi" name="posisi" value="' . htmlspecialchars($row['posisi']) . '" required></td>
                                    </tr>';
                              echo '<tr>
                                    <td>' . htmlspecialchars($row['password']) . '</td>
                                    <td><input type="text" class="txt-field" placeholder="Password" name="pass" value="' . htmlspecialchars($row['password']) . '" required></td>
                                    </tr>';
                              echo '</table>';
                              echo '<button name="update_walmur" type="submit" class="update-btn" value="' . htmlspecialchars($row['nip']) . '">Update</button></form>';
                        }
                     } else {
                        echo 'No records found.';
                     }                   
                  }else if (isset($_POST['btn_tambah'])) {
                     if ($_SESSION['kategori'] != 'siswa') {
                        echo "<tr><th colspan='2'>Tambah Data</th></tr>";
                        echo "<tr>
                                 <td>ID</td>
                                 <td><input type='number' class='txt-field' placeholder='NIP/ID' name='ID' required></td>
                              </tr>";
                        echo "<tr>
                                 <td>Nama</td>
                                 <td><input type='text' class='txt-field' placeholder='Nama' name='nama' required></td>
                              </tr>";
                        echo "<tr>
                                 <td>Jenis Kelamin</td>
                                 <td><select name='jk' class='edit-option' required>
                                    <option value='' disabled selected>jenis kelamin</option>
                                    <option value='L'>L</option>
                                    <option value='P'>P</option>
                                 </select></td>
                              </tr>";
                        echo "<tr>
                                 <td>Posisi</td>
                                 <td><select name='posisi' class='edit-option' required>";
                        if ($_SESSION['kategori'] === 'guru') {
                              echo "<option value='guru' selected>Guru</option>";
                        } else if ($_SESSION['kategori'] === 'walmur') {
                              echo "<option value='wali murid' selected>Wali Murid</option>";
                        }
                        echo "</select></td>
                              </tr>";
                        echo "<tr>
                                 <td>Password</td>
                                 <td><input type='text' class='txt-field' placeholder='Password' name='pass' required></td>
                              </tr>";
                        echo "</table>";
                        echo "<button name='tambah-user' type='submit' class='update-btn'>Tambah</button></form>";
                     } else if ($_SESSION['kategori'] === 'siswa') {
                        echo "<h1>Siswa</h1>";
                        echo "<tr><th colspan='2'>Tambah Data</th></tr>";
                        echo "<tr>
                                 <td>ID</td>
                                 <td><input type='number' class='txt-field' placeholder='NIP/ID' name='ID' required></td>
                              </tr>";
                        echo "<tr>
                                 <td>Nama</td>
                                 <td><input type='text' class='txt-field' placeholder='Nama' name='nama' required></td>
                              </tr>";
                        echo "<tr>
                                 <td>Jenis Kelamin</td>
                                 <td><select name='jk' class='edit-option' required>
                                    <option value='' disabled selected>jenis kelamin</option>
                                    <option value='L'>L</option>
                                    <option value='P'>P</option>
                                 </select></td>
                              </tr>";
                        echo "<tr>
                                 <td>Kelas</td>
                                 <td><input type='number' class='txt-field' placeholder='Kelas' name='kelas' required></td>
                              </tr>";
                        echo "<tr>
                                 <td>Alamat</td>
                                 <td><input type='text' class='txt-field' placeholder='Alamat' name='alamat' required></td>
                              </tr>";
                        echo "</table>";
                        echo "<button name='tambah-siswa' type='submit' class='update-btn'>Tambah</button></form>";
                     }
                  } else if (isset($_POST['hapus_user'])) {
                     $nip = intval($_POST['hapus_user']);
                     $stmt = $db->prepare("DELETE FROM user WHERE nip = ?");
                     $stmt->bind_param("i", $nip);
                     if ($stmt->execute()) {
                        header("Location: index.php?message=Hapus Data Berhasil");
                        $_SESSION['kategori'] = 'guru';
                        $_SESSION['form'] = '0';
                     } else {
                        header("Location: index.php?message=Hapus Data Gagal");
                        $_SESSION['kategori'] = 'guru';
                     }
                  } else if (isset($_POST['hapus_siswa'])) {
                     $id_siswa = intval($_POST['hapus_siswa']);
                     $stmt = $db->prepare("DELETE FROM siswa WHERE id_siswa = ?");
                     $stmt->bind_param("i", $id_siswa);
                     if ($stmt->execute()) {
                        header("Location: index.php?message=Hapus Data Berhasil");
                        $_SESSION['kategori'] = 'siswa';
                        $_SESSION['form'] = '0';
                     } else {
                        header("Location: index.php?message=Hapus Data Gagal");
                        $_SESSION['kategori'] = 'siswa';
                     }
                  } else if (isset($_POST['absen'])) {
                     $kelas = $_SESSION['kelas'];
                     $tgl = $_SESSION['tgl'];

                     $stmt = $db->prepare("SELECT * FROM siswa WHERE kelas = ?");
                     $stmt->bind_param("s", $kelas);
                     $stmt->execute();
                     $result = $stmt->get_result();
                     
                     while ($row = $result->fetch_assoc()) {
                        $nama_s[] = $row['nama'];
                        $id_siswa[] = $row['id_siswa'];
                     }

                     $stmt = $db->prepare("SELECT tgl FROM kehadiran WHERE kelas = ? AND tgl = ?");
                     $stmt->bind_param("ss", $kelas, $tgl);
                     $stmt->execute();
                     $check = $stmt->get_result();

                     if ($check->num_rows > 0) {
                        header("Location: index.php?message=ANDA SUDAH ABSEN");
                        $_SESSION['form'] = "0";
                     } else {
                        $i = 0;
                        foreach ($_POST['hadir'] as $key => $value) {
                              $stmt = $db->prepare("INSERT INTO kehadiran (nama, id_siswa, kelas, tgl, kehadiran, nip) VALUES (?, ?, ?, ?, ?, ?)");
                              $stmt->bind_param("sisssi", $nama_s[$i], $id_siswa[$i], $kelas, $tgl, $value, $_SESSION['nip']);
                              if ($stmt->execute()) {
                                 $i++;
                              } else {
                                 header("Location: index.php?message=Absen Gagal");
                                 $_SESSION['form'] = "0";
                                 exit();
                              }
                        }
                        header("Location: index.php?message=Absen Berhasil");
                        $_SESSION['form'] = "0";
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