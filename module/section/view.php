<?php
global $mydb;

$section = null;

if (isset($_GET['id']) && $_GET['id'] != '') {
    $mydb->setQuery("SELECT s.*, c.course_code, c.course_name
                      FROM `tblsections` s
                      LEFT JOIN `tblcourses` c ON c.course_id = s.COURSE_ID
                      WHERE s.`SECTION_ID`='".(int)$_GET['id']."' LIMIT 1");
    $section = $mydb->loadSingleResult();
}

$year_labels = array('1' => '1st Year', '2' => '2nd Year', '3' => '3rd Year', '4' => '4th Year');

// TEMP DEBUG: uncomment the line below to see the real column names returned,
// then remove SECTION_NAME / YEAR_LEVEL guesses below once confirmed.
// if ($section) { echo '<pre>'; print_r($section); echo '</pre>'; }

$sectionName = isset($section->SECTION_NAME) ? $section->SECTION_NAME : '';
$yearLevel   = isset($section->YEAR_LEVEL) ? $section->YEAR_LEVEL : '';
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$section): ?>
    <div class="alert alert-warning">
      No section was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/section/">section list</a> and click the view button of a section.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars($sectionName); ?>
            </h3>

            <p class="text-muted text-center">
              <?php echo isset($year_labels[$yearLevel]) ? $year_labels[$yearLevel] : htmlspecialchars($yearLevel); ?>
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Course</b> <a class="float-right"><?php echo isset($section->course_name) ? htmlspecialchars($section->course_code) : ''; ?></a>
              </li>
            </ul>

            <a href="<?php echo WEB_ROOT; ?>module/section/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <h3 class="card-title">Section Details</h3>
          </div><!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th style="width:30%">Section Name</th>
                <td><?php echo htmlspecialchars($sectionName); ?></td>
              </tr>
              <tr>
                <th>Year Level</th>
                <td><?php echo isset($year_labels[$yearLevel]) ? $year_labels[$yearLevel] : htmlspecialchars($yearLevel); ?></td>
              </tr>
              <tr>
                <th>Course</th>
                <td><?php echo isset($section->course_name) ? htmlspecialchars($section->course_code.' - '.$section->course_name) : ''; ?></td>
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