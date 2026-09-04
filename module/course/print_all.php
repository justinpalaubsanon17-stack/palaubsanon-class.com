<?php
require_once("../../include/initialize.php");
global $mydb;

$mydb->setQuery("SELECT `course_id`, `course_code`, `course_name`, `created_at`
                  FROM `tblcourses`
                  ORDER BY `course_code` ASC");
$courses = $mydb->loadResultList();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>List of Courses - Print</title>
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

    <h2>List of Courses</h2>
    <div class="print-date">Printed on: <?php echo date("Y-m-d H:i:s"); ?></div>

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
                <?php foreach ($courses as $row): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo htmlspecialchars($row->course_code); ?></td>
                    <td><?php echo htmlspecialchars($row->course_name); ?></td>
                    <td><?php echo htmlspecialchars($row->created_at); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align:center;">No courses found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>
</html>