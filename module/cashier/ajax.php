<?php
require_once("../../include/initialize.php");
global $mydb;

if (isset($_POST['UID'])) {
  // Fetch a single payment row for the Edit modal
  $output = array();
  $query =  "SELECT `PAYMENT_ID`, `ENROLLMENT_ID`, `FEE_TYPE_ID`, `AMOUNT_PAID`, `PAYMENT_DATE`, `PAYMENT_METHOD`, `REMARKS`
    FROM `tblcashier`
    WHERE PAYMENT_ID = '".$_POST["UID"]."'
    LIMIT 1";
  $mydb->setQuery($query);
  $result = $mydb->loadResultList();

  foreach($result as $row)
  {
    $output["UID"]             = $row->PAYMENT_ID;
    $output["ENROLLMENT_ID"]   = $row->ENROLLMENT_ID;
    $output["FEE_TYPE_ID"]     = $row->FEE_TYPE_ID;
    $output["AMOUNT_PAID"]     = $row->AMOUNT_PAID;
    $output["PAYMENT_DATE"]    = $row->PAYMENT_DATE;
    $output["PAYMENT_METHOD"]  = $row->PAYMENT_METHOD;
    $output["REMARKS"]         = $row->REMARKS;
  }
  echo json_encode($output);

} elseif (isset($_POST['FEE_ENROLLMENT_ID'])) {
  // Fetch the current total fee for the Set Fee modal
  $output = array();
  $eid = (int)$_POST['FEE_ENROLLMENT_ID'];

  $query = "SELECT e.ENROLLMENT_ID, s.FNAME, s.LNAME, sy.SCHOOL_YEAR, sy.SEMESTER,
      COALESCE(fa.TOTAL_FEE,0) AS TOTAL_FEE
    FROM tblenrollment e
    LEFT JOIN tblstudent s ON s.S_ID = e.STUDENT_ID
    LEFT JOIN tblschoolyear sy ON sy.SY_ID = e.SY_ID
    LEFT JOIN tblfeeassessment fa ON fa.ENROLLMENT_ID = e.ENROLLMENT_ID
    WHERE e.ENROLLMENT_ID = '".$eid."'
    LIMIT 1";
  $mydb->setQuery($query);
  $result = $mydb->loadResultList();

  foreach($result as $row)
  {
    $output["ENROLLMENT_ID"] = $row->ENROLLMENT_ID;
    $output["STUDENT_NAME"]  = trim($row->LNAME.', '.$row->FNAME).' - '.$row->SCHOOL_YEAR.' ('.$row->SEMESTER.')';
    $output["TOTAL_FEE"]     = $row->TOTAL_FEE;
  }
  echo json_encode($output);

} else {
  // DataTables server-side listing.
  // ROW = ONE ENROLLMENT (every enrolled student shows, even with ₱0 paid),
  // not one row per payment like before. Totals + latest payment info are
  // pulled in via subqueries against tblcashier.
  $output = array();
  $query = "SELECT e.`ENROLLMENT_ID`, s.`FNAME`, s.`LNAME`, s.`IDNO`, sy.`SCHOOL_YEAR`, sy.`SEMESTER`,
    COALESCE(fa.`TOTAL_FEE`,0) AS `TOTAL_FEE`,
    COALESCE((SELECT SUM(c.AMOUNT_PAID) FROM tblcashier c
              WHERE c.ENROLLMENT_ID = e.ENROLLMENT_ID),0) AS `TOTAL_PAID`,
    (SELECT c.PAYMENT_ID FROM tblcashier c
      WHERE c.ENROLLMENT_ID = e.ENROLLMENT_ID
      ORDER BY c.PAYMENT_DATE DESC, c.PAYMENT_ID DESC LIMIT 1) AS `LAST_PAYMENT_ID`,
    (SELECT c.PAYMENT_DATE FROM tblcashier c
      WHERE c.ENROLLMENT_ID = e.ENROLLMENT_ID
      ORDER BY c.PAYMENT_DATE DESC, c.PAYMENT_ID DESC LIMIT 1) AS `LAST_PAYMENT_DATE`,
    (SELECT c.PAYMENT_METHOD FROM tblcashier c
      WHERE c.ENROLLMENT_ID = e.ENROLLMENT_ID
      ORDER BY c.PAYMENT_DATE DESC, c.PAYMENT_ID DESC LIMIT 1) AS `LAST_PAYMENT_METHOD`,
    (SELECT ft.fee_type_name FROM tblcashier c
      LEFT JOIN tblfeetypes ft ON ft.fee_type_id = c.FEE_TYPE_ID
      WHERE c.ENROLLMENT_ID = e.ENROLLMENT_ID
      ORDER BY c.PAYMENT_DATE DESC, c.PAYMENT_ID DESC LIMIT 1) AS `LAST_PAYMENT_FEE_TYPE`
    FROM `tblenrollment` e
    LEFT JOIN `tblstudent` s ON s.`S_ID` = e.`STUDENT_ID`
    LEFT JOIN `tblschoolyear` sy ON sy.`SY_ID` = e.`SY_ID`
    LEFT JOIN `tblfeeassessment` fa ON fa.`ENROLLMENT_ID` = e.`ENROLLMENT_ID`";

  if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '')
  {
    $query .= " WHERE s.`FNAME` LIKE '%".$_POST["search"]["value"]."%'
      OR s.`LNAME` LIKE '%".$_POST["search"]["value"]."%'
      OR s.`IDNO` LIKE '%".$_POST["search"]["value"]."%' ";
  }

  // Sorting is disabled on the table (see index.php), so we always use a
  // fixed, sensible default order instead of reading $_POST['order'].
  $query .= " ORDER BY s.`LNAME` ASC, s.`FNAME` ASC ";

  $post_length = isset($_POST["length"]) ? (int)$_POST["length"] : 10;
  $post_start  = isset($_POST["start"])  ? (int)$_POST["start"]  : 0;
  if ($post_length != -1)
  {
    $query .= " LIMIT " . $post_start . ", " . $post_length . "";
  }
  $mydb->setQuery($query);
  $cur = $mydb->loadResultList();
  $data = array();
  $filtered_rows = $mydb->num_rows();
  $i = 1;
  foreach ($cur as $result) {
    $sub_array = array();
    $balance      = $result->TOTAL_FEE - $result->TOTAL_PAID;
    $studentName  = trim($result->LNAME.', '.$result->FNAME);
    $syLabel      = $result->SCHOOL_YEAR.' - '.$result->SEMESTER;

    $sub_array[] = $i;
    $sub_array[] = $studentName;
    $sub_array[] = $result->IDNO;
    $sub_array[] = $syLabel;
    $sub_array[] = '&#8369;'.number_format($result->TOTAL_PAID, 2);

    if ($result->TOTAL_FEE == 0) {
      $sub_array[] = '<span class="badge badge-secondary">Not Assessed</span>';
    } elseif ($balance <= 0) {
      $sub_array[] = '<span class="badge badge-success">Fully Paid</span>';
    } else {
      $sub_array[] = '&#8369;'.number_format($balance, 2);
    }

    $sub_array[] = $result->LAST_PAYMENT_DATE ? $result->LAST_PAYMENT_DATE : '&mdash;';
    $sub_array[] = $result->LAST_PAYMENT_METHOD ? $result->LAST_PAYMENT_METHOD : '&mdash;';
    $sub_array[] = $result->LAST_PAYMENT_FEE_TYPE ? $result->LAST_PAYMENT_FEE_TYPE : '&mdash;';

    // Everyone gets a "Pay" and "Set Fee" button. Edit/View/Delete only make
    // sense if this enrollment already has at least one payment on record.
    $payLabel = htmlspecialchars($studentName.' - '.$syLabel, ENT_QUOTES);

    $actions  = '<button type="button" data-eid="'.$result->ENROLLMENT_ID.'" data-name="'.$payLabel.'" class="btn btn-success btn-xs payEntry" title="Add Payment"><span class="fa fa-money-bill-wave"></span> Pay</button> ';

    $actions .= '<button type="button" name="setfee" EID="'.$result->ENROLLMENT_ID.'" class="btn btn-secondary btn-xs setFeeEntry" title="Set Fee"><span class="fa fa-money-bill"></span></button> ';

    if ($result->LAST_PAYMENT_ID) {
      // Has at least one payment: buttons act on the most recent one.
      $actions .= '<button type="button" name="update" UID="'.$result->LAST_PAYMENT_ID.'" class="btn btn-warning btn-xs editEntry" title="Edit Last Payment"><span class="fa fa-edit fw-fa"></span></button> ';

      $actions .= '<a href="index.php?view=view&id='.$result->LAST_PAYMENT_ID.'"><button type="button" class="btn btn-info btn-xs" title="View Receipt"><span class="fa fa-eye"></span></button></a> ';

      $actions .= '<a href="controller.php?action=delete&id='.$result->LAST_PAYMENT_ID.'" onclick="return confirm(\'Delete this payment record?\');"><button type="button" class="btn btn-danger btn-xs" title="Delete Last Payment"><span class="fa fa-trash fw-fa"></span></button></a>';
    } else {
      // No payment yet: buttons are clickable (not disabled) but there's
      // genuinely no payment record to edit/view/delete, so clicking
      // explains that instead of doing nothing silently.
      $actions .= '<button type="button" class="btn btn-warning btn-xs noPaymentEntry" data-msg="This student has no payment recorded yet. Click Pay to record one." title="No payment yet"><span class="fa fa-edit fw-fa"></span></button> ';
      $actions .= '<button type="button" class="btn btn-info btn-xs noPaymentEntry" data-msg="No receipt yet - this student has not made a payment." title="No payment yet"><span class="fa fa-eye"></span></button> ';
      $actions .= '<button type="button" class="btn btn-danger btn-xs noPaymentEntry" data-msg="Nothing to delete - this student has no payment recorded yet." title="No payment yet"><span class="fa fa-trash fw-fa"></span></button>';
    }

    $sub_array[] = $actions;
    $data[] = $sub_array;
    $i = $i + 1;
  }

  function get_total_all_records()
  {
    global $mydb;
    $statement = "SELECT `ENROLLMENT_ID` FROM `tblenrollment`";
    $mydb->setQuery($statement);
    return $mydb->num_rows();
  }

  $output = array(
    "draw"            => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
    "recordsTotal"    => get_total_all_records(),
    "recordsFiltered" => $filtered_rows,
    "data"            => $data
  );
  echo json_encode($output);
}
?>