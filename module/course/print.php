<?php
require_once("../../include/initialize.php");
global $mydb;

$mydb->setQuery("SELECT `course_code`, `course_name`, `created_at` FROM `tblcourses` ORDER BY `course_code` ASC");
$courses = $mydb->loadResultList();
?>
<!DOCTYPE html>
<html>
<head>
  <title>List of Courses - Print</title>
  <style>
    body { font-family: Arial, Helvetica, sans-serif; padding: 30px; color: #222; }
    h2 { margin-bottom: 4px; }
    .print-meta { color: #666; font-size: 12px; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #999; padding: 8px 10px; text-align: left; font-size: 13px; }
    th { background: #f2f2f2; }
    tr:nth-child(even) { background: #fafafa; }
    @media print {
      button { display: none; }
    }
  </style>
</head>
<body>
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

  <script>
    window.onload = function () {
      window.print();
    };
  </script>
</body>
</html>