<?php
global $mydb;
$mydb->setQuery("SELECT DISTINCT `course_code`, `course_name` FROM `tblcourses` ORDER BY `course_code` ASC");
$courseSuggestions = $mydb->loadResultList();
?>

<section class="content">
      <div class="container-fluid">
         <?php check_message(); ?>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Courses</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblcourse" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Created At</th>
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
                  <button type="button" class="btn btn-secondary" id="btnPrintCourses">
                    <span class="fa fa-print"></span> Print
                  </button>
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

<!-- Add New Course Modal -->
<div class="modal fade" id="AddNewEntry">
        <div class="modal-dialog">
        <form action="controller.php?action=add" enctype="multipart/form-data" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add New Course</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="course_code" class="font-weight-bold" style="font-size: 1rem;">Course Code</label>
                        <input type="text" class="form-control" name="course_code"
                        id="course_code" placeholder="Enter Course Code" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="course_name" class="font-weight-bold" style="font-size: 1rem;">Course Name</label>
                        <input type="text" class="form-control" name="course_name"
                        id="course_name" placeholder="Enter Course Name" required>
                      </div>
                    </div>
                  </div>

            </div>
            <div class="modal-footer justify-content-between">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-primary" name="save" type="submit">Save changes</button>
            </div>
          </div>
          </form>
        </div>
</div>

<!-- Edit Course Modal -->
<div class="modal fade" id="editEntry">
        <div class="modal-dialog">
        <form action="controller.php?action=edit" enctype="multipart/form-data" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Course</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">
                <input type="hidden" name="UID" id="UID">

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="course_code1" class="font-weight-bold" style="font-size: 1rem;">Course Code</label>
                        <select class="form-control form-control-sm" name="course_code1" id="course_code1" required>
                          <option value="" selected disabled>Select Course Code</option>
                          <?php foreach ($courseSuggestions as $s): ?>
                          <option value="<?php echo htmlspecialchars($s->course_code); ?>"><?php echo htmlspecialchars($s->course_code); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="course_name1" class="font-weight-bold" style="font-size: 1rem;">Course Name</label>
                        <select class="form-control form-control-sm" name="course_name1" id="course_name1" required>
                          <option value="" selected disabled>Select Course Name</option>
                          <?php foreach ($courseSuggestions as $s): ?>
                          <option value="<?php echo htmlspecialchars($s->course_name); ?>"><?php echo htmlspecialchars($s->course_name); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>

            </div>
            <div class="modal-footer justify-content-between">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-primary" name="save" type="submit">Save changes</button>
            </div>
          </div>
          </form>
        </div>
</div>