<!DOCTYPE html>
<html lang="en">

<?php
session_start();
$title = 'Dashboard';
include('../includes/header.php');
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
}
if ($_SESSION['user_type'] == 'student' || $_SESSION['user_type'] == 'teacher') {
?>
    <script> window.location = 'user_home.php'; </script>
<?php } ?>

<body>
    <div id="wrapper">
        <?php include('../includes/sidebar.php'); ?>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <?php include('../includes/navbar.php'); ?>

            <div class="wrapper wrapper-content">

                <?php if ($_SESSION['user_type'] == 'Administrator') { ?>
                    <?php
                    require_once('../modules/database.php');
                    $query = mysqli_query($connection, "SELECT 
                                                        (SELECT COUNT(id) FROM `request_type` WHERE document_type = 'Birth Certificate' AND `status` = 'FOR VERIFICATION') AS `birth`,
                                                        (SELECT COUNT(id) FROM `request_type` WHERE document_type = 'Death Certificate' AND `status` = 'FOR VERIFICATION') AS `death`,
                                                        (SELECT COUNT(id) FROM `request_type` WHERE document_type = 'CENOMAR' AND `status` = 'FOR VERIFICATION') AS `cenomar`,
                                                        (SELECT COUNT(id) FROM `request_type` WHERE document_type = 'Marriage Certificate' AND `status` = 'FOR VERIFICATION') AS `marriage`,
                                                        (SELECT COUNT(id) FROM `clients`) AS `clients`,
                                                        (SELECT COUNT(id) FROM `users`) AS `users`;")
                        or die(mysqli_error($connection));
                    $row = mysqli_fetch_array($query);
                    $birth = $row['birth'];
                    $death = $row['death'];
                    $cenomar = $row['cenomar'];
                    $marriage = $row['marriage'];
                    $clients = $row['clients'];
                    $users = $row['users'];
                    ?>

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="widget style1 navy-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-birthday-cake fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span> Birth Certificate </span>
                                        <h2 class="font-bold"> <?php echo $birth; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="widget style1 lazur-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-circle-o fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span> Marriage Certificate </span>
                                        <h2 class="font-bold"> <?php echo $marriage; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="widget style1 yellow-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-file-text-o fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span> CENOMAR </span>
                                        <h2 class="font-bold"> <?php echo $cenomar; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="widget style1" style="background-color: pink;">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <i class="fa fa-trophy fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span> Death Certificate </span>
                                        <h2 class="font-bold"> <?php echo $death; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Pending Request</h5>
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
                                                    <option value="Birth Certificate">Birth Certificate</option>
                                                    <option value="Death Certificate">Death Certificate</option>
                                                    <option value="CENOMAR">CENOMAR</option>
                                                    <option value="Marriage Certificate">Marriage Certificate</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-hover no-margins">
                                        <thead>
                                            <tr>
                                                <th>Document Type</th>
                                                <th>Date</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once('../modules/database.php');

                                            $session_id = $_SESSION["id"];
                                            $query = "SELECT * FROM request_type WHERE requested_by_id = '$session_id' ORDER BY id DESC";
                                            $result = mysqli_query($connection, $query);
                                            while ($rs = mysqli_fetch_array($result)) {
                                                $id = $rs['id'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $rs['document_type']; ?></td>
                                                    <td><?php echo $rs['date_requested']; ?></td>
                                                    <td><?php echo $rs['total_price']; ?></td>
                                                    <td data-target="status">
                                                        <span class="badge badge-<?php if ($rs['status'] == 'CLAIMED') echo 'success'; else echo 'info'; ?>"><?php echo $rs['status']; ?></span>
                                                    </td>
                                                    <td>
                                                    
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php } ?>
            </div>
            <?php include('../includes/footer.php') ?>
            <!-- BIRTH MODAL -->
            <?php include('modal/details_birth.php') ?>
            <!-- END BIRTH MODAL -->

        </div>

    </div>

    <?php include('../includes/scripts.php'); ?>

</body>

<script>
    $(document).ready(function () {
        // Trigger the change event for the document type dropdown to load data initially
        $('select[name="document_type"]').trigger('change');

        // iCheck setup
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
   
</script>

</html>
