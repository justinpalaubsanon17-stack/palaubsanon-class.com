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
    <meta charset="UTF-8">
    <title><?php echo $single ? 'Course - ' . htmlspecialchars($single->course_code) : 'List of Courses'; ?> - Print</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 30px;
            color: #222;
        }
        h2 {
            margin-bottom: 2px;
        }
        .print-date {
            font-size: 12px;
            color: #666;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px 10px;
            font-size: 13px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .no-print {
            margin-bottom: 15px;
        }
        .not-found {
            font-size: 13px;
            color: #666;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print();">Print</button>
        <button onclick="window.close();">Close</button>
    </div>

    <h2><?php echo $single ? 'Course Details' : 'List of Courses'; ?></h2>
    <div class="print-date">Printed on: <?php echo date("Y-m-d H:i:s"); ?></div>

    <?php if ($single): ?>

        <table>
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($single->course_code); ?></td>
                    <td><?php echo htmlspecialchars($single->course_name); ?></td>
                    <td><?php echo htmlspecialchars($single->created_at); ?></td>
                </tr>
            </tbody>
        </table>

    <?php elseif ($id > 0 && !$single): ?>

        <p class="not-found">Course not found.</p>

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
                <?php if (!empty($courses)): $i = 1; ?>
                    <?php foreach ($courses as $c): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($c->course_code); ?></td>
                        <td><?php echo htmlspecialchars($c->course_name); ?></td>
                        <td><?php echo htmlspecialchars($c->created_at); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">No courses found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    <?php endif; ?>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>
</html>