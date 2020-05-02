<?php

  //fungsi
  require 'functions.php';
  $mahasiswa = query("SELECT * FROM mahasiswa");
  //koneksi pada database mysql
  //$conn = mysqli_connect("localhost","root","","phpdasar");

  //langkah selanjutnya kita mengambil data mahasiswa dengan query
  //$result = mysqli_query($conn,"SELECT * FROM mahasiswa"); //memiliki 2 parameter yaitu koneksi dan querynya

  // var_dump($result); untuk mengecek hasil dari querynya

  //untuk mengecek apakah ada error atau tidak
  // if(!$result){
  //   echo mysqli_error($conn);
  // }

  //ambil data atau (fetch) mahasiswa dari object result
  //ada 4 cara yaitu
  /*
    1. mysqli_fetch_row() //mengembalikan nilai numeric
    2. mysqli_fetch_assoc()//mengembalikan nilai associative
    3. mysqli_fetch_array()//mengembalikan nilai numeric dan assoc
    4. mysqli_fetch_object()//mengemabalikan nilai object dengan ->
  */
  /*
    Cara menampilkan hasil dari 4 metode fetch tersebut adalah
    while ($mhs = mysqli_fetch_assoc($result)) {
      var_dump($mhs);
    }
  */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CRUD-Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Menyisipkan Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
  <body>
    <div class="container">
      <div class="table-responsive-md">
        <table class="table">
            <thead class="thead-dark">
              <tr>
                  <td><a href="tambah.php"><button type="button" class="btn">Tambah</button></a></td>

              </tr>
              <tr>

                <th scope="col">No.</th>
                <th scope="col">Nama</th>
                <th scope="col">Gambar</th>
                <th scope="col">Nim</th>
                <th scope="col">Jurusan</th>
                <th scope="col">Email</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
             <?php // while( $row = mysqli_fetch_assoc($result) ) : ?>
              <?php foreach ($mahasiswa as $row ): ?>
                <tr>
                  <th scope="row"><?= $i; ?></th>
                  <td><p><?= $row ["nama"]; ?></p></td>
                  <td><p><img src="gambar/<?=$row ["gambar"]; ?>" width="60" height="30"  class="img-thumbnail"></p></td>
                  <td><p><?= $row ["nim"]; ?></p></td>
                  <td><p><?= $row ["jurusan"]; ?></p></td>
                  <td><p><?= $row ["email"]; ?></p></td>
                  <td>
                      <a href="hapus.php?id=<?= $row["id"]; ?> " onclick="return confirm('yakin ');"><button type="button" class="btn btn-outline-danger btn-sm">Hapus</button></a>
                      <a href="ubah.php?id=<?= $row["id"]; ?> "><button type="button" class="btn btn-outline-primary btn-sm">Ubah </button></a>
                  </td>
                </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
            <?php //endwhile; ?>
            </tbody>
        </table>
      </div>
    </div>

      <!-- Menyisipkan JQuery dan Javascript Bootstrap -->
      <script src="js/bootstrap.min.js"></script>
      <script src="js/jquery.min.js"></script>
  </body>
</html>
