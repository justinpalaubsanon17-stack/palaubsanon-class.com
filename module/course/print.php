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
        .item .date {
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

    <div class="center doc-label">
        <?php echo $single ? 'Course Record' : 'Course List'; ?>
    </div>

    <div class="center">
        <div class="receipt-title">JUSTIN SOLUTION</div>
        <div class="receipt-sub">Academic Records Office</div>
    </div>

    <div class="dashed"></div>

    <div class="meta-row">
        <span>Ref No:</span>
        <span>COURSE-<?php echo $single ? str_pad($id, 4, '0', STR_PAD_LEFT) : date('Ymd'); ?></span>
    </div>

    <div class="dashed"></div>

    <?php if ($single): ?>

        <div class="item">
            <div class="row"><span class="code"><?php echo htmlspecialchars($single->course_code); ?></span></div>
            <div class="name"><?php echo htmlspecialchars($single->course_name); ?></div>
            <div class="date">Created: <?php echo htmlspecialchars($single->created_at); ?></div>
        </div>

        <div class="dashed"></div>

    <?php elseif ($id > 0 && !$single): ?>

        <p class="not-found">*** Course not found ***</p>
        <div class="dashed"></div>

    <?php else: ?>

        <?php if (!empty($courses)): $i = 1; ?>
            <?php foreach ($courses as $c): ?>
            <div class="item">
                <div class="row">
                    <span class="code"><?php echo $i++; ?>. <?php echo htmlspecialchars($c->course_code); ?></span>
                </div>
                <div class="name"><?php echo htmlspecialchars($c->course_name); ?></div>
                <div class="date">Created: <?php echo htmlspecialchars($c->created_at); ?></div>
            </div>
            <?php endforeach; ?>

            <div class="dashed"></div>
            <div class="total-row">
                <span>TOTAL COURSES</span>
                <span><?php echo count($courses); ?></span>
            </div>
            <div class="dashed"></div>

        <?php else: ?>
            <p class="not-found">*** No courses found ***</p>
            <div class="dashed"></div>
        <?php endif; ?>

    <?php endif; ?>

    <div class="center footer-msg">Thank you!</div>
    <div class="center footer-small">JUSTIN SOLUTION &copy; <?php echo date('Y'); ?></div>
    <div class="center footer-small">Generated automatically &mdash; Course Module</div>

</div>
<script>
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>