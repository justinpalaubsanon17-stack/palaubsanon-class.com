<?php
global $mydb;

$feeType = null;

if (isset($_GET['id']) && $_GET['id'] != '') {
    $mydb->setQuery("SELECT * FROM `tblfeetypes`
                      WHERE `fee_type_id`='".(int)$_GET['id']."' LIMIT 1");
    $feeType = $mydb->loadSingleResult();
}
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$feeType): ?>
    <div class="alert alert-warning">
      No fee type was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/feetype/">fee type list</a> and click the view button of a fee type.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars($feeType->fee_type_name); ?>
            </h3>

            <p class="text-muted text-center">
              <?php echo htmlspecialchars($feeType->description); ?>
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Created At</b> <a class="float-right"><?php echo htmlspecialchars($feeType->created_at); ?></a>
              </li>
            </ul>

            <a href="<?php echo WEB_ROOT; ?>module/feetype/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <h3 class="card-title">Fee Type Details</h3>
          </div><!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th style="width:30%">Fee Type Name</th>
                <td><?php echo htmlspecialchars($feeType->fee_type_name); ?></td>
              </tr>
              <tr>
                <th>Description</th>
                <td><?php echo htmlspecialchars($feeType->description); ?></td>
              </tr>
              <tr>
                <th>Created At</th>
                <td><?php echo htmlspecialchars($feeType->created_at); ?></td>
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
