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

    <h2>Course Details</h2>
    <div class="print-meta">Printed on <?php echo date('Y-m-d H:i:s'); ?></div>

    <table class="single-table">
      <tr>
        <th>Course Code</th>
        <td><?php echo htmlspecialchars($single->course_code); ?></td>
      </tr>
      <tr>
        <th>Course Name</th>
        <td><?php echo htmlspecialchars($single->course_name); ?></td>
      </tr>
      <tr>
        <th>Created At</th>
        <td><?php echo htmlspecialchars($single->created_at); ?></td>
      </tr>
    </table>

  <?php elseif ($id > 0 && !$single): ?>

    <div class="print-meta">Course not found.</div>

  <?php else: ?>

    <h2>List of Courses</h2>
    <div class="print-meta">Printed on <?php echo date('Y-m-d H:i:s'); ?></div>

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

  <script>
    window.onload = function () {
      window.print();
    };
  </script>
</body>
</html>