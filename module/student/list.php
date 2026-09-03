 <section class="content">
      <div class="container-fluid">
         <?php check_message(); ?>
        <div class="row">
          <div class="col-12">
          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Students</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblstudent" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <!-- <th>Emp#</th> -->
                    <!-- /`LNAME`, `FNAME`, `MNAME`, `SEX`, `BDAY`-->
                    <th>LNAME</th>
                    <th>FNAME</th>
                    <th>MNAME</th>
                    <th>SEX</th>
                      <th>BDAY</th>
                      <th>BPLACE</th>

                   
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
              <h4 class="modal-title">Add New Student</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                         
              <!-- /.card-header -->
              <div class="row">
                    
 <!-- /.container-fluid //`IDNO`, `FNAME`, `LNAME`, `MNAME`, `SEX`, `BDAY` -->

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Student ID Number</label>
                        <input type="text" class="form-control form-control-sm" name="IDNO"
                        id="IDNO" placeholder="Enter Student ID Number" required>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">First Name</label>
                        <input type="text" class="form-control form-control-sm" name="FNAME"
                        id="FNAME" placeholder="Enter First Name" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Middle Name</label>
                        <input type="text" class="form-control form-control-sm" name="MNAME"
                        id="MNAME" placeholder="Enter Middle Name" required>
                      </div>
                    </div>
                   
  <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Last Name</label>
                        <input type="text" class="form-control form-control-sm" name="LNAME"
                        id="LNAME" placeholder="Enter Last Name" required>
                      </div>
                    </div>


  <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Select Gender</label>
                         <select class="form-control form-control-sm" name="SEX" id="SEX">
                          <option selected>Select Gender</option>
  <option value="Male">Male</option>
  <option value="Female">Female</option>
                         
                        </select> 
                      </div>
                    </div>



                     <div class="col-sm-12">


                      <div class="form-group">
                       <label for="TYPE"  class="col-form-label col-form-label-sm">Date Started</label>
                       
                        <input type="date" class="form-control form-control-sm" name="BDAY"
                        id="BDAY" placeholder="Enter Birth of Date" required>
                      </div>
                    </div>
                   
                  </div>
                                
                <!-- /.card-body -->
           
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
              <h4 class="modal-title">Edit Student</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                         
              <!-- /.card-header -->
              <div class="row">
                    
 <!-- /.container-fluid //`IDNO`, `FNAME`, `LNAME`, `MNAME`, `SEX`, `BDAY` -->

<input type="text" name="UID" id="UID">



                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Student ID Number</label>
                        <input type="text" class="form-control form-control-sm" name="IDNO1"
                        id="IDNO1" placeholder="Enter Student ID Number" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">First Name</label>
                        <input type="text" class="form-control form-control-sm" name="FNAME1"
                        id="FNAME1" placeholder="Enter First Name" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Middle Name</label>
                        <input type="text" class="form-control form-control-sm" name="MNAME1"
                        id="MNAME1" placeholder="Enter Middle Name" required>
                      </div>
                    </div>
                   
  <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Last Name</label>
                        <input type="text" class="form-control form-control-sm" name="LNAME1"
                        id="LNAME1" placeholder="Enter Last Name" required>
                      </div>
                    </div>


  <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Select Gender</label>
                         <select class="form-control form-control-sm" name="SEX1" id="SEX1">
                          <option selected>Select Gender</option>
  <option value="Male">Male</option>
  <option value="Female">Female</option>
                         
                        </select> 
                      </div>
                    </div>



                     <div class="col-sm-12">


                      <div class="form-group">
                       <label for="TYPE"  class="col-form-label col-form-label-sm">Date Started</label>
                       
                        <input type="date" class="form-control form-control-sm" name="BDAY1"
                        id="BDAY1" placeholder="Enter Birth of Date" required>
                      </div>
                    </div>
                   
                  </div>
                                
                <!-- /.card-body -->
           
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