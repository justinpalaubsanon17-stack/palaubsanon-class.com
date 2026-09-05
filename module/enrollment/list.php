<?php
global $mydb;
$mydb->setQuery("SELECT `S_ID`, `FNAME`, `LNAME` FROM `tblstudent` ORDER BY `LNAME` ASC");
$students = $mydb->loadResultList();

$mydb->setQuery("SELECT `SY_ID`, `SCHOOL_YEAR`, `SEMESTER` FROM `tblschoolyear` ORDER BY `SCHOOL_YEAR` DESC");
$schoolyears = $mydb->loadResultList();
?>
 <section class="content">
      <div class="container-fluid">
         <?php check_message(); ?>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Enrollments</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblenrollment" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>STUDENT NAME</th>
                    <th>SCHOOL YEAR</th>
                    <th>SEMESTER</th>
                    <th>ENROLLMENT DATE</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>

                  </tfoot>
                </table>
                  <div class="btn-group">

                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddNewEntry">Add New</button>

                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>


<div class="modal fade" id="AddNewEntry">
        <div class="modal-dialog">
        <form action="controller.php?action=add" enctype="multipart/form-data" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add New Enrollment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <!-- /.card-header -->
              <div class="row">

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Student</label>
                         <select class="form-control form-control-sm" name="STUDENT_ID" id="STUDENT_ID" required>
                          <option value="" selected disabled>Select Student</option>
                          <?php foreach ($students as $s): ?>
                          <option value="<?php echo $s->S_ID; ?>"><?php echo htmlspecialchars($s->LNAME.', '.$s->FNAME); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">School Year</label>
                         <select class="form-control form-control-sm" name="SY_ID" id="SY_ID" required>
                          <option value="" selected disabled>Select School Year</option>
                          <?php foreach ($schoolyears as $sy): ?>
                          <option value="<?php echo $sy->SY_ID; ?>"><?php echo htmlspecialchars($sy->SCHOOL_YEAR.' - '.$sy->SEMESTER); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Enrollment Date</label>
                        <input type="date" class="form-control form-control-sm" name="ENROLLMENT_DATE"
                        id="ENROLLMENT_DATE" required>
                      </div>
                    </div>

                  </div>

              <!-- /.card-body -->

            </div>
            <div class="modal-footer justify-content-between">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary" name="save" type="submit">Save changes</button>

            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
<!-----START of Add Form---->


   <div class="modal fade" id="editEntry">
        <div class="modal-dialog">
        <form action="controller.php?action=edit" enctype="multipart/form-data" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Enrollment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <!-- /.card-header -->
              <div class="row">

<input type="hidden" name="UID" id="UID">

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Student</label>
                         <select class="form-control form-control-sm" name="STUDENT_ID1" id="STUDENT_ID1" required>
                          <option value="" selected disabled>Select Student</option>
                          <?php foreach ($students as $s): ?>
                          <option value="<?php echo $s->S_ID; ?>"><?php echo htmlspecialchars($s->LNAME.', '.$s->FNAME); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">School Year</label>
                         <select class="form-control form-control-sm" name="SY_ID1" id="SY_ID1" required>
                          <option value="" selected disabled>Select School Year</option>
                          <?php foreach ($schoolyears as $sy): ?>
                          <option value="<?php echo $sy->SY_ID; ?>"><?php echo htmlspecialchars($sy->SCHOOL_YEAR.' - '.$sy->SEMESTER); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Enrollment Date</label>
                        <input type="date" class="form-control form-control-sm" name="ENROLLMENT_DATE1"
                        id="ENROLLMENT_DATE1" required>
                      </div>
                    </div>

                  </div>

              <!-- /.card-body -->

            </div>
            <div class="modal-footer justify-content-between">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary" name="save" type="submit">Save changes</button>

            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
<!-----START of Add Form---->

<?php

?>
