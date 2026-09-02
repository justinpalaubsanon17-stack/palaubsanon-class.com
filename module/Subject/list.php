<?php
global $mydb;
$mydb->setQuery("SELECT `course_id`, `course_code`, `course_name` FROM `tblcourses` ORDER BY `course_name` ASC");
$courses = $mydb->loadResultList();
?>
 <section class="content">
      <div class="container-fluid">
         <?php check_message(); ?>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Subjects</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblsubject" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>SUBJECT CODE</th>
                    <th>SUBJECT NAME</th>
                    <th>UNITS</th>
                    <th>SEMESTER</th>
                    <th>YEAR LEVEL</th>
                    <th>COURSE</th>
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
              <h4 class="modal-title">Add New Subject</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <!-- /.card-header -->
              <div class="row">

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Subject Code</label>
                        <input type="text" class="form-control form-control-sm" name="SUBJECT_CODE"
                        id="SUBJECT_CODE" placeholder="Enter Subject Code" required>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Subject Name</label>
                        <input type="text" class="form-control form-control-sm" name="SUBJECT_NAME"
                        id="SUBJECT_NAME" placeholder="Enter Subject Name" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Units</label>
                        <input type="number" step="0.5" class="form-control form-control-sm" name="UNITS"
                        id="UNITS" placeholder="Enter Units" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Semester</label>
                         <select class="form-control form-control-sm" name="SEMESTER" id="SEMESTER" required>
                          <option value="" selected disabled>Select Semester</option>
                          <option value="1st Semester">1st Semester</option>
                          <option value="2nd Semester">2nd Semester</option>
                          <option value="Summer">Summer</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Year Level</label>
                         <select class="form-control form-control-sm" name="YEAR_LEVEL" id="YEAR_LEVEL" required>
                          <option value="" selected disabled>Select Year Level</option>
                          <option value="1">1st Year</option>
                          <option value="2">2nd Year</option>
                          <option value="3">3rd Year</option>
                          <option value="4">4th Year</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Course</label>
                         <select class="form-control form-control-sm" name="COURSE_ID" id="COURSE_ID" required>
                          <option value="" selected disabled>Select Course</option>
                          <?php foreach ($courses as $c): ?>
                          <option value="<?php echo $c->course_id; ?>"><?php echo htmlspecialchars($c->course_code.' - '.$c->course_name); ?></option>
                          <?php endforeach; ?>
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
              <h4 class="modal-title">Edit Subject</h4>
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
                       <label for="name"  class="col-form-label col-form-label-sm">Subject Code</label>
                        <input type="text" class="form-control form-control-sm" name="SUBJECT_CODE1"
                        id="SUBJECT_CODE1" placeholder="Enter Subject Code" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Subject Name</label>
                        <input type="text" class="form-control form-control-sm" name="SUBJECT_NAME1"
                        id="SUBJECT_NAME1" placeholder="Enter Subject Name" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Units</label>
                        <input type="number" step="0.5" class="form-control form-control-sm" name="UNITS1"
                        id="UNITS1" placeholder="Enter Units" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Semester</label>
                         <select class="form-control form-control-sm" name="SEMESTER1" id="SEMESTER1" required>
                          <option value="" selected disabled>Select Semester</option>
                          <option value="1st Semester">1st Semester</option>
                          <option value="2nd Semester">2nd Semester</option>
                          <option value="Summer">Summer</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Year Level</label>
                         <select class="form-control form-control-sm" name="YEAR_LEVEL1" id="YEAR_LEVEL1" required>
                          <option value="" selected disabled>Select Year Level</option>
                          <option value="1">1st Year</option>
                          <option value="2">2nd Year</option>
                          <option value="3">3rd Year</option>
                          <option value="4">4th Year</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Course</label>
                         <select class="form-control form-control-sm" name="COURSE_ID1" id="COURSE_ID1" required>
                          <option value="" selected disabled>Select Course</option>
                          <?php foreach ($courses as $c): ?>
                          <option value="<?php echo $c->course_id; ?>"><?php echo htmlspecialchars($c->course_code.' - '.$c->course_name); ?></option>
                          <?php endforeach; ?>
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