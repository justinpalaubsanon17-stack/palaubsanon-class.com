<?php

//TAGANILE SOLUTIONS - TAGANILE 2025

require_once("../../include/initialize.php");
// if (!isset($_SESSION['ACCOUNT_ID'])){
  //    redirect(web_root."/index.php");
//     }

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
 $title="User Type";
 $header=$view;
switch ($view) {
	case 'list' :
		$content    = 'list.php';
		break;

	case 'add' :
		$content    = 'add.php';
		break;

	case 'edit' :
		$content    = 'edit.php';
		break;
    case 'view' :
		$content    = 'view.php';
		break;
    case 'permision' :
    $content    = 'edit.php';
    break;

	default :
		$content    = 'list.php';
}
require_once ("../../theme/template.php");

?>

 <script type="text/javascript">
        $(document).ready(function() {
            var t = $('#tblusertype').DataTable( {
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
              url:"<?php echo WEB_ROOT; ?>module/usertype/usertype_ajax.php",
              type:"POST"
            },
                "columnDefs": [ {
                    "searchable": true,
                    "orderable": true,
                    "targets": 1
                } ],
                //vertical scroll
                 "scrollY":        "400px",
                "scrollCollapse": true,
                //ordering start at column 3
               "order": [[ 3, 'asc' ]]
            } );

                t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

        });
    </script>


  <script type="text/javascript">
  $(document).on('click', '.editEntry', function(){
    var TYPEID = $(this).attr("TYPEID");
    $.ajax({
      url:"<?php echo WEB_ROOT; ?>module/usertype/usertype_ajax.php",
      method:"POST",
      data:{TYPEID:TYPEID},
      dataType:"json",
      success:function(data)
      {
       $('#editEntry').modal('show');
       $('#TYPEID').val(data.TYPEID);
       $('#USERTYPE').val(data.USERTYPE);
        $('.modal-title').text("Modify User Type");

      }
    })
  });
  $(document).ready(function() {
$('input[type="checkbox"]').click(function(){
var id=$(this).data('id');
var ischeck = 0;
 if($(this).is(":checked")){
  ischeck = 1;
 }else{
   ischeck = 0;
 }
   $.ajax({
     url:"<?php echo WEB_ROOT; ?>module/usertype/usertype_ajax.php",
      method:"POST",
      data:{id:id, ischeck:ischeck},
      dataType:"json",

    })


});
});
</script>
