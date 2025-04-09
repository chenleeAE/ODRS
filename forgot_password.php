<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ODRS | Forgot Password</title>
	<link rel="icon" type="image/png" sizes="180x180" href="public/img/logo.png">
    
    <!-- Bootstrap CSS -->
    <link href="public/css/bootstrap5.min.css" rel="stylesheet">
    <link href="public/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="public/css/login.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="public/css/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Image Section (60%) -->
        <div class="col-lg-7 d-none d-lg-block image-container">
        </div>

        <!-- Form Section (40%) -->
        <div class="col-lg-5 d-flex justify-content-center align-items-center form-container">
            <form id="forgot-password-form" style="width: 100%; max-width: 400px;" autocomplete="off">
                <center>
                    <div>
                        <img src="public/img/logo.png" width="190"/>
                        <h2 style="font-size: 24px; font-weight: 600;">Online Nasipit Civil Registry</h2>
                    </div>
                </center>
                <br>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" id="email" name="email" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Send request</button>
                </div>
                <p class="text-center mt-3">
                    <a href="index.php" class="text-decoration-none">Return to Login Page</a>
                </p>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="public/js/jquery-3.1.1.min.js"></script>
<script src="public/js/plugins/toastr/toastr.min.js"></script>
<!-- SweetAlert -->
<script src="public/js/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $('#forgot-password-form').on('submit', function (event) {
        event.preventDefault();

        const url = 'modules/forgot-password.php';
        var email = $("#email").val();

        // Show loading spinner before making the request
        Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we process your request.',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.get(url, { email }, (response) => {
            console.log(response);
            const row = JSON.parse(response);
            
            // Close the loading spinner
            Swal.close();

            if ($.trim(row.status) == 'success') {
                Swal.fire({
                    title: 'Success!',
                    text: 'Your password reset request has been processed.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location = 'index.php';  // Redirect to index page
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: row.message,
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                });
            }
        }).fail(function() {
            // Handle request failure (e.g., network issues)
            Swal.close();
            Swal.fire({
                title: 'Error!',
                text: 'There was an issue processing your request. Please try again later.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
</script>
</body>
</html>
