<?php

  include '../../koneksi.php';

  session_start();

  if (!isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit();
  }

  if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
  }

  if ($_SESSION['role'] == 'admin') {
  header("Location: ../logout.php"); // Redirect admin ke halaman login
  exit();
  }

  $email = $_SESSION['email'];
  $query = mysqli_query($koneksi, "SELECT * FROM peminjaman_ruangan WHERE email_user = '$email'");

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIPARUNG</title>
  <link rel="icon" type="image/x-icon" href="../../dist/img/favicon.ico">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SPR</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SIPARUNG</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../../dist/img/user-160x160.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['username']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../../dist/img/user-160x160.png" class="img-circle" alt="User Image">
                <p>
                  <?php echo $_SESSION['username']; ?>
                  <small>Member</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="../logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../../dist/img/user-160x160.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['username']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li>
            <a href="../calendar.php">
                <i class="fa fa-calendar"></i> <span>Calendar</span>
            </a>
        </li>
        <li class="active">
            <a href="../tables/mading.php">
                <i class="fa fa-table"></i> <span>Jadwal</span>
            </a>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-edit"></i> <span>Forms</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="active"><a href="../forms/form.php"><i class="fa fa-circle-o"></i>Form Peminjaman Ruangan</a></li>
            </ul>
        </li>
        
    </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mading Jadwal
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List Peminjaman</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table">
                <thead>
                  <tr>
                    <th style="text-align:center">ID</th>
                    <th style="text-align:center">Nama Agenda</th>
                    <th style="text-align:center">Nama Ruangan</th>
                    <th style="text-align:center">Tanggal Mulai</th>
                    <th style="text-align:center">Tanggal Selesai</th>
                    <th style="text-align:center">Jam Mulai</th>
                    <th style="text-align:center">Jam Selesai</th>
                    <th style="text-align:center">Peminjam</th>
                    <th style="text-align:center">Surat Permohonan</th>
                    <th style="text-align:center">Surat Persetujuan</th>
                    <th style="text-align:center">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $no = 1;
                  while ($row = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= htmlspecialchars($row['nama_agenda']); ?></td>
                      <td><?= htmlspecialchars($row['nama_ruangan']); ?></td>
                      <td><?= htmlspecialchars($row['tanggal_mulai']); ?></td>
                      <td><?= htmlspecialchars($row['tanggal_selesai']); ?></td>
                      <td><?= htmlspecialchars(date("H:i", strtotime($row['jam_mulai']))); ?></td>
                      <td><?= htmlspecialchars(date("H:i", strtotime($row['jam_selesai']))); ?></td>
                      <td><?= htmlspecialchars($row['peminjam']); ?></td>
                      <td>
                          <?php if (!empty($row['surat_permohonan'])): ?>
                              <a href="../uploads/permohonan/<?php echo $row['surat_permohonan']; ?>" target="_blank">Lihat</a>
                          <?php else: ?>
                              Tidak ada
                          <?php endif; ?>
                      </td>
                      <td>
                          <?php if (!empty($row['surat_persetujuan'])): ?>
                              <a href="../uploads/persetujuan/<?php echo $row['surat_persetujuan']; ?>" target="_blank">Lihat</a>
                          <?php else: ?>
                              Belum tersedia
                          <?php endif; ?>
                      </td>
                      <td>
                        <?php 
                        if ($row['status'] == 'pending') { ?>
                          <span class="label label-warning">Pending</span>
                        <?php } elseif ($row['status'] == 'disetujui') { ?>
                          <span class="label label-success">Disetujui</span>
                        <?php } else { ?>
                          <span class="label label-danger">Ditolak</span>
                        <?php } ?>
                      </td>
                      <td>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2025 <a href="https://bkpsdm.samarindakota.go.id/new/home">BKPSDM</a>.</strong> All rights
    reserved.
  </footer>
</div>

<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>