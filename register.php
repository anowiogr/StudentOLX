<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta name="description"
        content="Strona stworzona w celach nauki programowania www. Studencki OLX to strona stworzona, aby przećwiczyć tworzenie kodu w HTML|PHP|JavaScript w powiązaniu z SQL.">
  <link rel="icon"
        type="image/png" href="images/favicon.ico">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <title>Studencki OLX</title>
</head>

<body class="hold-transition register-page">
<div class="register-box">
  <?php
    if (isset($_SESSION["error"])){
      echo <<< ERROR
        <div class="callout callout-danger">
          <h5>Błąd!</h5>
          <p>$_SESSION[error]</p>
        </div>
ERROR;
    unset($_SESSION["error"]);
    }
  ?>

  <div class="card card-outline card-secondary">
    <div class="card-header text-center">
      <a href="./index.php" class="h1"><b>Studencki</b>OLX</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="../scripts/register_user.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Podaj imię" name="firstName">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Podaj nazwisko" name="lastName">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Podaj adres email" name="email1">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Powtórz adres email" name="email2">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Podaj hasło" name="pass1">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Powtórz hasło" name="pass2">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

       <div class="row">
          <div class="col-7">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               Zapoznałem się z <a href="#">regulaminem</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-5">
            <button type="submit" class="btn btn-secondary btn-block">Zarejestruj</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <a href="./login.php" class="text-center">Mam już konto</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
