<!DOCTYPE html>
<html>

<?php
	session_start();
	$title = 'Application Form';
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
                    <h2>Application Forms</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php">Home</a></li>
                        <li class="active"><strong>Application Forms</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>

            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Application Forms</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="container my-5">
                                    <div class="row g-4">
                                    <!-- Card 1 -->
                                    <div class="col-12 col-md-4">
                                        <div class="card shadow-sm">
                                        <center>
                                            <img src="../public/img/birth.png" class="card-img-top" width="100" alt="Image 1">
                                        </center>
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Birth Certificate</h5>
                                            <!-- <p class="card-text">Some quick example text to build on the card title.</p> -->
                                            <a href="#" id="birth" class="btn btn-primary">Apply Now</a>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Card 2 -->
                                    <div class="col-12 col-md-4">
                                        <div class="card shadow-sm">
                                            <center>
                                                <img src="../public/img/death.png" class="card-img-top" width="100" alt="Image 1">
                                            </center>
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Death Certificate</h5>
                                            <!-- <p class="card-text">Some quick example text to build on the card title.</p> -->
                                            <a href="#" id="death" class="btn btn-primary">Apply Now</a>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Card 3 -->
                                    <div class="col-12 col-md-4">
                                        <div class="card shadow-sm">
                                            <center>
                                                <img src="../public/img/marriage.png" class="card-img-top" width="100" alt="Image 1">
                                            </center>
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Marriage Certificate</h5>
                                            <!-- <p class="card-text">Some quick example text to build on the card title.</p> -->
                                            <a href="#" id="marriage" class="btn btn-primary">Apply Now</a>
                                        </div>
                                        </div>
                                    </div>
                                    </div>

                                    <!-- Second row -->
                                    <div class="row g-4">
                                    <!-- Card 4 -->
                                    <div class="col-12 col-md-6">
                                        <div class="card shadow-sm">
                                            
                                        <center>
                                            <img src="../public/img/no-marriage.png" class="card-img-top" width="100" alt="Image 1">
                                        </center>
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Certificate of no record of Marriage</h5>
                                            <!-- <p class="card-text">Some quick example text to build on the card title.</p> -->
                                            <a href="#" id="cenomar" class="btn btn-primary">Apply Now</a>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Card 5 -->
                                    <div class="col-12 col-md-6">
                                        <div class="card shadow-sm">
                                        <center>
                                            <img src="../public/img/marriage-license.png" class="card-img-top" width="100" alt="Image 1">
                                        </center>

                                        <div class="card-body text-center">
                                            <h5 class="card-title">Marriage License</h5>
                                            <!-- <p class="card-text">Some quick example text to build on the card title.</p> -->
                                            <a href="#" class="btn btn-primary" onclick="displayMessage()">Apply Now</a>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('../includes/footer.php') ?>

            <!-- BIRTH MODAL -->
            <?php include('modal/birth.php') ?>
            <!-- END BIRTH MODAL -->

            <!-- DEATH MODAL -->
            <?php include('modal/death.php') ?>
            <!-- END DEATH MODAL -->

            <!-- CENOMAR MODAL -->
            <?php include('modal/cenomar.php') ?>
            <!-- END CENOMAR MODAL -->

            <!-- MARRIAGE MODAL -->
            <?php include('modal/marriage.php') ?>
            <!-- END MARRIAGE MODAL -->

        </div>
      
    </div>

    
