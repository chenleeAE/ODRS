<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Marriage License';
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
                    <h2>Marriage License</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                        <li class="active"><strong>Marriage License</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>
                
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>List of Marriage License</h5>
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
                                                <th>Client Name</th>
                                                <th>Received By</th>
                                                <th>License No</th>
                                                <th>Date Created</th>
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
            <?php include('modal/license.php') ?>
            <!-- END ADD MODAL -->

            <!-- REPORT LICENSE MODAL -->
            <?php include('modal/report_license.php') ?>
            <!-- END REPORT LICENSE MODAL -->
             
            <!-- REPORT NOTICE MODAL -->
            <?php include('modal/report_notice.php') ?>
            <!-- END REPORT NOTICE MODAL -->

            <?php include('../includes/footer.php') ?>
        </div>
      
    </div>

    
<?php include ('../includes/scripts.php'); ?>
<script src="../public/js/application/marriage-license.js"></script>

<script>
    $(document).ready(function(){
        $(document).on('click', '#add, #close', function(){
            edit = false;
            $('#license-form').trigger("reset");
            $('#add-modal').modal('toggle');
        });

        $('#license-form').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this); 
            $.ajax({
                url: '../modules/marriage_license/save.php',
                type: 'POST',
                data: formData,
                contentType: false,  // Let the browser set the correct content type
                processData: false,  // Prevent jQuery from processing the data
                success: function(response) {
                    // console.log(response);
                    if ($.trim(response) == 'success') {
                        toastrOptions();
                        toastr.success("Data saved successfully!", "System Message");
                        $('#couple-form').trigger("reset");
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
            var showNoticeBtn = "";
            const url = '../modules/marriage_license/get-all.php';
            var table = $('.table').DataTable();
            table.clear().draw();
            $.get(url, (response) => {
                console.log(response);
                const rows = JSON.parse(response);
                console.log(rows);
                rows.forEach(row => {
                    badge = (row.status == "CLAIMED") ? "primary" : "info";
                    showNoticeBtn = (!row.license_no) ? "block" : "none";

                    table.row.add($(`<tr id="${row.id}">
                                        <td data-target="client_name">${row.client_name}</td>
                                        <td data-target="received_by">${row.received_by}</td>
                                        <td data-target="licence_no">${row.licence_no || ''}</td>
                                        <td data-target="date_created">${moment(row.date_created).format('MMMM D, YYYY')}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-expanded="true">Action <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="groom_details.php?license_id=${row.license_id}">Groom Details</a></li>
                                                    <li><a href="bride_details.php?license_id=${row.license_id}">Bride Details</a></li>
                                                    <li style="display: ${showNoticeBtn}">
                                                        <a data-role='generate-license' data-id="${row.license_id}">Print License</a>
                                                    </li>
                                                    <li style="display: ${showNoticeBtn}">
                                                        <a data-role='generate-notice' data-id="${row.license_id}">Print Notice</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>`)).draw();
                });
            });
            table.order([0, 'desc']).draw();
        }

        getData();

    });

</script>
</body>

</html>
