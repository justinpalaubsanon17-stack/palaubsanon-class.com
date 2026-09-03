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
    body { font-family: Arial, Helvetica, sans-serif; padding: 30px; color: #222; }
    h2 { margin-bottom: 4px; }
    .print-meta { color: #666; font-size: 12px; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #999; padding: 8px 10px; text-align: left; font-size: 13px; }
    th { background: #f2f2f2; }
    tr:nth-child(even) { background: #fafafa; }
    .single-table th { width: 30%; background: #f2f2f2; }
    @media print {
      button { display: none; }
    }
  </style>
</head>
<body>

  <?php if ($single): ?>

    <h2>Subject Details</h2>
    <div class="print-meta">Printed on <?php echo date('Y-m-d H:i:s'); ?></div>

    <table class="single-table">
      <tr>
        <th>Subject Code</th>
        <td><?php echo htmlspecialchars($single->SUBJECT_CODE); ?></td>
      </tr>
      <tr>
        <th>Subject Name</th>
        <td><?php echo htmlspecialchars($single->SUBJECT_NAME); ?></td>
      </tr>
      <tr>
        <th>Units</th>
        <td><?php echo htmlspecialchars($single->UNITS); ?></td>
      </tr>
      <tr>
        <th>Semester</th>
        <td><?php echo semester_label($single->SEMESTER, $semester_labels); ?></td>
      </tr>
      <tr>
        <th>Year Level</th>
        <td><?php echo semester_label($single->YEAR_LEVEL, $year_labels); ?></td>
      </tr>
      <tr>
        <th>Course</th>
        <td><?php echo isset($single->course_name) ? htmlspecialchars($single->course_code . ' - ' . $single->course_name) : ''; ?></td>
      </tr>
    </table>

  <?php elseif ($id > 0 && !$single): ?>

    <div class="print-meta">Subject not found.</div>

  <?php else: ?>

    <h2>List of Subjects</h2>
    <div class="print-meta">Printed on <?php echo date('Y-m-d H:i:s'); ?></div>

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

  <script>
    window.onload = function () {
      window.print();
    };
  </script>
</body>
</html>