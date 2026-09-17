<?php

global $mydb;

$student  = null;
$payments = array();
$totalDue = 0;
$totalPaid = 0;
$totalBalance = 0;

if (isset($_GET['id']) && $_GET['id'] != '') {

    $mydb->setQuery("SELECT * FROM `tblstudent` WHERE `S_ID`='".(int)$_GET['id']."' LIMIT 1");
    $student = $mydb->loadSingleResult();

    $mydb->setQuery("SELECT c.*, sy.`school_year`, sy.`semester`
                      FROM `tblcashier` c
                      LEFT JOIN `tblschoolyear` sy ON sy.`sy_id` = c.`sy_id`
                      WHERE c.`student_id`='".(int)$_GET['id']."'
                      ORDER BY c.`PAY_ID` DESC");
    $payments = $mydb->loadResultList();

    foreach ($payments as $p) {
        $totalDue     += $p->amount_due;
        $totalPaid    += $p->amount_paid;
        $totalBalance += $p->balance;
    }
}
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$student): ?>
    <div class="alert alert-warning">
      No student was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/cashier/">payment list</a> and click the view button of a record.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">

        <!-- Student summary -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars($student->FNAME.' '.$student->MNAME.' '.$student->LNAME); ?>
            </h3>

            <p class="text-muted text-center">
              Student ID: <?php echo htmlspecialchars($student->IDNO); ?>
            </p>

            <a href="<?php echo WEB_ROOT; ?>module/cashier/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
        </div>

        <!-- Balance summary -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Account Summary</h3>
          </div>
          <div class="card-body">
            <strong><i class="fas fa-file-invoice-dollar mr-1"></i> Total Amount Due</strong>
            <p class="text-muted"><?php echo number_format($totalDue, 2); ?></p>
            <hr>
            <strong><i class="fas fa-money-bill-wave mr-1"></i> Total Amount Paid</strong>
            <p class="text-muted"><?php echo number_format($totalPaid, 2); ?></p>
            <hr>
            <strong><i class="fas fa-balance-scale mr-1"></i> Outstanding Balance</strong>
            <p class="<?php echo ($totalBalance > 0) ? 'text-danger' : 'text-success'; ?>">
              <b><?php echo number_format($totalBalance, 2); ?></b>
            </p>
          </div>
        </div>

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Payment History</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>School Year</th>
                  <th>Amount Due</th>
                  <th>Amount Paid</th>
                  <th>Balance</th>
                  <th>Payment Date</th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($payments) > 0): ?>
                  <?php foreach ($payments as $p): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($p->school_year.' - '.$p->semester); ?></td>
                    <td><?php echo number_format($p->amount_due, 2); ?></td>
                    <td><?php echo number_format($p->amount_paid, 2); ?></td>
                    <td><?php echo number_format($p->balance, 2); ?></td>
                    <td><?php echo htmlspecialchars($p->payment_date); ?></td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center text-muted">No payment records yet for this student.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  <?php endif; ?>

  </div><!-- /.container-fluid -->
</section>