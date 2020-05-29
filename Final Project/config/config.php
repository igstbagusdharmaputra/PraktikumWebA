<?php
// Configuration Apps
$folder = "sisinfoperpus";
if ($folder != null) {
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/$folder/";
} else {
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
}
define('APPNAME', 'Sistem Informasi Perpustakaan');
define('BASE_URL', $url);
define('TIMEZONE', 'Asia/Kuala_Lumpur');
//define('TIMEZONE', 'Asia/Jakarta');

// Configuration Database
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_DATABASE', 'db_perpus');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

$d = $_SERVER['REQUEST_URI'];
$p = parse_url($d, PHP_URL_PATH);
$c = explode('/', $p);
define('FIRST_PART', @$c[2]);
define('SECOND_PART', @$c[3]);
define('THIRD_PART', @$c[4]);
define('FOURTH_PART', @$c[5]);
// print_r($c[2]);
// List Routing
$menu = array(
    'Manajemen Data', 'Transaksi', 'Password'
);
$submenu = array(
    'User', 'Kategori', 'Penerbit', 'Pengarang', 'Buku', 'Rak', 'Peminjaman','Pengembalian'
);