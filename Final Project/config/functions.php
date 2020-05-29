<?php

function tanggal($tgl) {
    $hari = array(
        1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Minggu'
    );
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    $arr = explode('-', $tgl);
    return $hari[(int)$arr[0]] . ', ' . $arr[3] . '-' . $bulan[(int)$arr[2]] . '-' . $arr[1];
}

function bulan($bln) {
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    return $bulan[(int)$bln];
}
function result($code,$msg){
    return array(
        'code' => $code,
        'message' => $msg,
    );
}
function execute($sql){
    global $link;
    $query = null;
    $query = mysqli_query($link, $sql);
    return $query;
}
function hasPermit($p) {
    global $link;
    $r = $_SESSION['level'];
    $sqlevel = "SELECT tb_rules.*, tb_rule_permission.*, tb_permissions.* FROM tb_rules
                INNER JOIN tb_rule_permission ON tb_rule_permission.id_rule = tb_rules.id_rule
                INNER JOIN tb_permissions ON tb_permissions.id_permission = tb_rule_permission.id_permission
                WHERE tb_rules.name_rule='$r' AND tb_permissions.name_permission='$p'";
    $exc = mysqli_query($link, $sqlevel);
    return mysqli_num_rows($exc) == 1 ? true : false;
}
function tombol_tambah(array $box = null) {
    $html = '
        <div class="box">
            <div class="box-body">
                <a id="'.$box['box-add']['id'].'" name="'.$box['box-add']['name'].'" class="'.$box['box-add']['class'].'" title="'.$box['box-add']['title'].'" data-target="'.$box['box-add']['data-target'].'">
                    <i class="fa fa-plus"></i>&nbsp;
                    <span>'.$box['box-add']['title'].'</span>
                </a>
            </div>
        </div>
    ';
    return $html;
}
function table(array $data = null) {
    $th = null;
    foreach ($data['field'] as $k => $v) {
        $th .= "<th>".$v."</th>\n";
    }
    $html = '<div id="boxnyo" class="box box-solid box-primary">
                <div class="box-body">
                    <div class="col-md-12 col-xs-12 table-responsive">
                        <table id="'.$data['id'].'" name="'.$data['name'].'" class="'.$data['class'].'" data-remote="'.$data['data-remote'].'" data-target="'.$data['data-target'].'">
                            <thead>
                                <tr> 
                                    '.$th.'
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>';
    return $html;
}

function buatkode() {
    global $link;    
    $thn = date('Y',strtotime('now'));
    $query = "SELECT max(id_buku) as kodeTerbesar FROM tb_buku";
    $max_nilai = mysqli_query($link,$query);
    $data = mysqli_fetch_array($max_nilai);
    $kodeBuku= $data['kodeTerbesar'];
    
    $count = (int) substr($kodeBuku, 8, 13);
    $count++;
    $kode = "BK/".$thn."/".sprintf('%05s',$count); 
    return $kode;
}
function buatkodetransaksi() {
    global $link;    
    $thn = date('Y',strtotime('now'));
    $query = "SELECT max(id_peminjaman) as kodeTerbesar FROM tb_peminjaman";
    $max_nilai = mysqli_query($link,$query);
    $data = mysqli_fetch_array($max_nilai);
    $kodeBuku= $data['kodeTerbesar'];
    
    $count = (int) substr($kodeBuku, 9, 13);
    $count++;
    $kode = "TRK/".$thn."/".sprintf('%05s',$count); 
    return $kode;
}

function cek($v){
    global $link;
    return mysqli_real_escape_string($link, $v);
}