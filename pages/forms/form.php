<?php

  include '../../koneksi.php';

  session_start();

  if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
  }

  $query = mysqli_query($koneksi, "SELECT * FROM ruangan");

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
  <!-- daterange picker -->
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../plugins/select2/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!-- jQuery dan Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
            <a><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <ul class="sidebar-menu">
          <li>
            <a href="../calendar.php">
              <i class="fa fa-calendar"></i> <span>Calendar</span>
            </a>
          </li>
          <li>
            <a href="../tables/mading.php">
              <i class="fa fa-table"></i> <span>Jadwal</span>
            </a>
          </li>
          <li class="treeview active">
            <a href="#">
              <i class="fa fa-edit"></i> <span>Forms</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active"><a href="form.php"><i class="fa fa-circle-o"></i>Form Peminjaman Ruangan</a></li>
            </ul>
          </li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <section class="content">

        <div class="row">
          <div class="col-md-auto">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Form Peminjaman Ruang</h3>
              </div>
              <div class="box-body">
                <form action="proses_form.php" method="POST" enctype="multipart/form-data">
                  <!-- Date -->
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Agenda</label>
                    <input type="text" name="nama_agenda" class="form-control" id="exampleInputEmail1" placeholder="Nama Agenda" required>
                  </div>

                  <div class="form-group">
                    <label>Nama Ruang</label>
                    <select name="nama_ruangan" class="form-control select2" style="width: 100%;" required>
                      <option value="" disabled selected>Pilih Ruangan</option>
                      <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                          <option value="<?= $row['nama_ruangan']; ?>"><?= $row['nama_ruangan']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Tanggal Mulai:</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" name="tanggal_mulai" class="form-control pull-right" required>
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->

                  <div class="form-group">
                    <label>Tanggal Selesai:</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" name="tanggal_selesai" class="form-control pull-right" required>
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->

                  <div class="bootstrap-timepicker">
                    <div class="form-group">
                      <label>Jam Mulai:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-clock-o"></i>
                        </div>
                        <input type="text" id="jam_mulai" name="jam_mulai" class="form-control timepicker" required>
                      </div>
                    </div>
                  </div>

                  <div class="bootstrap-timepicker">
                    <div class="form-group">
                      <label>Jam Selesai:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-clock-o"></i>
                        </div>
                        <input type="text" id="jam_selesai" name="jam_selesai" class="form-control timepicker" required>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Peminjam</label>
                    <input type="text" name="peminjam" class="form-control" id="exampleInputEmail1" placeholder="Nama Peminjam">
                  </div>

                  <div class="form-group">
                    <label for="surat_permohonan">Upload Surat Permohonan (PDF)</label>
                    <input type="file" name="surat_permohonan" accept="application/pdf" required>
                    <p class="help-block">Maximum 1 MB</p>
                  </div>

                  <div class="box-footer">
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2025 <a href="https://bkpsdm.samarindakota.go.id/new/home">BKPSDM</a>.</strong> All rights
      reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery 2.2.3 -->
  <script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <!-- Select2 -->
  <script src="../../plugins/select2/select2.full.min.js"></script>
  <!-- InputMask -->
  <script src="../../plugins/input-mask/jquery.inputmask.js"></script>
  <script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <!-- date-range-picker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
  <!-- bootstrap time picker -->
  <script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <!-- SlimScroll 1.3.0 -->
  <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- iCheck 1.0.1 -->
  <script src="../../plugins/iCheck/icheck.min.js"></script>
  <!-- FastClick -->
  <script src="../../plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
  <!-- Page script -->
  <script>
    $(function () {
      //Initialize Select2 Elements
      $(".select2").select2();

      //Datemask dd/mm/yyyy
      $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
      //Datemask2 mm/dd/yyyy
      $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
      //Money Euro
      $("[data-mask]").inputmask();

      //Date range picker
      $('#reservation').daterangepicker();
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
      //Date range as a button
      $('#daterange-btn').daterangepicker(
          {
            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
          },
          function (start, end) {
            $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
          }
      );

      //Date picker
      $('#datepicker').datepicker({
        autoclose: true
      });

      //Timepicker
      $(".timepicker").timepicker({
        format: 'HH:mm',
        showMeridian: false,
        showInputs: false,
        todayHighlight: true
      });
    });
  </script>

  <!-- Modal Bootstrap untuk status -->
  <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #5cb85c; color: white;">
          <h4 class="modal-title" id="statusModalLabel">Berhasil!</h4>
        </div>
        <div class="modal-body">
          <?php
          if (isset($_GET['status'])) {
            if ($_GET['status'] == 'sukses') {
              echo "Peminjaman Berhasil Diajukan, Mohon Menunggu Verifikasi";
            } else {
              echo "Gagal menambahkan data";
            }
          }
          ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <?php if (isset($_GET['status'])): ?>
  <script>
    $(document).ready(function() {
      $('#statusModal').modal('show');
    });
  </script>
  <?php endif; ?>

  <!-- Modal Bootstrap untuk notifikasi -->
  <div class="modal fade" id="notifikasiModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content" style="border-radius: 10px;">
        <div class="modal-header" style="background-color: #d9534f;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modalLabel">Gagal!</h4>
        </div>
        <div class="modal-body">
          <?php if (isset($_GET['error'])): ?>
            <p><?= htmlspecialchars($_GET['error']) ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Trigger modal jika error dikirim -->
  <?php if (isset($_GET['error'])): ?>
  <script>
    $(document).ready(function () {
      $('#notifikasiModal').modal('show');
    });
  </script>
  <?php endif; ?>

</body>
</html>