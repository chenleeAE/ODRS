<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Activity Logs';
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
                    <h2>Activity Logs</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                        <li class="active"><strong>Activity Logs</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>

            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Activity List</h5>
                                <div class="ibox-tools">
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
                                                <th>Full Name</th>
                                                <th>Logs Description</th>
                                                <th>Timestamp</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
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

</body>
<script>
    $(document).ready(function(){

        function getData() {
            var badge = "";
            const url = '../modules/activity/get.php';
            var table = $('.table').DataTable();
            table.clear().draw();
            $.get(url, (response) => {
                const rows = JSON.parse(response);
                rows.forEach(row => {
                    
                    table.row.add($(`<tr>
                                        <td>${row.first_name} ${row.last_name}</td>
                                        <td>${row.logs_detail}</td>
                                        <td>${moment(row.date_created).format('MMMM D, YYYY')}</td>
                                    </tr>`)).draw();
                });
            });
            table.order([0, 'desc']).draw();
        }
	
        getData();
    });

</script>

</html>
