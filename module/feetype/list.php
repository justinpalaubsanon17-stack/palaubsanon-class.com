 <section class="content">
      <div class="container-fluid">
         <?php check_message(); ?>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Fee Types</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblfeetype" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Fee Type Name</th>
                    <th>Description</th>
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
              <h4 class="modal-title">Add New Fee Type</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Fee Type Name</label>
                        <input type="text" class="form-control form-control-sm" name="fee_type_name"
                        id="fee_type_name" placeholder="e.g. Tuition Fee" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Description</label>
                        <input type="text" class="form-control form-control-sm" name="description"
                        id="description" placeholder="Optional description">
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
<!-----START of Add Form---->


   <div class="modal fade" id="editEntry">
        <div class="modal-dialog">
        <form action="controller.php?action=edit" enctype="multipart/form-data" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Fee Type</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">

<input type="hidden" name="UID" id="UID">

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Fee Type Name</label>
                        <input type="text" class="form-control form-control-sm" name="fee_type_name1"
                        id="fee_type_name1" placeholder="e.g. Tuition Fee" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Description</label>
                        <input type="text" class="form-control form-control-sm" name="description1"
                        id="description1" placeholder="Optional description">
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
<!-----START of Edit Form---->

<?php

?>
