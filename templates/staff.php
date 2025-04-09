<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Staff';
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
                    <h2>Staff</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                        <li class="active"><strong>Staff</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>

            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Staff List</h5>
                                <div class="ibox-tools">
                                    <button class="btn btn-primary btn-rounded btn-sm" id="add"><i class="fa fa-plus-circle"></i> Add</button>
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Status<span class="text-danger">*</span></label>
                                            <select name="status" class="form-control" required>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Username</th>
                                                <th>Status</th>
                                                <th>Action</th>
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

            
            <!-- ADD MODAL -->
            <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" id="close"><span>&times;</span></button>
                            <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add / Edit Staff</h4>
                        </div>
                        <form id="staff-form" class="form-horizontal" autocomplete="off">
                            <div class="modal-body">
                                <div class="panel">
                                    <div class="panel-body">
                                        <input type="hidden" name="id">
                                       
                                        <div class="form-group">
                                            <label>First Name<span class="text-danger">*</span></label> 
                                            <input type="text" name="first_name" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name<span class="text-danger">*</span></label> 
                                            <input type="text" name="last_name" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Username<span class="text-danger">*</span></label> 
                                            <input type="text" name="username" class="form-control" autocomplete="off" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Status<span class="text-danger">*</span></label>&emsp;
                                            <div class="i-checks checkbox-inline">
                                                <label><input type="radio" value="Active" id="active" name="status" required> Active </label>
                                            </div>
                                            <div class="i-checks checkbox-inline">
                                                <label> <input type="radio" value="Inactive" name="status" required> Inactive </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END ADD MODAL -->

            <?php include('../includes/footer.php') ?>
            
        </div>
      
    </div>

    
<?php include ('../includes/scripts.php'); ?>
<script>
    $(document).ready(function(){
        var edit = false;
        
        $('select[name="status"]').change(function(){
            var selectedValue = $(this).val(); // Get the selected value
            getData(selectedValue);
        });

        $('select[name="status"]').trigger('change');

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        $(document).on('click', '#add, #close', function(){
            edit = false;
            $('#payment-type-form').trigger("reset");
            $("#active").iCheck('check');
            $('#add-modal').modal('toggle');
        });

        $(document).on('click', 'a[data-role=edit]', function(){
            edit = true;
            var id = $(this).data('id');
            var first_name = $('#'+id).children('td[data-target=first_name]').text();
            var last_name = $('#'+id).children('td[data-target=last_name]').text();
            var username = $('#'+id).children('td[data-target=username]').text();
            var status = $('#'+id).children('td[data-target=status]').text();
            $('input[name="first_name"]').val(first_name);
            $('input[name="last_name"]').val(last_name);
            $('input[name="username"]').val(username);
            $("input[name='status'][value='"+status+"']").iCheck('check');
            $('input[name="id"]').val(id);
            $('#add-modal').modal('toggle');
        });
        
        $('#staff-form').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);  // 'this' refers to the form
            const url = (edit) ? '../modules/staff/edit.php' : '../modules/staff/save.php';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,  // Let the browser set the correct content type
                processData: false,  // Prevent jQuery from processing the data
                success: function(response) {
                    console.log(response);
                    if ($.trim(response) == 'success') {
                        toastrOptions();
                        toastr.success("Data saved successfully!", "System Message");
                        $('#staff-form').trigger("reset");
                        $('#add-modal').modal('toggle');
                        getData();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Form submission failed: " + error);
                    toastrOptions();
                    toastr.error("There was an error with the form submission", "System Message");
                }
            });
        });

        function getData(status) {
            var badge = "";
            const url = '../modules/staff/get.php';
            var table = $('.table').DataTable();
            table.clear().draw();
            $.get(url, { status }, (response) => {
                const rows = JSON.parse(response);
                rows.forEach(row => {
                    badge = (row.status == "Active") ? "primary" : "danger";

                    table.row.add($(`<tr id="${row.id}">
                                        <td>${row.id}</td>
                                        <td data-target="first_name">${row.first_name}</td>
                                        <td data-target="last_name">${row.last_name}</td>
                                        <td data-target="username">${row.username}</td>
                                        <td data-target="status"><span class="badge badge-pill badge-${badge}">${row.status}</span></td>
                                        <td>
                                            <a class='btn btn-primary btn-sm' data-role='edit' data-id="${row.id}" style="color: white;"><i class="fa fa-pencil"> </i> Edit</a>
                                        </td>
                                    </tr>`)).draw();
                });
            });
            table.order([0, 'desc']).draw();
        }
	
    });

</script>
</body>

</html>
