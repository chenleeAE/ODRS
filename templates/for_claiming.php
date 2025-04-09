<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'For Claiming';
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
                    <h2>For Claiming</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                        <li>Application List</li>
                        <li class="active"><strong>For Claiming</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>
                
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>List of All Applications</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="ibox-content">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Document Type<span class="text-danger">*</span></label>
                                            <select name="document_type" class="form-control" required>
                                                <option value="Birth Certificate">Birth Certificate</option>
                                                <option value="Death Certificate">Death Certificate</option>
                                                <option value="CENOMAR">CENOMAR</option>
                                                <option value="Marriage Certificate">Marriage Certificate</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date Requested</th>
                                                <th>Price</th>
                                                <th>Requested By</th>
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

        </div>
      
    </div>

    
<?php include ('../includes/scripts.php'); ?>
<script>
    $(document).ready(function(){
        $('select[name="document_type"]').on('change', function() {
            var documentType = $('select[name="document_type"]').val();
            getData(documentType, 'FOR CLAIMING');
        });

        $('select[name="document_type"]').trigger('change');

        $(document).on('click', 'button[data-role=claim]', function() {
            var id = $(this).data('id');
            var email = $(this).data('email');
            
            Swal.fire({
                title: "Are you sure?",
                text: "You are about to finish this transaction.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we update the transaction.',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading(); 
                        }
                    });

                    $.post('../modules/application_list/claim.php', { id: id, email: email }, function(response) {
                        if ($.trim(response) === 'success') {
                            Swal.fire({
                                title: 'System Message',
                                text: "The transaction has been claimed.",
                                icon: 'success',
                                confirmButtonText: "Okay"
                            }).then(() => location.reload());
                        } else {
                            Swal.fire("Error", "There was a problem.", "error");
                        }
                    });
                }
            });
        });

        function getData(document_type, status) {
            var badge = "";
            const url = '../modules/application_list/get-all.php';
            var table = $('.table').DataTable();
            table.clear().draw();
            $.get(url, { document_type, status }, (response) => {
                const rows = JSON.parse(response);
                rows.forEach(row => {
                    badge = (row.status == "CLAIMED") ? "primary" : "info";

                    table.row.add($(`<tr id="${row.id}">
                                        <td>${row.id}</td>
                                        <td data-target="date_requested">${moment(row.date_requested).format('MMMM D, YYYY')}</td>
                                        <td data-target="price">${row.total_price}</td>
                                        <td data-target="requested_by">${row.requested_by}</td>
                                        <td data-target="status"><span class="badge badge-pill badge-${badge}">${row.status}</span></td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-success" type="button" data-role='claim' data-id="${row.id}" data-email="${row.email}" style="color: white;"><i class="fa fa-check-square-o"> </i> Claim</button>
                                            </div>
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
