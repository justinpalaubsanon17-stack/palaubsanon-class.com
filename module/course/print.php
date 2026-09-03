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
      --ink: #172536;
      --navy: #173b5f;
      --gold: #c89b3c;
      --muted: #667384;
      --panel: #f4f6f8;
      --border: #d8dee5;
    }
    * { box-sizing: border-box; }
    body {
      font-family: Arial, Helvetica, sans-serif;
      color: var(--ink);
      margin: 0;
      padding: 32px 20px;
      background: #eef1f4;
    }
    .page {
      max-width: 880px;
      margin: 0 auto;
      background: #fff;
      border-top: 6px solid var(--navy);
      box-shadow: 0 8px 28px rgba(23,37,54,0.09);
    }

    .top-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 24px 44px 20px;
      border-bottom: 1px solid var(--border);
    }
    .brand-mini { display: flex; align-items: center; gap: 13px; }
    .brand-mini img {
      width: 42px; height: 42px; object-fit: contain;
    }
    .brand-mini .name { font-weight: 700; font-size: 15px; color: var(--navy); letter-spacing: 0.4px; }
    .brand-mini .sub { font-size: 9px; color: var(--muted); text-transform: uppercase; letter-spacing: 1.4px; margin-top: 3px; }

    .pill {
      font-size: 9px;
      font-weight: 700;
      color: var(--navy);
      border: 1px solid var(--gold);
      padding: 7px 11px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .main { padding: 34px 44px 30px; }

    .title-block { margin: 0 0 26px; }
    .title-block h1 {
      margin: 0;
      font-size: 25px;
      font-weight: 700;
      color: var(--navy);
    }
    .title-block .meta {
      font-size: 12px;
      color: var(--muted);
      margin-top: 8px;
    }

    .stat-row {
      display: flex;
      gap: 18px;
      margin: 0 0 18px;
    }
    .stat-box {
      flex: 1;
      border: 1px solid var(--border);
      padding: 16px 18px;
    }
    .stat-box .k { font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 700; }
    .stat-box .v { font-size: 16px; font-weight: 700; margin-top: 8px; color: var(--ink); }
    .stat-box.wide { flex: 2; }

    table { width: 100%; border-collapse: collapse; margin-top: 8px; }
    th, td { padding: 13px 12px; text-align: left; font-size: 13px; }
    thead th {
      background: var(--navy);
      border-bottom: 2px solid var(--gold);
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: #fff;
      font-weight: 700;
    }
    tbody tr { border-bottom: 1px solid var(--border); }
    tbody tr:nth-child(even) { background: var(--panel); }

    .row-num {
      color: var(--muted);
      font-size: 12px;
      font-weight: 700;
    }
    .code-chip {
      display: inline-block;
      color: var(--navy);
      font-size: 12px;
      font-weight: 700;
    }

    .bottom-bar {
      margin-top: 36px;
      padding-top: 12px;
      border-top: 2px solid var(--gold);
      display: flex;
      justify-content: space-between;
      font-size: 10px;
      color: var(--muted);
    }

    @media print {
      body { background: #fff; }
      .page { box-shadow: none; margin: 0; max-width: 100%; border-top-width: 4px; }
      .main { padding-bottom: 0; }
      button { display: none; }
    }
    @media (max-width: 620px) {
      body { padding: 0; }
      .top-row, .main { padding-left: 22px; padding-right: 22px; }
      .top-row { align-items: flex-start; gap: 16px; }
      .stat-row { display: block; margin-bottom: 0; }
      .stat-box { margin-bottom: 14px; }
      table { min-width: 620px; }
      .main { overflow-x: auto; }
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