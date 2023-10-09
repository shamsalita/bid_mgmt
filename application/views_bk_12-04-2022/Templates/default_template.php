<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/fontawesome-free/css/all.min.css'; ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'; ?>">
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'; ?>">
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'; ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/dist/css/adminlte.min.css'; ?>">
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/dist/css/bootstrap-datepicker.css'; ?>">
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/dist/css/custom.css'; ?>">
  <link rel="icon" href="<?php echo base_url(); ?>assets/dist/img/Vector.svg" sizes="192x192" />
</head>
<body class="hold-transition sidebar-mini">
  <?php
  $user_data = $this->session->userdata('user');
  ?>
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php
    if($user_data['role'] == 1){
      $user_role = 'admin/';
    ?>
    <a href="<?php echo base_url(); ?>admin/home" class="brand-link">
    <?php
    }else{
      $user_role = 'user/';
    ?>
    <a href="<?php echo base_url(); ?>user/home" class="brand-link">
    <?php
    }
    ?>
    <img src="<?php echo base_url(); ?>assets/dist/img/Group_1000000778.png" alt="Logo" class="brand-image">
      <span class="brand-text font-weight-light">&nbsp;</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block"><?php echo $this->session->userdata('user')['first_name'] . ' ' . $this->session->userdata('user')['last_name'] ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <?php
              $bids_active = '';
              if($this->uri->segment(2) == 'bids'){
                $bids_active = ' active';
              }
            ?>
            <a href="<?php echo base_url() . $user_role; ?>bids" class="nav-link<?php echo $bids_active; ?>">
              <i class="nav-icon fa fa-gavel"></i>
              <p>
                Bids
              </p>
            </a>
          </li>
          <?php
          if($user_data['role'] == 1 || $user_data['role'] == 3){
          ?>
          <li class="nav-item">
            <?php
              $reports_active = '';
              if($this->uri->segment(2) == 'report'){
                $reports_active = ' active';
              }
            ?>
            <a href="<?php echo base_url(); ?>admin/report" class="nav-link<?php echo $reports_active; ?>">
              <i class="nav-icon fa fa-chart-bar"></i>
              <p>
                Report
              </p>
            </a>
          </li>
          <?php
          }
          ?>
          <li class="nav-item">
            <?php
            if($user_data['role'] == 1){
              $users_active = '';
              if($this->uri->segment(2) == 'users' || $this->uri->segment(2) == 'add_user' || $this->uri->segment(2) == 'edit_user'){
                $users_active = ' active';
              }
            ?>
            <a href="<?php echo base_url(); ?>admin/users" class="nav-link<?php echo $users_active; ?>">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Users
              </p>
            </a>
            <?php
            }
            ?>
          </li>
          <li class="nav-item">
          <?php
            $change_pass_active = '';
            if($this->uri->segment(2) == 'change_password'){
              $change_pass_active = ' active';
            }
          ?>
            <a href="<?php echo base_url() . $user_role; ?>change_password" class="nav-link<?php echo $change_pass_active; ?>">
              <i class="fa fa-lock"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>logout" class="nav-link">
            <i class="nav-icon fa fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
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
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; <?php echo date('Y'); ?> Alita Infotech.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/fontawesome-free/css/all.min.css'; ?>">
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/common.js?v=<?php echo time(); ?>"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
