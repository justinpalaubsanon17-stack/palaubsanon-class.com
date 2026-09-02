

  <nav class="main-header navbar navbar-expand navbar-dark" style="background-color: #F5B915;">
  <style>
    .main-header.navbar-dark .nav-link { color: #1A1A1A !important; }
    .main-header.navbar-dark .nav-link:hover { color: #E8641A !important; }
  </style>

 <!-- TAGANILE SOLUTIONS - TAGANILE 2025  -->

    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" data-controlsidebar-side="false" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
         Hello <i class="far fa-user"></i>
          <span class="badge navbar-badge" style="background-color:#B3261E;"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right tiger-user-dropdown">

          <div class="tiger-user-card">
            <div class="tiger-user-top">
              <img class="tiger-user-avatar" src="<?php echo WEB_ROOT; ?>module/user/images/admin-avatar.jpg" alt="User avatar">
              <div>
                <div class="tiger-user-name"><?php if (isset($_SESSION['DISPLAYNAME'])) { echo $_SESSION['DISPLAYNAME']; } else { echo "User"; } ?></div>
                <div class="tiger-user-role"><?php if (isset($_SESSION['TYPE'])) { echo $_SESSION['TYPE']; } else { echo "Guest"; } ?></div>
              </div>
            </div>
            <a href="<?php echo WEB_ROOT; ?>logout.php" class="tiger-user-logout">Logout <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>


        </div>
      </li>

    </ul>
  </nav>

  <style>
    .tiger-user-dropdown { padding: 0; border: none; background: transparent; box-shadow: none; }
    .tiger-user-card {
      background-color: rgba(26,26,26,0.85);
      backdrop-filter: blur(6px);
      border-radius: 8px;
      border-top: 3px solid #F5B915;
      padding: 16px;
      min-width: 220px;
    }
    .tiger-user-top { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
    .tiger-user-avatar { width: 48px; height: 48px; border-radius: 50%; border: 2px solid #F5B915; object-fit: cover; }
    .tiger-user-name { color: #FAFAFA; font-weight: 600; font-size: 14px; }
    .tiger-user-role { color: #CFCFCF; font-size: 12px; }
    .tiger-user-logout {
      display: block;
      text-align: right;
      color: #F5B915;
      font-size: 13px;
      border-top: 1px solid rgba(255,255,255,0.15);
      padding-top: 10px;
    }
    .tiger-user-logout:hover { color: #E8641A; }
  </style>
