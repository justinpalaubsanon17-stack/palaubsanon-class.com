<?php
global $mydb;

$subject = null;

if (isset($_GET['id']) && $_GET['id'] != '') {
    $mydb->setQuery("SELECT s.*, c.course_code, c.course_name
                      FROM `tblsubjects` s
                      LEFT JOIN `tblcourses` c ON c.course_id = s.COURSE_ID
                      WHERE s.`SUBJECT_ID`='".(int)$_GET['id']."' LIMIT 1");
    $subject = $mydb->loadSingleResult();
}

$semester_labels = array('1' => '1st Semester', '2' => '2nd Semester', '3' => 'Summer');
$year_labels     = array('1' => '1st Year', '2' => '2nd Year', '3' => '3rd Year', '4' => '4th Year');
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$subject): ?>
    <div class="alert alert-warning">
      No subject was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/subject/">subject list</a> and click the view button of a subject.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars($subject->SUBJECT_CODE); ?>
            </h3>

            <p class="text-muted text-center">
              <?php echo htmlspecialchars($subject->SUBJECT_NAME); ?>
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Units</b> <a class="float-right"><?php echo htmlspecialchars($subject->UNITS); ?></a>
              </li>
              <li class="list-group-item">
                <b>Semester</b> <a class="float-right"><?php echo isset($semester_labels[$subject->SEMESTER]) ? $semester_labels[$subject->SEMESTER] : htmlspecialchars($subject->SEMESTER); ?></a>
              </li>
              <li class="list-group-item">
                <b>Year Level</b> <a class="float-right"><?php echo isset($year_labels[$subject->YEAR_LEVEL]) ? $year_labels[$subject->YEAR_LEVEL] : htmlspecialchars($subject->YEAR_LEVEL); ?></a>
              </li>
            </ul>

            <a href="<?php echo WEB_ROOT; ?>module/subject/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <h3 class="card-title">Subject Details</h3>
          </div><!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th style="width:30%">Subject Code</th>
                <td><?php echo htmlspecialchars($subject->SUBJECT_CODE); ?></td>
              </tr>
              <tr>
                <th>Subject Name</th>
                <td><?php echo htmlspecialchars($subject->SUBJECT_NAME); ?></td>
              </tr>
              <tr>
                <th>Units</th>
                <td><?php echo htmlspecialchars($subject->UNITS); ?></td>
              </tr>
              <tr>
                <th>Semester</th>
                <td><?php echo isset($semester_labels[$subject->SEMESTER]) ? $semester_labels[$subject->SEMESTER] : htmlspecialchars($subject->SEMESTER); ?></td>
              </tr>
              <tr>
                <th>Year Level</th>
                <td><?php echo isset($year_labels[$subject->YEAR_LEVEL]) ? $year_labels[$subject->YEAR_LEVEL] : htmlspecialchars($subject->YEAR_LEVEL); ?></td>
              </tr>
              <tr>
                <th>Course</th>
                <td><?php echo isset($subject->course_name) ? htmlspecialchars($subject->course_code.' - '.$subject->course_name) : ''; ?></td>
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
