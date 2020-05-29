<?php 
session_start();
require_once '../path.php';
require_once(ABSPATH . '../config/config.php');
require_once(ABSPATH . '../config/database.php');
require_once(ABSPATH . '../config/header-json.php');
include_once(ABSPATH . '../config/functions.php');
require_once(ABSPATH . '../config/route.php');
$data = array();

$mods = @$_REQUEST['tipe'] ?? @$_REQUEST['tipe'];

if($mods=="login"){
    if(isset($_POST['username']) && isset($_POST['password'])){
        $a = mysqli_real_escape_string($link,strip_tags($_POST['username']));
        $b = mysqli_real_escape_string($link,strip_tags($_POST['password']));
        $check  = execute("SELECT username from tb_users WHERE username='$a'");
        if (mysqli_num_rows($check) == 0) {
            $data['auth'] = result(0, 'Username not found !');
        } else {
            $pass = md5($b);
            $sqlLogin = execute("SELECT id_user,name,username,password,status,name_rule FROM tb_users AS u 
                INNER JOIN tb_rules AS r ON r.id_rule = u.id_rule WHERE username='$a' AND password='$pass' LIMIT 1");
            $r = mysqli_fetch_assoc($sqlLogin);
            if (mysqli_num_rows($sqlLogin) == 1 && $r['status'] == 0) {
                $data['auth'] = result(0, 'Your account isn\'t active !');
            } else if (mysqli_num_rows($sqlLogin) == 1 && $r['status'] == 1) {
                $data['auth'] = result(1, 'Login Success ! Waiting redirected');
                $_SESSION['is_logged'] = true;
                $_SESSION['id'] = $r['id_user'];
                $_SESSION['name'] = $r['name'];
                $_SESSION['username'] = $r['username'];
                $_SESSION['level'] = $r['name_rule'];
                $_SESSION['user_agent'] = $userAgent;
                setcookie("sisteminformasiperpustakaan", true, time() + (60 * 10), "/sisinfoperpus", "localhost", false, true);
            } else {
                $data['auth'] = result(0, 'Username or Password is wrong !');
            }
        }
    } else {
        $data['auth'] = result(0, 'Username or Password is required !');
    }
}
else if ($mods == "dashboard"){
    if(isset($_SESSION['is_logged'])){
        $user  = mysqli_num_rows(execute("SELECT * FROM tb_users"));
        $html = ' 
            <div class="col-lg-4 col-xs-12">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>' . $user . '</h3>
                        <p>Jumlah Pengguna</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="small-box-footer"></div>
                </div>
            </div>
        ';
        $data = $html;
    }
}elseif ($mods== "register"){
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['password_confirm'])){
        $name = cek($_POST['name']);
        $user = cek($_POST['username']);
        $level = 3;
        $stts = '1';
        $pass = cek($_POST['password']);
        $conf = cek($_POST['password_confirm']);
        $date = date('Y-m-d H:i:s', strtotime('now'));
        if ($pass == $conf) {
            $passnew = md5($pass);
            $sql = mysqli_query($link, "INSERT INTO tb_users VALUES ('','$level','$name','$user','$passnew','$stts','$date','$date')");
        if ($sql) {
            $data['register'] = array(
            'code' => 1,
            'message' => 'Pengguna telah ditambahkan !'
            );
        } else {
            $data['register'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
            );
        }
        } else {
        $data['register'] = array(
            'code' => 0,
            'message' => 'Konfirmasi password tidak sama dengan field password'
            );
        }
    }
}
else {
    $data['api'] = result(0, 'Url Invalid');
}
echo json_encode($data);

