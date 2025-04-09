<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
	<link rel="icon" type="image/png" sizes="180x180" href="public/img/logo.png">

    <!-- Bootstrap CSS -->
    <link href="public/css/bootstrap5.min.css" rel="stylesheet">
    <link href="public/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="public/css/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <link href="public/css/login.css" rel="stylesheet">
    
      <style>
    .image-container {
    background-image: url('public/img/login-bg.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    
}

.form-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.form-container-registration {
    background-color: white; /* Light gray */
    padding: 30px;
    border-radius: 8px;
}

.form-label {
    font-weight: 500;
    font-size: 16px;
}

.form-control {
    border-radius: 8px;
    padding: 12px;
    font-size: 16px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
}

.btn-primary {
    background-color:  rgb(68, 4, 4);;
    border-color: #007bff;
    border-radius: 8px;
    padding: 12px;
    font-size: 16px;
}

.btn-primary:hover {
    background-color: black;
    border-color: #004085;
}

.formContainer{
     background-color: white;
     border-radius: 20px;
     border: 1px solid;
     box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
     display: flex;
     flex-direction: column;
     align-items: center;
}
.container{
    width: 530px;
    height: 600px;
    margin: 200px auto;
}
a{
    color: #3d95af;
}
     </style>
</head>
<body>

<div class="container-fluid vh-100">
    <div class="row h-100">


       
        <div class=" image-container">

               <div class="formContainer container">

                 
            <form style="width: 100%; max-width: 500px;" id="register-form" autocomplete="off">
                <center>
                    <div>
                        <img src="public/img/logo.png" width="190"/>
                        <h2 style="font-size: 24px; font-weight: 600;">Online Civil Registry</h2>
                    </div>
                </center>

                <div class="row mb-3">
                    <div class="col-md-6 mx-auto">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="col-md-6 --mx-auto">
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mx-auto">
                        <div class="form-group">
                            <label for="mobile">Mobile Number</label>
                            <input type="text" name="mobile" maxlength="11" class="form-control"
                                                placeholder="Mobile Number" onkeydown="return ( event.ctrlKey || event.altKey 
                                                                    || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
                                                                    || (95<event.keyCode && event.keyCode<106)
                                                                    || (event.keyCode==8) || (event.keyCode==9) 
                                                                    || (event.keyCode>34 && event.keyCode<40) 
                                                                    || (event.keyCode==46) )" />

                        </div>
                    </div>
                    <div class="col-md-6 mx-auto">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mx-auto">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Address" required>
                        </div>
                    </div>
                    <div class="col-md-6 mx-auto">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>

                <p class="text-center mt-3">
                    Already have an account? <a href="index.php" class="text-decoration-none">Login</a>
                </p>
            </form>

               </div>

        </div>

       
       
       
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="public/js/jquery-3.1.1.min.js"></script>
<script src="public/js/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<script>

$('#register-form').on('submit', function(event) { 
    event.preventDefault();
    
    // Serialize the form data directly
    const formData = $(this).serialize();  // Automatically converts form data to URL-encoded string

    // Show a SweetAlert2 loading dialog while processing the request
    Swal.fire({
        title: 'Processing...',
        text: 'Please wait while we process your registration.',
        icon: 'info',
        showConfirmButton: false,
        allowOutsideClick: false,  // Prevent clicking outside to close
        didOpen: () => {
            Swal.showLoading();  // Show the loading spinner
        }
    });

    // Use $.post with form data
    $.post('modules/registration.php', formData)
        .done(response => {
            console.log(response);

            // Parse the JSON response from the server
            const jsonResponse = JSON.parse(response);

            // Close the loading spinner
            Swal.close();  

            // Handle the response logic based on the JSON response
            if (jsonResponse.status === 'success') { // Proper 'if' condition block
                Swal.fire({
                    title: 'Registration Successful!',
                    text: jsonResponse.message,
                    icon: 'success',
                    confirmButtonText: 'Okay'
                }).then(() => {
                    window.location.href = 'index.php'; // Redirect after success
                });
            } else {  // Else block for error
                Swal.fire({
                    title: 'Error',
                    text: jsonResponse.message,
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                });
            }
        })
        .fail(error => {
            console.error('Error:', error);
            // Close the loading spinner on failure
            Swal.close();
            // Show an error message if the request fails
            Swal.fire("System Message", "An error occurred. Please try again.", "error");
        });
});

</script>
</body>
</html>