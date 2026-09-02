<?php
require_once("../../include/initialize.php");

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title = "Course Module";
$header = $view;

switch ($view) {
	case 'list' :
		$content = 'list.php';
		break;

	case 'add' :
		$content = 'add.php';
		break;

	case 'edit' :
		$content = 'edit.php';
		break;

	case 'view' :
		$content = 'view.php';
		break;

	default :
		$content = 'list.php';
}
require_once ("../../theme/template.php");

?>

<script type="text/javascript">
    $(document).ready(function() {
        var t = $('#tblcourse').DataTable( {
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
          url: "<?php echo WEB_ROOT; ?>module/course/ajax.php",
          type: "POST"
        },
        "columnDefs": [ {
            "searchable": true,
            "orderable": true,
            "targets": 1
        } ],
        "scrollY": "400px",
        "scrollCollapse": true,
        "order": [[ 3, 'asc' ]]
    } );

    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
} );
</script>

<script type="text/javascript">
  $(document).on('click', '.editEntry', function(){
    var uid = $(this).attr("UID");
    $.ajax({
      url: "<?php echo WEB_ROOT; ?>module/course/ajax.php",
      method: "POST",
      data: {UID: uid},
      dataType: "json",
      success: function(data) {
        $('#editEntry').modal('show');
        $('#UID').val(data.course_id);
        $('#course_code1').val(data.course_code);
        $('#course_name1').val(data.course_name);
      }
    });
  });
</script>

<script type="text/javascript">
  $(document).on('click', '.viewcourse', function(){
    var uid = $(this).attr("UID");
    window.location.href = "index.php?view=view&id=" + uid;
  });
</script>
