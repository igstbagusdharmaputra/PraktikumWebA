<?php
session_start();
require_once '../path.php';
require_once(ABSPATH . '../config/config.php');
require_once(ABSPATH . '../config/database.php');
require_once(ABSPATH . '../config/route.php');
require_once(ABSPATH . '../config/header-json.php');
require_once(ABSPATH . '../config/functions.php');
$data = array();
// function cek($v){
//   global $link;
//   return mysqli_real_escape_string($link, $v);
// }
if (isset($_SESSION['is_logged'])) {
    if (isset($_GET['f']) && isset($_GET['d'])) {
        $rt = $_GET['f'];
        $dst = $_GET['d'];
        //Manajemen data user
        if ($rt == $route['data-user']['remote'] && $dst == $route['data-user']['crud'][0]) { //untuk show data di tabel
          $columns = array(
            'created_at',
            'name',
            'username',
            'name_rule',
            'status'
          );
          $sql = "SELECT id_user,name,username,name_rule,status,created_at FROM tb_users AS u INNER JOIN tb_rules AS r ON u.id_rule = r.id_rule";
          $query = mysqli_query($link, $sql) or die("error1");
          $totalData = mysqli_num_rows($query);
          $totalFiltered = $totalData;
          if (!empty(cek($_POST['search']['value']))) {
            $sql .= " WHERE name LIKE '%" . cek($_POST['search']['value']) . "%' ";
            $sql .= " OR username LIKE '%" . cek($_POST['search']['value']) . "%' ";
            $query = mysqli_query($link, $sql) or die("error2");
            $totalFiltered = mysqli_num_rows($query);
            if (($_POST['length'])!= -1) {
              $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir']  . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
              $query = mysqli_query($link, $sql) or die("error3");
            } else {
              $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " .$_POST['start'] . ", $totalData";
              $query = mysqli_query($link, $sql) or die("error4");
            }
          } else {
            if ($_POST['length'] != -1) {
              $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
              $query = mysqli_query($link, $sql) or die("error5");
            } else {
              $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . ", $totalData";
              $query = mysqli_query($link, $sql) or die("error6");
            }
          }
          $i = 1;
          $dataTable = array();
          while ($row = mysqli_fetch_array($query)) {
            $edit = $route['data-user']['crud'][3];
            $detail = $route['data-user']['crud'][5];
            $delete = $route['data-user']['crud'][6];
            $nestedData = array();
            $nestedData[] = "";
            $nestedData[] = $row["name"];
            $nestedData[] = $row["username"];
            $nestedData[] = ucwords(str_replace("_", "\r", $row['name_rule']));
            $nestedData[] = $row["status"] == 1 ? '<label class="label label-success">Aktif</label>' : '<label class="label label-danger">Tidak Aktif</label>';
            if (hasPermit('update_user') && hasPermit('delete_user')) {
              $nestedData[] =
                '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['id_user'] . '" data-target="' . $edit . '">
                  <i class="fa fa-edit"></i>
                  <span>Edit</span>
                </a>&nbsp;
                <a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['id_user'] . '" data-target="' . $detail . '">
                  <i class="fa fa-list"></i>
                  <span>Detail</span>
                </a>&nbsp;
                <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['name'] . '" data-content="' . $row['id_user'] . '" data-target="' . $delete . '">
                  <i class="fa fa-trash"></i>
                  <span>Hapus</span>
                </a>';
            } else {
              $nestedData[] =
                '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['id_user'] . '" data-target="' . $detail . '">
                  <i class="fa fa-list"></i>
                  <span>Detail</span>
                </a>';
            }
            $dataTable[] = $nestedData;
          }
          $test = $_POST;
          $data = array(
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $dataTable,
            "test"            => $test
          );
        }else if ($rt == $route['data-user']['remote'] && $dst == $route['data-user']['check'][0] && isset($_GET['username'])){ //check username
          $username = cek($_GET['username']);
          $sql = mysqli_query($link, "SELECT username FROM tb_users WHERE username='$username'");
          if (mysqli_num_rows($sql) > 0) {
            $data= false;
          } else {
            $data= true;
          }
        }else if ($rt == $route['data-user']['remote'] && $dst == $route['data-user']['crud'][2]){ //tambah user
          $name = cek($_POST['name']);
          $level = cek($_POST['level']);
          $stts = cek($_POST['status']);
          $user = cek($_POST['username']);
          $pass = cek($_POST['password']);
          $conf = cek($_POST['password_confirm']);
          $date = date('Y-m-d H:i:s', strtotime('now'));
          if ($pass == $conf) {
            $passnew = md5($pass);
            $sql = mysqli_query($link, "INSERT INTO tb_users VALUES ('','$level','$name','$user','$passnew','$stts','$date','$date')");
            if ($sql) {
              $data['user'] = array(
                'code' => 1,
                'message' => 'Pengguna telah ditambahkan !'
              );
            } else {
              $data['user'] = array(
                'code' => 0,
                'message' => mysqli_error($link)
              );
            }
          } else {
            $data['user'] = array(
              'code' => 0,
              'message' => 'Konfirmasi password tidak sama dengan field password'
            );
          }
        }else if($rt == $route['data-user']['remote'] && $dst == $route['data-user']['crud'][3] && isset($_GET['id'])){ //edit user
          $id = cek($_GET['id']);
          $sql = mysqli_query($link, "SELECT id_user,name,id_rule,status,username FROM tb_users WHERE id_user='$id' LIMIT 1");
          if (mysqli_num_rows($sql) > 0) {
            $r = mysqli_fetch_array($sql, MYSQLI_NUM);
            $data['user'] = array(
              'code' => 1,
              'data' => $r,
            );
          } else {
            $data['user'] = array(
              'code' => 0,
              'message' => 'Data tidak ditemukan !',
            );
          }
        }elseif ($rt == $route['data-user']['remote'] && $dst == $route['data-user']['check'][1] && isset($_GET['id']) && isset($_GET['username'])) {//check user
          $id = cek($_GET['id']);
          $username = cek($_GET['username']);
          $sql = mysqli_query($link, "SELECT id_user,username FROM tb_users WHERE id_user='$id' AND username='$username'");
          if (mysqli_num_rows($sql) >0) {
            $data = true;
          } else {
            $sql = mysqli_query($link, "SELECT username FROM tb_users WHERE username='$username'");
            if (mysqli_num_rows($sql) > 0) {
              $data = false;
            } else {
              $data = true;
            }
          }
        } elseif ($rt == $route['data-user']['remote'] && $dst == $route['data-user']['crud'][4] && isset($_GET['id'])) { //edit
          $id = cek($_GET['id']);
          $name = ucwords(cek($_POST['nama']));
          $level = cek($_POST['level']);
          $stts = cek($_POST['status']);
          $user = cek($_POST['username']);
          $date = date('Y-m-d H:i:s', strtotime('now'));
          $sql = mysqli_query($link, "UPDATE tb_users SET name='$name', id_rule='$level', status='$stts', username='$user', updated_at='$date' WHERE id_user='$id'");
          if ($sql) {
            if ($_SESSION['id'] == $id) {
              $ch = mysqli_fetch_assoc(mysqli_query($link, "SELECT id_user,name FROM tb_users WHERE id_user='$id' LIMIT 1"));
              $_SESSION['name'] = $ch['name'];
            }
            $data['user'] = array(
              'code' => 1,
              'message' => 'Data berhasil diubah !'
            );
          } else {
            $data['user'] = array(
              'code' => 0,
              'message' => mysqli_error($link)
            );
          }
        } elseif ($rt == $route['data-user']['remote'] && $dst == $route['data-user']['crud'][5] && isset($_GET['id'])) { //show user
          $id = cek($_GET['id']);
          $query = "SELECT id_user,name,username,name_rule,status,created_at FROM tb_users AS u
                    INNER JOIN tb_rules AS r ON u.id_rule = r.id_rule
                    WHERE id_user='$id'";
          $sql = mysqli_query($link, $query);
          if (mysqli_num_rows($sql) > 0) {
            $r = mysqli_fetch_assoc($sql);
            $data['user'] = array(
              'code' => 1,
              'data' => $r,
            );
          } else {
            $data['user'] = array(
              'code' => 0,
              'message' => 'Data tidak ditemukan !',
            );
          }
        } elseif ($rt == $route['data-user']['remote'] && $dst == $route['data-user']['crud'][6] && isset($_GET['id'])) { //delete user
          $id = cek($_GET['id']);
          $sql = mysqli_query($link, "DELETE FROM tb_users WHERE id_user='$id'");
          if ($sql) {
            $data['user'] = array(
              'code' => 1,
              'message' => 'Data berhasil dihapus'
            );
          } else {
            $data['user'] = array(
              'code' => 0,
              'message' => mysqli_error($link)
            );
          }
        }
        //Manajemen Data kategori
        else if ($rt == $route['data-kategori']['remote'] && $dst == $route['data-kategori']['crud'][0]) { //untuk show data di tabel
          $columns = array(
            'created_at',
            'nama_kategori'
          );
          $sql = "SELECT id_kategori,nama_kategori FROM tb_kategori";
          $query = mysqli_query($link, $sql) or die("error1");
          $totalData = mysqli_num_rows($query);
          $totalFiltered = $totalData;
          if (!empty(cek($_POST['search']['value']))) {
            $sql .= " WHERE nama_kategori LIKE '%" . cek($_POST['search']['value']) . "%' ";
            $query = mysqli_query($link, $sql) or die("error2");
            $totalFiltered = mysqli_num_rows($query);
            if (($_POST['length'])!= -1) {
              $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir']  . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
              $query = mysqli_query($link, $sql) or die("error3");
            } else {
              $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " .$_POST['start'] . ", $totalData";
              $query = mysqli_query($link, $sql) or die("error4");
            }
          } else {
            if ($_POST['length'] != -1) {
              $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
              $query = mysqli_query($link, $sql) or die("error5");
            } else {
              $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . ", $totalData";
              $query = mysqli_query($link, $sql) or die("error6");
            }
          }
          $i = 1;
          $dataTable = array();
          while ($row = mysqli_fetch_array($query)) {
            $edit = $route['data-kategori']['crud'][3];
            $delete = $route['data-kategori']['crud'][6];
            $nestedData = array();
            $nestedData[] = "";
            $nestedData[] = $row["nama_kategori"];
            if (hasPermit('update_kategori') && hasPermit('delete_kategori')) {
              $nestedData[] =
                '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['id_kategori'] . '" data-target="' . $edit . '">
                  <i class="fa fa-edit"></i>
                  <span>Edit</span>
                </a>&nbsp;
                <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['nama_kategori'] . '" data-content="' . $row['id_kategori'] . '" data-target="' . $delete . '">
                  <i class="fa fa-trash"></i>
                  <span>Hapus</span>
                </a>';
            } else {
              $nestedData[] =
                '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['id_kategori'] . '" data-target="' . $detail . '">
                  <i class="fa fa-list"></i>
                  <span>Detail</span>
                </a>';
            }
            $dataTable[] = $nestedData;
          }
          $test = $_POST;
          $data = array(
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $dataTable,
          );
        }else if ($rt == $route['data-kategori']['remote'] && $dst == $route['data-kategori']['check'][0] && isset($_GET['nama_kategori'])){ //check kategori
          $nama_kategori = cek($_GET['nama_kategori']);
          $sql = mysqli_query($link, "SELECT nama_kategori FROM tb_kategori WHERE nama_kategori='$nama_kategori'");
          if (mysqli_num_rows($sql) >0) {
            $data = false;
          } else {
            $data = true;
          }
        }else if ($rt == $route['data-kategori']['remote'] && $dst == $route['data-kategori']['crud'][2]){ //tambah kategori
          $name = cek($_POST['nama_kategori']);
          $date = date('Y-m-d H:i:s', strtotime('now'));
          $sql = mysqli_query($link,"INSERT INTO tb_kategori VALUES(NULL,'$name','$date','$date')");
          if ($sql) {
            $data['kategori'] = array(
              'code' => 1,
              'message' => 'Data berhasil ditambahkan !'
            );
          } else {
            $data['kategori'] = array(
              'code' => 0,
              'message' => mysqli_error($link)
            );
          }
        }else if($rt == $route['data-kategori']['remote'] && $dst == $route['data-kategori']['crud'][3] && isset($_GET['id'])){ //edit kategori
          $id = cek($_GET['id']);
          $sql = mysqli_query($link, "SELECT id_kategori,nama_kategori FROM tb_kategori WHERE id_kategori='$id' LIMIT 1");
          if (mysqli_num_rows($sql) >0) {
            $r = mysqli_fetch_array($sql);
            $data['kategori'] = array(
              'code' => 1,
              'data' => $r,
            );
          } else {
            $data['kategori'] = array(
              'code' => 0,
              'message' => 'Data tidak ditemukan !',
            );
          }
        }elseif ($rt == $route['data-kategori']['remote'] && $dst == $route['data-kategori']['check'][1] && isset($_GET['id']) && isset($_GET['nama_kategori'])) {//check user
          $id = cek($_GET['id']);
          $nama_kategori = cek($_GET['nama_kategori']);
          $sql = mysqli_query($link, "SELECT id_kategori,nama_kategori FROM tb_kategori WHERE id_kategori='$id' AND nama_kategori='$nama_kategori'");
          if (mysqli_num_rows($sql) >0) {
            $data = true;
          } else {
            $sql = mysqli_query($link, "SELECT nama_kategori FROM tb_kategori WHERE nama_kategori='$nama_kategori'");
            if (mysqli_num_rows($sql)> 0) {
              $data = false;
            } else {
              $data = true;
            }
          }
        } elseif ($rt == $route['data-kategori']['remote'] && $dst == $route['data-kategori']['crud'][4] && isset($_GET['id'])) { //edit
          $id = cek($_GET['id']);
          $nama_kategori = cek($_POST['nama_kategori']);
          $date = date('Y-m-d H:i:s', strtotime('now'));
          $sql = mysqli_query($link, "UPDATE tb_kategori SET nama_kategori='$nama_kategori',updated_at='$date' WHERE id_kategori='$id'");
          if ($sql) {
            $data['kategori'] = array(
              'code' => 1,
              'message' => 'Data berhasil diubah !'
            );
          } else {
            $data['kategori'] = array(
              'code' => 0,
              'message' => mysqli_error($link)
            );
          }
        } elseif ($rt == $route['data-kategori']['remote'] && $dst == $route['data-kategori']['crud'][6] && isset($_GET['id'])) { //delete user
          $id = cek($_GET['id']);
          $sql = mysqli_query($link, "DELETE FROM tb_kategori WHERE id_kategori='$id'");
          if ($sql) {
            $data['kategori'] = array(
              'code' => 1,
              'message' => 'Data berhasil dihapus'
            );
          } else {
            $data['kategori'] = array(
              'code' => 0,
              'message' => mysqli_error($link)
            );
          }
        }
        //manajemen data penerbit
    else if ($rt == $route['data-penerbit']['remote'] && $dst == $route['data-penerbit']['crud'][0]) { //untuk show data di tabel
      $columns = array(
        'created_at',
        'nama_penerbit'
      );
      $sql = "SELECT id_penerbit,nama_penerbit FROM tb_penerbit";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty(cek($_POST['search']['value']))) {
        $sql .= " WHERE nama_penerbit LIKE '%" . cek($_POST['search']['value']) . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if (($_POST['length'])!= -1) {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir']  . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " .$_POST['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($_POST['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = $route['data-penerbit']['crud'][3];
        $delete = $route['data-penerbit']['crud'][6];
        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["nama_penerbit"];
        if (hasPermit('update_penerbit') && hasPermit('delete_penerbit')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['id_penerbit'] . '" data-target="' . $edit . '">
              <i class="fa fa-edit"></i>
              <span>Edit</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['nama_penerbit'] . '" data-content="' . $row['id_penerbit'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] =
            '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['id_penerbit'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }
      $test = $_POST;
      $data = array(
        "draw"            => intval($_POST['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable,
      );
    }else if ($rt == $route['data-penerbit']['remote'] && $dst == $route['data-penerbit']['check'][0] && isset($_GET['nama_penerbit'])){ //check kategori
      $nama_penerbit = cek($_GET['nama_penerbit']);
      $sql = mysqli_query($link, "SELECT nama_penerbit FROM tb_penerbit WHERE nama_penerbit='$nama_penerbit'");
      if (mysqli_num_rows($sql) >0) {
        $data = false;
      } else {
        $data = true;
      }
    }else if ($rt == $route['data-penerbit']['remote'] && $dst == $route['data-penerbit']['crud'][2] ){ //tambah penerbit
      $name = cek($_POST['nama_penerbit']);
      $date = date('Y-m-d H:i:s', strtotime('now'));
      $sql = mysqli_query($link,"INSERT INTO tb_penerbit VALUES('','$name','$date','$date')");
      if ($sql) {
        $data['penerbit'] = array(
          'code' => 1,
          'message' => 'Data berhasil ditambahkan !'
        );
      } else {
        $data['penerbit'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }else if($rt == $route['data-penerbit']['remote'] && $dst == $route['data-penerbit']['crud'][3] && isset($_GET['id'])){ //edit penerbit
      $id = cek($_GET['id']);
      $sql = mysqli_query($link, "SELECT id_penerbit,nama_penerbit FROM tb_penerbit WHERE id_penerbit='$id' LIMIT 1");
      if (mysqli_num_rows($sql)>0) {
        $r = mysqli_fetch_array($sql);
        $data['penerbit'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['penerbit'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    }elseif ($rt == $route['data-penerbit']['remote'] && $dst == $route['data-penerbit']['check'][1] && isset($_GET['id']) && isset($_GET['nama_penerbit'])) {//check user
      $id = cek($_GET['id']);
      $nama_penerbit = cek($_GET['nama_penerbit']);
      $sql = mysqli_query($link, "SELECT id_penerbit,nama_penerbit FROM tb_penerbit WHERE id_penerbit='$id' AND nama_penerbit='$nama_penerbit'");
      if (mysqli_num_rows($sql) >0) {
        $data = true;
      } else {
        $sql = mysqli_query($link, "SELECT nama_penerbit FROM tb_penerbit WHERE nama_penerbit='$nama_penerbit'");
        if (mysqli_num_rows($sql)>0) {
          $data = false;
        } else {
          $data = true;
        }
      }
    } elseif ($rt == $route['data-penerbit']['remote'] && $dst == $route['data-penerbit']['crud'][4] && isset($_GET['id'])) { //edit
      $id = cek($_GET['id']);
      $nama_penerbit = cek($_POST['nama_penerbit']);
      $date = date('Y-m-d H:i:s', strtotime('now'));
      $sql = mysqli_query($link, "UPDATE tb_penerbit SET nama_penerbit='$nama_penerbit',updated_at='$date' WHERE id_penerbit='$id'");
      if ($sql) {
        $data['penerbit'] = array(
          'code' => 1,
          'message' => 'Data berhasil diubah !'
        );
      } else {
        $data['penerbit'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($rt == $route['data-penerbit']['remote'] && $dst == $route['data-penerbit']['crud'][6] && isset($_GET['id'])) { //delete user
      $id = cek($_GET['id']);
      $sql = mysqli_query($link, "DELETE FROM tb_penerbit WHERE id_penerbit='$id'");
      if ($sql) {
        $data['penerbit'] = array(
          'code' => 1,
          'message' => 'Data berhasil dihapus'
        );
      } else {
        $data['penerbit'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }
    //manajemen data pengarang
    else if ($rt == $route['data-pengarang']['remote'] && $dst == $route['data-pengarang']['crud'][0]) { //untuk show data di tabel
      $columns = array(
        'created_at',
        'nama_pengarang'
      );
      $sql = "SELECT id_pengarang,nama_pengarang FROM tb_pengarang";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty(cek($_POST['search']['value']))) {
        $sql .= " WHERE nama_pengarang LIKE '%" . cek($_POST['search']['value']) . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if (($_POST['length'])!= -1) {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir']  . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " .$_POST['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($_POST['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = $route['data-pengarang']['crud'][3];
        $delete = $route['data-pengarang']['crud'][6];
        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["nama_pengarang"];
        if (hasPermit('update_pengarang') && hasPermit('delete_pengarang')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['id_pengarang'] . '" data-target="' . $edit . '">
              <i class="fa fa-edit"></i>
              <span>Edit</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['nama_pengarang'] . '" data-content="' . $row['id_pengarang'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] =
            '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['id_pengarang'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }
      $test = $_POST;
      $data = array(
        "draw"            => intval($_POST['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable,
      );
    }else if ($rt == $route['data-pengarang']['remote'] && $dst == $route['data-pengarang']['check'][0] && isset($_GET['nama_pengarang'])){ //check pengarang
      $nama_pengarang = cek($_GET['nama_pengarang']);
      $sql = mysqli_query($link, "SELECT nama_pengarang FROM tb_pengarang WHERE nama_pengarang='$nama_pengarang'");
      if (mysqli_num_rows($sql) > 0) {
        $data=false;
      } else {
        $data=true;
      }
    }else if ($rt == $route['data-pengarang']['remote'] && $dst == $route['data-pengarang']['crud'][2]){ //tambah pengarang
      $name = cek($_POST['nama_pengarang']);
      $date = date('Y-m-d H:i:s', strtotime('now'));
      $sql = mysqli_query($link,"INSERT INTO tb_pengarang VALUES('','$name','$date','$date')");
      if ($sql) {
        $data['pengarang'] = array(
          'code' => 1,
          'message' => 'Data berhasil ditambahkan !'
        );
      } else {
        $data['pengarang'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }else if($rt == $route['data-pengarang']['remote'] && $dst == $route['data-pengarang']['crud'][3] && isset($_GET['id'])){ //edit pengarang
      $id = cek($_GET['id']);
      $sql = mysqli_query($link, "SELECT id_pengarang,nama_pengarang FROM tb_pengarang WHERE id_pengarang='$id' LIMIT 1");
      if (mysqli_num_rows($sql) > 0) {
        $r = mysqli_fetch_array($sql);
        $data['pengarang'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['pengarang'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    }elseif ($rt == $route['data-pengarang']['remote'] && $dst == $route['data-pengarang']['check'][1] && isset($_GET['id']) && isset($_GET['nama_pengarang'])) {//check user
      $id = cek($_GET['id']);
      $nama_pengarang = cek($_GET['nama_pengarang']);
      $sql = mysqli_query($link, "SELECT id_pengarang,nama_pengarang FROM tb_pengarang WHERE id_pengarang='$id' AND nama_pengarang='$nama_pengarang'");
      if (mysqli_num_rows($sql) > 0) {
        $data = true;
      } else {
        $sql = mysqli_query($link, "SELECT nama_pengarang FROM tb_pengarang WHERE nama_pengarang='$nama_pengarang'");
        if (mysqli_num_rows($sql) > 0) {
          $data = false;
        } else {
          $data = true;
        }
      }
    } elseif ($rt == $route['data-pengarang']['remote'] && $dst == $route['data-pengarang']['crud'][4] && isset($_GET['id'])) { //edit
      $id = cek($_GET['id']);
      $nama_pengarang = cek($_POST['nama_pengarang']);
      $date = date('Y-m-d H:i:s', strtotime('now'));
      $sql = mysqli_query($link, "UPDATE tb_pengarang SET nama_pengarang='$nama_pengarang',updated_at='$date' WHERE id_pengarang='$id'");
      if ($sql) {
        $data['pengarang'] = array(
          'code' => 1,
          'message' => 'Data berhasil diubah !'
        );
      } else {
        $data['pengarang'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($rt == $route['data-pengarang']['remote'] && $dst == $route['data-pengarang']['crud'][6] && isset($_GET['id'])) { //delete user
      $id = cek($_GET['id']);
      $sql = mysqli_query($link, "DELETE FROM tb_pengarang WHERE id_pengarang='$id'");
      if ($sql) {
        $data['pengarang'] = array(
          'code' => 1,
          'message' => 'Data berhasil dihapus'
        );
      } else {
        $data['pengarang'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }
    //manajemen data rak
    else if ($rt == $route['data-rak']['remote'] && $dst == $route['data-rak']['crud'][0]) { //untuk show data di tabel
      $columns = array(
        'created_at',
        'nama_rak'
      );
      $sql = "SELECT id_rak,nama_rak FROM tb_rak";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty(cek($_POST['search']['value']))) {
        $sql .= " WHERE nama_rak LIKE '%" . cek($_POST['search']['value']) . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if (($_POST['length'])!= -1) {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir']  . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " .$_POST['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($_POST['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = $route['data-rak']['crud'][3];
        $delete = $route['data-rak']['crud'][6];
        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["nama_rak"];
        if (hasPermit('update_rak') && hasPermit('delete_rak')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['id_rak'] . '" data-target="' . $edit . '">
              <i class="fa fa-edit"></i>
              <span>Edit</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['nama_rak'] . '" data-content="' . $row['id_rak'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] =
            '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['id_rak'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }
      $test = $_POST;
      $data = array(
        "draw"            => intval($_POST['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable,
      );
    }else if ($rt == $route['data-rak']['remote'] && $dst == $route['data-rak']['check'][0] && isset($_GET['nama_rak'])){ //check rak
      $nama_rak = cek($_GET['nama_rak']);
      $sql = mysqli_query($link, "SELECT nama_rak FROM tb_rak WHERE nama_rak='$nama_rak'");
      if (mysqli_num_rows($sql) > 0) {
        $data=false;
      } else {
        $data=true;
      }
    }else if ($rt == $route['data-rak']['remote'] && $dst == $route['data-rak']['crud'][2]){ //tambah rak
      $name = cek($_POST['nama_rak']);
      $date = date('Y-m-d H:i:s', strtotime('now'));
      $sql = mysqli_query($link,"INSERT INTO tb_rak VALUES('','$name','$date','$date')");
      if ($sql) {
        $data['rak'] = array(
          'code' => 1,
          'message' => 'Data berhasil ditambahkan !'
        );
      } else {
        $data['rak'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }else if($rt == $route['data-rak']['remote'] && $dst == $route['data-rak']['crud'][3] && isset($_GET['id'])){ //edit rak
      $id = cek($_GET['id']);
      $sql = mysqli_query($link, "SELECT id_rak,nama_rak FROM tb_rak WHERE id_rak='$id' LIMIT 1");
      if (mysqli_num_rows($sql) > 0) {
        $r = mysqli_fetch_array($sql);
        $data['rak'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['rak'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    }elseif ($rt == $route['data-rak']['remote'] && $dst == $route['data-rak']['check'][1] && isset($_GET['id']) && isset($_GET['nama_rak'])) {//check user
      $id = cek($_GET['id']);
      $nama_rak = cek($_GET['nama_rak']);
      $sql = mysqli_query($link, "SELECT id_rak,nama_rak FROM tb_rak WHERE id_rak='$id' AND nama_rak='$nama_rak'");
      if (mysqli_num_rows($sql) > 0) {
        $data = true;
      } else {
        $sql = mysqli_query($link, "SELECT nama_rak FROM tb_rak WHERE nama_rak='$nama_rak'");
        if (mysqli_num_rows($sql) > 0) {
          $data = false;
        } else {
          $data = true;
        }
      }
    } elseif ($rt == $route['data-rak']['remote'] && $dst == $route['data-rak']['crud'][4] && isset($_GET['id'])) { //edit
      $id = cek($_GET['id']);
      $nama_rak = cek($_POST['nama_rak']);
      $date = date('Y-m-d H:i:s', strtotime('now'));
      $sql = mysqli_query($link, "UPDATE tb_rak SET nama_rak='$nama_rak',updated_at='$date' WHERE id_rak='$id'");
      if ($sql) {
        $data['rak'] = array(
          'code' => 1,
          'message' => 'Data berhasil diubah !'
        );
      } else {
        $data['rak'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($rt == $route['data-rak']['remote'] && $dst == $route['data-rak']['crud'][6] && isset($_GET['id'])) { //delete user
      $id = cek($_GET['id']);
      $sql = mysqli_query($link, "DELETE FROM tb_rak WHERE id_rak='$id'");
      if ($sql) {
        $data['rak'] = array(
          'code' => 1,
          'message' => 'Data berhasil dihapus'
        );
      } else {
        $data['rak'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }
    //manajemen data buku
    else if ($rt == $route['data-buku']['remote'] && $dst == $route['data-buku']['crud'][0]) { //untuk show data di tabel
      $columns = array(
        'tb.created_at',
        'id_buku',
        'judul_buku',
        'nama_kategori',
        'stok_buku',
        
      );
      $sql = "SELECT id_buku,judul_buku,nama_kategori,stok_buku FROM tb_buku AS tb INNER JOIN tb_kategori AS tk ON tk.id_kategori = tb.id_kategori";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty(cek($_POST['search']['value']))) {
        $sql .= " WHERE judul_buku LIKE '%" . cek($_POST['search']['value']) . "%' ";
        $sql .= " OR nama_kategori LIKE '%" . cek($_POST['search']['value']) . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if (($_POST['length'])!= -1) {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir']  . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " .$_POST['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($_POST['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = $route['data-buku']['crud'][3];
        $detail = $route['data-buku']['crud'][5];
        $delete = $route['data-buku']['crud'][6];
        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["id_buku"];
        $nestedData[] = $row['judul_buku'];
        $nestedData[] = $row['nama_kategori'];
        $nestedData[] = $row['stok_buku'];
        if (hasPermit('update_buku') && hasPermit('delete_buku')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['id_buku'] . '" data-target="' . $edit . '">
              <i class="fa fa-edit"></i>
              <span>Edit</span>
            </a>&nbsp;
            <a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['id_buku'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['judul_buku'] . '" data-content="' . $row['id_buku'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] =
            '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['id_buku'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }
    
      $data = array(
        "draw"            => intval($_POST['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable,
        
      );
    }else if ($rt == $route['data-buku']['remote'] && $dst == $route['data-buku']['crud'][2]){ //tambah Buku
      $judul_buku = ucwords($_POST['judul_buku']);
      $kategori_buku = $_POST['kategori'];
      $pengarang_buku = $_POST['pengarang'];
      $penerbit_buku = $_POST['penerbit'];
      $rak_buku = $_POST['rak'];
      $tahun_buku = $_POST['tahun_buku'];
      $stok_buku = $_POST['stok_buku'];
      $imge = $_FILES['gambar']['name'];
      $date = date('Y-m-d H:i:s', strtotime('now'));
      $kode = buatkode();
      if ($imge != "") {
        $ext = explode(".", $imge);
        if ($ext[1] == "jpg" || $ext[1] == "jpeg" || $ext[1] == "png" || $ext[1] == "gif" || $ext[1] == "bmp") {
          $tmp = $_FILES['gambar']['tmp_name'];
          $cover = uniqid() . "." . $ext[1];
          $path = ABSPATH . "../assets/img/buku/" . $cover;
          if (move_uploaded_file($tmp, $path)) {
            $sql = "INSERT INTO tb_buku VALUES('$kode','$kategori_buku','$pengarang_buku','$penerbit_buku','$rak_buku','$judul_buku','$cover','$tahun_buku','$stok_buku','$date','$date')";
            $exec = mysqli_query($link, $sql);
            if ($exec) {
              $data['buku'] = array(
                'code' => 1,
                'message' => 'Data berhasil disimpan'
              );
            } else {
              $data['buku'] = array(
                'code' => 0,
                'message' => mysqli_error($link)
              );
            }
          } else {
            $data['buku'] = array(
              'code' => 0,
              'message' => 'Gagal upload gambar ' . $imge . ' !'
            );
          }
        } else {
          $data['buku'] = array(
            'code' => 0,
            'message' => 'Format gambar harus *.jpg, *.jpeg, *.png, *.bmp, *.gif !'
          );
        }
      } else {
        $sql = "INSERT INTO tb_buku VALUES('$kode','$kategori_buku','$pengarang_buku','$penerbit_buku','$rak_buku','$judul_buku','default.png','$tahun_buku','$stok_buku','$date','$date')";
        $exec = mysqli_query($link, $sql);
        if ($exec) {
          $data['buku'] = array(
            'code' => 1,
            'message' => 'Data berhasil disimpan'
          );
        } else {
          $data['buku'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    } //lanjut
    else if($rt == $route['data-buku']['remote'] && $dst == $route['data-buku']['crud'][3] && isset($_GET['id'])){
      $id = cek($_GET['id']);
      $sql = mysqli_query($link,"SELECT id_buku,judul_buku,tk.id_kategori,tp.id_pengarang,tper.id_penerbit,tr.id_rak,tahun_buku,stok_buku,gambar_buku FROM tb_buku AS tb INNER JOIN tb_kategori AS tk ON tk.id_kategori = tb.id_kategori INNER JOIN tb_pengarang AS tp ON tb.id_pengarang = tp.id_pengarang 
                                 INNER JOIN tb_penerbit AS tper ON tb.id_penerbit = tper.id_penerbit 
                                 INNER JOIN tb_rak AS tr ON tr.id_rak = tb.id_rak WHERE tb.id_buku = '$id' LIMIT 1");
      if (mysqli_num_rows($sql) > 0) {
        $r = mysqli_fetch_array($sql);
        $data['buku'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['buku'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($rt == $route['data-buku']['remote'] && $dst == $route['data-buku']['crud'][4] && isset($_GET['id'])) { //edit
      $id = cek($_GET['id']);
      $judul_buku = ucwords($_POST['judul_buku']);
      $kategori_buku = $_POST['kategori'];
      $pengarang_buku = $_POST['pengarang'];
      $penerbit_buku = $_POST['penerbit'];
      $rak_buku = $_POST['rak'];
      $tahun_buku = $_POST['tahun_buku'];
      $stok_buku = $_POST['stok_buku'];
      $imge = $_FILES['gambar']['name'];
      $date = date('Y-m-d H:i:s', strtotime('now'));
      if ($imge != "") {
        $ext = explode(".", $imge);
        if ($ext[1] == "jpg" || $ext[1] == "jpeg" || $ext[1] == "png" || $ext[1] == "gif" || $ext[1] == "bmp") {
          $tmp = $_FILES['gambar']['tmp_name'];
          $cover = uniqid() . "." . $ext[1];
          $path = ABSPATH . "../assets/img/buku/" . $cover;
          if (move_uploaded_file($tmp, $path)) {
            $sql = "UPDATE tb_buku SET judul_buku='$judul_buku',id_kategori='$kategori_buku',id_pengarang='$pengarang_buku',id_penerbit='$penerbit_buku',
                    id_rak='$rak_buku',tahun_buku='$tahun_buku',stok_buku='$stok_buku',gambar_buku='$cover',updated_at='$date'
                    WHERE id_buku='$id'";
            $exec = mysqli_query($link, $sql);
            if ($exec) {
              $data['buku'] = array(
                'code' => 1,
                'message' => 'Data berhasil diubah'
              );
            } else {
              $data['buku'] = array(
                'code' => 0,
                'message' => mysqli_error($link)
              );
            }
          } else {
            $data['buku'] = array(
              'code' => 0,
              'message' => 'Gagal upload gambar ' . $imge . ' !'
            );
          }
        } else {
          $data['buku'] = array(
            'code' => 0,
            'message' => 'Format gambar harus *.jpg, *.jpeg, *.png, *.bmp, *.gif !'
          );
        }
      } else {
        $sql = "UPDATE tb_buku SET judul_buku='$judul_buku',id_kategori='$kategori_buku',id_pengarang='$pengarang_buku',id_penerbit='$penerbit_buku',
        id_rak='$rak_buku',tahun_buku='$tahun_buku',stok_buku='$stok_buku',updated_at='$date'
        WHERE id_buku='$id'";
        $exec = mysqli_query($link, $sql);
        if ($exec) {
          $data['buku'] = array(
            'code' => 1,
            'message' => 'Data berhasil diubah'
          );
        } else {
          $data['buku'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    }elseif ($rt == $route['data-buku']['remote'] && $dst == $route['data-buku']['crud'][5] && isset($_GET['id'])) { //show user
      $id = cek($_GET['id']);
      $query ="SELECT id_buku,judul_buku,tk.nama_kategori,tp.nama_pengarang,tper.nama_penerbit,tr.nama_rak,tahun_buku,stok_buku,gambar_buku FROM tb_buku AS tb INNER JOIN tb_kategori AS tk ON tk.id_kategori = tb.id_kategori INNER JOIN tb_pengarang AS tp ON tb.id_pengarang = tp.id_pengarang 
      INNER JOIN tb_penerbit AS tper ON tb.id_penerbit = tper.id_penerbit 
      INNER JOIN tb_rak AS tr ON tr.id_rak = tb.id_rak WHERE tb.id_buku = '$id' ";
      $sql = mysqli_query($link, $query);
      if (mysqli_num_rows($sql) > 0) {
        $r = mysqli_fetch_array($sql,MYSQLI_NUM);
        $data['buku'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['buku'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
        print_r($data);
      }
    } elseif ($rt == $route['data-buku']['remote'] && $dst == $route['data-buku']['crud'][6] && isset($_GET['id'])) { //delete buku
      $id = cek($_GET['id']);
      $sql = mysqli_query($link, "DELETE FROM tb_buku WHERE id_buku='$id'");
      if ($sql) {
        $data['buku'] = array(
          'code' => 1,
          'message' => 'Data berhasil dihapus'
        );
      } else {
        $data['buku'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }
    elseif ($rt == $route['data-password']['remote'] && $dst == $route['data-password']['crud'][1] && isset($_GET['u'])) {
      $id = $_GET['u'];
      $pass = md5($_GET['passwordlama']);
      $sql = mysqli_query($link, "SELECT username,password FROM tb_users WHERE username='$id' AND password='$pass' LIMIT 1");
      if (mysqli_num_rows($sql) == 1) {
        $data = true;
      } else {
        $data = false;
      }
    } elseif ($rt == $route['data-password']['remote'] && $dst == $route['data-password']['crud'][0] && isset($_GET['u'])) {
      $id =$_GET['u'];
      $passnew = $_POST['passwordbaru'];
      $passcon = $_POST['konfirmasipassword'];
      if ($passnew == $passcon) {
        $a = md5($passnew);
        $sql = mysqli_query($link, "UPDATE tb_users SET password='$a' WHERE username='$id'");
        if ($sql) {
          $data['password'] = array(
            'code' => 1,
            'message' => 'Password berhasil diubah !'
          );
        } else {
          $data['password'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      } else {
        $data['password'] = array(
          'code' => 0,
          'message' => "Invalid request"
        );
      }
    }
    //transaksi
    else if ($rt == $route['data-peminjaman']['remote'] && $dst == $route['data-peminjaman']['crud'][0]) {
      $columns = array(
        'tp.created_at',
        'id_peminjaman',
        'username',
        'created_at',
        'due_date',
        'tp.status'
      );
      $sql = "SELECT tp.created_at,id_peminjaman,username,due_date,tp.status FROM tb_peminjaman AS tp INNER JOIN tb_users AS tu ON tp.id_user = tu.id_user";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($_POST['search']['value'])) {
        $sql .= " WHERE id_peminjaman LIKE '%" . $_POST['search']['value'] . "%' ";
        $sql .= " OR username LIKE '%" . $_POST['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($_POST['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($_POST['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = ($route['data-peminjaman']['crud'][3]);
        $detail = ($route['data-peminjaman']['crud'][5]);
        $delete = ($route['data-peminjaman']['crud'][6]);
        $status = $row['status'];
        $today = new DateTime(date('Y-m-d H:i:s',strtotime('now')));
        $exp = new DateTime(date('Y-m-d H:i:s',strtotime($row["due_date"])));
        if ($status == 0) {
          $msg = '<label class="label label-warning">Pending</label>';
        } else if ($status==1) {
          $msg = '<label class="label label-success">Setuju</label>';            
        } else {
          $msg = '<label class="label label-danger">Tolak</label>';
        }
        if ($today > $exp) {
          $msg .= '<br>'.'<label class="label label-danger">Telah lewat jatuh tempo</label>';
        } 
        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["id_peminjaman"];
        $nestedData[] = $row["username"];
        $nestedData[] = date("d-m-Y, H:i", strtotime($row["created_at"]));
        $nestedData[] = date("d-m-Y, H:i", strtotime($row["due_date"]));
        $nestedData[] = $msg;
        if(hasPermit('cek_status') && hasPermit('update_peminjaman')){
          $nestedData[] =
          '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['id_peminjaman'] . '" data-target="' . $edit . '">
          <i class="fa fa-edit"></i>
          <span>Edit</span>
          </a>&nbsp;
          ';
        }
        if (hasPermit('update_peminjaman') && hasPermit('delete_peminjaman')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['id_peminjaman'] . '" data-target="' . $edit . '">
            <i class="fa fa-edit"></i>
            <span>Edit</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['username'] . '" data-content="' . $row['id_peminjaman'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] =
            '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['id_peminjaman'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($_POST['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    }elseif ($rt == $route['data-peminjaman']['remote'] && $dst == $route['data-peminjaman']['crud'][1]) {
      $sql = "SELECT tb.created_at,judul_buku,nama_kategori,id_buku,stok_buku FROM tb_buku AS tb INNER JOIN tb_kategori as tk ON tb.id_kategori = tk.id_kategori
      ORDER BY tb.created_at DESC ";
      $query = mysqli_query($link, $sql) or die("error1");
      if (mysqli_num_rows($query) > 0) {
      $a = array();
      $i = 0;
      while ($r = mysqli_fetch_assoc($query)) {
        $stok =  $r['stok_buku'];
        $code = $r['id_buku'];
        $i++;
        $a[] = array(
          'no' => $i . ".",
          'items' => $r['judul_buku'],
          'category' => $r['nama_kategori'],
          'stock' => $stok,
          'checkbox' => "<input type=\"checkbox\" id=\"pinjam\" name=\"pinjam[$code]\"> Ya</div>",
          'amount' => "<input type=\"number\" id=\"jumlah\" name=\"jumlah[$code]\" class=\"form-control input-sm\" placeholder=\"Jumlah\" value=\"1\" min=\"1\" max=\"$stok\" disabled required>"
        );
      }
      $data['peminjaman'] = array(
        'code' => 1,
        'total' => mysqli_num_rows(mysqli_query($link,"SELECT * FROM tb_buku")),
        'filter' => $i,
        'data' => $a
      );
      } else {
      $data['peminjaman'] = array(
        'code' => 0,
        'message' => 'Stok Buku Kosong !',
      );
      }
    }elseif ($rt == $route['data-peminjaman']['remote'] && $dst == $route['data-peminjaman']['crud'][7]) {
      
      $sql = "SELECT tb.created_at,judul_buku,nama_kategori,id_buku,stok_buku FROM tb_buku AS tb INNER JOIN tb_kategori as tk ON tb.id_kategori = tk.id_kategori
      ORDER BY tb.created_at DESC ";
      $query = mysqli_query($link, $sql) or die("error1");
      if (mysqli_num_rows($query) > 0) {
      $a = array();
      $i = 0;
      while ($r = mysqli_fetch_assoc($query)) {
        $stok =  $r['stok_buku'];
        $code = $r['id_buku'];
        $i++;
        $a[] = array(
          'no' => $i . ".",
          'items' => $r['judul_buku'],
          'category' => $r['nama_kategori'],
          'stock' => $stok,
          'checkbox' => "<input type=\"checkbox\" id=\"pinjam\" name=\"pinjam[$code]\"> Ya</div>",
          'amount' => "<input type=\"number\" id=\"jumlah\" name=\"jumlah[$code]\" class=\"form-control input-sm\" placeholder=\"Jumlah\" value=\"1\" min=\"1\" max=\"$stok\" disabled required>"
        );
      }
      $data['peminjaman'] = array(
        'code' => 1,
        'total' => mysqli_num_rows(mysqli_query($link,"SELECT * FROM tb_buku")),
        'filter' => $i,
        'data' => $a
      );
      } else {
      $data['peminjaman'] = array(
        'code' => 0,
        'message' => 'Data Tidak Ditemukan !',
      );
      }
    } elseif ($rt == $route['data-peminjaman']['remote'] && $dst == $route['data-peminjaman']['crud'][2]) {
      if (!(@$_POST['pinjam'] || @$_POST['jumlah'])) {
        $data['peminjaman'] = array(
          'code' => 0,
          'message' => 'Checklist items !',
        );
      } else {
        $nama = $_SESSION['id'];
        $pjmn = $_POST['pinjam'];
        $jmlh = $_POST['jumlah'];
        $drsi = $_POST['durasi'];
        $due = date('Y-m-d H:i:s',strtotime($drsi));
        $date = date('Y-m-d H:i:s', strtotime('now'));
        $kode = buatkodetransaksi();
        $sql = mysqli_query($link,"INSERT INTO tb_peminjaman VALUES('$kode','$nama','0','$due','$date','$date')");
        if ($sql) {
          foreach ($jmlh as $key => $value) {
            mysqli_query($link,"INSERT INTO tb_peminjaman_detail VALUES(NULL,'$kode','$key','$value','$date','$date')");
          }
          $data['peminjaman'] = array(
            'code' => 1,
            'message' => 'Data berhasil disimpan !',
          );
        } else {
          $data['peminjaman'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    }
    elseif ($rt == $route['data-peminjaman']['remote'] && $dst == $route['data-peminjaman']['crud'][3] && isset($_GET['id'])) {
      $id = $_GET['id'];
     
      $check = mysqli_query($link,"SELECT id_peminjaman,status FROM tb_peminjaman WHERE id_peminjaman='$id'");
      
      $row = mysqli_fetch_assoc($check);

      if (mysqli_num_rows($check) > 0 ) {
        $a = array();
        $b = array();
        $query =  $sql = "SELECT tp.id_peminjaman,tp.status,tbuku.id_buku,tbuku.judul_buku,tuser.username,tp.due_date,tp.status,tpdetail.amount,tkategori.nama_kategori,tbuku.stok_buku FROM tb_peminjaman as tp
        INNER JOIN tb_peminjaman_detail as tpdetail ON tp.id_peminjaman = tpdetail.id_peminjaman
        INNER JOIN tb_users as tuser ON tuser.id_user = tp.id_user
        INNER JOIN tb_buku as tbuku ON tbuku.id_buku = tpdetail.id_buku
        INNER JOIN tb_kategori as tkategori ON tkategori.id_kategori = tbuku.id_kategori
        WHERE tp.id_peminjaman = '$id'";
        $sql = mysqli_query($link, $query);
        while ($r = mysqli_fetch_assoc($sql)) {
          $stok = $r['stok_buku'];
          $code = $r['id_buku'];
          $a[] = array(
            'name' => $r['judul_buku'],
            'category' => $r['nama_kategori'],
            'stock' => $stok ,
            'amount' => $r['amount'] ,
            'checkbox' => "<input type=\"checkbox\" id=\"tambah\" name=\"tambah[$code]\"> Ya</div>",
            'jumlah' => "<input type=\"number\" id=\"jumlah_edit\" name=\"jumlah[$code]\" class=\"form-control input-sm\" placeholder=\"Jumlah\" value=\"1\" min=\"1\" max=\"$stok\" disabled required>"
          );
          $b = array(
            
            'code' => $r['id_peminjaman'],
            'name' => $r['username'],
            'exp' => $r['due_date'],
            'status' => $r['status']
          );
         
        }
        $data['peminjaman'] = array(
          'code' => 1,
          'data' => array(
            'peminjam' => $b,
            'peralatan' => $a
          )
        );
      } else {
        $data['peminjaman'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    }
    elseif ($rt == $route['data-peminjaman']['remote'] && $dst == $route['data-peminjaman']['crud'][4] && isset($_GET['id'])) {
      $id = $_GET['id'];
      $status = $_POST['status'];
      // untuk edit jumlah buku yang di pinjam
      // edit aja sesuai tag name nya di frontend untuk $_POST tanpa @
      $jumlah_buku = @$_POST['jumlah_buku'];
      $drsi = $_POST['durasi_edit'];
      $date = date('Y-m-d H:i:s', strtotime('now'));
      $due = date('Y-m-d H:i:s',strtotime($drsi));

      // status harus ada 3
      // 0: pending
      // 1: approved
      // 2: rejected
      if (!in_array($status, [0, 1, 2])) {
        $data['peminjaman'] = [
          'code' => 0,
          'message' => "Value status tidak valid !"
        ];
      } else {
        // check dulu status nya
        $status_peminjam = mysqli_fetch_assoc(mysqli_query($link, "SELECT status FROM tb_peminjaman WHERE id_peminjaman='$id'"))['status'];
        if ($status_peminjam == 2) {
          $data['peminjaman'] = [
            'code' => 0,
            'message' => "Status peminjaman di tolak"
          ];
        } else if ($status_peminjam == 1) {
          $data['peminjaman'] = [
            'code' => 0,
            'message' => "Status peminjaman telah aktif"
          ];
        } else {
          if (in_array($status, [0, 2])) {
            mysqli_query($link, "UPDATE tb_peminjaman SET status='$status' WHERE id_peminjaman='$id'");
            $data['peminjaman'] = [
              'code' => 1,
              'message' => "Data berhasil diubah"
            ];
          } else {
            // ambil detail nya dahulu
            $detail_pinjaman = mysqli_query($link, "SELECT id_peminjaman ID_PEMINJAM, id_buku ID_BUKU, amount JMLH FROM tb_peminjaman_detail WHERE ID_PEMINJAMAN='$id'");
            
            if (mysqli_num_rows($detail_pinjaman) > 0) {
              $dataBuku = [];
              $dataUpdate = [];

              while ($r = mysqli_fetch_assoc($detail_pinjaman)) {
                $buku = $r['ID_BUKU'];
                $jmlh = $r['JMLH'];
                $row = mysqli_fetch_assoc(mysqli_query($link, "SELECT stok_buku STOCK, judul_buku FROM tb_buku WHERE id_buku = '$buku'"));
                // jika stock nya kurang dari jumlah pinjam
                if ($row['STOCK'] < $jmlh) {
                  $data['peminjaman'] = [
                    'code' => 2,
                    'message' => "Stok buku " . $row['judul_buku'] . " yang dipinjam kurang dari $jmlh atau kosong\nStatus peminjaman dibatalkan"
                  ];
                  mysqli_query($link, "UPDATE tb_peminjaman SET status='2' WHERE id_peminjaman='$id'");
                  $dataBuku = [];
                  break;
                } else {
                  $dataBuku[] = [
                    'buku' => $buku,
                    'jmlh' => $jmlh
                  ];
                }
              }

              // check jumlah data buku yang di pinjam
              if (count($dataBuku) > 0) {
                // update jumlah buku yang di pinjam
                foreach ($dataBuku as $k => $v) {
                  $dataUpdate[] = mysqli_query($link,"UPDATE tb_buku SET stok_buku=stok_buku-" . $v['jmlh'] . " WHERE id_buku='" . $v['buku'] . "'");
                }

                if (count($dataUpdate) == count($dataBuku)) {
                  $success = [];
                  foreach ($dataUpdate as $k => $v) {
                    if (!$v) {
                      $data['peminjaman'] = [
                        'code' => 0,
                        'message' => "Data " . $dataBuku[$k]['buku'] . " gagal di update !",
                      ];
                      break;
                    } else {
                      $success[] = $v;
                    }
                  }

                  // check jumlah success query dengan data yang di update
                  if (count($success) == count($dataUpdate)) {
                    $sql = mysqli_query($link, "UPDATE tb_peminjaman SET status='1' WHERE id_peminjaman='$id'");
                    if ($sql) {
                      $data['peminjaman'] = [
                        'code' => 1,
                        'message' => 'Data berhasil !',
                      ];
                    } else {
                      $data['peminjaman'] = [
                        'code' => 0,
                        'message' => mysqli_error($link)
                      ];
                    }
                  } else {
                    $data['peminjaman'] = [
                      'code' => 0,
                      'message' => 'Data gagal diubah !',
                    ];
                  }
                } else {
                  $data['peminjaman'] = [
                    'code' => 0,
                    'message' => 'Data gagal diubah !',
                  ];
                }
              }
            } else {
              $data['peminjaman'] = [
                'code' => 0,
                'message' => 'Data kosong !',
              ];
            }
          }
        }
      }
    } elseif ($rt == $route['data-peminjaman']['remote'] && $dst == $route['data-peminjaman']['crud'][6] && isset($_GET['id'])) {
      $id = $_GET['id'];
      $check = mysqli_query($link,"SELECT * FROM tb_peminjaman WHERE id_peminjaman='$id' OR status='0' OR status='2'");
      if (mysqli_num_rows($check) == 1) {
          mysqli_query($link, "DELETE FROM tb_peminjaman_detail WHERE id_peminjaman='$id'");
      }
      $sql = mysqli_query($link, "DELETE FROM tb_peminjaman WHERE id_peminjaman='$id'");
      if ($sql) {
        $data['peminjaman'] = array(
          'code' => 1,
          'message' => 'Data berhasil dihapus'
        );
      } else {
        $data['peminjaman'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }
    //pengembalian
    else if ($rt == $route['data-pengembalian']['remote'] && $dst == $route['data-pengembalian']['crud'][0]){
      $columns = array(
        'created_at',
        'id_pengembalian',
        'id_peminjaman',
        'ketepatan',
        'created_at'
      );
      $sql = "SELECT created_at,id_pengembalian,id_peminjaman,ketepatan FROM tb_pengembalian";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($_POST['search']['value'])) {
        $sql .= " WHERE id_pengembalian LIKE '%" . $_POST['search']['value'] . "%' ";
        $sql .= " OR id_peminjaman LIKE '%" . $_POST['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($_POST['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($_POST['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $delete = ($route['data-pengembalian']['crud'][6]);
        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["id_peminjaman"];
        $nestedData[] = date("d-m-Y, H:i", strtotime($row["created_at"]));
        $nestedData[] = $row['ketepatan'] == 1 ? '<label class="text-success">Tepat waktu</label>' : '<label class="text-red">Terlambat</label>';
        if (hasPermit('update_pengembalian') && hasPermit('delete_pengembalian')) {
          $nestedData[] =
            '<a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['id_pengembalian'] . '" data-content="' . $row['id_pengembalian'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } 
        $dataTable[] = $nestedData;
      }
      $data = array(
        "draw"            => intval($_POST['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    }else if ($rt == $route['data-pengembalian']['remote'] && $dst == $route['data-pengembalian']['check'][0] && isset($_GET['kode'])){ //check username
      $kode = cek($_GET['kode']);
      $sql = mysqli_query($link, "SELECT id_peminjaman FROM tb_peminjaman WHERE id_peminjaman='$kode'");
      if (mysqli_num_rows($sql) > 0) {
        $data= true;
      } else {
        $data= false;
      }
    }else if ($rt == $route['data-pengembalian']['remote'] && $dst == $route['data-pengembalian']['crud'][2] ){ //tambah pengembalian
      $kode = cek($_POST['kode']);
      $date = date('Y-m-d H:i:s', strtotime('now'));
      $cek_tanggal = mysqli_query($link,"SELECT due_date,status FROM tb_peminjaman WHERE id_peminjaman='$kode' AND status='1'");
      global $ketepatan_waktu;
      global $today;
      global $exp;
      
      while ($row = mysqli_fetch_assoc($cek_tanggal)) {
        $today = new DateTime(date('Y-m-d H:i:s',strtotime('now')));
        $exp = new DateTime(date('Y-m-d H:i:s',strtotime($row["due_date"])));
      }
      if($today<$exp){
        $ketepatan_waktu='1';
      }else{
        $ketepatan_waktu='0'; 
      }
      $sql = mysqli_query($link,"INSERT INTO tb_pengembalian VALUES('','$kode','$date','$ketepatan_waktu','$date','$date')");
      if ($sql) {
        $query1 = "SELECT  DISTINCT tb.id_buku AS kode_buku,tpd.amount AS total FROM tb_peminjaman_detail as tpd
        INNER JOIN tb_buku AS tb ON tpd.id_buku = tb.id_buku
        INNER JOIN tb_peminjaman as tpem ON tpem.id_peminjaman = tpd.id_peminjaman
        WHERE tpem.status='1' AND tpem.id_peminjaman ='$kode'";
        $sql1 = mysqli_query($link, $query1);
        while ($r = mysqli_fetch_array($sql1)) {
          $a=$r['total'];
          $b=$r['kode_buku'];
          mysqli_query($link,"UPDATE tb_buku SET stok_buku=stok_buku+'$a' WHERE id_buku='$b'");
        }
        $data['pengembalian'] = array(
          'code' => 1,
          'message' => 'Data berhasil ditambahkan !'
        );
      } else {
        $data['pengembalian'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }elseif ($rt == $route['data-pengembalian']['remote'] && $dst == $route['data-pengembalian']['crud'][6] && isset($_GET['id'])) { //delete buku
      $id = cek($_GET['id']);
      $sql = mysqli_query($link, "DELETE FROM tb_pengembalian WHERE id_pengembalian='$id'");
      if ($sql) {
        $data['pengembalian'] = array(
          'code' => 1,
          'message' => 'Data berhasil dihapus'
        );
      } else {
        $data['pengembalian'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }
    // //check username register
    // else if ($rt == $route['data-user']['remote'] && $dst == $route['data-user']['check'][2] && isset($_GET['username'])){
    //   $username = cek($_GET['username']);
    //   $sql = mysqli_query($link, "SELECT username FROM tb_users WHERE username='$username'");
    //   if (mysqli_num_rows($sql) > 0) {
    //     $data= false;
    //   } else {
    //     $data= true;
    //   }
    // }
   
  }
  else {
    $data = array('code' => 404, 'message' => 'Invalid Url');
  }
   
}else {
  $data = array('code' => 403, 'message' => 'Access Forbidden');
}

echo json_encode($data);