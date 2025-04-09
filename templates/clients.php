<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Clients';
	include ('../includes/header.php');
	if(!isset($_SESSION['id'])){ header("Location: ../index.php"); }
?>

<body>
    <div id="wrapper">
        <?php include ('../includes/sidebar.php'); ?>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <?php include ('../includes/navbar.php'); ?>
            
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Clients</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                        <li class="active"><strong>Clients</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>

            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Clients List</h5>
                                <div class="ibox-tools">
                                     <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="data"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('../includes/footer.php') ?>

            <!-- RESET MODAL -->
            <div class="modal fade" id="reset-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Reset Password</h4>
                        </div>
                        <div class="modal-body">
                            <div class="panel">
                                <input type="hidden" name="id">
                                <h2>Are you sure you want to reset the password?</h2>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="close1" class="btn btn-secondary">Cancel</button>
                            <!-- <a class='ladda-button ladda-button-demo btn btn-primary' id='id"+ info[i][0] +"' data-style='zoom-in' data-role='email' data-id='"+ info[i][0] +"'> <i class='fa fa-envelope'></i> Send Email</a> -->
                            <button type="button" class="ladda-button ladda-button-demo btn btn-primary" data-role="submit" data-style='zoom-in'>Yes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END RESET MODAL -->

        </div>
      
    </div>

    
<?php include ('../includes/scripts.php'); ?>
<script>
    $(document).ready(function(){
        var edit = false;
        getData();

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        $(document).on('click', '#close1', function(){
            $('#reset-modal').modal('toggle');
        });

        $(document).on('click', 'button[data-role=submit]', function(){
            var id = $('input[name="id"]').val();

            var btn = $('.ladda-button-demo').ladda();
            const url = '../modules/clients/reset-password.php';
			$.ajax({
				data : { id },
				url  : url,
				type : 'POST',
				beforeSend: function(){
                    $("#close1").attr("disabled", true);
					btn.ladda('start');
				},
				complete: function(){
                    $("#close1").attr("disabled", false);
					btn.ladda('stop');
				},
				success: function(response){
                    if($.trim(response) == 'Email has been sent successfully!') {
                        $('#reset-modal').modal('toggle');
                        toastrOptions();
                        toastr.success('Reset Successfully!', 'Update Info');
                        getData();
                    }
				}
			});
        });

        $(document).on('click', 'a[data-role=reset]', function(){
            var id = $(this).data('id');
            $('input[name="id"]').val(id);
            $('#reset-modal').modal('toggle');
        });

        function getData() {
            var badge = "";
            const url = '../modules/clients/get.php';
            var table = $('.table').DataTable();
            table.clear().draw();
            $.get(url, (response) => {
                const rows = JSON.parse(response);
                rows.forEach(row => {
                    badge = (row.status == "Active") ? "primary" : "danger";

                    table.row.add($(`<tr id="${row.id}">
                                        <td>${row.id}</td>
                                        <td>${row.first_name}</td>
                                        <td>${row.last_name}</td>
                                        <td>${row.mobile_number}</td>
                                        <td>${row.email}</td>
                                        <td>${row.address}</td>
                                        <td data-target="status"><span class="badge badge-pill badge-${badge}">${row.status}</span></td>
                                    </tr>`)).draw();
                });
            });
            table.order([0, 'desc']).draw();
        }
	
    });

</script>
</body>

</html>
