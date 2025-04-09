<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Home';
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
                    <h2>Home</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>

            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <center>
                                    <div>
                                        <img src="../public/img/logo.png" width="190"/>
                                        <h2 style="font-size: 24px; font-weight: 600;">ONLINE DOCUMENT REQUEST SYSTEM </h2>
                                    </div>
                                    <div>
                                        <h2 style="font-size: 24px; font-weight: 600; line-height: 1.5;">
                                            Welcome to the LCR Nasipit Application Form! 
                                            <br> 
                                            This platform streamlines your civil registry document requests, 
                                            <br> offering, efficiency, accessibility and transparency.
                                        </h2>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('../includes/footer.php') ?>

        </div>
      
    </div>

    <?php include ('../includes/scripts.php'); ?>
</body>

</html>
