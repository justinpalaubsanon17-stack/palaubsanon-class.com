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
      --gold: #e8a324;
      --gold-deep: #b8790f;
      --ink: #1a1a1a;
      --muted: #8a8a8a;
      --panel: #fafafa;
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
      display: flex;
      box-shadow: 0 4px 24px rgba(0,0,0,0.08);
      position: relative;
      overflow: hidden;
    }

    .side-strip {
      width: 14px;
      background: linear-gradient(180deg, var(--ink) 0%, var(--gold) 100%);
      flex-shrink: 0;
    }

    .watermark {
      position: absolute;
      top: 45%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-28deg);
      font-size: 68px;
      font-weight: 900;
      color: rgba(0,0,0,0.035);
      white-space: nowrap;
      pointer-events: none;
      z-index: 0;
      letter-spacing: 4px;
    }

    .main { flex: 1; padding: 34px 40px 30px; position: relative; z-index: 1; }

    .top-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-bottom: 18px;
      border-bottom: 2px solid #eee;
    }
    .brand-mini { display: flex; align-items: center; gap: 10px; }
    .brand-mini .crest {
      width: 34px; height: 34px; border-radius: 8px;
      background: var(--ink); color: var(--gold);
      display: flex; align-items: center; justify-content: center;
      font-weight: 800; font-size: 13px;
    }
    .brand-mini .name { font-weight: 800; font-size: 14px; }
    .brand-mini .sub { font-size: 9px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; }

    .pill {
      font-size: 10px;
      font-weight: 700;
      color: var(--gold-deep);
      background: #fdf1dc;
      border: 1px solid var(--gold);
      padding: 5px 12px;
      border-radius: 20px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .title-block { margin: 24px 0 6px; }
    .title-block h1 {
      margin: 0;
      font-size: 25px;
      font-weight: 800;
    }
    .title-block .meta {
      font-size: 12px;
      color: var(--muted);
      margin-top: 4px;
    }

    .stat-row {
      display: flex;
      gap: 12px;
      margin: 24px 0 8px;
    }
    .stat-box {
      flex: 1;
      background: var(--panel);
      border-radius: 8px;
      padding: 14px 16px;
      border-top: 3px solid var(--gold);
    }
    .stat-box .k { font-size: 9px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 700; }
    .stat-box .v { font-size: 17px; font-weight: 800; margin-top: 4px; color: var(--ink); }
    .stat-box.wide { flex: 2; }

    table { width: 100%; border-collapse: collapse; margin-top: 22px; }
    th, td { padding: 11px 8px; text-align: left; font-size: 13px; }
    thead th {
      border-bottom: 2px solid var(--ink);
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--muted);
      font-weight: 700;
    }
    tbody tr { border-bottom: 1px solid #f0f0f0; }
    tbody tr:hover { background: var(--panel); }
    tbody td:first-child { color: var(--gold-deep); font-weight: 700; }

    .bottom-bar {
      margin-top: 30px;
      padding-top: 14px;
      border-top: 1px solid #eee;
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
  <div class="side-strip"></div>
  <div class="watermark">JUSTIN SOLUTION</div>

  <div class="main">

    <div class="top-row">
      <div class="brand-mini">
        <div class="crest">JS</div>
        <div>
          <div class="name">JUSTIN SOLUTION</div>
          <div class="sub">Academic Records</div>
        </div>
      </div>
      <div class="pill"><?php echo $single ? 'Course Record' : 'Course Registry'; ?></div>
    </div>

    <div class="title-block">
      <h1><?php echo $single ? 'Course Details' : 'List of Courses'; ?></h1>
      <div class="meta">Printed <?php echo date('F j, Y \a\t h:i A'); ?> &nbsp;&middot;&nbsp; Ref: COURSE-<?php echo $single ? str_pad($id, 4, '0', STR_PAD_LEFT) : date('Ymd'); ?></div>
    </div>

    <?php if ($single): ?>

      <div class="stat-row">
        <div class="stat-box">
          <div class="k">Course Code</div>
          <div class="v"><?php echo htmlspecialchars($single->course_code); ?></div>
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
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($c->course_code); ?></td>
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