<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Application List';
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
                    <h2>Application List</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                        <li class="active"><strong>Application List</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>
                
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>List of Applications</h5>
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
                                                <th>Copies</th>
                                                <th>Price</th>
                                                <th>Requested By</th>
                                                <th>Acted By</th>
                                                <th>Official Receipt</th>
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

            <!-- PAYMENT MODAL -->
            <div class="modal fade" id="payment-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            <h4 class="modal-title"><i class="fa fa-plus-square"></i> Payment Details</h4>
                        </div>
                        <form id="payment-form" class="form-horizontal m-t-30" autocomplete="off">
                            <div class="modal-body">
                                <div class="panel">
                                    <div class="panel-body">
                                        <input type="hidden" name="id">
                                        
                                        <h4 class="p-3">Payment Method:</h4>
                                        <div class="row">
                                            <?php 
                                                require_once('../modules/database.php');
                                                $query = "SELECT * FROM payment_type WHERE `status` = 'Active';";

                                                $result = mysqli_query($connection, $query);
                                            
                                                while($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <div class="col-md-3 text-center">
                                                    <img src="../public<?php echo $row['picture']; ?>" class="img-fluid mb-3" width="50px" height="50px" alt="Image">
                                                    <div class="details">
                                                        <h5>Type: <?php echo $row['type']; ?></h5>
                                                        <h5>Merchant Name: <?php echo $row['account_name']; ?></h5>
                                                        <p>Account Number: <?php echo $row['account_number']; ?></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="form-group">
                                            <h5 class="font-weight-bold">Total Price: <span id="total-price" class="text-success">₱0.00</span></h5>
                                        </div>

                                        <div class="form-group">
                                            <label>Proof of Payment<span class="text-danger">*</span></label>&emsp;
                                            <input class="form-control" type="file" name="file" accept=".png, .jpg, .jpeg" required />
                                            <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
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
            <!-- PAYMENT MODAL -->

        </div>
      
    </div>

    
<?php include ('../includes/scripts.php'); ?>
<script>
   $(document).ready(function () {

// Handle dropdown change
$('select[name="document_type"]').on('change', function () {
    const document_type = $(this).val();
    getData(document_type);
});

$('select[name="document_type"]').trigger('change');

// iCheck setup
$('.i-checks').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
});

// Handle pay button
$(document).on('click', 'button[data-role=payment]', function () {
    const id = $(this).data('id');
    const price = $('#' + id).children('td[data-target=price]').text();
    const copies = $('#' + id).children('td[data-target=copies]').text();
    const total = parseFloat(price) * parseInt(copies);
    $('#total-price').text(total.toFixed(2));
    $('input[name="id"]').val(id);
    $('#payment-modal').modal('toggle');
});

// Reset form modal
$(document).on('click', '#add, #close', function () {
    edit = false;
    $('#payment-type-form').trigger("reset");
    $("#active").iCheck('check');
    $('#add-modal').modal('toggle');
});

// Submit payment
$('#payment-form').submit(function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    $.ajax({
        url: '../modules/application_list/submit-payment.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if ($.trim(response) === 'success') {
                toastrOptions();
                toastr.success("Data saved successfully!", "System Message");
                $('#payment-form').trigger("reset");
                $('#payment-modal').modal('toggle');
                const documentType = $('select[name="document_type"]').val();
                getData(documentType);
            }
        },
        error: function (xhr, status, error) {
            console.error("Form submission failed: " + error);
            toastrOptions();
            toastr.error("There was an error with the form submission", "System Message");
        }
    });
});

// Cancel payment
$(document).on('click', '.cancel-payment-btn', function () {
    const id = $(this).data('id');

    Swal.fire({
        title: 'Cancel Payment?',
        text: 'This will remove your uploaded proof of payment and set your request back to FOR PAYMENT.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, cancel it',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../modules/application_list/cancel_payment.php',
                type: 'POST',
                data: { id: id },
                success: function (response) {
                    if ($.trim(response) === 'success') {
                        Swal.fire('Cancelled!', 'Your payment was cancelled.', 'success');
                        getData($('select[name="document_type"]').val());
                    } else {
                        Swal.fire('Error', 'Could not cancel payment.', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'An unexpected error occurred.', 'error');
                }
            });
        }
    });
});

// Fetch data from backend and render table
function getData(document_type) {
    const url = '../modules/application_list/get.php';
    const table = $('.table').DataTable();
    table.clear().draw();

    $.get(url, { document_type }, (response) => {
        const rows = JSON.parse(response);
        rows.forEach(row => {
            // Set badge color
            const badge = (row.status === "CLAIMED") ? "primary" : "info";
            const showPayBtn = (row.status === "FOR PAYMENT") ? "block" : "none";

            // Cancel button condition
            let cancelBtn = '';
            if (row.proof_payment && row.status === 'FOR VERIFICATION') {
                cancelBtn = `<button class="btn btn-danger btn-sm cancel-payment-btn" data-id="${row.id}">
                                <i class="fa fa-times"></i> Cancel Payment
                             </button>`;
            }

            table.row.add($(`
                <tr id="${row.id}">
                    <td>${row.id}</td>
                    <td data-target="date_requested">${moment(row.date_requested).format('MMMM D, YYYY')}</td>
                    <td data-target="copies">${row.number_of_copies}</td>
                    <td data-target="price">${row.total_price}</td>
                    <td data-target="requested_by">${row.requested_by}</td>
                    <td data-target="acted_by">${row.acted_by}</td>
                    <td>
                        ${row.official_receipt ? `<img src="../public/${row.official_receipt}" alt="Payment Image" width="50" height="50">` : ''}
                    </td>
                    <td data-target="status"><span class="badge badge-pill badge-${badge}">${row.status}</span></td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-primary" type="button" data-role='payment' data-id="${row.id}" style="color: white; display: ${showPayBtn}">
                                <i class="fa fa-money"> </i> Pay
                            </button>
                            ${cancelBtn}
                        </div>
                    </td>
                </tr>
            `)).draw();
        });

        table.order([0, 'desc']).draw();
    });
}

});


</script>
</body>

</html>
