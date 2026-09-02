<?php
require_once("../../include/initialize.php");


$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title="Subject Module";
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

	default :
		$content    = 'list.php';
}
require_once ("../../theme/template.php");

?>

<script type="text/javascript">
        $(document).ready(function() {
            var t = $('#tblsubject').DataTable( {
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
              url:"<?php echo WEB_ROOT; ?>module/subject/ajax.php",
              type:"POST"
            },
                "columnDefs": [ {
                    "searchable": true,
                    "orderable": true,
                    "targets": 1
                } ],
                 "scrollY":        "400px",
                "scrollCollapse": true,
               "order": [[ 1, 'asc' ]]
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
    var uid = $(this).attr("UID");
    $.ajax({
      url:"<?php echo WEB_ROOT; ?>module/subject/ajax.php",
      method:"POST",
      data:{UID:uid},
      dataType:"json",
      success:function(data)
      {
       $('#editEntry').modal('show');

       $('#UID').val(data.UID);
       $('#SUBJECT_CODE1').val(data.SUBJECT_CODE);
       $('#SUBJECT_NAME1').val(data.SUBJECT_NAME);
       $('#UNITS1').val(data.UNITS);
       $('#SEMESTER1').val(data.SEMESTER);
       $('#YEAR_LEVEL1').val(data.YEAR_LEVEL);
       $('#COURSE_ID1').val(data.COURSE_ID);

      }
    })
  });
</script>
