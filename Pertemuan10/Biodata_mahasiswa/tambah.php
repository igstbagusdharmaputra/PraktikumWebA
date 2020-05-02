<?php
  //TANPA MENGGUNAKAN FUNCTION
  //koneksi ke database
  //$conn = mysqli_connect("localhost","root","","phpdasar");
  //cek apakah tombol submit sudah tekan atau belum
  //if (isset ($_POST["submit"]) )
  //{
    //cek apakah ada data dalam $_POST
    // var_dump($_POST);
    //ambil data dari form
    /*$nama = $_POST["nama"];
    $nim = $_POST["nim"];
    $email = $_POST["email"];
    $jurusan = $_POST["jurusan"];
    $gambar = $_POST["gambar"];

    //query insert data $mahasiswa
    $query = " INSERT INTO mahasiswa VALUES ('','$nama','$nim','$email','$jurusan','$gambar') ";
    mysqli_query($conn,$query);

    //mengecek apakah data berhasil ditambahkan atau tidak
    //var_dump (mysqli_affected_rows($conn));
    if(mysqli_affected_rows($conn) > 0 )
    {
      echo "berhasil";
    }
      else {
        echo "error";
        echo mysqli_error($conn);
      }

    } */
  require 'functions.php';
  if(isset($_POST["submit"]))
  {
    if(tambah($_POST) > 0 )
    {
      echo "
          <script>
              alert('data berhasil ditambahkan');
              document.location.href = 'index.php';

          </script>
      ";
    }
    else {
      echo "
          <script>
              alert('data gagal ditambahkan');
              document.location.href = 'index.php';

          </script>
      ";
    }
  }

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CRUD-Tambah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Menyisipkan Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
  </head>
  <body>
    <div class="container">
      <form action="" method="post">
        <div class="form-group">
          <label for="Nama">Nama :</label>
          <input type="name"  name="nama" class="form-control" id="Nama">
        </div>
        <div class="form-group">
          <label for="Nim">Nim :</label>
          <input type="text" name="nim" class="form-control" id="Nim" required>
        </div>
        <div class="form-group">
          <label for="email">Email :</label>
          <input type="email" name="email" class="form-control" id="email">
        </div>
        <div class="form-group">
          <label for="Jurusan">Jurusan :</label>
          <input type="text" name="jurusan" class="form-control" id="Jurusan">
        </div>
        <div class="form-group">
          <label for="Gambar">Gambar :</label>
          <input type="text" name="gambar" class="form-control" id="Gambar">
        </div>
      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
  </body>
</html>
