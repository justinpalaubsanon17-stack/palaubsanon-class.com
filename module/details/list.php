 <section class="content">
      <div class="container-fluid">
         <?php check_message(); ?>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Details</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tbldetails" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <!-- `InstitutionName`, `Degree`, `FieldOfStudy`, `StartDate`, `EndDate` -->
                    <th>INSTITUTION NAME</th>
                    <th>DEGREE</th>
                    <th>FIELD OF STUDY</th>
                    <th>START DATE</th>
                    <th>END DATE</th>

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
              <h4 class="modal-title">Add New Detail</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <!-- /.card-header -->
              <div class="row">

 <!-- /.container-fluid //`InstitutionName`, `Degree`, `FieldOfStudy`, `StartDate`, `EndDate`, `logo`, `description` -->

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Institution Name</label>
                        <input type="text" class="form-control form-control-sm" name="InstitutionName"
                        id="InstitutionName" placeholder="Enter Institution Name" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Degree</label>
                        <input type="text" class="form-control form-control-sm" name="Degree"
                        id="Degree" placeholder="Enter Degree" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Field of Study</label>
                        <input type="text" class="form-control form-control-sm" name="FieldOfStudy"
                        id="FieldOfStudy" placeholder="Enter Field of Study">
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Start Date</label>
                        <input type="date" class="form-control form-control-sm" name="StartDate"
                        id="StartDate">
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">End Date</label>
                        <input type="date" class="form-control form-control-sm" name="EndDate"
                        id="EndDate">
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Logo (URL or path)</label>
                        <input type="text" class="form-control form-control-sm" name="logo"
                        id="logo" placeholder="Enter Logo URL or Path" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Description</label>
                        <textarea class="form-control form-control-sm" name="description"
                        id="description" placeholder="Enter Description" rows="3" required></textarea>
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
              <h4 class="modal-title">Edit Detail</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <!-- /.card-header -->
              <div class="row">

 <!-- /.container-fluid //`InstitutionName`, `Degree`, `FieldOfStudy`, `StartDate`, `EndDate`, `logo`, `description` -->

<input type="text" name="UID" id="UID">

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Institution Name</label>
                        <input type="text" class="form-control form-control-sm" name="InstitutionName1"
                        id="InstitutionName1" placeholder="Enter Institution Name" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Degree</label>
                        <input type="text" class="form-control form-control-sm" name="Degree1"
                        id="Degree1" placeholder="Enter Degree" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Field of Study</label>
                        <input type="text" class="form-control form-control-sm" name="FieldOfStudy1"
                        id="FieldOfStudy1" placeholder="Enter Field of Study">
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Start Date</label>
                        <input type="date" class="form-control form-control-sm" name="StartDate1"
                        id="StartDate1">
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">End Date</label>
                        <input type="date" class="form-control form-control-sm" name="EndDate1"
                        id="EndDate1">
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Logo (URL or path)</label>
                        <input type="text" class="form-control form-control-sm" name="logo1"
                        id="logo1" placeholder="Enter Logo URL or Path" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Description</label>
                        <textarea class="form-control form-control-sm" name="description1"
                        id="description1" placeholder="Enter Description" rows="3" required></textarea>
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
