<?php

  include '../../koneksi.php';

  session_start();

  if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
  }

  if ($_SESSION['role'] != 'admin') {
    header("Location: ../logout.php"); // Redirect user ke Login
    exit();
  }

$query = mysqli_query($koneksi, "SELECT * FROM peminjaman_ruangan ORDER BY id DESC");

if (!$query) {
  die("Query gagal: " . mysqli_error($koneksi));
}
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
                <img src="../../dist/img/admin-160x160.png" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $_SESSION['username']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="../../dist/img/admin-160x160.png" class="img-circle" alt="User Image">
                  <p>
                    <?php echo $_SESSION['username']; ?>
                    <small>Admin since Mar. 2025</small>
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
            <img src="../../dist/img/admin-160x160.png" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $_SESSION['username']; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li>
            <a href="../calendar_admin.php">
              <i class="fa fa-calendar"></i> <span>Calendar</span>
            </a>
          </li>
          <li class="treeview active">
            <a href="#">
              <i class="fa fa-table"></i> <span>Jadwal</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active"><a href="jadwal.php"><i class="fa fa-circle-o"></i> Kelola Jadwal</a></li>
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
          Kelola Jadwal
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
                      <th style="text-align:center">Aksi</th>
                      <th style="text-align:center">Upload Surat Persetujuan</th>
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
                            Tidak ada file
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php if (!empty($row['surat_persetujuan'])): ?>
                            <a href="../uploads/persetujuan/<?php echo $row['surat_persetujuan']; ?>" target="_blank">Lihat</a>
                          <?php else: ?>
                            Belum diupload
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
                          <div style="display: flex; gap: 8px;">
                            <a href="update_status.php?id=<?= $row['id']; ?>&status=Disetujui" class="btn btn-success btn-sm">Setujui</a>
                            <a href="update_status.php?id=<?= $row['id']; ?>&status=Ditolak" class="btn btn-danger btn-sm">Tolak</a>
                          </div>
                        </td>
                        <td>
                          <form action="update_persetujuan.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="file" name="surat_persetujuan" accept="application/pdf" required>
                            <button type="submit">Upload</button>
                          </form>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>
      </section>
      <!-- /.content -->
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

  <?php if (isset($_GET['status'])): ?>
  <!-- Modal -->
  <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: <?= $_GET['status'] == 'berhasil' ? '#5cb85c' : '#d9534f' ?>; color: white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="statusModalLabel">
            <?= $_GET['status'] == 'berhasil' ? 'Berhasil!' : 'Gagal!' ?>
          </h4>
        </div>
        <div class="modal-body">
          <?= $_GET['status'] == 'berhasil' ? 'Status peminjaman berhasil diperbarui.' : 'Terjadi kesalahan saat memperbarui status.' ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Script untuk otomatis tampilkan modal -->
  <script>
    $(document).ready(function() {
      $('#statusModal').modal('show');
    });
  </script>
  <?php endif; ?>

  <?php if (isset($_GET['modal']) && isset($_GET['message'])): ?>
  <!-- Modal Bootstrap -->
  <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 10px;">
        <div class="modal-header" style="color:white; border-top-left-radius: 10px; border-top-right-radius: 10px; background-color: <?php echo $_GET['modal'] === 'success' ? '#5cb85c' : '#d9534f'; ?>">
          <h4 class="modal-title" id="statusModalLabel">
              <?php echo $_GET['modal'] === 'success' ? 'Berhasil!' : 'Gagal!'; ?>
          </h4>
        </div>
        <div class="modal-body">
          <?php echo htmlspecialchars(urldecode($_GET['message'])); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Script untuk memunculkan modal -->
  <script>
    $(document).ready(function(){
        $("#statusModal").modal('show');
    });
  </script>
  <?php endif; ?>

</body>
</html>