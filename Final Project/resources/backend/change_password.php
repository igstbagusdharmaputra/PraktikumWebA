<div class="col-md-6 col-xs-12">
    <div class="box box-primary">
        <div class="box-header">
            <h4 class="box-title">Form Password</h4>
        </div>
        <div class="box-body">
            <!-- Form Password -->
            <form class="form-horizontal" method="post" role="form" id="formpassword" data-remote="<?= ($route['data-password']['remote']); ?>" data-target="<?= ($route['data-password']['crud'][0]); ?>" data-session="<?= ($_SESSION['username']); ?>">
                <div class="form-group">
                    <label class="col-md-3 control-label">Kata Sandi Lama</label>
                    <div class="col-md-9">
                        <input type="password" id="passwordlama" name="passwordlama" class="passlama form-control" placeholder="Kata Sandi Lama" data-target="<?= ($route['data-password']['crud'][1])?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Kata Sandi Baru</label>
                    <div class="col-md-9">
                        <input type="password" id="passwordbaru" name="passwordbaru" class="form-control passbaru" placeholder="Kata Sandi Baru">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Konfirmasi Kata Sandi</label>
                    <div class="col-md-9">
                        <input type="password" id="konfirmasipassword" name="konfirmasipassword" class="form-control konfirpass" placeholder="Konfirmasi Kata Sandi">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="pull-right">
                            <button type="submit" name="updatepassword" class="btn btn-primary">
                                <span class="glyphicon glyphicon-refresh"></span> &nbsp;Ubah Password
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Form Password -->
        </div>
    </div> 
</div>
<script src="<?= BASE_URL ?>assets/js/page/password.js"></script>