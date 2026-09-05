<?php
require_once("../../include/initialize.php");
global $mydb;

$semester_labels = array('1' => '1st Semester', '2' => '2nd Semester', '3' => 'Summer');
$year_labels     = array('1' => '1st Year', '2' => '2nd Year', '3' => '3rd Year', '4' => '4th Year');

function semester_label($val, $labels) {
	return isset($labels[$val]) ? $labels[$val] : htmlspecialchars($val);
}

$mydb->setQuery("SELECT s.*, c.course_code, c.course_name
	FROM `tblsubjects` s
	LEFT JOIN `tblcourses` c ON c.`course_id` = s.`COURSE_ID`
	ORDER BY s.`SUBJECT_CODE` ASC");
$subjects = $mydb->loadResultList();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        @page {
            margin: 0;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 40px 60px;
            color: #000;
            background: #fff;
        }
        .page {
            max-width: 700px;
            margin: 0 auto;
        }
        .center { text-align: center; }
        .receipt-title {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 0;
        }
        .receipt-sub {
            font-size: 13px;
            margin-top: 4px;
        }
        .dashed {
            margin: 16px 0;
        }
        .doc-label {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 10px 0 6px;
        }
        .meta-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin: 2px 0;
        }
        .item {
            margin: 12px 0;
        }
        .item .row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }
        .item .code {
            font-weight: bold;
        }
        .item .name {
            font-size: 13px;
            margin-top: 2px;
        }
        .item .detail {
            font-size: 11.5px;
            color: #333;
            margin-top: 2px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: bold;
            margin-top: 6px;
        }
        .footer-msg {
            font-size: 13px;
            margin-top: 6px;
        }
        .footer-small {
            font-size: 10.5px;
            color: #444;
            margin-top: 3px;
        }
        .not-found {
            font-size: 13px;
            text-align: center;
            margin: 16px 0;
        }
        .no-print {
            text-align: center;
            margin-bottom: 20px;
        }
        .no-print button {
            font-family: inherit;
            font-size: 12px;
            padding: 5px 14px;
            border: 1px solid #000;
            background: #fff;
            cursor: pointer;
            margin: 0 4px;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 20px 40px; }
        }
    </style>
</head>
<body>
<div class="page">

    <div class="no-print">
        <button onclick="window.print();">Print</button>
        <button onclick="window.close();">Close</button>
    </div>

    <div class="center doc-label">List Of Subjects</div>

    <div class="center">
        <div class="receipt-title">JUSTIN SOLUTION</div>
        <div class="receipt-sub">Academic Records Office</div>
    </div>

    <div class="dashed"></div>

    <div class="meta-row">
        <span>Ref No:</span>
        <span>SUBJECT-<?php echo date('Ymd'); ?></span>
    </div>

    <div class="dashed"></div>

    <?php if (!empty($subjects)): $i = 1; ?>
        <?php foreach ($subjects as $s): ?>
        <div class="item">
            <div class="row">
                <span class="code"><?php echo $i++; ?>. <?php echo htmlspecialchars($s->SUBJECT_CODE); ?></span>
            </div>
            <div class="name"><?php echo htmlspecialchars($s->SUBJECT_NAME); ?></div>
            <div class="detail">Units: <?php echo htmlspecialchars($s->UNITS); ?></div>
            <div class="detail">Semester: <?php echo semester_label($s->SEMESTER, $semester_labels); ?></div>
            <div class="detail">Year Level: <?php echo semester_label($s->YEAR_LEVEL, $year_labels); ?></div>
            <div class="detail">Course: <?php echo isset($s->course_name) ? htmlspecialchars($s->course_code . ' - ' . $s->course_name) : ''; ?></div>
        </div>
        <?php endforeach; ?>

        <div class="dashed"></div>
        <div class="total-row">
            <span>TOTAL SUBJECTS</span>
            <span><?php echo count($subjects); ?></span>
        </div>
        <div class="dashed"></div>

    <?php else: ?>
        <p class="not-found">*** No subjects found ***</p>
        <div class="dashed"></div>
    <?php endif; ?>

    <div class="center footer-msg">Thank you!</div>
    <div class="center footer-small">JUSTIN SOLUTION &copy; <?php echo date('Y'); ?></div>
    <div class="center footer-small">Generated automatically &mdash; Subject Module</div>

</div>
<script>
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>