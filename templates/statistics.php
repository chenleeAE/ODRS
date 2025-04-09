<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Statistics';
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
                    <h2>Statistics</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                        <li class="active"><strong>Statistics</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>
                
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Pie Chart of Applications</h5>
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
                                                <option value="All">All</option>
                                                <option value="Birth Certificate">Birth Certificate</option>
                                                <option value="Death Certificate">Death Certificate</option>
                                                <option value="CENOMAR">CENOMAR</option>
                                                <option value="Marriage Certificate">Marriage Certificate</option>
                                                <option value="Marriage License">Marriage License</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="flot-chart">
                                    <div class="flot-chart-pie-content" id="flot-pie-chart"></div>
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
            var document_type = $(this).val();
            getData(document_type);
        });

        $('select[name="document_type"]').trigger('change');

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        function getData(document_type) {
            
            $.get('../modules/statistics/get.php', { document_type }, (response) => {
                const rows = JSON.parse(response);
                var data = rows;

                // Now plot the data using Flot
                var plotObj = $.plot($("#flot-pie-chart"), data, {
                    series: {
                        pie: {
                            show: true
                        }
                    },
                    grid: {
                        hoverable: true
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                        shifts: {
                            x: 20,
                            y: 0
                        },
                        defaultTheme: false
                    }
                });

            });
            
        }
	
    });

</script>
</body>

</html>
