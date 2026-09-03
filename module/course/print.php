<?php
require_once("../../include/initialize.php");
global $mydb;

$single = null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
	$mydb->setQuery("SELECT `course_code`, `course_name`, `created_at` FROM `tblcourses` WHERE `course_id` = '".$id."' LIMIT 1");
	$single = $mydb->loadSingleResult();
} else {
	$mydb->setQuery("SELECT `course_code`, `course_name`, `created_at` FROM `tblcourses` ORDER BY `course_code` ASC");
	$courses = $mydb->loadResultList();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $single ? 'Course - ' . htmlspecialchars($single->course_code) : 'List of Courses'; ?> - Print</title>
  <style>
    :root {
      --ink: #1A1A1A;
      --gold: #F5B915;
      --gold-bg: #fdf3d6;
      --orange: #E8641A;
      --red: #B3261E;
      --muted: #8a8a8a;
      --panel: #f7f7f6;
      --border: #e6e6e2;
      --border-strong: #cfcfc8;
    }
    * { box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
      color: var(--ink);
      margin: 0;
      padding: 0;
      background: #f2f2f2;
    }
    .page {
      max-width: 880px;
      margin: 30px auto;
      background: #fff;
      box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    }

    .top-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      background: var(--ink);
      border-bottom: 3px solid var(--gold);
    }
    .brand-mini { display: flex; align-items: center; gap: 10px; }
    .brand-mini img {
      width: 34px; height: 34px; object-fit: contain;
    }
    .brand-mini .name { font-weight: 700; font-size: 14px; color: var(--gold); letter-spacing: 0.3px; }
    .brand-mini .sub { font-size: 9px; color: #cfcfcf; text-transform: uppercase; letter-spacing: 1px; }

    .pill {
      font-size: 10px;
      font-weight: 700;
      color: var(--ink);
      background: var(--gold);
      padding: 5px 12px;
      border-radius: 6px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .main { padding: 26px 40px 30px; }

    .title-block { margin: 0 0 6px; }
    .title-block h1 {
      margin: 0;
      font-size: 22px;
      font-weight: 700;
    }
    .title-block .meta {
      font-size: 12px;
      color: var(--muted);
      margin-top: 4px;
    }

    .stat-row {
      display: flex;
      gap: 12px;
      margin: 22px 0 8px;
    }
    .stat-box {
      flex: 1;
      background: #fff;
      border: 1px solid var(--border);
      border-left: 3px solid var(--orange);
      border-radius: 8px;
      padding: 14px 16px;
    }
    .stat-box .k { font-size: 9px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 700; }
    .stat-box .v { font-size: 16px; font-weight: 700; margin-top: 4px; color: var(--ink); }
    .stat-box.wide { flex: 2; }

    table { width: 100%; border-collapse: collapse; margin-top: 22px; }
    th, td { padding: 10px 8px; text-align: left; font-size: 13px; }
    thead th {
      border-bottom: 2px solid var(--ink);
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--muted);
      font-weight: 700;
    }
    tbody tr { border-bottom: 1px solid var(--border); }
    tbody tr:hover { background: var(--panel); }

    .row-num {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 22px;
      height: 22px;
      border-radius: 6px;
      background: var(--ink);
      color: var(--gold);
      font-size: 11px;
      font-weight: 700;
    }
    .code-chip {
      display: inline-block;
      padding: 3px 9px;
      border-radius: 6px;
      background: var(--gold-bg);
      color: #8a640b;
      font-size: 12px;
      font-weight: 700;
    }

    .bottom-bar {
      margin-top: 30px;
      padding-top: 14px;
      border-top: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      font-size: 10px;
      color: var(--muted);
    }

    @media print {
      body { background: #fff; }
      .page { box-shadow: none; margin: 0; max-width: 100%; }
      button { display: none; }
    }
  </style>
</head>
<body>
<div class="page">

  <div class="top-row">
    <div class="brand-mini">
      <img src="<?php echo WEB_ROOT; ?>ust-scc.png" alt="Justin Solution">
      <div>
        <div class="name">JUSTIN SOLUTION</div>
        <div class="sub">Academic Records</div>
      </div>
    </div>
    <div class="pill"><?php echo $single ? 'Course Record' : 'Course Registry'; ?></div>
  </div>

  <div class="main">

    <div class="title-block">
      <h1><?php echo $single ? 'Course Details' : 'List of Courses'; ?></h1>
      <div class="meta">Printed <?php echo date('F j, Y \a\t h:i A'); ?> &nbsp;&middot;&nbsp; Ref: COURSE-<?php echo $single ? str_pad($id, 4, '0', STR_PAD_LEFT) : date('Ymd'); ?></div>
    </div>

    <?php if ($single): ?>

      <div class="stat-row">
        <div class="stat-box">
          <div class="k">Course Code</div>
          <div class="v"><span class="code-chip"><?php echo htmlspecialchars($single->course_code); ?></span></div>
        </div>
        <div class="stat-box">
          <div class="k">Created At</div>
          <div class="v" style="font-size:13px;"><?php echo htmlspecialchars($single->created_at); ?></div>
        </div>
      </div>
      <div class="stat-row">
        <div class="stat-box wide">
          <div class="k">Course Name</div>
          <div class="v"><?php echo htmlspecialchars($single->course_name); ?></div>
        </div>
      </div>

    <?php elseif ($id > 0 && !$single): ?>

      <p style="color:var(--muted);">Course not found.</p>

    <?php else: ?>

      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; foreach ($courses as $c): ?>
          <tr>
            <td><span class="row-num"><?php echo $i++; ?></span></td>
            <td><span class="code-chip"><?php echo htmlspecialchars($c->course_code); ?></span></td>
            <td><?php echo htmlspecialchars($c->course_name); ?></td>
            <td><?php echo htmlspecialchars($c->created_at); ?></td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($courses)): ?>
          <tr><td colspan="4" style="text-align:center;">No courses found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>

    <?php endif; ?>

    <div class="bottom-bar">
      <span>JUSTIN SOLUTION &copy; <?php echo date('Y'); ?></span>
      <span>Generated automatically &mdash; Course Module</span>
    </div>

  </div>
</div>
  <script>
    window.onload = function () {
      window.print();
    };
  </script>
</body>
</html>