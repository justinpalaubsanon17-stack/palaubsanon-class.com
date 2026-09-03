<?php
require_once("../../include/initialize.php");
global $mydb;

$semester_labels = array('1' => '1st Semester', '2' => '2nd Semester', '3' => 'Summer');
$year_labels     = array('1' => '1st Year', '2' => '2nd Year', '3' => '3rd Year', '4' => '4th Year');

$single = null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
	$mydb->setQuery("SELECT s.*, c.course_code, c.course_name
		FROM `tblsubjects` s
		LEFT JOIN `tblcourses` c ON c.`course_id` = s.`COURSE_ID`
		WHERE s.`SUBJECT_ID` = '".$id."' LIMIT 1");
	$single = $mydb->loadSingleResult();
} else {
	$mydb->setQuery("SELECT s.*, c.course_code, c.course_name
		FROM `tblsubjects` s
		LEFT JOIN `tblcourses` c ON c.`course_id` = s.`COURSE_ID`
		ORDER BY s.`SUBJECT_CODE` ASC");
	$subjects = $mydb->loadResultList();
}

function semester_label($val, $labels) {
	return isset($labels[$val]) ? $labels[$val] : htmlspecialchars($val);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $single ? 'Subject - ' . htmlspecialchars($single->SUBJECT_CODE) : 'List of Subjects'; ?> - Print</title>
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
      max-width: 960px;
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
      flex-wrap: wrap;
    }
    .stat-box {
      flex: 1;
      min-width: 140px;
      background: var(--panel);
      border-radius: 8px;
      padding: 14px 16px;
      border-top: 3px solid var(--gold);
    }
    .stat-box .k { font-size: 9px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 700; }
    .stat-box .v { font-size: 17px; font-weight: 800; margin-top: 4px; color: var(--ink); }
    .stat-box.wide { flex: 2 1 100%; }

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
      <div class="pill"><?php echo $single ? 'Subject Record' : 'Subject Registry'; ?></div>
    </div>

    <div class="title-block">
      <h1><?php echo $single ? 'Subject Details' : 'List of Subjects'; ?></h1>
      <div class="meta">Printed <?php echo date('F j, Y \a\t h:i A'); ?> &nbsp;&middot;&nbsp; Ref: SUBJ-<?php echo $single ? str_pad($id, 4, '0', STR_PAD_LEFT) : date('Ymd'); ?></div>
    </div>

    <?php if ($single): ?>

      <div class="stat-row">
        <div class="stat-box">
          <div class="k">Subject Code</div>
          <div class="v"><?php echo htmlspecialchars($single->SUBJECT_CODE); ?></div>
        </div>
        <div class="stat-box">
          <div class="k">Units</div>
          <div class="v"><?php echo htmlspecialchars($single->UNITS); ?></div>
        </div>
        <div class="stat-box">
          <div class="k">Semester</div>
          <div class="v" style="font-size:14px;"><?php echo semester_label($single->SEMESTER, $semester_labels); ?></div>
        </div>
        <div class="stat-box">
          <div class="k">Year Level</div>
          <div class="v" style="font-size:14px;"><?php echo semester_label($single->YEAR_LEVEL, $year_labels); ?></div>
        </div>
      </div>
      <div class="stat-row">
        <div class="stat-box wide">
          <div class="k">Subject Name</div>
          <div class="v"><?php echo htmlspecialchars($single->SUBJECT_NAME); ?></div>
        </div>
      </div>
      <div class="stat-row">
        <div class="stat-box wide">
          <div class="k">Course</div>
          <div class="v" style="font-size:14px;"><?php echo isset($single->course_name) ? htmlspecialchars($single->course_code . ' - ' . $single->course_name) : ''; ?></div>
        </div>
      </div>

    <?php elseif ($id > 0 && !$single): ?>

      <p style="color:var(--muted);">Subject not found.</p>

    <?php else: ?>

      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Subject Code</th>
            <th>Subject Name</th>
            <th>Units</th>
            <th>Semester</th>
            <th>Year Level</th>
            <th>Course</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; foreach ($subjects as $s): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($s->SUBJECT_CODE); ?></td>
            <td><?php echo htmlspecialchars($s->SUBJECT_NAME); ?></td>
            <td><?php echo htmlspecialchars($s->UNITS); ?></td>
            <td><?php echo semester_label($s->SEMESTER, $semester_labels); ?></td>
            <td><?php echo semester_label($s->YEAR_LEVEL, $year_labels); ?></td>
            <td><?php echo isset($s->course_name) ? htmlspecialchars($s->course_code . ' - ' . $s->course_name) : ''; ?></td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($subjects)): ?>
          <tr><td colspan="7" style="text-align:center;">No subjects found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>

    <?php endif; ?>

    <div class="bottom-bar">
      <span>JUSTIN SOLUTION &copy; <?php echo date('Y'); ?></span>
      <span>Generated automatically &mdash; Subject Module</span>
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