<?php
require_once("../../include/initialize.php");


$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title="Cashier Module";
$header=$view;
switch ($view) {
  case 'list' :
    $content    = 'list.php';
    break;

  case 'view' :
    $content    = 'view.php';
    break;

  default :
    $content    = 'list.php';
}
require_once ("../../theme/template.php");

?>

<script type="text/javascript">
        $(document).ready(function() {
            var t = $('#tblcashier').DataTable( {
            "processing":true,
            "serverSide":true,
            "ordering": false,
            "ajax":{
              url:"<?php echo WEB_ROOT; ?>module/cashier/ajax.php",
              type:"POST"
            },
                "columnDefs": [
                    { "searchable": true, "targets": 1 }
                ],
                 "scrollY":        "400px",
                "scrollCollapse": true
            } );

                t.on( 'search.dt', function () {
                t.column(0, {search:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

        });
    </script>

<script type="text/javascript">
  // "Pay" button on a row: opens the Add Payment modal already pointed at
  // that student's enrollment (no need to search/select it manually).
  $(document).on('click', '.payEntry', function(){
    var eid  = $(this).data('eid');
    var name = $(this).data('name');

    $('#ENROLLMENT_ID').val(eid);
    $('#PAY_STUDENT_NAME').val(name);
    $('#AddNewEntry').modal('show');
  });

  // Reset the fee type/amount/date/method/remarks fields every time the Add
  // modal opens (ENROLLMENT_ID / PAY_STUDENT_NAME are set right before this
  // by payEntry above)
  $('#AddNewEntry').on('show.bs.modal', function () {
    $('#FEE_TYPE_ID').val('');
    $('#AMOUNT_PAID').val('');
    $('#PAYMENT_DATE').val('<?php echo date('Y-m-d'); ?>');
    $('#PAYMENT_METHOD').val('Cash');
    $('#REMARKS').val('');
  });

  // Edit/View/Delete on a row with no payment yet: nothing exists to act
  // on, so let the cashier know instead of the button doing nothing.
  $(document).on('click', '.noPaymentEntry', function(){
    alert($(this).data('msg'));
  });
</script>

<script type="text/javascript">
  // Single searchable combo box: typing filters a dropdown list of matching
  // enrollments; clicking a match fills the hidden field used on submit.
  // (Still used by the Edit modal, which can reassign a payment to a
  // different enrollment.)
  function setupEnrollmentCombo(inputSel, hiddenSel, containerSel) {
    var $input     = $(inputSel);
    var $hidden    = $(hiddenSel);
    var $container = $(containerSel);
    var $options   = $container.find('.enrollment-option');
    var $noMatch   = $container.find('.no-match');

    function filterOptions(term) {
      term = term.toLowerCase();
      var anyVisible = false;
      $options.each(function () {
        var match = $(this).data('text').toString().toLowerCase().indexOf(term) > -1;
        $(this).toggle(match);
        if (match) { anyVisible = true; }
      });
      $noMatch.toggle(!anyVisible);
    }

    $input.on('focus', function () {
      filterOptions($input.val());
      $container.show();
    });

    $input.on('keyup', function () {
      $hidden.val('');            // typing invalidates any previous selection
      $input.removeClass('is-invalid');
      filterOptions($input.val());
      $container.show();
    });

    $container.on('click', '.enrollment-option', function () {
      $hidden.val($(this).data('id'));
      $input.val($(this).data('text'));
      $input.removeClass('is-invalid');
      $container.hide();
    });

    $(document).on('click', function (e) {
      if (!$(e.target).closest($input).length && !$(e.target).closest($container).length) {
        $container.hide();
      }
    });
  }

  $(document).ready(function () {
    setupEnrollmentCombo('#ENROLLMENT_SEARCH1', '#ENROLLMENT_ID1', '#enrollmentOptionsEdit');
  });

  $('#editEntry form').on('submit', function (e) {
    if ($('#ENROLLMENT_ID1').val() === '') {
      e.preventDefault();
      $('#enrollmentErrorEdit').show();
      $('#ENROLLMENT_SEARCH1').addClass('is-invalid').focus();
    }
  });
</script>

<script type="text/javascript">
  $(document).on('click', '.editEntry', function(){
    var uid = $(this).attr("UID");
    $.ajax({
      url:"<?php echo WEB_ROOT; ?>module/cashier/ajax.php",
      method:"POST",
      data:{UID:uid},
      dataType:"json",
      success:function(data)
      {
       $('#editEntry').modal('show');

       $('#UID').val(data.UID);

       var $match = $('#enrollmentOptionsEdit .enrollment-option[data-id="' + data.ENROLLMENT_ID + '"]');
       $('#ENROLLMENT_ID1').val(data.ENROLLMENT_ID);
       $('#ENROLLMENT_SEARCH1').val($match.length ? $match.data('text') : '').removeClass('is-invalid');
       $('#enrollmentOptionsEdit').hide();
       $('#enrollmentErrorEdit').hide();

       $('#FEE_TYPE_ID1').val(data.FEE_TYPE_ID);
       $('#AMOUNT_PAID1').val(data.AMOUNT_PAID);
       $('#PAYMENT_DATE1').val(data.PAYMENT_DATE);
       $('#PAYMENT_METHOD1').val(data.PAYMENT_METHOD);
       $('#REMARKS1').val(data.REMARKS);

      }
    })
  });
</script>

<script type="text/javascript">
  $(document).on('click', '.setFeeEntry', function(){
    var eid = $(this).attr("EID");
    $.ajax({
      url:"<?php echo WEB_ROOT; ?>module/cashier/ajax.php",
      method:"POST",
      data:{FEE_ENROLLMENT_ID:eid},
      dataType:"json",
      success:function(data)
      {
       $('#setFeeEntry').modal('show');

       $('#ENROLLMENT_ID_FEE').val(data.ENROLLMENT_ID);
       $('#STUDENT_NAME_FEE').text(data.STUDENT_NAME);
       $('#TOTAL_FEE2').val(data.TOTAL_FEE);

      }
    })
  });
</script>