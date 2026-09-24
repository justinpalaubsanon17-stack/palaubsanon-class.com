<?php
global $mydb;

$payment = null;
$totals = null;

if (isset($_GET['id']) && $_GET['id'] != '') {
    $mydb->setQuery("SELECT c.`PAYMENT_ID`, c.`ENROLLMENT_ID`, c.`FEE_TYPE_ID`, c.`AMOUNT_PAID`,
                      c.`PAYMENT_DATE`, c.`PAYMENT_METHOD`, c.`REMARKS`,
                      s.FNAME, s.LNAME, s.MNAME, s.IDNO, sy.SCHOOL_YEAR, sy.SEMESTER,
                      ft.fee_type_name
                      FROM `tblcashier` c
                      LEFT JOIN `tblenrollment` e ON e.ENROLLMENT_ID = c.ENROLLMENT_ID
                      LEFT JOIN `tblstudent` s ON s.S_ID = e.STUDENT_ID
                      LEFT JOIN `tblschoolyear` sy ON sy.SY_ID = e.SY_ID
                      LEFT JOIN `tblfeetypes` ft ON ft.fee_type_id = c.FEE_TYPE_ID
                      WHERE c.`PAYMENT_ID`='".(int)$_GET['id']."' LIMIT 1");
    $payment = $mydb->loadSingleResult();

    if ($payment) {
        $mydb->setQuery("SELECT COALESCE(fa.TOTAL_FEE,0) AS TOTAL_FEE,
                          COALESCE((SELECT SUM(c2.AMOUNT_PAID) FROM tblcashier c2 WHERE c2.ENROLLMENT_ID = '".$payment->ENROLLMENT_ID."'),0) AS TOTAL_PAID
                          FROM tblenrollment e
                          LEFT JOIN tblfeeassessment fa ON fa.ENROLLMENT_ID = e.ENROLLMENT_ID
                          WHERE e.ENROLLMENT_ID = '".$payment->ENROLLMENT_ID."'");
        $totals = $mydb->loadSingleResult();
    }
}

// OR number: your database doesn't keep a separate OR_NUMBER, so the
// payment's own ID (zero-padded) is used as the official receipt number.
$orNumber = $payment ? str_pad($payment->PAYMENT_ID, 6, '0', STR_PAD_LEFT) : '';

function safe_amount($val) {
    if ($val === null || $val === '' || !is_numeric($val)) {
        return 0.0;
    }
    return (float)$val;
}
?>

<style>
    /* ---- On-screen receipt card ---- */
    .or-receipt {
        max-width: 640px;
        margin: 0 auto;
        background: #fff;
        border: 1px solid #333;
        font-family: Arial, Helvetica, sans-serif;
        color: #1a1a1a;
    }
    .or-receipt .or-band {
        height: 4px;
        background: #1a1a1a;
    }
    .or-receipt .or-header {
        text-align: center;
        padding: 22px 24px 14px;
        border-bottom: 2px solid #1a1a1a;
    }
    .or-receipt .or-header h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #1a1a1a;
    }
    .or-receipt .or-header .or-sub {
        font-size: 12px;
        color: #777;
        margin-top: 2px;
    }
    .or-receipt .or-header .or-title {
        display: inline-block;
        margin-top: 10px;
        padding: 4px 14px;
        border: 1px solid #333;
        color: #1a1a1a;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 1.5px;
    }
    .or-receipt .or-meta {
        display: flex;
        justify-content: space-between;
        padding: 14px 24px;
        font-size: 13px;
        color: #555;
        border-bottom: 1px solid #eee;
    }
    .or-receipt .or-meta strong { color: #111; }
    .or-body { padding: 18px 24px; }
    .or-body table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .or-body table td { padding: 7px 0; vertical-align: top; }
    .or-body table td.label { color: #666; width: 45%; }
    .or-body table td.value { text-align: right; font-weight: 600; color: #1a1a1a; }
    .or-divider { border: none; border-top: 1px solid #eee; margin: 10px 0; }
    .or-summary {
        margin: 14px 24px 6px;
        padding: 14px 16px;
        background: #f7f7f7;
        border: 1px solid #ccc;
    }
    .or-summary table { width: 100%; font-size: 13px; }
    .or-summary td { padding: 4px 0; }
    .or-summary td.value { text-align: right; font-weight: 600; }
    .or-summary .balance-row td { font-size: 15px; font-weight: 700; color: #1a1a1a; padding-top: 8px; border-top: 1px solid #333; }
    .or-summary .balance-row.paid td { color: #1a1a1a; }
    .or-signature {
        margin: 30px 24px 22px;
        display: flex;
        justify-content: flex-end;
    }
    .or-signature .sig-box {
        text-align: center;
        font-size: 12px;
        color: #444;
    }
    .or-signature .sig-line {
        width: 220px;
        border-top: 1px solid #333;
        margin-bottom: 6px;
    }
    .or-footer {
        text-align: center;
        font-size: 11px;
        color: #999;
        padding: 10px 24px 20px;
    }
    .or-actions {
        max-width: 640px;
        margin: 14px auto 0;
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    /* ---- Print isolation: show ONLY the receipt, regardless of theme markup ---- */
    @media print {
        body * { visibility: hidden !important; }
        #receiptPrintArea, #receiptPrintArea * { visibility: visible !important; }
        #receiptPrintArea {
            position: absolute;
            left: 0; top: 0;
            width: 100%;
            margin: 0;
            box-shadow: none;
            border: none;
        }
        .or-actions, .no-print { display: none !important; }
        @page { margin: 12mm; }
    }
</style>

<section class="content">
  <div class="container-fluid">

  <?php if (!$payment): ?>
    <div class="alert alert-warning">
      No record was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/cashier/">payment list</a> and click the view button of a record.
    </div>

  <?php else:
    $balance = safe_amount($totals->TOTAL_FEE) - safe_amount($totals->TOTAL_PAID);
    $fully_paid = ($balance <= 0 && $totals->TOTAL_FEE > 0);
  ?>

    <div id="receiptPrintArea" class="or-receipt">
        <div class="or-band"></div>

        <div class="or-header">
            <h2>JUSTIN SOLUTION</h2>
            <div class="or-sub">School Management System</div>
            <div class="or-title">OFFICIAL RECEIPT</div>
        </div>

        <div class="or-meta">
            <div>OR No. <strong>#<?php echo htmlspecialchars($orNumber); ?></strong></div>
            <div>Date: <strong><?php echo htmlspecialchars($payment->PAYMENT_DATE); ?></strong></div>
        </div>

        <div class="or-body">
            <table>
                <tr>
                    <td class="label">Received From</td>
                    <td class="value"><?php echo htmlspecialchars(trim($payment->LNAME.', '.$payment->FNAME.' '.$payment->MNAME)); ?></td>
                </tr>
                <tr>
                    <td class="label">ID Number</td>
                    <td class="value"><?php echo htmlspecialchars($payment->IDNO); ?></td>
                </tr>
                <tr>
                    <td class="label">School Year</td>
                    <td class="value"><?php echo htmlspecialchars($payment->SCHOOL_YEAR); ?></td>
                </tr>
                <tr>
                    <td class="label">Semester</td>
                    <td class="value"><?php echo htmlspecialchars($payment->SEMESTER); ?></td>
                </tr>
                <tr>
                    <td class="label">Fee Type</td>
                    <td class="value"><?php echo $payment->fee_type_name ? htmlspecialchars($payment->fee_type_name) : '&mdash;'; ?></td>
                </tr>
                <tr>
                    <td class="label">Payment Method</td>
                    <td class="value"><?php echo htmlspecialchars($payment->PAYMENT_METHOD); ?></td>
                </tr>
                <?php if (!empty($payment->REMARKS)): ?>
                <tr>
                    <td class="label">Remarks</td>
                    <td class="value"><?php echo htmlspecialchars($payment->REMARKS); ?></td>
                </tr>
                <?php endif; ?>
            </table>

            <hr class="or-divider">

            <table>
                <tr>
                    <td class="label" style="font-size:16px; color:#333;">Amount Paid</td>
                    <td class="value" style="font-size:20px; color:#1a1a1a;">&#8369;<?php echo number_format(safe_amount($payment->AMOUNT_PAID), 2); ?></td>
                </tr>
            </table>
        </div>

        <div class="or-summary">
            <table>
                <tr>
                    <td>Total Assessed Fee</td>
                    <td class="value">&#8369;<?php echo number_format(safe_amount($totals->TOTAL_FEE), 2); ?></td>
                </tr>
                <tr>
                    <td>Total Paid to Date</td>
                    <td class="value">&#8369;<?php echo number_format(safe_amount($totals->TOTAL_PAID), 2); ?></td>
                </tr>
                <tr class="balance-row <?php echo $fully_paid ? 'paid' : ''; ?>">
                    <td><?php echo $fully_paid ? 'Status' : 'Remaining Balance'; ?></td>
                    <td class="value">
                        <?php echo $fully_paid ? 'FULLY PAID' : '&#8369;'.number_format(safe_amount($balance), 2); ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="or-signature">
            <div class="sig-box">
                <div class="sig-line"></div>
                Cashier's Signature
            </div>
        </div>

        <div class="or-footer">
            This is a system-generated receipt. Keep this for your records.
        </div>
    </div>

    <div class="or-actions no-print">
        <a href="<?php echo WEB_ROOT; ?>module/cashier/" class="btn btn-secondary"><b>Back to List</b></a>
        <button onclick="window.print()" class="btn btn-dark"><b>Print Receipt</b></button>
    </div>

  <?php endif; ?>

  </div>
</section>