<?php include_once '../master/header.php'; ?>
  <div class="login-box">
    <div class="login-logo">
      <a href="<?= BASE_URL . 'home/' ?>">
        <b><?= APPNAME; ?></b>
      </a>
    </div>
    <div class="login-box-body">
      <p class="login-box-msg">Silahkan Daftar Akun</p>
      <div id="message"></div>
      <form method="POST" id="register">
        <div class="form-group has-feedback">
          <input type="text" id="name" name="name" class="form-control" placeholder="Nama Lengkap">
        </div>
        <div class="form-group has-feedback">
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" data-remote="<?= $route['register']['remote'] ?>" data-target="<?= $route['register']['check'][0] ?>">
        </div>
        <div class="form-group has-feedback">
            <input type="password" id="password1" name="password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group has-feedback">
            <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="Konfirmasi Password">
        </div>
        <div class="row">
          <!--div class="col-xs-4 pull-left">
            <a href="<?= BASE_URL . 'home/' ?>" class="btn btn-default btn-block">Home</a>
          </div-->
          <div class="col-xs-4 pull-right">
            <input type="submit" class="btn btn-info btn-block" value="Register">
          </div>
        </div>
      </form>
    </div>
  </div>
<?php include_once '../master/footer.php'; ?>