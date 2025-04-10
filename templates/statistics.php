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
                                        <div class="col-md-2">
                                            <label for="frequency">Frequency <span class="text-danger">*</span></label>
                                            <select id="frequency" name="frequency" class="form-control">
                                                <option value="Yearly">Yearly</option>
                                                <option value="Monthly">Monthly</option>
                                                <option value="Daily">Daily</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2" id="dynamicFields">
                                        </div>

                                        <div class="col-md-2">
                                            <div class="btn-group mt-4" role="group" aria-label="Report Actions">
                                                <button id="printButton" class="btn btn-info" type="button">Print Report</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="printableArea">
                                    <div class="header">
                                        <img src="../public/img/logo.png" alt="College Logo" class="logo">
                                        <div class="header-content">
                                            <h2>Republic of the Philippines</h2>
                                            <p>Province of Agusan del Norte</p>
                                            <p>Municipality of Nasipit</p>
                                            <h5>OFFICE OF THE MUNICIPAL CIVIL REGISTRAR</h5>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="flot-chart">
                                        <div class="flot-chart-pie-content" id="flot-pie-chart"></div>
                                    </div>

                                    <h4>No. of Release Documents: <span id="document-count">0</span></h4>
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
        $('#printButton').click(function() {
            var printContent = document.getElementById('printableArea');
            var canvas = $("#flot-pie-chart")[0].getElementsByTagName("canvas")[0];
            if (canvas) {
                var chartImage = canvas.toDataURL();
            }

            var screenWidth = window.innerWidth;
            var screenHeight = window.innerHeight;

            // Define the window's width and height
            var windowWidth = 800;
            var windowHeight = 600;

            var left = (screenWidth - windowWidth) / 2;
            var top = (screenHeight - windowHeight) / 2;

            var newWindow = window.open('', '', `height=${windowHeight},width=${windowWidth},top=${top},left=${left}`);

            newWindow.document.write('<html><head><title>Print</title>');
            newWindow.document.write('<style>body { font-family: Arial, sans-serif; }</style>'); // Optional style
            newWindow.document.write(`<style>
                .header {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                    margin-bottom: 10px; /* Reduced space */
                }
                .logo {
                    width: 80px; /* Adjust size as needed */
                    height: 80px;
                    margin-top: -50px;
                    margin-left: -10px; /* Less space */
                }
                .header-content {
                    max-width: 400px; /* Keeps text compact */
                    margin: 0;
                    padding: 0;
                }
                h2 {
                    font-size: 16px; /* Smaller heading */
                    margin: 3px 0;
                }
                h3 {
                    margin: 6px 0;
                }
                p {
                    font-size: 12px; /* Smaller text */
                    margin: 1px 0;
                }
            </style>`);
            newWindow.document.write('</head><body>');
            newWindow.document.write(printContent.innerHTML); // Write the content of the printable div
            newWindow.document.write('<center><img src="' + chartImage + '" /></center>'); // Insert the image of the chart
            newWindow.document.write('</body></html>');
            
            newWindow.document.close();
            setTimeout(function() {
                newWindow.print();
            }, 1000);
        });
        
        $('#frequency').on('change', function() {
            var selectedFrequency = $(this).val();
            var currentYear = new Date().getFullYear();
            var dynamicContent = '';

            // Based on the selected frequency, create the appropriate fields
            if (selectedFrequency === 'Monthly') {
                // Month and Year fields
                dynamicContent = '<label for="year">Year <span class="text-danger">*</span></label>';
                dynamicContent += '<select id="year" name="year" class="form-control">';
                dynamicContent += '<option value="">Please select</option>'; // Default option
                for (var i = 2024; i <= currentYear; i++) {
                    dynamicContent += `<option value="${i}">${i}</option>`;
                }
                dynamicContent += '</select>';
                
                dynamicContent += '<label for="month">Month <span class="text-danger">*</span></label>';
                dynamicContent += '<select id="month" name="month" class="form-control">';
                dynamicContent += '<option value="">Please select</option>'; // Default option
                dynamicContent += '<option value="1">January</option>';
                dynamicContent += '<option value="2">February</option>';
                dynamicContent += '<option value="3">March</option>';
                dynamicContent += '<option value="4">April</option>';
                dynamicContent += '<option value="5">May</option>';
                dynamicContent += '<option value="6">June</option>';
                dynamicContent += '<option value="7">July</option>';
                dynamicContent += '<option value="8">August</option>';
                dynamicContent += '<option value="9">September</option>';
                dynamicContent += '<option value="10">October</option>';
                dynamicContent += '<option value="11">November</option>';
                dynamicContent += '<option value="12">December</option>';
                dynamicContent += '</select>';
            } else if (selectedFrequency === 'Yearly') {
                // Year field
                dynamicContent = '<label for="year">Year <span class="text-danger">*</span></label>';
                dynamicContent += '<select id="year" name="year" class="form-control">';
                dynamicContent += '<option value="">Please select</option>'; // Default option
                for (var i = 2024; i <= currentYear; i++) {
                    dynamicContent += `<option value="${i}">${i}</option>`;
                }
                dynamicContent += '</select>';
            } else if (selectedFrequency === 'Daily') {
                var currentDate = new Date().toISOString().split('T')[0];  // Get current date in YYYY-MM-DD format
                dynamicContent = '<label for="day">Day <span class="text-danger">*</span></label>';
                dynamicContent += `<input type="date" id="day" name="day" class="form-control" required>`;
                // dynamicContent += `<input type="date" id="day" name="day" class="form-control" value='${currentDate}' required>`;
            }

            // Insert the dynamic content into the "dynamicFields" div
            $('#dynamicFields').html(dynamicContent);
        });

        // Trigger change event on page load to set the initial state
        $('#frequency').trigger('change');

        $('select[name="document_type"]').on('change', function() {
            var document_type = $(this).val();
            var reportData = getReportData();
            getData(document_type, reportData);
        });
        
        $('#dynamicFields').on('change', 'select, input', function() {
            var document_type = $('select[name="document_type"]').val();
            var reportData = getReportData();
            getData(document_type, reportData);  
        });

        // $('select[name="document_type"]').trigger('change');

        function getReportData() {
            var selectedFrequency = $('#frequency').val();
            var reportData = {};

            // Capture the values based on the selected frequency
            if (selectedFrequency === 'Monthly') {
                var selectedYear = $('#year').val();
                var selectedMonth = $('#month').val();
                reportData = {
                    frequency: selectedFrequency,
                    year: selectedYear,
                    month: selectedMonth
                };
            } else if (selectedFrequency === 'Yearly') {
                var selectedYear = $('#year').val();
                reportData = {
                    frequency: selectedFrequency,
                    year: selectedYear
                };
            } else if (selectedFrequency === 'Daily') {
                var selectedDay = $('#day').val();
                reportData = {
                    frequency: selectedFrequency,
                    day: selectedDay
                };
            }

            return reportData;
        }

        function getData(document_type, reportData) {
            
            $.get('../modules/statistics/get.php', { document_type, reportData: JSON.stringify(reportData) }, (response) => {
                console.log(response);
                const rows = JSON.parse(response);
                console.log(rows);
                
                if (rows.message) {
                    alert('No data found!');
                    return;
                }

                // Function to sum all the 'data' values
                const totalData = rows.map(item => item.data).reduce((sum, currentData) => sum + currentData, 0);
                const spanElement = document.getElementById("document-count");
                spanElement.textContent = totalData;

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
