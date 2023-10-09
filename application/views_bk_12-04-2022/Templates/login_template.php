<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link href="<?php echo base_url() . 'assets/plugins/fontawesome-free/css/all.min.css'; ?>" rel="stylesheet" />
  <!-- icheck bootstrap -->
  <link href="<?php echo base_url() . 'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'; ?>" rel="stylesheet" />
  <!-- Theme style -->
  <link href="<?php echo base_url() . 'assets/dist/css/adminlte.min.css'; ?>" rel="stylesheet" />
  <link rel="icon" href="<?php echo base_url(); ?>assets/dist/img/Vector.svg" sizes="192x192" />
</head>
<body class="hold-transition login-page">

<?php
if ($this->session->flashdata('success') != '') {
    ?>
    <div class="alert alert-success no-border">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
    <?php
}
?>
<?php
if ($this->session->flashdata('error') != '') {
    ?>
    <div class="alert alert-danger no-border">
        <?php
        echo $this->session->flashdata('error');
        ?>
    </div>
    <?php
}
?>
<?php echo $body; ?>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo base_url() . 'assets/plugins/jquery/jquery.min.js'; ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() . 'assets/plugins/bootstrap/js/bootstrap.bundle.min.js'; ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() . 'assets/dist/js/adminlte.min.js'; ?>"></script>
</body>
</html>
