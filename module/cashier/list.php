<?php
global $mydb;
$mydb->setQuery("SELECT e.`ENROLLMENT_ID`, s.`FNAME`, s.`LNAME`, s.`IDNO`, sy.`SCHOOL_YEAR`, sy.`SEMESTER`
  FROM `tblenrollment` e
  LEFT JOIN `tblstudent` s ON s.`S_ID` = e.`STUDENT_ID`
  LEFT JOIN `tblschoolyear` sy ON sy.`SY_ID` = e.`SY_ID`
  ORDER BY s.`LNAME` ASC");
$enrollments = $mydb->loadResultList();

$mydb->setQuery("SELECT `fee_type_id`, `fee_type_name` FROM `tblfeetypes` ORDER BY `fee_type_name` ASC");
$feeTypes = $mydb->loadResultList();
?>
 <section class="content">
      <div class="container-fluid">
         <?php check_message(); ?>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Payments</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblcashier" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>STUDENT NAME</th>
                    <th>ID NUMBER</th>
                    <th>SCHOOL YEAR</th>
                    <th>AMOUNT PAID</th>
                    <th>BALANCE</th>
                    <th>PAYMENT DATE</th>
                    <th>METHOD</th>
                    <th>FEE TYPE</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>

                  </tfoot>
                </table>
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
              <h4 class="modal-title">Record Payment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">

                    <input type="hidden" name="ENROLLMENT_ID" id="ENROLLMENT_ID">

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Paying For</label>
                        <input type="text" class="form-control form-control-sm" id="PAY_STUDENT_NAME" readonly>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Fee Type</label>
                         <select class="form-control form-control-sm" name="FEE_TYPE_ID" id="FEE_TYPE_ID" required>
                          <option value="" selected disabled>Select Fee Type</option>
                          <?php foreach ($feeTypes as $ft): ?>
                          <option value="<?php echo $ft->fee_type_id; ?>"><?php echo htmlspecialchars($ft->fee_type_name); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Amount Paid</label>
                        <input type="number" step="0.01" min="0.01" class="form-control form-control-sm" name="AMOUNT_PAID"
                        id="AMOUNT_PAID" placeholder="Enter Amount Paid" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Payment Date</label>
                        <input type="date" class="form-control form-control-sm" name="PAYMENT_DATE"
                        id="PAYMENT_DATE" value="<?php echo date('Y-m-d'); ?>" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Payment Method</label>
                         <select class="form-control form-control-sm" name="PAYMENT_METHOD" id="PAYMENT_METHOD">
                          <option value="Cash" selected>Cash</option>
                          <option value="GCash">GCash</option>
                          <option value="Bank Transfer">Bank Transfer</option>
                          <option value="Check">Check</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Remarks</label>
                        <input type="text" class="form-control form-control-sm" name="REMARKS"
                        id="REMARKS" placeholder="Optional remarks">
                      </div>
                    </div>

                  </div>

            </div>
            <div class="modal-footer justify-content-between">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary" name="save" type="submit">Pay Now</button>

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
              <h4 class="modal-title">Edit Payment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">

<input type="hidden" name="UID" id="UID">

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Enrollment (Student / School Year)</label>
                       <div style="position:relative;">
                         <input type="text" class="form-control form-control-sm" id="ENROLLMENT_SEARCH1" placeholder="Type student name or ID number to search..." autocomplete="off">
                         <input type="hidden" name="ENROLLMENT_ID1" id="ENROLLMENT_ID1">
                         <div class="list-group enrollment-options" id="enrollmentOptionsEdit" style="position:absolute; z-index:1060; width:100%; max-height:220px; overflow-y:auto; display:none; border:1px solid #ced4da; border-top:none;">
                          <?php foreach ($enrollments as $e): ?>
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action enrollment-option" data-id="<?php echo $e->ENROLLMENT_ID; ?>" data-text="<?php echo htmlspecialchars($e->LNAME.', '.$e->FNAME.' ('.$e->IDNO.') - '.$e->SCHOOL_YEAR.' ('.$e->SEMESTER.')'); ?>"><?php echo htmlspecialchars($e->LNAME.', '.$e->FNAME.' ('.$e->IDNO.') - '.$e->SCHOOL_YEAR.' ('.$e->SEMESTER.')'); ?></a>
                          <?php endforeach; ?>
                          <div class="list-group-item text-muted no-match" style="display:none;">No matching enrollment found.</div>
                         </div>
                       </div>
                       <small class="text-danger enrollment-error" id="enrollmentErrorEdit" style="display:none;">Please select an enrollment from the list.</small>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Fee Type</label>
                         <select class="form-control form-control-sm" name="FEE_TYPE_ID1" id="FEE_TYPE_ID1" required>
                          <option value="" selected disabled>Select Fee Type</option>
                          <?php foreach ($feeTypes as $ft): ?>
                          <option value="<?php echo $ft->fee_type_id; ?>"><?php echo htmlspecialchars($ft->fee_type_name); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Amount Paid</label>
                        <input type="number" step="0.01" min="0.01" class="form-control form-control-sm" name="AMOUNT_PAID1"
                        id="AMOUNT_PAID1" placeholder="Enter Amount Paid" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Payment Date</label>
                        <input type="date" class="form-control form-control-sm" name="PAYMENT_DATE1"
                        id="PAYMENT_DATE1" required>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Payment Method</label>
                         <select class="form-control form-control-sm" name="PAYMENT_METHOD1" id="PAYMENT_METHOD1">
                          <option value="Cash">Cash</option>
                          <option value="GCash">GCash</option>
                          <option value="Bank Transfer">Bank Transfer</option>
                          <option value="Check">Check</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Remarks</label>
                        <input type="text" class="form-control form-control-sm" name="REMARKS1"
                        id="REMARKS1" placeholder="Optional remarks">
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


   <div class="modal fade" id="setFeeEntry">
        <div class="modal-dialog">
        <form action="controller.php?action=setfee" enctype="multipart/form-data" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Set Total Fee</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">

<input type="hidden" name="ENROLLMENT_ID_FEE" id="ENROLLMENT_ID_FEE">

                    <div class="col-sm-12">
                      <p><strong id="STUDENT_NAME_FEE"></strong></p>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                       <label for="name"  class="col-form-label col-form-label-sm">Total Fee</label>
                        <input type="number" step="0.01" min="0" class="form-control form-control-sm" name="TOTAL_FEE"
                        id="TOTAL_FEE2" placeholder="Enter Total Fee" required>
                      </div>
                    </div>

                  </div>

            </div>
            <div class="modal-footer justify-content-between">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary" name="save" type="submit">Save Fee</button>

            </div>
          </div>
          </form>
        </div>
      </div>
<!-----START of Set Fee Form---->

<?php

?>