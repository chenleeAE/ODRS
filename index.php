<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ODRS | Login Page</title>
	<link rel="icon" type="image/png" sizes="180x180" href="public/img/logo.png">
    
    <!-- Bootstrap CSS -->
    <link href="public/css/bootstrap5.min.css" rel="stylesheet">
    <link href="public/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="../public/css/login.css" rel="stylesheet">
    
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
    background-color:  rgb(68, 4, 4);
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


        <!-- Image Section (60%) -->
        <div class=" image-container">

              <div class="formContainer container">

              <form id="login-form">
                <center>
                    <div>
                        <img src="public/img/logo.png" width="190"/>
                        <h2 style="font-size: 24px; font-weight: 600;">Online Nasipit Civil Registry</h2>
                    </div>
                </center>
                <br>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">LOGIN</button>
                </div>
                <p class="text-center mt-3">
                    Don't have an account? <a href="registration.php" class="text-decoration-none">Sign Up</a>
                </p>
                <p class="text-center">
                    <a href="forgot_password.php" class="text-decoration-none">Trouble Logging In? Reset Your Password</a>
                </p>
            </form>

              </div>


        </div>

        
       
           
       
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="public/js/jquery-3.1.1.min.js"></script>
<script src="public/js/plugins/toastr/toastr.min.js"></script>

<script>
    $('#login-form').on('submit', function (event) {
        event.preventDefault();

        const url = 'modules/login.php';

        var username = $("#username").val();
        var password = $("#password").val();

        $.get(url, { username, password }, (response) => {
			const row = JSON.parse(response);
            if ($.trim(row.status) == 'success') {
                window.location = 'templates/dashboard.php';
            } else {
                toastr.error(row.message, 'Error');
            }
        });
    });
</script>
</body>
</html>