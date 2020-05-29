<?php
if (@$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[0]))) {
    if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[0]))) { //user
        ?>
            <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[0] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-user" data-target="<?= ($route['data-user']['crud'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Lengkap</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Nama Lengkap">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Level</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="level" name="level">
                                            <option selected disabled value="">Pilih Level</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_rules");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_rule'] ?>"><?= ucwords(str_replace("_", "\r", $row['name_rule'])) ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Status</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="status" name="status">
                                            <option selected disabled value="">Pilih Status</option>
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Username</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" data-target="<?= $route['data-user']['check'][0] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Password</label>
                                    <div class="col-xs-9">
                                        <input type="password" id="password1" name="password" class="form-control" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Konfirmasi Password</label>
                                    <div class="col-xs-9">
                                        <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="Konfirmasi Password">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[0] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-user" data-target="<?= $route['data-user']['crud'][4] ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Lengkap</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Lengkap">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Level</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="level" name="level">
                                            <option selected disabled value="">Pilih Level</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_rules");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_rule'] ?>"><?= ucwords(str_replace("_", "\r", $row['name_rule'])) ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Status</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="status" name="status">
                                            <option selected disabled value="">Pilih Status</option>
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Username</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" data-target="<?= ($route['data-user']['check'][1]) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Detail Data <?= $submenu[0] ?></h3>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-striped table-hover">
                                <tbody id="detail-table"></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
        <?php
    } elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[1]))) { //kategori
        ?>
            <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[1] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-kategori" data-target="<?= $route['data-kategori']['crud'][2] ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Kategori</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" placeholder="Nama Kategori" data-target="<?= $route['data-kategori']['check'][0] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[1] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-kategori" data-target="<?= $route['data-kategori']['crud'][4] ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Kategori</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" placeholder="Nama Kategori" data-target="<?= $route['data-kategori']['check'][1] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
   
        <?php
    } elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[2]))) { //penerbit
        ?>
         <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[2] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-penerbit" data-target="<?= $route['data-penerbit']['crud'][2] ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Penerbit</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama_penerbit" name="nama_penerbit" class="form-control" placeholder="Nama Penerbit" data-target="<?= $route['data-penerbit']['check'][0] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[2] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-penerbit" data-target="<?= $route['data-penerbit']['crud'][4] ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Penerbit</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama_penerbit" name="nama_penerbit" class="form-control" placeholder="Nama Penerbit" data-target="<?= $route['data-penerbit']['check'][1] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    } elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[3]))) { //pengarang
        ?>
          <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[3] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-pengarang" data-target="<?= $route['data-pengarang']['crud'][2] ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Pengarang</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama_pengarang" name="nama_pengarang" class="form-control" placeholder="Nama Pengarang" data-target="<?= $route['data-pengarang']['check'][0] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[3] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-pengarang" data-target="<?= $route['data-pengarang']['crud'][4] ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Pengarang</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama_pengarang" name="nama_pengarang" class="form-control" placeholder="Nama Pengarang" data-target="<?= $route['data-pengarang']['check'][1] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    } else if($_REQUEST['submenu'] == strtolower(str_replace(' ','-',$submenu[4]))){ //buku
        ?>
        <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[4] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-buku" data-target="<?= $route['data-buku']['crud'][2] ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Judul buku</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="judul_buku" name="judul_buku" class="form-control" placeholder="Judul buku">
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Kategori Buku</label>
                                    <div class="col-xs-9">
                                        <select name="kategori" id="kategori" class="form-control">
                                            <option selected disabled value="">Pilih Kategori</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_kategori");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_kategori'] ?>"><?= $row['nama_kategori'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Pengarang Buku</label>
                                    <div class="col-xs-9">
                                        <select name="pengarang" id="pengarang" class="form-control">
                                            <option selected disabled value="">Pilih Pengarang Buku</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_pengarang");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_pengarang'] ?>"><?= $row['nama_pengarang'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Penerbit Buku</label>
                                    <div class="col-xs-9">
                                        <select name="penerbit" id="penerbit" class="form-control">
                                            <option selected disabled value="">Pilih Penerbit Buku</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_penerbit");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_penerbit'] ?>"><?= $row['nama_penerbit'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rak Buku</label>
                                    <div class="col-xs-9">
                                        <select name="rak" id="rak" class="form-control">
                                            <option selected disabled value="">Pilih Rak Buku</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_rak");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_rak'] ?>"><?= $row['nama_rak'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Tahun Buku</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="tahun_buku" name="tahun_buku" class="form-control auto" placeholder="Tahun Buku">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Stok Buku</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="stok_buku" name="stok_buku" class="form-control auto" placeholder="Stok Buku">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Gambar Buku</label>
                                    <div class="col-xs-9">
                                        <div class="input-group" id="fupload">
                                            <input type="text" id="img" name="img" class="form-control" placeholder="Pilih Gambar" readonly>
                                            <span class="input-group-btn">
                                                <a id="choose" class="btn btn-success" data-input="img" data-preview="holder">
                                                    <i class="fa fa-picture-o">&nbsp;Pilih Gambar</i>
                                                </a>
                                                <a id="reset" class="btn btn-danger" data-input="img" data-preview="holder">
                                                    <i class="fa fa-refresh">&nbsp;Reset</i>
                                                </a>
                                            </span>
                                            <input type="file" id="gambar" name="gambar" style="display: none;" accept="image/*">
                                        </div>
                                        <br>
                                        <img id="preview" class="img-responsive" src="" alt="Gambar Buku" height="250" width="250" style="display: none;">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[4] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-buku" data-target="<?= $route['data-buku']['crud'][4] ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Judul buku</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="judul_buku" name="judul_buku" class="form-control" placeholder="Judul buku">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Kategori Buku</label>
                                    <div class="col-xs-9">
                                        <select name="kategori" id="kategori" class="form-control">
                                            <option selected disabled value="">Pilih Kategori</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_kategori");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_kategori'] ?>"><?= $row['nama_kategori'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Pengarang Buku</label>
                                    <div class="col-xs-9">
                                        <select name="pengarang" id="pengarang" class="form-control">
                                            <option selected disabled value="">Pilih Pengarang Buku</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_pengarang");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_pengarang'] ?>"><?= $row['nama_pengarang'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Penerbit Buku</label>
                                    <div class="col-xs-9">
                                        <select name="penerbit" id="penerbit" class="form-control">
                                            <option selected disabled value="">Pilih Penerbit Buku</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_penerbit");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_penerbit'] ?>"><?= $row['nama_penerbit'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rak Buku</label>
                                    <div class="col-xs-9">
                                        <select name="rak" id="rak" class="form-control">
                                            <option selected disabled value="">Pilih Rak Buku</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_rak");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_rak'] ?>"><?= $row['nama_rak'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Tahun Buku</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="tahun_buku" name="tahun_buku" class="form-control auto" placeholder="Tahun Buku">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Stok Buku</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="stok_buku" name="stok_buku" class="form-control auto" placeholder="Stok Buku">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Gambar Buku</label>
                                    <div class="col-xs-9">
                                        <div class="input-group" id="fupload">
                                            <input type="text" id="img-edit" name="img" class="form-control" placeholder="Pilih Gambar" readonly>
                                            <span class="input-group-btn">
                                                <a id="choose-edit" class="btn btn-success" data-input="img" data-preview="holder">
                                                    <i class="fa fa-picture-o">&nbsp;Pilih Gambar</i>
                                                </a>
                                            </span>
                                            <input type="file" id="gambar-edit" name="gambar" style="display: none;" accept="image/*">
                                        </div>
                                        <br>
                                        <img id="preview-edit" class="img-responsive" src="" alt="Gambar Buku" height="250" width="250" style="display: none;">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Detail Data <?= $submenu[4] ?></h3>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-striped table-hover">
                                <tbody id="detail-table"></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <?php
    } else if($_REQUEST['submenu'] == strtolower(str_replace(' ','-',$submenu[5]))){ //Rak
        ?>
        <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[5] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-rak" data-target="<?= $route['data-rak']['crud'][2] ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama rak</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama_rak" name="nama_rak" class="form-control" placeholder="Nama rak" data-target="<?= $route['data-rak']['check'][0] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[5] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-rak" data-target="<?= $route['data-rak']['crud'][4] ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama rak</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama_rak" name="nama_rak" class="form-control" placeholder="Nama rak" data-target="<?= $route['data-kategori']['check'][1] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <?php
    }
} elseif (@$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[1]))) {
    if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[6]))) {?>
        <div class="modal fade" id="addModal">
            <div class="modal-dialog modal-lg animated zoomIn">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title text-center">Tambah Data <?= $submenu[6] ?></h3>
                    </div>
                    <form class="form-horizontal" method="post" role="form" id="add-peminjaman" data-target="<?= ($route['data-peminjaman']['crud'][2]) ?>">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Tanggal Tempo</label>
                                <div class="col-xs-9">
                                    <input type='text' id="durasi" name="durasi" class="form-control date" />
                                </div>
                            </div>
                            <div class="form-group">
                                <h4 class="col-xs-12 text-center">List Buku <small class="text-red"><i>Pilih item yang akan dipinjam dengan checklist</i></small></h4>
                            </div>
                            <table id="table_peminjaman" name="table_peminjaman" class="table table-bordered table-striped table-hover table_peminjaman" data-target="<?= ($route['data-peminjaman']['crud'][1]) ?>">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Buku</th>
                                        <th>Kategori Buku</th>
                                        <th>Stok</th>
                                        <th>Pinjam</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="list_peminjaman"></tbody>
                            </table>
                            <!-- <div class="text-center" id="box-load" style="display: block;" data-target="<?= ($route['data-peminjaman']['crud'][7]) ?>">
                                <button id="loadmore" name="loadmore" type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Klik tombol load more untuk menampilkan data selanjutnya">Load more</button>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                <span class="fa fa-save"></span> &nbsp;Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[6] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-peminjaman" data-target="<?= $route['data-peminjaman']['crud'][4] ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                            <?php if (hasPermit('cek_status')) { ?>
                                <div class="form-group"  >
                                    <div class="col-xs-9">
                                        <select class="form-control" id="status" name="status" style="display:none;">
                                            <option hidden selected disabled value="">Pilih Status</option>
                                            <option hidden value="0">Pending</option>
                                            <option hidden value="1">Setuju</option>
                                            <option hidden value="2">Tolak</option>
                                        </select>
                                    </div>
                                </div>
                            <?php } else {?>
                                <div class="form-group" >
                                    <label class="col-xs-3 control-label">Status</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="status" name="status">
                                            <option selected disabled value="">Pilih Status</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Setuju</option>
                                            <option value="2">Tolak</option>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Tanggal Tempo</label>
                                    <div class="col-xs-9">
                                        <input type='text' id="durasi_edit" name="durasi_edit" class="form-control date" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h4 class="col-xs-12 text-center">List Buku <small class="text-red"><i>Pilih item yang akan ditambah dengan checklist</i></small></h4>
                                </div>
                                <table id="table_peralatan" name="table_peralatan" class="table table-bordered table-striped table-hover table_peralatan">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama peralatan</th>
                                            <th>Jenis</th>
                                            <th style="width: 10% !important;">Stok</th>
                                            <th style="width: 10% !important;">Dipinjam</th>
                                            <th>Tambah</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_peralatan_edit"></tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
        <div class="modal fade" id="detailModal">
            <div class="modal-dialog modal-lg animated zoomIn">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title text-center">Detail Data <?= $submenu[6] ?></h3>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped table-hover">
                            <tbody id="detail-peminjam"></tbody>
                        </table>
                        <table class="table table-bordered table-striped table-hover table_detail_peminjaman">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode peminjaman</th>
                                    <th>Nama peminjaman</th>
                                    <th>Jenis peminjaman</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="detail-peminjaman"></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    <?php } 
    elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[7]))) {
        ?>
        <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn" style="width: 100% !important; margin: 0px auto !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[7] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-pengembalian" data-target="<?= ($route['data-pengembalian']['crud'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Kode</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="kode" name="kode" class="form-control" placeholder="Kode Peminjaman" data-target="<?= $route['data-pengembalian']['check'][0] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-danger" id="reset_pengembalian">
                                    <span class="fa fa-refresh"></span> &nbsp;Reset
                                </button>
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <?php
    } 
        
}?>