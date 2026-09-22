<?php
require_once("../../include/initialize.php");
// if (!isset($_SESSION['ACCOUNT_ID'])){
  //    redirect(web_root."/index.php");
//     }

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
            "ajax":{
              url:"<?php echo WEB_ROOT; ?>module/cashier/ajax.php",
              type:"POST"
            },
                "columnDefs": [ {
                    "searchable": true,
                    "orderable": true,
                    "targets": 1
                }, {
                    "orderable": false,
                    "targets": [ 0, 7 ]
                } ],
                 "scrollY":        "400px",
                "scrollCollapse": true,
               "order": [[ 2, 'asc' ]]
            } );

                t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

        });
    </script>

<script type="text/javascript">
  // Auto-compute balance as amount due / amount paid change (Add modal)
  $(document).on('input', '#amount_due, #amount_paid', function(){
    var due  = parseFloat($('#amount_due').val())  || 0;
    var paid = parseFloat($('#amount_paid').val()) || 0;
    $('#balance_display').val((due - paid).toFixed(2));
  });
  // Auto-compute balance (Edit modal)
  $(document).on('input', '#amount_due1, #amount_paid1', function(){
    var due  = parseFloat($('#amount_due1').val())  || 0;
    var paid = parseFloat($('#amount_paid1').val()) || 0;
    $('#balance_display1').val((due - paid).toFixed(2));
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

       $('#UID').val(data.PAY_ID);
       $('#student_id1').val(data.student_id);
       $('#sy_id1').val(data.sy_id);
       $('#amount_due1').val(data.amount_due);
       $('#amount_paid1').val(data.amount_paid);
       $('#balance_display1').val(data.balance);
       $('#payment_date1').val(data.payment_date);
      }
    })
  });
</script>