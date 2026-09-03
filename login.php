<?php



require_once("include/initialize.php");
  if(isset($_SESSION['UID'])){
    redirect("index.php");
    header("Location: index.php");
  }

  // Handle login submission FIRST, before any HTML is output,
  // so we can redirect cleanly with an error code instead of alert().
  if(isset($_POST['btnLogin'])){

    $email   = trim($_POST['username']);
    $upass   = trim($_POST['userpass']);
    $h_upass = sha1($upass);

    if ($email == '' OR $upass == '') {

      header("Location: login.php?error=empty");
      exit;

    } else {

      $user = new User();
      $res  = $user::AuthenticateUser($email, $h_upass);

      if ($res == true) {

        if ($_SESSION['TYPE']=='Administrator' || $_SESSION['TYPE']=='Doctor' || $_SESSION['TYPE']=='Staff'){
          header("Location: index.php");
          exit;
        } else {
          // Valid login, but this account type isn't allowed to log in here.
          session_unset();
          session_destroy();
          header("Location: login.php?error=denied");
          exit;
        }

      } else {
        header("Location: login.php?error=invalid");
        exit;
      }
    }
  }

  // Build the error message (if any) shown in the animated banner below.
  $loginError = '';
  if (isset($_GET['error'])) {
    switch ($_GET['error']) {
      case 'empty':
        $loginError = 'Please enter both your username and password.';
        break;
      case 'invalid':
        $loginError = 'Account does not exist or password is incorrect.';
        break;
      case 'denied':
        $loginError = 'This account does not have permission to log in here.';
        break;
      default:
        $loginError = 'Something went wrong. Please try again.';
    }
  }
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>JUSTIN SOLUTIONS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo  WEB_ROOT;?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo  WEB_ROOT;?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo  WEB_ROOT;?>dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

<!-- Tiger palette override -->
<style>
  body.login-page {
    background-color: #1A1A1A !important;
    position: relative;
    overflow: hidden;
  }
  body.login-page::before {
    content: "";
    position: fixed;
    top: 60%; left: 50%;
    width: 900px; height: 900px;
    background-image: url('ust-scc.png');
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    transform: translate(-50%, -50%);
    opacity: 0.14;
    pointer-events: none;
  }
  body.login-page::after {
    content: "";
    position: fixed;
    inset: -10%;
    background-image: radial-gradient(circle at 25% 30%, rgba(232,100,26,0.35), transparent 35%),
                       radial-gradient(circle at 75% 70%, rgba(245,185,21,0.3), transparent 40%),
                       radial-gradient(circle at 50% 100%, rgba(179,38,30,0.25), transparent 40%);
    pointer-events: none;
    animation: glowDrift 5s ease-in-out infinite alternate;
  }
  @keyframes glowDrift {
    0%   { transform: translate(0, 0) scale(1); }
    50%  { transform: translate(-3%, 2%) scale(1.06); }
    100% { transform: translate(2%, -3%) scale(1); }
  }
  .login-box {
    position: relative;
    z-index: 1;
    opacity: 0;
    animation: cardRise 0.8s ease-out 0.15s forwards;
  }
  @keyframes cardRise {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .login-card-body center img {
    animation: logoPulse 3s ease-in-out infinite;
  }
  @keyframes logoPulse {
    0%, 100% { transform: scale(1); }
    50%      { transform: scale(1.035); }
  }
  .input-group {
    opacity: 0;
    animation: fieldFade 0.6s ease-out forwards;
  }
  .input-group:nth-of-type(1) { animation-delay: 0.5s; }
  .input-group:nth-of-type(2) { animation-delay: 0.65s; }
  .row { opacity: 0; animation: fieldFade 0.6s ease-out 0.8s forwards; }
  @keyframes fieldFade {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .btn-success {
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }
  .btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(232,100,26,0.4);
  }
  .login-box .card,
  .login-box .card-body,
  .login-card-body {
    background-color: rgba(20,20,20,0.32) !important;
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border: 1px solid rgba(245,185,21,0.35);
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.45), inset 0 1px 0 rgba(255,255,255,0.08);
  }
  .login-box .card { border-top: 3px solid #F5B915; }
  .login-box-msg {
    color: #FAFAFA;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0,0,0,0.6);
  }
  .form-control {
    background-color: rgba(255,255,255,0.12) !important;
    border: 1px solid rgba(255,255,255,0.3) !important;
    color: #FAFAFA !important;
  }
  .form-control::placeholder { color: #E5E5E5 !important; }
  .input-group-text { background-color: rgba(255,255,255,0.12) !important; border: 1px solid rgba(255,255,255,0.3) !important; color: #F5B915 !important; }
  .btn-success { background-color: #E8641A !important; border-color: #E8641A !important; }
  .btn-success:hover { background-color: #C6540F !important; border-color: #C6540F !important; }

  .login-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(179,38,30,0.20);
    border: 1px solid rgba(255,107,74,0.55);
    color: #FFE1D9;
    padding: 10px 14px;
    border-radius: 10px;
    margin-bottom: 16px;
    font-size: 0.88rem;
    font-weight: 500;
    line-height: 1.3;
    animation: alertFadeIn 0.35s ease-out, alertShake 0.5s ease-out 0.35s;
  }
  .login-alert i {
    color: #FF6B4A;
    font-size: 1.05rem;
    flex-shrink: 0;
  }
  @keyframes alertFadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes alertShake {
    10%, 90% { transform: translateX(-1px); }
    20%, 80% { transform: translateX(2px); }
    30%, 50%, 70% { transform: translateX(-4px); }
    40%, 60% { transform: translateX(4px); }
  }
</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <center>
       <img src="ust-scc.png" width="50%"></center>
      <p class="login-box-msg">Login to start your session</p>

      <?php if ($loginError): ?>
      <div class="login-alert" id="loginAlert">
        <i class="fas fa-exclamation-triangle"></i>
        <span><?php echo htmlspecialchars($loginError); ?></span>
      </div>
      <?php endif; ?>

      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="userpass" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">

            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="btnLogin" class="btn btn-success btn-block"><i class="fas fa-sign-in-alt">Log in</i></button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <!-- /.social-auth-links -->

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo  WEB_ROOT;?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo  WEB_ROOT;?>dist/js/adminlte.min.js"></script>

</body>
</html>