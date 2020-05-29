<?php include_once '../master/header.php'; ?>
    <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                        if (FIRST_PART == "dashboard" && SECOND_PART == "" && THIRD_PART == "") {
                            echo ucwords(str_replace('-', ' ', FIRST_PART));
                        }
                        elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[2]))) {
                            if ($_REQUEST['submenu'] == "@".strtolower(str_replace([' ', '_'],'-',$_SESSION['username']))) {
                                echo $menu[2];
                            }
                            else {
                                echo "Error";
                            }
                        }
                        elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[0]))) {
                            if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[0]))) {
                                echo $menu[0] ." ".$submenu[0];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[1]))) {
                                echo $menu[0] ." ".$submenu[1];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[2]))) {
                                echo $menu[0] ." ".$submenu[2];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[3]))) {
                                echo $menu[0] ." ".$submenu[3];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[4]))) {
                                echo $menu[0] ." ".$submenu[4];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[5 ]))) {
                                echo $menu[0] ." ".$submenu[5];
                            }
                            else {
                                echo "Error";
                            }
                        }
                        elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[1]))) {
                            if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[6]))) {
                                echo $menu[1] ." ".$submenu[6];
                            }
                            else if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[7]))) {
                                echo $menu[1] ." ".$submenu[7];
                            }
                            else {
                                echo "Error";
                            }
                        }
                        else {
                            echo "Error";
                        }
                    ?>
                    <small><b><?= tanggal(date('N-Y-n-d',strtotime('now'))) ?> <span id="clock"></span></b></small>
                </h1>
                <ol class="breadcrumb">
                    
                </ol>
            </section>
            <!-- Main content -->
            <section class="content container-fluid" id="content-js">
                <?php
                    // Dashboard //
                    if (FIRST_PART == "dashboard" && SECOND_PART == "" && THIRD_PART == "") { ?>
                        <div class="callout callout-info">
                            <h4 class="text-center">Selamat Datang Di Sistem Infromasi Perpustakaan</h4>
                        </div>
                        <div class="row" id="data-box"></div>
                        
                <?php }
                    // Manajemen Data //
                    elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[0])) && hasPermit('menu_data')) {
                        if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[0]))) {
                            if (hasPermit('submenu_data_user')) {
                                if (hasPermit($static['data-user']['permissions'][0])) { 
                                    echo tombol_tambah($static['data-user']['box-create']);
                                }
                                echo table($static['data-user']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/user.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[1]))) {
                            if (hasPermit('submenu_data_kategori')) {
                                if (hasPermit($static['data-kategori']['permissions'][0])) { 
                                    echo tombol_tambah($static['data-kategori']['box-create']);
                                }
                                echo table($static['data-kategori']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/kategori.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[2]))) {
                            if (hasPermit('submenu_data_penerbit')) {
                                if (hasPermit($static['data-penerbit']['permissions'][0])) { 
                                    echo tombol_tambah($static['data-penerbit']['box-create']);
                                }
                                echo table($static['data-penerbit']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/penerbit.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[3]))) {
                            if (hasPermit('submenu_data_pengarang')) {
                                if (hasPermit($static['data-pengarang']['permissions'][0])) { 
                                    echo tombol_tambah($static['data-pengarang']['box-create']);
                                }
                                echo table($static['data-pengarang']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/pengarang.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[4]))) {
                            if (hasPermit('submenu_data_buku')) {
                                if (hasPermit($static['data-buku']['permissions'][0])) { 
                                    echo tombol_tambah($static['data-buku']['box-create']);
                                }
                                echo table($static['data-buku']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/buku.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[5]))) {
                            if (hasPermit('submenu_data_rak')) {
                                if (hasPermit($static['data-rak']['permissions'][0])) { 
                                    echo tombol_tambah($static['data-rak']['box-create']);
                                }
                                echo table($static['data-rak']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/rak.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        
                        
                        else {
                            include_once '../master/error/404.php';
                        }
                    }
                    elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[2]))) {
                        if ($_REQUEST['submenu'] == "@".strtolower(str_replace([' ', '_'],'-',$_SESSION['username']))) {
                            include_once 'change_password.php';
                        }
                        else {
                            echo "404";
                        }
                    }
                    //menu transaksi
                    elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[1])) && hasPermit('menu_transaksi')) {
                        if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[6]))) {
                            if (hasPermit('submenu_transaksi_peminjaman')) {
                                if (hasPermit($static['data-peminjaman']['permissions'][0])) { 
                                    echo tombol_tambah($static['data-peminjaman']['box-create']);
                                }
                                echo table($static['data-peminjaman']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/peminjaman.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[7]))) {
                            if (hasPermit('submenu_transaksi_pengembalian')) {
                                if (hasPermit($static['data-pengembalian']['permissions'][0])) { 
                                    echo tombol_tambah($static['data-pengembalian']['box-create']);
                                }
                                echo table($static['data-pengembalian']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/pengembalian.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                    }
                    
                    // Error Handling //
                    else {
                        include_once '../master/error/404.php';
                    }
                ?>
            </section>
            <!-- /.content -->
    </div>
<?php include_once '../master/footer.php'; ?>