<?php
global $mydb;

$enrollment = null;

if (isset($_GET['id']) && $_GET['id'] != '') {
    $mydb->setQuery("SELECT e.*, s.FNAME, s.LNAME, s.MNAME, s.IDNO, s.LRNNO, sy.SCHOOL_YEAR, sy.SEMESTER
                      FROM `tblenrollment` e
                      LEFT JOIN `tblstudent` s ON s.S_ID = e.STUDENT_ID
                      LEFT JOIN `tblschoolyear` sy ON sy.SY_ID = e.SY_ID
                      WHERE e.`ENROLLMENT_ID`='".(int)$_GET['id']."' LIMIT 1");
    $enrollment = $mydb->loadSingleResult();
}
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$enrollment): ?>
    <div class="alert alert-warning">
      No enrollment was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/enrollment/">enrollment list</a> and click the view button of an enrollment.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars(trim($enrollment->LNAME.', '.$enrollment->FNAME.' '.$enrollment->MNAME)); ?>
            </h3>

            <p class="text-muted text-center">
              <?php echo htmlspecialchars($enrollment->LRNNO); ?>
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>School Year</b> <a class="float-right"><?php echo htmlspecialchars($enrollment->SCHOOL_YEAR); ?></a>
              </li>
              <li class="list-group-item">
                <b>Semester</b> <a class="float-right"><?php echo htmlspecialchars($enrollment->SEMESTER); ?></a>
              </li>
              <li class="list-group-item">
                <b>Enrollment Date</b> <a class="float-right"><?php echo htmlspecialchars($enrollment->enrollment_date); ?></a>
              </li>
            </ul>

            <a href="<?php echo WEB_ROOT; ?>module/enrollment/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <h3 class="card-title">Enrollment Details</h3>
          </div><!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th style="width:30%">Student Name</th>
                <td><?php echo htmlspecialchars(trim($enrollment->LNAME.', '.$enrollment->FNAME.' '.$enrollment->MNAME)); ?></td>
              </tr>
              <tr>
                <th>LRN No.</th>
                <td><?php echo htmlspecialchars($enrollment->LRNNO); ?></td>
              </tr>
              <tr>
                <th>School Year</th>
                <td><?php echo htmlspecialchars($enrollment->SCHOOL_YEAR); ?></td>
              </tr>
              <tr>
                <th>Semester</th>
                <td><?php echo htmlspecialchars($enrollment->SEMESTER); ?></td>
              </tr>
              <tr>
                <th>Enrollment Date</th>
                <td><?php echo htmlspecialchars($enrollment->enrollment_date); ?></td>
              </tr>
            </table>
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  <?php endif; ?>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
