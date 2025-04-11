<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Report';
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
                    <h2>Report</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                        <li class="active"><strong>Report</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>
                
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>List of Records</h5>
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
                                            <label>Search Name</label>
                                            <input type="text" id="search_name" name="search_name" class="form-control" placeholder="Search Name">
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
                                        <img src="../public/img/logo.png" alt="Municipal logo" class="logo">
                                        <div class="header-content">
                                            <h2>Republic of the Philippines</h2>
                                            <p>Province of Agusan del Norte</p>
                                            <p>Municipality of Nasipit</p>
                                            <h5>OFFICE OF THE MUNICIPAL CIVIL REGISTRAR</h5>
                                            <br>
                                        </div>
                                    </div>
                                        
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example report-table" >
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Document Type</th>
                                                    <th>Date Requested</th>
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
            </div>
            
            <!-- Report Modal -->
            <div id="report-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body" id="report-form">
                            <button class="btnPrint" style="background-color: #007BFF; color: white; padding: 15px 25px; border: none; border-radius: 5px; cursor: pointer;"
                                onmouseover="this.style.backgroundColor='#0056b3'" 
                                onmouseout="this.style.backgroundColor='#007BFF'" onclick="window.print()">PRINT
                            </button>
                            
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

                            <table id="report-table">
                                <thead></thead>
                                <tbody></tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div> 
            <!-- Report Modal -->

            <?php include('../includes/footer.php') ?>
        </div>
      
    </div>

<?php include ('../includes/scripts.php'); ?>

<script>
    $(document).ready(function(){
        $('#printButton').click(function() {
            event.preventDefault(); // Prevent form submission

            var document_type = $('select[name="document_type"]').val();
            var search_name = $('#search_name').val();
            
            var reportData = getReportData();
            fetchReportData(document_type, reportData, search_name);  

            setTimeout(() => {
                // $('#report-modal').modal('toggle');
                let css = `
                    @media print {
                        @page {
                            size: A4 landscape;  /* Ensure page size is A4 in landscape orientation */
                        }
                    }
                `;
                
                var toPrint = document.getElementById('report-form');
                var newTab = window.open('', '_blank');
                newTab.document.write('<html><head><title>Released Report</title>');
                newTab.document.write('<style>' + css + '</style>');

                // Link to an external CSS file
                newTab.document.write('<link rel="stylesheet" type="text/css" href="../public/css/report.css?v=' + new Date().getTime() + '">');

                newTab.document.write('</head><body>');
                newTab.document.write(toPrint.innerHTML);
                newTab.document.write('</body></html>');

                newTab.document.close(); // necessary for IE >= 10
                newTab.focus(); // necessary for IE >= 10
                // newTab.print();
            }, 500); // Delay of 500 milliseconds (0.5 seconds)

        });

        function fetchReportData(document_type, reportData, search_name) {
                const url = '../modules/report/get-report.php';
                var template = '';
                var table = $('#report-table thead');
                table.empty();

                var tableBody = $('#report-table tbody');
                tableBody.empty();
                template += `
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Document Type</th>
                            <th>Date Requested</th>
                        </tr>
                    `;

                $.ajaxSetup({async: false});
                $.get(url, { document_type, reportData: JSON.stringify(reportData), search_name }, (response) => {
                    console.log(response);
                    const rows = JSON.parse(response);
                    if (rows.length === 0) { 
                        template += `<tr>`;
                        template += `<td colspan=5 class="text-center">No data available!</td>`;
                        template += `</tr>`;
                    }
                    else {
                        rows.forEach((row, index) => {
                            const { requested_by, document_type, date_requested, status } = row;

                            template += `<tr>`;
                            template += `<td>${index + 1}</td>`;
                            template += `<td>${requested_by}</td>`;
                            template += `<td>${document_type}</td>`;
                            template += `<td>${moment(date_requested).format('MMMM DD, YYYY')}</td>`;
                            template += `</tr>`;
                        });
                    }

                    table.append(template);
                });
            }
        
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
            }

            // Insert the dynamic content into the "dynamicFields" div
            $('#dynamicFields').html(dynamicContent);
        });

        // Trigger change event on page load to set the initial state
        $('#frequency').trigger('change');

        $('select[name="document_type"]').on('change', function() {
            var document_type = $(this).val();
            var search_name = $('#search_name').val();
            var reportData = getReportData();
            getData(document_type, reportData, search_name);
        });
        
        $('#search_name').on('input', function() {
            var document_type = $('select[name="document_type"]').val();
            var search_name = $('#search_name').val();
            var reportData = getReportData();
            getData(document_type, reportData, search_name);
        });
        
        $('#dynamicFields').on('change', 'select, input', function() {
            var document_type = $('select[name="document_type"]').val();
            var search_name = $('#search_name').val();
            var reportData = getReportData();
            getData(document_type, reportData, search_name);
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

        function getData(document_type, reportData, search_name) {
            const url = '../modules/report/get-report.php';

            var table = $('.report-table').DataTable();
            table.clear().draw();
            $.get(url, { document_type, reportData: JSON.stringify(reportData), search_name }, (response) => {
                console.log(response);
                const rows = JSON.parse(response);
                if (rows.message) { 
                    // alert('No data available');
                }
                else {
                    rows.forEach((row, index) => {
                        table.row.add($(`<tr>
                                            <td>${index + 1}</td>
                                            <td>${row.requested_by}</td>
                                            <td>${row.document_type}</td>
                                            <td>${moment(row.date_requested).format('MMMM D, YYYY')}</td>
                                        </tr>`)).draw();
                    });
                }
            });

        }
	
    });

</script>
</body>

</html>
