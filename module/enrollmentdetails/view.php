<?php
global $mydb;

$detail = null;

if (isset($_GET['id']) && $_GET['id'] != '') {
    $mydb->setQuery("SELECT ed.*, s.FNAME, s.LNAME, s.LRNNO, sy.SCHOOL_YEAR, sy.SEMESTER,
                      sub.SUBJECT_CODE, sub.SUBJECT_NAME, sub.UNITS
                      FROM `tblenrollment_details` ed
                      LEFT JOIN `tblenrollment` e ON e.ENROLLMENT_ID = ed.ENROLLMENT_ID
                      LEFT JOIN `tblstudent` s ON s.S_ID = e.STUDENT_ID
                      LEFT JOIN `tblschoolyear` sy ON sy.SY_ID = e.SY_ID
                      LEFT JOIN `tblsubjects` sub ON sub.SUBJECT_ID = ed.SUBJECT_ID
                      WHERE ed.`DEATIL_ID`='".(int)$_GET['id']."' LIMIT 1");
    $detail = $mydb->loadSingleResult();
}
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$detail): ?>
    <div class="alert alert-warning">
      No record was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/enrollmentdetails/">enrollment subjects list</a> and click the view button of a record.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars($detail->SUBJECT_CODE); ?>
            </h3>

            <p class="text-muted text-center">
              <?php echo htmlspecialchars($detail->SUBJECT_NAME); ?>
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Student</b> <a class="float-right"><?php echo htmlspecialchars(trim($detail->LNAME.', '.$detail->FNAME)); ?></a>
              </li>
              <li class="list-group-item">
                <b>School Year</b> <a class="float-right"><?php echo htmlspecialchars($detail->SCHOOL_YEAR); ?></a>
              </li>
              <li class="list-group-item">
                <b>Semester</b> <a class="float-right"><?php echo htmlspecialchars($detail->SEMESTER); ?></a>
              </li>
            </ul>

            <a href="<?php echo WEB_ROOT; ?>module/enrollmentdetails/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <h3 class="card-title">Enrollment Subject Details</h3>
          </div><!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th style="width:30%">Student</th>
                <td><?php echo htmlspecialchars(trim($detail->LNAME.', '.$detail->FNAME)); ?> (LRN: <?php echo htmlspecialchars($detail->LRNNO); ?>)</td>
              </tr>
              <tr>
                <th>School Year</th>
                <td><?php echo htmlspecialchars($detail->SCHOOL_YEAR); ?></td>
              </tr>
              <tr>
                <th>Semester</th>
                <td><?php echo htmlspecialchars($detail->SEMESTER); ?></td>
              </tr>
              <tr>
                <th>Subject Code</th>
                <td><?php echo htmlspecialchars($detail->SUBJECT_CODE); ?></td>
              </tr>
              <tr>
                <th>Subject Name</th>
                <td><?php echo htmlspecialchars($detail->SUBJECT_NAME); ?></td>
              </tr>
              <tr>
                <th>Units</th>
                <td><?php echo htmlspecialchars($detail->UNITS); ?></td>
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