<?php include ('../includes/scripts.php'); ?>
<script>
    function displayMessage() {
        alert("Please visit the office for further instructions.");
    }
    $(document).ready(function(){
        var edit = false;

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        $('select[name="pob_province"]').on('change', function() {
            var province_id = $(this).val();
            $.get('../modules/reference/get_city_by_province.php', { province_id }, function(response) {
                var data = JSON.parse(response);

                var $citySelect = $('select[name="pob_city"]');
                $citySelect.empty();
                $citySelect.append(
                    $('<option>').val('').text('Please select')
                );

                // Populate the second select with new options
                $.each(data, function(index, item) {
                    $citySelect.append(
                        $('<option>').val(item.city).text(item.city)
                    );
                });
            });
        });

        $(document).on('click', '#birth, #close-birth', function(){
            resetCheckbox();
            $('#birth-form').trigger("reset");
            $('#birth-modal').modal('toggle');
        });
        
        $(document).on('click', '#death, #close-death', function(){
            resetCheckbox();
            $('#death-form').trigger("reset");
            $('#death-modal').modal('toggle');
        });
        
        $(document).on('click', '#cenomar, #close-cenomar', function(){
            resetCheckbox();
            $('#cenomar-form').trigger("reset");
            $('#cenomar-modal').modal('toggle');
        });

        $(document).on('click', '#marriage, #close-marriage', function(){
            resetCheckbox();
            $('#marriage-form').trigger("reset");
            $('#marriage-modal').modal('toggle');
        });


        function resetCheckbox() {
            $('input[name="request_for"]').iCheck('uncheck');
            $('input[name="purpose"]').iCheck('uncheck');
        }

        $('input[name="purpose"]').on('ifChanged', function() {
            var selectedPurpose = $('input[name="purpose"]:checked').val();
            if (selectedPurpose === "Passport / Travel" || selectedPurpose === "Employment (Abroad)" || selectedPurpose === "Others") {
                // Remove readonly attribute
                $('input[name="specify"]').prop('readonly', false);
            } else {
                // Add readonly attribute
                $('input[name="specify"]').prop('readonly', true);
            }
        });

        $('#birth-form').submit(function(e){
		    e.preventDefault();
            var provinceText = $('#birth_province option:selected').text();
            var cityText = $('#birth_city option:selected').text();
            const formData = new FormData(this);  // 'this' refers to the form
            
            formData.set('pob_province', provinceText);
            formData.set('pob_city', cityText);
            
            $.ajax({
                url: '../modules/birth/save.php',
                type: 'POST',
                data: formData,
                contentType: false,  // Let the browser set the correct content type
                processData: false,  // Prevent jQuery from processing the data
                success: function(response) {
                    console.log(response);
                    if ($.trim(response) == 'success') {
                        Swal.fire("System Message", "Your application has been saved. Kindly complete the payment to move forward.", "success");
                        resetCheckbox();
                        $('#birth-form').trigger("reset");
                        $('#birth-modal').modal('toggle');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Form submission failed: " + error);
                    toastrOptions();
                    toastr.error("There was an error with the form submission", "System Message");
                }
            });
        });

        $('#death-form').submit(function(e){
		    e.preventDefault();
            var provinceText = $('#death_province option:selected').text();
            var cityText = $('#death_city option:selected').text();
            const formData = new FormData(this);  // 'this' refers to the form
            
            formData.set('pob_province', provinceText);
            formData.set('pob_city', cityText);

            $.ajax({
                url: '../modules/death/save.php',
                type: 'POST',
                data: formData,
                contentType: false,  // Let the browser set the correct content type
                processData: false,  // Prevent jQuery from processing the data
                success: function(response) {
                    if ($.trim(response) == 'success') {
                        Swal.fire("System Message", "Your application has been saved. Kindly complete the payment to move forward.", "success");
                        resetCheckbox();
                        $('#death-form').trigger("reset");
                        $('#death-modal').modal('toggle');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Form submission failed: " + error);
                    toastrOptions();
                    toastr.error("There was an error with the form submission", "System Message");
                }
            });
        });

        $('#cenomar-form').submit(function(e){
		    e.preventDefault();
            var provinceText = $('#cenomar_province option:selected').text();
            var cityText = $('#cenomar_city option:selected').text();
            const formData = new FormData(this);  // 'this' refers to the form
            
            formData.set('pob_province', provinceText);
            formData.set('pob_city', cityText);
    
            $.ajax({
                url: '../modules/cenomar/save.php',
                type: 'POST',
                data: formData,
                contentType: false,  // Let the browser set the correct content type
                processData: false,  // Prevent jQuery from processing the data
                success: function(response) {
                    if ($.trim(response) == 'success') {
                        Swal.fire("System Message", "Your application has been saved. Kindly complete the payment to move forward.", "success");
                        resetCheckbox();
                        $('#cenomar-form').trigger("reset");
                        $('#cenomar-modal').modal('toggle');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Form submission failed: " + error);
                    toastrOptions();
                    toastr.error("There was an error with the form submission", "System Message");
                }
            });
        });
        
        $('#marriage-form').submit(function(e){
		    e.preventDefault();
            var provinceText = $('#marriage_province option:selected').text();
            var cityText = $('#marriage_city option:selected').text();
            const formData = new FormData(this);  // 'this' refers to the form
            
            formData.append('pom_province', provinceText);
            formData.append('pom_city', cityText);

            $.ajax({
                url: '../modules/marriage/save.php',
                type: 'POST',
                data: formData,
                contentType: false,  // Let the browser set the correct content type
                processData: false,  // Prevent jQuery from processing the data
                success: function(response) {
                    if ($.trim(response) == 'success') {
                        Swal.fire("System Message", "Your application has been saved. Kindly complete the payment to move forward.", "success");
                        resetCheckbox();
                        $('#marriage-form').trigger("reset");
                        $('#marriage-modal').modal('toggle');
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
