<?php
global $mydb;

$detail = null;

if (isset($_GET['id']) && $_GET['id'] != '') {
    $mydb->setQuery("SELECT * FROM `alumni_details` WHERE `AlumniID`='".(int)$_GET['id']."' LIMIT 1");
    $detail = $mydb->loadSingleResult();
}
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$detail): ?>
    <div class="alert alert-warning">
      No record was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/details/">details list</a> and click the view button of a record.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                   src="<?php echo htmlspecialchars($detail->logo); ?>"
                   alt="Institution logo"
                   onerror="this.style.display='none'">
            </div>

            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars($detail->InstitutionName); ?>
            </h3>

            <p class="text-muted text-center">
              <?php echo htmlspecialchars($detail->Degree); ?>
            </p>

            <a href="<?php echo WEB_ROOT; ?>module/details/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <h3 class="card-title">Detail Information</h3>
          </div><!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th style="width:30%">Institution Name</th>
                <td><?php echo htmlspecialchars($detail->InstitutionName); ?></td>
              </tr>
              <tr>
                <th>Degree</th>
                <td><?php echo htmlspecialchars($detail->Degree); ?></td>
              </tr>
              <tr>
                <th>Field of Study</th>
                <td><?php echo htmlspecialchars($detail->FieldOfStudy); ?></td>
              </tr>
              <tr>
                <th>Start Date</th>
                <td><?php echo htmlspecialchars($detail->StartDate); ?></td>
              </tr>
              <tr>
                <th>End Date</th>
                <td><?php echo htmlspecialchars($detail->EndDate); ?></td>
              </tr>
              <tr>
                <th>Description</th>
                <td><?php echo nl2br(htmlspecialchars($detail->description)); ?></td>
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
