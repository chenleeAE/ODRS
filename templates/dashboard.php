<!DOCTYPE html>
<html lang="en">

<?php
session_start();
$title = 'Dashboard';
include('../includes/header.php');

// Redirect if the user is not logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

// Redirect if the user is not an administrator
if ($_SESSION['user_type'] == 'student' || $_SESSION['user_type'] == 'teacher') {
    echo "<script>window.location = 'user_home.php';</script>";
    exit();
}
?>

<body>
    <div id="wrapper">
        <?php include('../includes/sidebar.php'); ?>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <?php include('../includes/navbar.php'); ?>

            <div class="wrapper wrapper-content">
                <?php if ($_SESSION['user_type'] == 'Administrator') { ?>
                    <?php
                    require_once('../modules/database.php');

                    // Fetch counts for each document type and status
                    $query = mysqli_query($connection, "
                        SELECT 
                            document_type,
                            SUM(status = 'FOR VERIFICATION') AS for_verification,
                            SUM(status = 'FOR PROCESSING') AS for_processing,
                            SUM(status = 'FOR PAYMENT') AS for_payment,
                            SUM(status = 'FOR CLAIMING') AS for_claiming,
                            SUM(status = 'CLAIMED') AS claimed
                        FROM request_type
                        GROUP BY document_type
                    ") or die(mysqli_error($connection));

                    $dashboardData = [];
                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                            $dashboardData[] = [
                                'document_type' => $row['document_type'],
                                'statuses' => [
                                    ['title' => 'For Verification', 'count' => $row['for_verification'], 'icon' => 'fa-check-circle', 'bg' => 'navy-bg'],
                                    ['title' => 'For Processing', 'count' => $row['for_processing'], 'icon' => 'fa-cogs', 'bg' => 'yellow-bg'],
                                    ['title' => 'For Payment', 'count' => $row['for_payment'], 'icon' => 'fa-credit-card', 'bg' => 'blue-bg'],
                                    ['title' => 'For Claiming', 'count' => $row['for_claiming'], 'icon' => 'fa-handshake-o', 'bg' => 'lazur-bg'],
                                    ['title' => 'Claimed', 'count' => $row['claimed'], 'icon' => 'fa-trophy', 'bg' => 'green-bg'],
                                ],
                            ];
                        }
                    }
                    ?>

                    <?php if (!empty($dashboardData)) { ?>
                        <div class="row">
                            <?php foreach ($dashboardData as $data) { ?>
                                <div class="col-lg-12">
                                    <h3><?php echo $data['document_type']; ?></h3>
                                    <div class="row">
                                        <?php foreach ($data['statuses'] as $status) { ?>
                                            <div class="col-lg-2">
                                                <div class="widget style1 <?php echo $status['bg']; ?>">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <i class="fa <?php echo $status['icon']; ?> fa-5x"></i>
                                                        </div>
                                                        <div class="col-xs-8 text-right">
                                                            <span><?php echo $status['title']; ?></span>
                                                            <h2 class="font-bold"><?php echo $status['count']; ?></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p>No data available for the dashboard.</p>
                    <?php } ?>
                <?php } ?>
            </div>
            <?php include('../includes/footer.php'); ?>
        </div>
    </div>

    <?php include('../includes/scripts.php'); ?>
</body>

<script>
    $(document).ready(function () {
        if ($('select[name="document_type"]').length) {
            $('select[name="document_type"]').trigger('change');
        }

        if ($('.i-checks').length) {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        }
    });
</script>

</html>