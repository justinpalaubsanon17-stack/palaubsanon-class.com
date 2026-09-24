<?php
require_once("../../include/initialize.php");
global $mydb;

$payment = null;

if (isset($_GET['id']) && $_GET['id'] != '') {
    $mydb->setQuery("SELECT c.*, s.`IDNO`, s.`FNAME`, s.`MNAME`, s.`LNAME`,
                             sy.`school_year`, sy.`semester`
                      FROM `tblcashier` c
                      LEFT JOIN `tblstudent` s ON s.`S_ID` = c.`student_id`
                      LEFT JOIN `tblschoolyear` sy ON sy.`sy_id` = c.`sy_id`
                      WHERE c.`PAY_ID` = '".(int)$_GET['id']."'
                      LIMIT 1");
    $payment = $mydb->loadSingleResult();
}

function safe_amount($val) {
    if ($val === null || $val === '' || !is_numeric($val)) {
        return 0.0;
    }
    return (float)$val;
}

$status = 'UNPAID';
if ($payment) {
    if (safe_amount($payment->balance) <= 0) {
        $status = 'PAID';
    } elseif (safe_amount($payment->amount_paid) > 0) {
        $status = 'PARTIAL';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Official Receipt<?php echo $payment ? ' - #'.str_pad($payment->PAY_ID, 6, '0', STR_PAD_LEFT) : ''; ?></title>
    <style>
        * { box-sizing: border-box; }

        :root{
            --ink:#1a1a1a;
            --ink-soft:#555;
            --rule:#333;
            --rule-faint:#ccc;
            --accent:#1a3d6d;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 40px 20px 60px;
            color: var(--ink);
        }

        .no-print {
            text-align: center;
            margin-bottom: 24px;
        }
        .no-print button {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            padding: 9px 22px;
            border: 1px solid var(--accent);
            background: var(--accent);
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
        }
        .no-print button:hover { opacity: 0.9; }
        .no-print button.secondary {
            background: #fff;
            color: var(--accent);
            margin-left: 8px;
        }
        .no-print button.secondary:hover { background: #f0f4f9; }

        .receipt-wrap {
            max-width: 640px;
            margin: 0 auto;
        }

        .receipt {
            background: #fff;
            border: 1px solid var(--rule);
            padding: 36px 40px 28px;
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid var(--accent);
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .brand-name {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.3px;
            color: var(--ink);
        }
        .brand-sub {
            font-size: 12px;
            color: var(--ink-soft);
            margin: 3px 0 0;
        }
        .brand-doc {
            text-align: right;
        }
        .brand-doc .doc-title {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--accent);
            margin: 0;
        }
        .brand-doc .doc-no {
            font-size: 13px;
            color: var(--ink-soft);
            margin-top: 4px;
        }

        .status-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 4px 12px;
            border: 1px solid var(--rule);
            border-radius: 3px;
            margin-bottom: 18px;
        }

        table.details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
        }
        table.details td {
            padding: 6px 0;
            font-size: 13px;
            vertical-align: top;
            border-bottom: 1px solid var(--rule-faint);
        }
        table.details td.label {
            color: var(--ink-soft);
            width: 40%;
        }
        table.details td.value {
            font-weight: 600;
            color: var(--ink);
            text-align: right;
        }

        table.amounts {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        table.amounts th {
            font-size: 12px;
            color: #fff;
            background: var(--accent);
            padding: 8px 10px;
            text-align: left;
            font-weight: 600;
        }
        table.amounts th.right, table.amounts td.right { text-align: right; }
        table.amounts td {
            padding: 9px 10px;
            font-size: 13px;
            border-bottom: 1px solid var(--rule-faint);
        }
        table.amounts tr.balance-row td {
            font-weight: 700;
            font-size: 14px;
            border-bottom: none;
            border-top: 2px solid var(--rule);
            padding-top: 12px;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .sig-box {
            width: 45%;
            text-align: center;
            font-size: 12px;
            color: var(--ink-soft);
        }
        .sig-line {
            border-top: 1px solid var(--ink);
            margin-bottom: 6px;
            padding-top: 4px;
        }

        .footer-note {
            margin-top: 28px;
            font-size: 11px;
            color: var(--ink-soft);
            text-align: center;
            border-top: 1px solid var(--rule-faint);
            padding-top: 12px;
            line-height: 1.6;
        }

        @media print {
            @page { margin: 0.5in; }
            body { background: #fff; padding: 0; }
            .receipt-wrap { max-width: 100%; margin: 0 auto; }
            .receipt { border: none; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<?php if (!$payment): ?>

    <div class="receipt-wrap">
        <div class="receipt">
            <p>No payment record found for this receipt.</p>
        </div>
    </div>

<?php else: ?>

    <div class="no-print">
        <button onclick="window.print()">Print Receipt</button>
        <button class="secondary" onclick="window.close()">Close</button>
    </div>

    <div class="receipt-wrap">
        <div class="receipt">

            <div class="brand">
                <div>
                    <p class="brand-name">JUSTIN SOLUTION</p>
                    <p class="brand-sub">School Management System &mdash; Cashier Office</p>
                </div>
                <div class="brand-doc">
                    <p class="doc-title">OFFICIAL RECEIPT</p>
                    <div class="doc-no">No. <?php echo str_pad($payment->PAY_ID, 6, '0', STR_PAD_LEFT); ?></div>
                </div>
            </div>

            <span class="status-badge"><?php echo htmlspecialchars($status); ?></span>

            <table class="details">
                <tr>
                    <td class="label">Student Name</td>
                    <td class="value"><?php echo htmlspecialchars($payment->FNAME.' '.$payment->MNAME.' '.$payment->LNAME); ?></td>
                </tr>
                <tr>
                    <td class="label">Student ID No.</td>
                    <td class="value"><?php echo htmlspecialchars($payment->IDNO); ?></td>
                </tr>
                <tr>
                    <td class="label">School Year</td>
                    <td class="value"><?php echo htmlspecialchars($payment->school_year.' - '.$payment->semester); ?></td>
                </tr>
                <tr>
                    <td class="label">Payment Date</td>
                    <td class="value"><?php echo htmlspecialchars($payment->payment_date); ?></td>
                </tr>
            </table>

            <table class="amounts">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="right">Amount (&#8369;)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Amount Due</td>
                        <td class="right"><?php echo number_format(safe_amount($payment->amount_due), 2); ?></td>
                    </tr>
                    <tr>
                        <td>Amount Paid</td>
                        <td class="right"><?php echo number_format(safe_amount($payment->amount_paid), 2); ?></td>
                    </tr>
                    <tr class="balance-row">
                        <td>Balance</td>
                        <td class="right"><?php echo number_format(safe_amount($payment->balance), 2); ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="signatures">
                <div class="sig-box">
                    <div class="sig-line">&nbsp;</div>
                    Received By (Cashier)
                </div>
                <div class="sig-box">
                    <div class="sig-line">&nbsp;</div>
                    Authorized Signature
                </div>
            </div>

            <div class="footer-note">
                This is a system-generated receipt issued by JUSTIN SOLUTION.<br>
                Please keep this receipt for your records.
            </div>

        </div>
    </div>

<?php endif; ?>

</body>
</html>