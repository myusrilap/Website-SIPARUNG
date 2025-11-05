<?php
include '../koneksi.php';
session_start();

if (isset($_SESSION['username'])) {
    // Jika user sudah login, langsung arahkan sesuai role
    if ($_SESSION['role'] == 'admin') {
        header("Location: tables/jadwal.php");
        exit();
    } elseif ($_SESSION['role'] == 'user') {
        header("Location: calendar.php");
        exit();
    }
}

$modalType = "";
$modalMessage = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = hash('sha256', $_POST['password']);

    $sql = "SELECT * FROM akun WHERE email='$email' AND password='$password'";
    $result = mysqli_query($koneksi, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['email'] = $row['email'];

        $modalType = "success";
        $modalMessage = "Selamat datang, Anda berhasil login.";

        // Redirect berdasarkan role setelah 2 detik
        if ($row['role'] == 'admin') {
            $redirectPage = "tables/jadwal.php";
        } else {
            $redirectPage = "calendar.php";
        }
    } else {
        $modalType = "error";
        $modalMessage = "Email atau password salah. Silakan coba lagi.";
    }
}

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SIPARUNG</title>
    <link rel="icon" type="image/x-icon" href="../dist/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="csslogin/bootstrap.min.css">
    <link rel="stylesheet" href="csslogin/font-awesome.min.css">
    <link rel="stylesheet" href="csslogin/themify-icons.css">
    <link rel="stylesheet" href="csslogin/metisMenu.css">
    <link rel="stylesheet" href="csslogin/owl.carousel.min.css">
    <link rel="stylesheet" href="csslogin/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="csslogin/typography.css">
    <link rel="stylesheet" href="csslogin/default-css.css">
    <link rel="stylesheet" href="csslogin/styles.css">
    <link rel="stylesheet" href="csslogin/responsive.css">
    <!-- modernizr css -->
    <script src="jslogin/modernizr-2.8.3.min.js"></script>
    <script src="jslogin/jquery-2.2.4.min.js"></script>
    <script src="jslogin/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">
                <form action="" method="POST">
                    <div class="login-form-head">
                        <h4>Sign In</h4>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="inputemail">Email address</label>
                            <input type="email" name="email" id="inputemail" required
                            oninvalid="this.setCustomValidity('Silahkan Isi Email!')"
                            oninput="this.setCustomValidity('')">
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="inputpassword">Password</label>
                            <input type="password" name="password" id="inputpassword" required
                            oninvalid="this.setCustomValidity('Silahkan Isi Password!')"
                            oninput="this.setCustomValidity('')">
                            <div class="text-danger"></div>
                        </div>
                        <div class="row mb-4 rmber-area">
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit" name="submit">Submit</button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="register.php">Sign up</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header <?= ($modalType == 'success') ? 'bg-success' : 'bg-danger'; ?> text-white">
                    <h5 class="modal-title"><?= ($modalType == 'success') ? 'Login Berhasil' : 'Login Gagal'; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <p><?= $modalMessage; ?></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            <?php if ($modalType != ""): ?>
                $('#loginModal').modal('show');
                <?php if ($modalType == 'success'): ?>
                    setTimeout(function() {
                        window.location.href = "<?= $redirectPage; ?>";
                    }, 2000);
                <?php endif; ?>
            <?php endif; ?>
        });
    </script>

    <!-- jquery latest version -->
    <script src="jslogin/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="jslogin/popper.min.js"></script>
    <script src="jslogin/bootstrap.min.js"></script>
    <script src="jslogin/owl.carousel.min.js"></script>
    <script src="jslogin/metisMenu.min.js"></script>
    <script src="jslogin/jquery.slimscroll.min.js"></script>
    <script src="jslogin/jquery.slicknav.min.js"></script>
    
    <!-- others plugins -->
    <script src="jslogin/plugins.js"></script>
    <script src="jslogin/scripts.js"></script>
</body>
</html>