<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LOGIN - PAGE </title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css')?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('plugins/icheck-bootstrap/icheck-bootstrap.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css')?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <?php $successFlash = session()->getFlashdata('success'); ?>
<?php if (isset($successFlash)): ?>
    <div class="row" id="myDiv">
        <div class="alert alert-success">
            <?= $successFlash ?>
        </div>
    </div>
<?php endif; ?>
<?php $errorFlash = session()->getFlashdata('error'); ?>
<?php if (isset($errorFlash)): ?>
    <div class="row" id="myDiv">
        <div class="alert alert-danger">
            <?= $errorFlash ?>
        </div>
    </div>
<?php endif; ?>
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= base_url('https://www.fes-marketing.net/')?>" target="_blank" class="h1"><b>FMS Gestion</b></a>
    </div>
    <div class="card-body">

      <form action="/logged" method="post">
        <?= csrf_field() ?>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row" style="display:flex;justify-content:center">
          <div class="col-4">
            <button type="submit" class="btn btn-outline-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="<?= base_url('plugins/jquery/jquery.min.js')?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('dist/js/adminlte.min.js')?>"></script>
</body>
</html>
