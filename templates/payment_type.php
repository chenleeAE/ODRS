<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Payment Type';
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
                    <h2>Payment Type</h2>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php">Home</a></li>
                        <li>References</li>
                        <li class="active"><strong>Payment Type</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>
                
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>List of Payment Types</h5>
                                <div class="ibox-tools">
                                    <button class="btn btn-primary btn-rounded btn-sm" id="add"><i class="fa fa-plus-circle"></i> Add</button>
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
                                                <th>Type</th>
                                                <th>Account Name</th>
                                                <th>Account Number</th>
                                                <th>Price</th>
                                                <th>Picture</th>
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

            <?php include('../includes/footer.php') ?>

            <!-- ADD MODAL -->
            <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" id="close"><span>&times;</span></button>
                            <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add / Edit Payment Type</h4>
                        </div>
                        <form id="payment-type-form" class="form-horizontal">
                            <div class="modal-body">
                                <div class="panel">
                                    <div class="panel-body">
                                        <input type="hidden" name="id">
                                       
                                        <div class="form-group">
                                            <label>Type<span class="text-danger">*</span></label> 
                                            <input type="text" name="type" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Account Name<span class="text-danger">*</span></label> 
                                            <input type="text" name="account_name" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Account Number<span class="text-danger">*</span></label> 
                                            <input type="text" name="account_number" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Price<span class="text-danger">*</span></label> 
                                            <input type="number" name="price" class="form-control" min=1 required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Picture <span class="text-danger">*</span></label>
                                            <input class="form-control" type="file" name="file" accept=".png, .jpg, .jpeg"/>
                                            <small class="form-text text-danger">Allowed file types: png, jpg, jpeg.</small>
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

        $(document).on('click', 'a[data-role=edit]', function(){
            edit = true;
            var id = $(this).data('id');
            var type = $('#'+id).children('td[data-target=type]').text();
            var account_name = $('#'+id).children('td[data-target=account_name]').text();
            var account_number = $('#'+id).children('td[data-target=account_number]').text();
            var price = $('#'+id).children('td[data-target=price]').text();
            var status = $('#'+id).children('td[data-target=status]').text();
            $('input[name="type"]').val(type);
            $('input[name="account_name"]').val(account_name);
            $('input[name="account_number"]').val(account_number);
            $('input[name="price"]').val(price);
            $("input[name='status'][value='"+status+"']").iCheck('check');
            $('input[name="id"]').val(id);
            $('#add-modal').modal('toggle');
        });

        $(document).on('click', '#add, #close', function(){
            edit = false;
            $('#payment-type-form').trigger("reset");
            $("#active").iCheck('check');
            $('#add-modal').modal('toggle');
        });

        $('#payment-type-form').submit(function(e) {
            e.preventDefault();
            // Create a new FormData object from the form
            const formData = new FormData(this);  // 'this' refers to the form
            const url = (edit) ? '../modules/reference/payment-edit.php' : '../modules/reference/payment-save.php';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,  // Let the browser set the correct content type
                processData: false,  // Prevent jQuery from processing the data
                success: function(response) {
                    if ($.trim(response) == 'success') {
                        toastrOptions();
                        toastr.success("Data saved successfully!", "System Message");
                        $('#payment-type-form').trigger("reset");
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

        function getData() {
            var badge = "";
            const url = '../modules/reference/payment-get.php';
            var table = $('.table').DataTable();
            table.clear().draw();
            $.get(url, (response) => {
                const rows = JSON.parse(response);
                rows.forEach(row => {
                    badge = (row.status == "Active") ? "primary" : "danger";

                    table.row.add($(`<tr id="${row.id}">
                                        <td>${row.id}</td>
                                        <td data-target="type">${row.type}</td>
                                        <td data-target="account_name">${row.account_name}</td>
                                        <td data-target="account_number">${row.account_number}</td>
                                        <td data-target="price">${row.price}</td>
                                        <td>
                                            <img src="../public/${row.picture}" alt="Payment Image" width="50" height="50">
                                        </td>
                                        <td data-target="status"><span class="badge badge-pill badge-${badge}">${row.status}</span></td>
                                        <td><a class='btn btn-primary btn-sm' data-role='edit' data-id="${row.id}" style="color: white;"><i class="fa fa-pencil"> </i> Edit</a></td>
                                    </tr>`)).draw();
                });
            });
            table.order([0, 'desc']).draw();
        }
	
    });

</script>
</body>

</html>
