<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Pending Payment';
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
                    <h2>Pending Payment</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                        <li>Application List</li>
                        <li class="active"><strong>Pending Payment</strong></li>
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
            getData(documentType, 'FOR PAYMENT');
        });

        $('select[name="document_type"]').trigger('change');

        $(document).on('click', 'button[data-role=reminder]', function(){
            var id = $(this).data('id');

            $.get('../modules/application_list/reminder.php', {id})
                .done(response => {
                    if ($.trim(response) === 'Email has been sent successfully!') {
                        Swal.fire("System Message", response, "success");
                    } else {
                        Swal.fire("System Message", response, "info");
                    }
                })
                .fail(error => {
                    console.error('Error:', error);
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
                                        <td data-target="price">${row.price}</td>
                                        <td data-target="requested_by">${row.requested_by}</td>
                                        <td data-target="status"><span class="badge badge-pill badge-${badge}">${row.status}</span></td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-primary" type="button" data-role='reminder' data-id="${row.id}" style="color: white;"><i class="fa fa-send"> </i> Reminder</button>
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
