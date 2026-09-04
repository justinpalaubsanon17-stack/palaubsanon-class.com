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
    <meta charset="UTF-8">
    <title><?php echo $single ? 'Subject - ' . htmlspecialchars($single->SUBJECT_CODE) : 'List of Subjects'; ?> - Print</title>
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

    <h2><?php echo $single ? 'Subject Details' : 'List of Subjects'; ?></h2>
    <div class="print-date">Printed on: <?php echo date("Y-m-d H:i:s"); ?></div>

    <?php if ($single): ?>

        <table>
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Units</th>
                    <th>Semester</th>
                    <th>Year Level</th>
                    <th>Course</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($single->SUBJECT_CODE); ?></td>
                    <td><?php echo htmlspecialchars($single->SUBJECT_NAME); ?></td>
                    <td><?php echo htmlspecialchars($single->UNITS); ?></td>
                    <td><?php echo semester_label($single->SEMESTER, $semester_labels); ?></td>
                    <td><?php echo semester_label($single->YEAR_LEVEL, $year_labels); ?></td>
                    <td><?php echo isset($single->course_name) ? htmlspecialchars($single->course_code . ' - ' . $single->course_name) : ''; ?></td>
                </tr>
            </tbody>
        </table>

    <?php elseif ($id > 0 && !$single): ?>

        <p class="not-found">Subject not found.</p>

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
                <?php if (!empty($subjects)): $i = 1; ?>
                    <?php foreach ($subjects as $s): ?>
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
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center;">No subjects found.</td>
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