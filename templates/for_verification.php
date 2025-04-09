<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'For Verification';
	include ('../includes/header.php');
	if(!isset($_SESSION['id'])){ header("Location: ../index.php"); }
?>
       <head>
        <link rel="stylesheet" href="../public/css/message.css">
       </head>
<body>
    <div id="wrapper">
        <?php include ('../includes/sidebar.php'); ?>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <?php include ('../includes/navbar.php'); ?>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>For Verification</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                        <li>Application List</li>
                        <li class="active"><strong>For Verification</strong></li>
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

            <!-- VIEW MODAL -->
            <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            <h4 class="modal-title"><i class="fa fa-plus-square"></i> View Proof of Payment</h4>
                        </div>
                        <div class="modal-body">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <center>
                                            <img id="modalImage" src="" alt="User Image" class="img-fluid">
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"></div>
                    </div>
                </div>
            </div>
            <!-- VIEW MODAL -->
               
<!-- Message Modal -->
<div class="modal fade" id="message-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="messageModalLabel" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-envelope"></i> Send Message</h4>
            </div>
            <div class="modal-body">
                <form id="sendMessageForm">
                    <div class="form-group">
                        <label for="messageContent">Message</label>
                        <textarea class="form-control" id="messageContent" name="messageContent" rows="5" required></textarea>
                    </div>
                    <input type="hidden" id="recipientId" name="recipientId">
                    <input type="hidden" id="recipientEmail" name="recipientEmail">
                </form>

            

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="sendMessageButton">Send Message</button>
            </div>
        </div>
    </div>
</div>

        </div>
      
    </div>

    
<?php include ('../includes/scripts.php'); ?>

<script>
    $(document).ready(function(){
        $('select[name="document_type"]').on('change', function() {
            var documentType = $('select[name="document_type"]').val();
            getData(documentType, 'FOR VERIFICATION');
        });

        $('select[name="document_type"]').trigger('change');

        $(document).on('click', 'button[data-role=approve]', function() {
            var id = $(this).data('id');
            var email = $(this).data('email');
            
            Swal.fire({
                title: "Are you sure?",
                text: "You are about to verify this transaction.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading while the AJAX request is being processed
                    Swal.fire({
                        title: 'Verifying...',
                        text: 'Please wait while we process your request.',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Make the POST request
                    $.post('../modules/application_list/verify.php', { id: id, email: email }, function(response) {
                        console.log(response);

                        // Close the loading screen when the request is done
                        Swal.close();

                        // Check if the response is success
                        if ($.trim(response) === 'success') {
                            Swal.fire({
                                title: 'System Message',
                                text: "The transaction has been verified and email sent.",
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

// Reject button click handler (similar to approve)
$(document).on('click', 'button[data-role=reject]', function() {
        var id = $(this).data('id');
        var email = $(this).data('email');
        
        Swal.fire({
            title: "Are you sure?",
            text: "You are about to reject this transaction.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Reject!",
            cancelButtonText: "No",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading while the AJAX request is being processed
                Swal.fire({
                    title: 'Rejecting...',
                    text: 'Please wait while we process your request.',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Make the POST request
                $.post('../modules/application_list/reject.php', { id: id, email: email }, function(response) {
                    console.log(response);

                    // Close the loading screen when the request is done
                    Swal.close();

                    // Check if the response is success
                    if ($.trim(response) === 'success') {
                        Swal.fire({
                            title: 'System Message',
                            text: "The transaction has been rejected and email sent.",
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




    
});

                


        $(document).on('click', 'button[data-role=view]', function(){
            var imagePath = $(this).data('image');
            $('#modalImage').attr('src', '../public' + imagePath);
            $('#view-modal').modal('toggle');
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
                                                <button class="btn btn-primary" type="button" data-role='view' data-id="${row.id}" data-image="${row.proof_payment}" style="color: white;"><i class="fa fa-eye"> </i> View</button>
                                                <button class="btn btn-success" type="button" data-role='approve' data-id="${row.id}" data-email="${row.email}" style="color: white;"><i class="fa fa-thumbs-up"> </i> Approve</button>
                                                <button class="btn btn-danger"  type="button" data-role='reject' data-id="${row.id}" data-email="${row.email}"  style="color: white;"> <i class="fa fa-times">Reject </i></button>
    

                                            <button class="btn btn-info" type="button" data-role='message' data-id="${row.id}" data-email="${row.email}" style="color: white;"><i class="fa fa-envelope"> </i> Message</button> <!-- New Message Button -->
                                            </div>
                                        </td>
                                    </tr>`)).draw();
                });
            });
            table.order([0, 'desc']).draw();
        }


        $(document).on('click', 'button[data-role=message]', function(){
        var id = $(this).data('id');
        var email = $(this).data('email');

        // Populate the hidden fields with the id and email of the recipient
        $('#recipientId').val(id);
        $('#recipientEmail').val(email);

        // Show the message modal
        $('#message-modal').modal('show');
    });
	
   

    $(document).ready(function(){
    // Handle form submission for sending the message
    $('#sendMessageButton').on('click', function(){
        var messageContent = $('#messageContent').val();
        var recipientId = $('#recipientId').val();
        var recipientEmail = $('#recipientEmail').val();

        if (messageContent.trim() === "") {
            alert("Please enter a message before sending.");
            return;
        }

        // Send the message via AJAX to a PHP file (send_email.php)
        $.ajax({
            url: '../modules/send_email.php', // Backend PHP file to handle sending the email
            type: 'POST',
            data: {
                messageContent: messageContent,
                recipientId: recipientId,
                recipientEmail: recipientEmail
            },
            success: function(response) {
    // Log the response to the console for debugging purposes
    console.log("Response from server:", response);

    // Check if the response is a success or an error
    if (response.trim() === "success") {
            alert("Message sent successfully!");
            $('#message-modal').modal('hide');
            $('#sendMessageForm')[0].reset();
        } else {
            alert("There was an error sending the message: " + response);  // Show error message
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error("AJAX request failed: " + textStatus, errorThrown);  // Log full error
        alert("Something went wrong. Please try again.");
    }
        });
    });
});     





</script>

    

</body>

</html>