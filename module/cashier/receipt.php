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

$status = 'UNPAID';
if ($payment) {
    if ($payment->balance <= 0) {
        $status = 'PAID';
    } elseif ($payment->amount_paid > 0) {
        $status = 'PARTIAL';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Official Receipt<?php echo $payment ? ' - #'.str_pad($payment->PAY_ID, 6, '0', STR_PAD_LEFT) : ''; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        :root{
            --paper:#fdfdfb;
            --ink:#1a1a1a;
            --ink-soft:#555;
            --rule:#1a1a1a;
            --rule-faint:#bbb;
        }

        body {
            font-family: 'Courier Prime', 'Space Mono', 'Courier New', Consolas, Menlo, monospace;
            background: #e9e7e2;
            margin: 0;
            padding: 40px 20px 60px;
            color: var(--ink);
        }

        /* Force Chrome/Safari to print backgrounds (barcode, perforated
           edges, paper texture) even if "Background graphics" is left off */
        *, *::before, *::after {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color-adjust: exact;
        }

        .no-print {
            text-align: center;
            margin-bottom: 28px;
        }
        .no-print button {
            font-family: 'Space Mono', 'Courier New', Consolas, Menlo, monospace;
            font-size: 13px;
            letter-spacing: .04em;
            padding: 10px 20px;
            border: 1px solid var(--ink);
            background: var(--ink);
            color: var(--paper);
            border-radius: 2px;
            cursor: pointer;
        }
        .no-print button:hover { background: var(--paper); color: var(--ink); }
        .no-print button.secondary {
            background: var(--paper);
            color: var(--ink);
            margin-left: 8px;
        }
        .no-print button.secondary:hover { background: var(--ink); color: var(--paper); }

        .receipt-wrap {
            position: relative;
            max-width: 420px;
            margin: 0 auto;
            filter: drop-shadow(0 18px 30px rgba(0,0,0,0.18));
        }

        .edge {
            height: 12px;
            width: 100%;
            background:
                linear-gradient(-45deg, var(--paper) 6px, transparent 0),
                linear-gradient(45deg, var(--paper) 6px, transparent 0);
            background-position: left top;
            background-repeat: repeat-x;
            background-size: 14px 14px;
            background-color: transparent;
        }
        .edge.top { transform: scaleY(-1); }

        .receipt {
            background: var(--paper);
            padding: 32px 28px 22px;
            background-image: repeating-linear-gradient(0deg, rgba(0,0,0,0.015) 0px, rgba(0,0,0,0.015) 1px, transparent 1px, transparent 3px);
        }

        .brand { text-align: center; margin-bottom: 18px; }
        .brand-name {
            font-family: 'Space Mono', 'Courier New', Consolas, Menlo, monospace;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: .06em;
            margin: 0;
        }
        .brand-sub {
            font-size: 11px;
            letter-spacing: .12em;
            color: var(--ink-soft);
            margin: 4px 0 0;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .rule { border: none; border-top: 1px dashed var(--rule); margin: 16px 0; }
        .rule.solid { border-top: 1.5px solid var(--rule); }

        .status-line {
            text-align: center;
            font-size: 12px;
            letter-spacing: .2em;
            font-weight: 700;
            margin-bottom: 14px;
        }
        .status-line::before { content: "* "; }
        .status-line::after { content: " *"; }

        table.details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        table.details td {
            padding: 6px 0;
            font-size: 13px;
            vertical-align: top;
            border-bottom: 1px dotted var(--rule-faint);
        }
        table.details td.label {
            color: var(--ink-soft);
            letter-spacing: .03em;
        }
        table.details td.value {
            font-weight: 700;
            color: var(--ink);
            text-align: right;
        }

        table.amounts {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }
        table.amounts th {
            font-size: 11px;
            letter-spacing: .08em;
            color: var(--ink-soft);
            padding-bottom: 6px;
            text-align: left;
            border-bottom: 1px solid var(--rule);
            font-weight: 400;
        }
        table.amounts th.right, table.amounts td.right { text-align: right; }
        table.amounts td {
            padding: 9px 0;
            font-size: 13px;
            border-bottom: 1px dotted var(--rule-faint);
        }
        table.amounts tr.balance-row td {
            font-weight: 700;
            font-size: 15px;
            border-bottom: none;
            border-top: 1.5px solid var(--rule);
            padding-top: 12px;
        }

        .barcode {
            margin: 24px 0 6px;
            height: 44px;
            background: repeating-linear-gradient(
                90deg,
                var(--ink), var(--ink) 2px,
                transparent 2px, transparent 3px,
                var(--ink) 3px, var(--ink) 4px,
                transparent 4px, transparent 6px,
                var(--ink) 6px, var(--ink) 8px,
                transparent 8px, transparent 9px
            );
            opacity: .85;
        }
        .barcode-num {
            text-align: center;
            font-size: 11px;
            letter-spacing: .3em;
            color: var(--ink-soft);
            margin-top: 6px;
        }

        .footer-note {
            margin-top: 20px;
            font-size: 11px;
            color: var(--ink-soft);
            text-align: center;
            line-height: 1.6;
        }

        @media print {
            @page { margin: 0.4in; }
            body { background: var(--paper); padding: 0; }
            .receipt-wrap { filter: none; max-width: 100%; margin: 0 auto; }
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
        <div class="edge top"></div>
        <div class="receipt">

            <div class="brand">
                <p class="brand-name">JUSTIN SOLUTION</p>
                <p class="brand-sub">SCHOOL CASHIER OFFICE</p>
            </div>

            <div class="meta-row">
                <span>RECEIPT NO.</span>
                <span>#<?php echo str_pad($payment->PAY_ID, 6, '0', STR_PAD_LEFT); ?></span>
            </div>

            <hr class="rule solid">

            <div class="status-line"><?php echo $status; ?></div>

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
                        <th class="right">Amount (₱)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Amount Due</td>
                        <td class="right"><?php echo number_format($payment->amount_due, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Amount Paid</td>
                        <td class="right"><?php echo number_format($payment->amount_paid, 2); ?></td>
                    </tr>
                    <tr class="balance-row">
                        <td>Balance</td>
                        <td class="right"><?php echo number_format($payment->balance, 2); ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="barcode"></div>
            <div class="barcode-num"><?php echo str_pad($payment->PAY_ID, 16, '0', STR_PAD_LEFT); ?></div>

            <div class="footer-note">
                This is a system-generated receipt issued by JUSTIN SOLUTION.<br>
                Please keep this receipt for your records.
            </div>

        </div>
        <div class="edge"></div>
    </div>

<?php endif; ?>

</body>
</html>