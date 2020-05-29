<?php

require_once '../path.php';
require_once(ABSPATH . '../config/config.php');
require_once(ABSPATH . '../config/database.php');
require_once(ABSPATH . '../config/route.php');
require_once(ABSPATH . '../config/header-json.php');
require_once(ABSPATH . '../config/functions.php');
$data = array();
if (isset($_GET['f']) && isset($_GET['d'])) {
    $rt = $_GET['f'];
    $dst = $_GET['d'];
    if ($rt == $route['register']['remote'] && $dst == $route['register']['check'][0] && isset($_GET['username'])){
        $username = cek($_GET['username']);
        $sql = mysqli_query($link, "SELECT username FROM tb_users WHERE username='$username'");
        if (mysqli_num_rows($sql) > 0) {
          $data= false;
        } else {
          $data= true;
        }
      } else {
        $data = array('code' => 404, 'message' => 'Invalid Url');
      }
} else {
    $data = array('code' => 404, 'message' => 'Invalid Url');
}

echo json_encode($data);