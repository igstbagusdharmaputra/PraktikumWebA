<?php
    session_start();
    include_once '../path.php';
    require_once (ABSPATH . '../config/config.php');
    $url = BASE_URL;
    session_destroy();
    unset($_COOKIE['sisteminformasiperpustakaan']);
    setcookie("sisteminformasiperpustakaan",false,time() - (60*10));
    echo "<script>window.location.href= '".$url."login/';</script>";
    exit();