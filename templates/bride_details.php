<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Bride Details';
	include ('../includes/header.php');
	if(!isset($_SESSION['id'])){ header("Location: ../index.php"); }
?>

<?php
    require_once ('../modules/database.php');  

    $license_id = $_GET['license_id'];

    // Fetch case details
    $sql = "SELECT * FROM marriage_bride WHERE license_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $license_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bride = $result->fetch_assoc();

    $stmt->close();
?>

<body>
    <div id="wrapper">
        <?php include ('../includes/sidebar.php'); ?>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <?php include ('../includes/navbar.php'); ?>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Bride Details</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                        <li><a href="marriage_license.php">Marriage License</a></li>
                        <li class="active"><strong>Bride Details</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>
                
            <div class="wrapper wrapper-content">
                <div class="row">
                    
                    <div class="col-sm-4">
                        <div class="ibox ">
                            <div class="ibox-content">
                                <div class="tab-content">
                                    <div id="contact-1" class="tab-pane active">
                                        <div class="row m-b-lg">
                                            <div class="col-lg-12 text-center">
                                                Other information
                                            </div>
                                            <hr>
                                            <div class="col-lg-12">
                                                <button type="button" name="btnConsent" style="display: none;" class="btn btn-primary btn-block mt btnConsent">
                                                    <i class="fa fa-file"></i> Parent's Consent
                                                </button>
                                                <button type="button" name="btnAdvice" style="display: none;" class="btn btn-info btn-block mt btnAdvice">
                                                    <i class="fa fa-phone"></i> Parent's Advice
                                                </button>
                                                <button type="button" name="btnWitness" style="display: none;" class="btn btn-warning btn-block mt btnWitness">
                                                    <i class="fa fa-edit"></i> Witness
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="ibox">
                            <div class="ibox-content">
                            <div class="col-lg-12"><h4>BRIDE'S INFORMATION</h4> </div>
                                <form id="couple-form" class="form-horizontal" autocomplete="off">
                                    <div class="modal-body">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <input type="hidden" name="id">
                                                <input type="hidden" name="license_id">
                                                <input type="hidden" name="type" value="bride">
                                                
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Registry No.<span class="text-danger">*</span></label> 
                                                            <input type="text" name="registry_no" class="form-control" required>    
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Marriage License No.</label> 
                                                            <input type="text" name="license_no" class="form-control">    
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Date of Issuance<span class="text-danger">*</span></label> 
                                                            <input type="date" name="date_issuance" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label id="couple-label">Groom name<span class="text-danger">*</span></label> 
                                                            <input type="text" name="to_marry" class="form-control" required>    
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>First name<span class="text-danger">*</span></label> 
                                                            <input type="text" name="fname" class="form-control" required>    
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Middle name</label> 
                                                            <input type="text" name="mname" class="form-control">    
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Last name<span class="text-danger">*</span></label> 
                                                            <input type="text" name="lname" class="form-control" required>    
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label>Date of Birth<span class="text-danger">*</span></label> 
                                                            <input type="date" name="bday" class="form-control" required>    
                                                        </div>
                                                        <div class="col-md-1">
                                                            <label>Age<span class="text-danger">*</span></label> 
                                                            <span name="age"></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Sex<span class="text-danger">*</span></label> 
                                                            <select name="sex" class="form-control" required>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label>Citizenship<span class="text-danger">*</span></label> 
                                                            <input type="text" name="citizenship" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <p>Place of Birth</p>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>City / Municipality<span class="text-danger">*</span></label> 
                                                            <input type="text" name="pob_city" class="form-control" placeholder="Enter data here" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Province<span class="text-danger">*</span></label> 
                                                            <input type="text" name="pob_province" class="form-control" placeholder="Enter data here" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Country</label> 
                                                            <input type="text" name="pob_country" class="form-control" value="Philippines" placeholder="Enter data here">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Residence<span class="text-danger">*</span></label> 
                                                            <input type="text" name="residence" class="form-control" required>    
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Religion<span class="text-danger">*</span></label> 
                                                            <input type="text" name="religion" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Civil Status<span class="text-danger">*</span></label> 
                                                            <select name="civil_status" class="form-control" required>
                                                                <option value="" disabled selected>Select Civil Status</option>
                                                                <option value="single">Single</option>
                                                                <option value="married">Married</option>
                                                                <option value="divorced">Divorced</option>
                                                                <option value="widowed">Widowed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <p>If previously Married</p>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>How was it dissolved</label> 
                                                            <input type="text" name="previously_married" class="form-control">    
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Place where dissolved</label> 
                                                            <input type="text" name="place_dissolved" class="form-control">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Date when dissolved</label> 
                                                            <input type="date" name="date_dissolved" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Degree of relationship w/ contracting parties</label> 
                                                            <input type="text" name="degree" class="form-control">    
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Father Name</label> 
                                                            <input type="text" name="father_name" class="form-control">    
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Father Citizenship</label> 
                                                            <input type="text" name="father_citizenship" class="form-control">    
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Father Residence</label> 
                                                            <input type="text" name="father_residence" class="form-control">    
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Mother Name</label> 
                                                            <input type="text" name="mother_name" class="form-control">    
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Mother Citizenship</label> 
                                                            <input type="text" name="mother_citizenship" class="form-control">    
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Mother Residence</label> 
                                                            <input type="text" name="mother_residence" class="form-control">    
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <p>Person who gave consent or advice</p>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Name</label> 
                                                            <input type="text" name="person_consent" class="form-control">    
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Relationship</label> 
                                                            <input type="text" name="person_relationship" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Citizenship</label> 
                                                            <input type="text" name="person_citizenship" class="form-control">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Residence</label> 
                                                            <input type="text" name="person_residence" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Submit</button>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONSENT MODAL -->
            <?php include('modal/view_consent.php') ?>
            <!-- END CONSENT MODAL -->
            
            <!-- ADVICE MODAL -->
            <?php include('modal/view_advice.php') ?>
            <!-- END ADVICE MODAL -->

            <!-- WITNESS MODAL -->
            <?php include('modal/view_witness.php') ?>
            <!-- END WITNESS MODAL -->

        </div>
      
    </div>

    
