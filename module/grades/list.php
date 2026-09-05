<?php
global $mydb;
$mydb->setQuery("SELECT e.`ENROLLMENT_ID`, s.`FNAME`, s.`LNAME`, sy.`SCHOOL_YEAR`, sy.`SEMESTER`
	FROM `tblenrollment` e
	LEFT JOIN `tblstudent` s ON s.`S_ID` = e.`STUDENT_ID`
	LEFT JOIN `tblschoolyear` sy ON sy.`SY_ID` = e.`SY_ID`
	ORDER BY s.`LNAME` ASC");
$enrollments = $mydb->loadResultList();

$mydb->setQuery("SELECT `SUBJECT_ID`, `SUBJECT_CODE`, `SUBJECT_NAME` FROM `tblsubjects` ORDER BY `SUBJECT_NAME` ASC");
$subjects = $mydb->loadResultList();
?>
 <section class="content">
      <div class="container-fluid">
         <?php check_message(); ?>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Grades</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblgrades" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>STUDENT NAME</th>
                    <th>SCHOOL YEAR</th>
                    <th>SUBJECT</th>
                    <th>MIDTERM</th>
                    <th>FINAL</th>
                    <th>AVERAGE</th>
                    <th>REMARKS</th>
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
              <h4 class="modal-title">Add New Grade</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <!-- /.card-header -->
              <div class="row">

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Enrollment (Student / School Year)</label>
                         <select class="form-control form-control-sm" name="ENROLLMENT_ID" id="ENROLLMENT_ID" required>
                          <option value="" selected disabled>Select Enrollment</option>
                          <?php foreach ($enrollments as $e): ?>
                          <option value="<?php echo $e->ENROLLMENT_ID; ?>"><?php echo htmlspecialchars($e->LNAME.', '.$e->FNAME.' - '.$e->SCHOOL_YEAR.' ('.$e->SEMESTER.')'); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Subject</label>
                         <select class="form-control form-control-sm" name="SUBJECT_ID" id="SUBJECT_ID" required>
                          <option value="" selected disabled>Select Subject</option>
                          <?php foreach ($subjects as $sub): ?>
                          <option value="<?php echo $sub->SUBJECT_ID; ?>"><?php echo htmlspecialchars($sub->SUBJECT_CODE.' - '.$sub->SUBJECT_NAME); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Midterm</label>
                        <input type="number" step="0.01" min="0" max="100" class="form-control form-control-sm" name="MIDTERM"
                        id="MIDTERM" placeholder="Enter Midterm Grade" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Final</label>
                        <input type="number" step="0.01" min="0" max="100" class="form-control form-control-sm" name="FINAL"
                        id="FINAL" placeholder="Enter Final Grade" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Remarks</label>
                         <select class="form-control form-control-sm" name="REMARKS" id="REMARKS">
                          <option selected value="">Select Remarks</option>
                          <option value="Passed">Passed</option>
                          <option value="Failed">Failed</option>
                          <option value="Incomplete">Incomplete</option>
                        </select>
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
              <h4 class="modal-title">Edit Grade</h4>
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
                       <label for="name"  class="col-form-label col-form-label-sm">Enrollment (Student / School Year)</label>
                         <select class="form-control form-control-sm" name="ENROLLMENT_ID1" id="ENROLLMENT_ID1" required>
                          <option value="" selected disabled>Select Enrollment</option>
                          <?php foreach ($enrollments as $e): ?>
                          <option value="<?php echo $e->ENROLLMENT_ID; ?>"><?php echo htmlspecialchars($e->LNAME.', '.$e->FNAME.' - '.$e->SCHOOL_YEAR.' ('.$e->SEMESTER.')'); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Subject</label>
                         <select class="form-control form-control-sm" name="SUBJECT_ID1" id="SUBJECT_ID1" required>
                          <option value="" selected disabled>Select Subject</option>
                          <?php foreach ($subjects as $sub): ?>
                          <option value="<?php echo $sub->SUBJECT_ID; ?>"><?php echo htmlspecialchars($sub->SUBJECT_CODE.' - '.$sub->SUBJECT_NAME); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Midterm</label>
                        <input type="number" step="0.01" min="0" max="100" class="form-control form-control-sm" name="MIDTERM1"
                        id="MIDTERM1" placeholder="Enter Midterm Grade" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Final</label>
                        <input type="number" step="0.01" min="0" max="100" class="form-control form-control-sm" name="FINAL1"
                        id="FINAL1" placeholder="Enter Final Grade" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Remarks</label>
                         <select class="form-control form-control-sm" name="REMARKS1" id="REMARKS1">
                          <option selected value="">Select Remarks</option>
                          <option value="Passed">Passed</option>
                          <option value="Failed">Failed</option>
                          <option value="Incomplete">Incomplete</option>
                        </select>
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
