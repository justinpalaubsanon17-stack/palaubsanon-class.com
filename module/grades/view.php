<?php
global $mydb;

$grade = null;

if (isset($_GET['id']) && $_GET['id'] != '') {
    $mydb->setQuery("SELECT g.*, s.FNAME, s.LNAME, sy.SCHOOL_YEAR, sy.SEMESTER,
                      sub.SUBJECT_CODE, sub.SUBJECT_NAME, sub.UNITS
                      FROM `tblgrades` g
                      LEFT JOIN `tblenrollment` e ON e.ENROLLMENT_ID = g.ENROLLMENT_ID
                      LEFT JOIN `tblstudent` s ON s.S_ID = e.STUDENT_ID
                      LEFT JOIN `tblschoolyear` sy ON sy.SY_ID = e.SY_ID
                      LEFT JOIN `tblsubjects` sub ON sub.SUBJECT_ID = g.SUBJECT_ID
                      WHERE g.`GRADE_ID`='".(int)$_GET['id']."' LIMIT 1");
    $grade = $mydb->loadSingleResult();
}
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$grade): ?>
    <div class="alert alert-warning">
      No record was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/grades/">grades list</a> and click the view button of a record.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars($grade->SUBJECT_CODE); ?>
            </h3>

            <p class="text-muted text-center">
              <?php echo htmlspecialchars($grade->SUBJECT_NAME); ?>
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Student</b> <a class="float-right"><?php echo htmlspecialchars(trim($grade->LNAME.', '.$grade->FNAME)); ?></a>
              </li>
              <li class="list-group-item">
                <b>School Year</b> <a class="float-right"><?php echo htmlspecialchars($grade->SCHOOL_YEAR); ?></a>
              </li>
              <li class="list-group-item">
                <b>Semester</b> <a class="float-right"><?php echo htmlspecialchars($grade->SEMESTER); ?></a>
              </li>
            </ul>

            <a href="<?php echo WEB_ROOT; ?>module/grades/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <h3 class="card-title">Grade Details</h3>
          </div><!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th style="width:30%">Student</th>
                <td><?php echo htmlspecialchars(trim($grade->LNAME.', '.$grade->FNAME)); ?></td>
              </tr>
              <tr>
                <th>School Year</th>
                <td><?php echo htmlspecialchars($grade->SCHOOL_YEAR); ?></td>
              </tr>
              <tr>
                <th>Semester</th>
                <td><?php echo htmlspecialchars($grade->SEMESTER); ?></td>
              </tr>
              <tr>
                <th>Subject Code</th>
                <td><?php echo htmlspecialchars($grade->SUBJECT_CODE); ?></td>
              </tr>
              <tr>
                <th>Subject Name</th>
                <td><?php echo htmlspecialchars($grade->SUBJECT_NAME); ?></td>
              </tr>
              <tr>
                <th>Units</th>
                <td><?php echo htmlspecialchars($grade->UNITS); ?></td>
              </tr>
              <tr>
                <th>Midterm</th>
                <td><?php echo htmlspecialchars($grade->MIDTERM); ?></td>
              </tr>
              <tr>
                <th>Final</th>
                <td><?php echo htmlspecialchars($grade->FINAL); ?></td>
              </tr>
              <tr>
                <th>Average</th>
                <td><?php echo htmlspecialchars($grade->AVERAGE); ?></td>
              </tr>
              <tr>
                <th>Remarks</th>
                <td><?php echo htmlspecialchars($grade->REMARKS); ?></td>
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
