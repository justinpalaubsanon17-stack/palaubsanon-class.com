<?php
global $mydb;

// Students for the dropdowns
$mydb->setQuery("SELECT `S_ID`, `IDNO`, `FNAME`, `MNAME`, `LNAME` FROM `tblstudent` ORDER BY `LNAME` ASC");
$studentList = $mydb->loadResultList();

// School years for the dropdowns
$mydb->setQuery("SELECT `sy_id`, `school_year`, `semester` FROM `tblschoolyear` ORDER BY `sy_id` DESC");
$syList = $mydb->loadResultList();
?>

 <section class="content">
      <div class="container-fluid">
         <?php check_message(); ?>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Cashier - Student Payments</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblcashier" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>School Year</th>
                    <th>Amount Due</th>
                    <th>Amount Paid</th>
                    <th>Balance</th>
                    <th>Payment Date</th>
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
              <h4 class="modal-title">Record New Payment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="student_id" class="col-form-label col-form-label-sm">Student</label>
                        <select class="form-control form-control-sm" name="student_id" id="student_id" required>
                          <option value="">Select Student</option>
                          <?php foreach ($studentList as $s): ?>
                          <option value="<?php echo $s->S_ID; ?>"><?php echo htmlspecialchars($s->LNAME.', '.$s->FNAME.' '.$s->MNAME.' ('.$s->IDNO.')'); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="sy_id" class="col-form-label col-form-label-sm">School Year</label>
                        <select class="form-control form-control-sm" name="sy_id" id="sy_id" required>
                          <option value="">Select School Year</option>
                          <?php foreach ($syList as $sy): ?>
                          <option value="<?php echo $sy->sy_id; ?>"><?php echo htmlspecialchars($sy->school_year.' - '.$sy->semester); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="amount_due" class="col-form-label col-form-label-sm">Amount Due</label>
                        <input type="number" step="0.01" min="0" class="form-control form-control-sm" name="amount_due"
                        id="amount_due" placeholder="0.00" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="amount_paid" class="col-form-label col-form-label-sm">Amount Paid</label>
                        <input type="number" step="0.01" min="0" class="form-control form-control-sm" name="amount_paid"
                        id="amount_paid" placeholder="0.00" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label class="col-form-label col-form-label-sm">Balance (auto-computed)</label>
                        <input type="text" class="form-control form-control-sm" id="balance_display" readonly>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="payment_date" class="col-form-label col-form-label-sm">Payment Date</label>
                        <input type="date" class="form-control form-control-sm" name="payment_date"
                        id="payment_date">
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


   <div class="modal fade" id="editEntry">
        <div class="modal-dialog">
        <form action="controller.php?action=edit" enctype="multipart/form-data" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Payment Record</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">

<input type="hidden" name="UID" id="UID">

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="student_id1" class="col-form-label col-form-label-sm">Student</label>
                        <select class="form-control form-control-sm" name="student_id1" id="student_id1" required>
                          <option value="">Select Student</option>
                          <?php foreach ($studentList as $s): ?>
                          <option value="<?php echo $s->S_ID; ?>"><?php echo htmlspecialchars($s->LNAME.', '.$s->FNAME.' '.$s->MNAME.' ('.$s->IDNO.')'); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="sy_id1" class="col-form-label col-form-label-sm">School Year</label>
                        <select class="form-control form-control-sm" name="sy_id1" id="sy_id1" required>
                          <option value="">Select School Year</option>
                          <?php foreach ($syList as $sy): ?>
                          <option value="<?php echo $sy->sy_id; ?>"><?php echo htmlspecialchars($sy->school_year.' - '.$sy->semester); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="amount_due1" class="col-form-label col-form-label-sm">Amount Due</label>
                        <input type="number" step="0.01" min="0" class="form-control form-control-sm" name="amount_due1"
                        id="amount_due1" placeholder="0.00" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="amount_paid1" class="col-form-label col-form-label-sm">Amount Paid</label>
                        <input type="number" step="0.01" min="0" class="form-control form-control-sm" name="amount_paid1"
                        id="amount_paid1" placeholder="0.00" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label class="col-form-label col-form-label-sm">Balance (auto-computed)</label>
                        <input type="text" class="form-control form-control-sm" id="balance_display1" readonly>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="payment_date1" class="col-form-label col-form-label-sm">Payment Date</label>
                        <input type="date" class="form-control form-control-sm" name="payment_date1"
                        id="payment_date1">
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