<?php include ('../includes/scripts.php'); ?>
<script src="../public/js/application/bride-consent.js"></script>
<script src="../public/js/application/bride-advice.js"></script>
<script src="../public/js/application/bride-witness.js"></script>

<script>
    $(document).ready(function(){
        
        // ------------------------------------------------------------------------------------------------
        $("select[name='civil_status']").change(function() {
            // Get the selected value
            var status = $(this).val();
            
            // Check if the selected value is "single" or "widowed"
            if (status == "single" || status == "widowed") {
                $("input[name='date_dissolved']").attr("type", "text").val("N/A");
                $("input[name='previously_married']").val("N/A");
                $("input[name='place_dissolved']").val("N/A");
            } else {
                $("input[name='date_dissolved']").attr("type", "date").val("")
                $("input[name='previously_married']").val("");
                $("input[name='place_dissolved']").val("");
            }
        });

        $(document).on('change', 'input[name="bday"]', function() {
            var birthDate = new Date($(this).val()); // Get the selected date
            var today = new Date(); // Get the current date
            var age = today.getFullYear() - birthDate.getFullYear(); // Calculate age difference in years
            var m = today.getMonth() - birthDate.getMonth(); // Check if birthday has passed this year

            // If the birthday hasn't occurred yet this year, subtract 1 from the age
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            // Update the age input field
            $('span[name="age"]').text(age);

            // Hide all buttons initially
            $('button[name="btnConsent"], button[name="btnAdvice"], button[name="btnWitness"]').hide();

            // Determine which button to show based on age
            if (age >= 18 && age <= 24) {
                $('button[name="btnConsent"]').show();
            } 
            if (age >= 22 && age <= 25) {
                $('button[name="btnAdvice"]').show();
            } 
            if (age > 25) {
                $('button[name="btnWitness"]').show();
            }

        });

        function getBrideDetails() {
            const license_id = "<?php echo htmlspecialchars($license_id ?? ''); ?>";
            $("input[name='license_id']").val(license_id);

            var url = '../modules/marriage_license/get-license.php';
            $.get(url, { license_id }, (response) => {
                const rows = JSON.parse(response);
                rows.forEach(row => {
                    $("input[name='registry_no']").val(row.registry_no);
                    $("input[name='license_no']").val(row.license_no);
                    $("input[name='date_issuance']").val(row.date_issuance);
                });
            });

            var url = '../modules/marriage_license/get-bride.php';
            $.get(url, { license_id }, (response) => {
                const rows = JSON.parse(response);
                rows.forEach(row => {
                    $("input[name='id']").val(row.id);
                    $("input[name='to_marry']").val(row.to_marry);
                    $("input[name='fname']").val(row.fname);
                    $("input[name='mname']").val(row.mname);
                    $("input[name='lname']").val(row.lname);
                    $("input[name='bday']").val(row.bday);
                    $("select[name='sex']").val(row.sex).change();
                    $("input[name='citizenship']").val(row.citizenship);
                    $("input[name='pob_city']").val(row.pob_city);
                    $("input[name='pob_province']").val(row.pob_province);
                    $("input[name='pob_country']").val(row.pob_country);
                    $("input[name='residence']").val(row.residence);
                    $("input[name='religion']").val(row.religion);
                    $("select[name='civil_status']").val(row.civil_status).change();
                    $("input[name='previously_married']").val(row.previously_married);
                    $("input[name='place_dissolved']").val(row.place_dissolved);
                    $("input[name='date_dissolved']").val(row.date_dissolved);
                    $("input[name='degree']").val(row.degree);
                    $("input[name='father_name']").val(row.father_name);
                    $("input[name='father_citizenship']").val(row.father_citizenship);
                    $("input[name='father_residence']").val(row.father_residence);
                    $("input[name='mother_name']").val(row.mother_name);
                    $("input[name='mother_citizenship']").val(row.mother_citizenship);
                    $("input[name='mother_residence']").val(row.mother_residence);
                    $("input[name='person_consent']").val(row.person_consent);
                    $("input[name='person_relationship']").val(row.person_relationship);
                    $("input[name='person_residence']").val(row.person_residence);
                });

                $('input[name="bday"]').trigger('change');
            });
        }
        
        getBrideDetails();
        
        $('#couple-form').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);  // 'this' refers to the form

            $.ajax({
                url: '../modules/marriage_license/save_couple.php',
                type: 'POST',
                data: formData,
                contentType: false,  // Let the browser set the correct content type
                processData: false,  // Prevent jQuery from processing the data
                success: function(response) {
                    console.log(response);
                    if ($.trim(response) == 'success') {
                        toastrOptions();
                        toastr.success("Data saved successfully!", "System Message");
                        getBrideDetails();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Form submission failed: " + error);
                    toastrOptions();
                    toastr.error("There was an error with the form submission", "System Message");
                }
            });
        });

	
    });

</script>
</body>

</html>
