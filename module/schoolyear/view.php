<?php
global $mydb;

$schoolyear = null;

if (isset($_GET['id']) && $_GET['id'] != '') {
    $mydb->setQuery("SELECT * FROM `tblschoolyear`
                      WHERE `SY_ID`='".(int)$_GET['id']."' LIMIT 1");
    $schoolyear = $mydb->loadSingleResult();
}

$semester_labels = array('1st' => '1st Semester', '2nd' => '2nd Semester', 'Summer' => 'Summer');
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$schoolyear): ?>
    <div class="alert alert-warning">
      No school year was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/schoolyear/">school year list</a> and click the view button of a school year.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars($schoolyear->school_year); ?>
            </h3>

            <p class="text-muted text-center">
              <?php echo isset($semester_labels[$schoolyear->semester]) ? $semester_labels[$schoolyear->semester] : htmlspecialchars($schoolyear->semester); ?>
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Status</b>
                <a class="float-right">
                  <?php if ($schoolyear->status == 'Open'): ?>
                    <span class="badge badge-success">Open</span>
                  <?php else: ?>
                    <span class="badge badge-secondary">Closed</span>
                  <?php endif; ?>
                </a>
              </li>
            </ul>

            <a href="<?php echo WEB_ROOT; ?>module/schoolyear/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <h3 class="card-title">School Year Details</h3>
          </div><!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th style="width:30%">School Year</th>
                <td><?php echo htmlspecialchars($schoolyear->school_year); ?></td>
              </tr>
              <tr>
                <th>Semester</th>
                <td><?php echo isset($semester_labels[$schoolyear->semester]) ? $semester_labels[$schoolyear->semester] : htmlspecialchars($schoolyear->semester); ?></td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  <?php if ($schoolyear->status == 'Open'): ?>
                    <span class="badge badge-success">Open</span>
                  <?php else: ?>
                    <span class="badge badge-secondary">Closed</span>
                  <?php endif; ?>
                </td>
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