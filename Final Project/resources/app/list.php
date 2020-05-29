<?php
require_once '../path.php';
require_once(ABSPATH . '../config/config.php');
require_once(ABSPATH . '../config/database.php');
require_once(ABSPATH . '../config/route.php');
require_once(ABSPATH . '../config/header-json.php');
require_once(ABSPATH . '../config/functions.php');
$data = array();

if (isset($_GET['f']) && isset($_GET['d'])) {
    $rt = ($_GET['f']);
    $dst = ($_GET['d']);
    if ($rt == $route['data-home']['remote'] && $dst == $route['data-home']['crud'][0]) {
        $sql = "SELECT tb.created_at,id_buku,judul_buku,tk.nama_kategori,tp.nama_pengarang,tper.nama_penerbit,tr.nama_rak,tahun_buku,stok_buku,gambar_buku FROM tb_buku AS tb INNER JOIN tb_kategori AS tk ON tk.id_kategori = tb.id_kategori INNER JOIN tb_pengarang AS tp ON tb.id_pengarang = tp.id_pengarang 
        INNER JOIN tb_penerbit AS tper ON tb.id_penerbit = tper.id_penerbit 
        INNER JOIN tb_rak AS tr ON tr.id_rak = tb.id_rak ORDER BY tb.created_at DESC LIMIT 0,6";
        $query = mysqli_query($link, $sql) or die("error1");
        if (mysqli_num_rows($query) > 0) {
            $a = array();
            $i = 0;
            $rmt = ($route['data-home']['remote']);
            $tgt = ($route['data-home']['crud'][1]);
            while ($r = mysqli_fetch_assoc($query)) {
                $a[] = array(
                    'code' => $r['id_buku'],
                    'items' => $r['judul_buku'],
                    'cover' => $r['gambar_buku'],
                    'cats' => $r['nama_kategori'],
                    'remote' => $rmt,
                    'target' => $tgt
                );
                $i++;
            }
            $data['home'] = array(
                'code' => 1,
                'total' => mysqli_num_rows(mysqli_query($link, "SELECT * FROM tb_buku WHERE stok_buku > 0")),
                'filter' => $i,
                'data' => $a
            );
        } else {
            $data['home'] = array(
                'code' => 0,
                'message' => 'Stok Buku Kosong !',
            );
        }
    } 
    elseif ($rt == $route['data-home']['remote'] && $dst == $route['data-home']['crud'][1] && isset($_GET['id'])) {
        $id = $_GET['id'];
       
        $sql =  $sql = "SELECT tb.created_at,id_buku,judul_buku,tk.nama_kategori,tp.nama_pengarang,tper.nama_penerbit,tr.nama_rak,tahun_buku,stok_buku,gambar_buku FROM tb_buku AS tb INNER JOIN tb_kategori AS tk ON tk.id_kategori = tb.id_kategori INNER JOIN tb_pengarang AS tp ON tb.id_pengarang = tp.id_pengarang 
        INNER JOIN tb_penerbit AS tper ON tb.id_penerbit = tper.id_penerbit 
        INNER JOIN tb_rak AS tr ON tr.id_rak = tb.id_rak WHERE tb.id_buku='$id'";
        $query = mysqli_query($link, $sql) or die("error1");
        if (mysqli_num_rows($query) > 0) {
            $rmt = ($route['data-home']['remote']);
            $tgt = ($route['data-home']['crud'][2]);
            $a = array();
            $r = mysqli_fetch_assoc($query);
            $a = array(
                'code' => $r['id_buku'],
                'items' => $r['judul_buku'],
                'cat' => $r['nama_kategori'],
                'np' => $r['nama_pengarang'],
                'cover' => $r['gambar_buku'],
                'stok' => $r['stok_buku'],
                'nper' => $r['nama_penerbit'],
                'rak' => $r['nama_rak'],
                'th'  => $r['tahun_buku']
            );
            $data['home'] = array(
                'code' => 1,
                'data' => $a
            );
        } else {
            $data['home'] = array(
                'code' => 0,
                'message' => 'Stok Buku Kosong !',
            );
        }
    } 
} else {
    $data = array('code' => 404, 'message' => 'Invalid Url');
}

echo json_encode($data);
