<?php

$username = "";
$email = "";
$password = "";
$cpassword = "";

$modalType = "";
$modalMessage = "";

include '../koneksi.php';
session_start();

if (isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);
    $cpassword = hash('sha256', $_POST['cpassword']);

    if (strlen($username) > 15) {
        $modalMessage = "Username tidak boleh lebih dari 15 karakter.";
        $modalType = "error";
    } elseif ($password !== $cpassword) {
        $modalMessage = "Password tidak sesuai.";
        $modalType = "error";
    } else {
        $sql = "SELECT * FROM akun WHERE email='$email'";
        $result = mysqli_query($koneksi, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO akun (username, email, password) VALUES ('$username', '$email', '$password')";
            if (mysqli_query($koneksi, $sql)) {
                $modalMessage = "Selamat, pendaftaran berhasil!";
                $modalType = "success";
                $redirect = "login.php";
            } else {
                $modalMessage = "Maaf, terjadi kesalahan saat menyimpan data.";
                $modalType = "error";
            }
        } else {
            $modalMessage = "Email sudah terdaftar.";
            $modalType = "error";
        }
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
                <form action="" method="POST" class="login-email">
                    <div class="login-form-head">
                        <h4>Sign up</h4>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="inputname">Username</label>
                            <input type="text" id="inputname" name="username" maxlength="15" value="<?php echo $username; ?>" required 
                            oninvalid="this.setCustomValidity('Silahkan Isi Username! (Max 15 Karakter)')"
                            oninput="this.setCustomValidity('')">
                        </div>
                        <div class="form-gp">
                            <label for="inputemail">Email address</label>
                            <input type="email" id="inputemail" name="email" value ="<?php echo $email; ?>" required
                            oninvalid="this.setCustomValidity('Silahkan Isi Email!')"
                            oninput="this.setCustomValidity('')">
                        </div>
                        <div class="form-gp">
                            <label for="inputpassword">Password</label>
                            <input type="password" id="inputpassword" name="password" value="<?php echo $_POST['password'] ?? ''; ?>" required
                            oninvalid="this.setCustomValidity('Silahkan Isi Password!')"
                            oninput="this.setCustomValidity('')">
                        </div>
                        <div class="form-gp">
                            <label for="inputpassword2">Confirm Password</label>
                            <input type="password" id="inputpassword2" name="cpassword" value="<?php echo $_POST['cpassword'] ?? ''; ?>" required
                            oninvalid="this.setCustomValidity('Silahkan Isi Konfirmasi Password!')"
                            oninput="this.setCustomValidity('')">
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" name="submit" type="submit">Submit</button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Already have an account? <a href="login.php">Sign in</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- Modal -->
    <?php if (!empty($modalType)) : ?>
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header <?= $modalType == 'success' ? 'bg-success' : 'bg-danger' ?>" style="color:white;">
                    <h4 class="modal-title" id="modalLabel"><?= $modalType == 'success' ? 'Berhasil!' : 'Gagal!' ?></h4>
                </div> 
                <div class="modal-body">
                    <?= $modalMessage ?>
                </div>
                <div class="modal-footer">
                    <?php if ($modalType != 'success') : ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#feedbackModal').modal('show');
        <?php if ($modalType == 'success') : ?>
            setTimeout(function() {
                window.location.href = '<?= $redirect ?>';
            }, 2000); // redirect setelah 2 detik
        <?php endif; ?>
    });
    </script>
    <?php endif; ?>

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

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const usernameInput = document.getElementById("username");
        usernameInput.addEventListener("input", function() {
            if (this.value.length > 15) {
                this.setCustomValidity("Username maksimal 15 karakter.");
            } else {
                this.setCustomValidity("");
            }
        });
    });
    </script>

</body>
</html>