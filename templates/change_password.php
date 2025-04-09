<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Change Password';
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
                    <h2>Change Password</h2>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php">Home</a></li>
                        <li class="active"><strong>Change Password</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>
                
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Password Form</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <form id="change-password-form">
                                    <div class="form-group">
                                        <label>Old Password<span class="text-danger">*</span></label> 
                                        <input type="password" id="old_password" class="form-control" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label>New Password<span class="text-danger">*</span></label> 
                                        <input type="password" id="new_password" class="form-control" autocomplete="off" required>
                                    </div>
                                    <button type="submit" class="btn waves-effect waves-light btn-success">Save Changes</button>
                                </form>
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

        $('#change-password-form').submit(function(e){
            e.preventDefault();

            const formData = {
                old_password: $("#old_password").val(),
                new_password: $("#new_password").val()
            };
            const url = '../modules/profile/change_password.php';

            $.post(url, formData, (response) => {
                if ($.trim(response) === 'success') {
                    Swal.fire('System Message', 'Password changed successfully!', 'info').then(() => {
                        location.reload();
                    });
                } 
                else {
                    Swal.fire("System Message", $.trim(response), "info");
                }
            });

        });
	
    });

</script>
</body>

</html>
