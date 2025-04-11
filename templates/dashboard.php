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

require_once('../modules/database.php');
?>

<body>
    <div id="wrapper">
        <?php include('../includes/sidebar.php'); ?>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <?php include('../includes/navbar.php'); ?>


            <?php if ($_SESSION['user_type'] == 'Administrator' || $_SESSION['user_type'] == 'Staff') { ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Document Requests Overview</h5>
                            </div>
                            <div class="ibox-content">
                                <?php
                                $query = mysqli_query($connection, "
                        WITH document_types AS (
                            SELECT 'Birth Certificate' as document_type
                            UNION SELECT 'Death Certificate'
                            UNION SELECT 'CENOMAR'
                            UNION SELECT 'Marriage Certificate'
                        )
                        SELECT 
                            d.document_type,
                            COALESCE(SUM(CASE WHEN r.status = 'FOR VERIFICATION' THEN 1 ELSE 0 END), 0) as for_verification,
                            COALESCE(SUM(CASE WHEN r.status = 'FOR PROCESSING' THEN 1 ELSE 0 END), 0) as for_processing,
                            COALESCE(SUM(CASE WHEN r.status = 'FOR PAYMENT' THEN 1 ELSE 0 END), 0) as for_payment,
                            COALESCE(SUM(CASE WHEN r.status = 'FOR CLAIMING' THEN 1 ELSE 0 END), 0) as for_claiming,
                            COALESCE(SUM(CASE WHEN r.status = 'CLAIMED' THEN 1 ELSE 0 END), 0) as claimed
                        FROM document_types d
                        LEFT JOIN request_type r ON d.document_type = r.document_type
                        GROUP BY d.document_type
                        ORDER BY d.document_type
                    ") or die(mysqli_error($connection));

                                $dashboardData = [];
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $dashboardData[] = [
                                        'document_type' => $row['document_type'],
                                        'statuses' => [
                                            ['title' => 'For Verification', 'count' => $row['for_verification'], 'icon' => 'fa-clock-o', 'bg' => 'navy-bg', 'style' => 'color: #000000 !important'],
                                            ['title' => 'For Processing', 'count' => $row['for_processing'], 'icon' => 'fa-cogs', 'bg' => 'yellow-bg', 'style' => 'color: #000000 !important'],
                                            ['title' => 'For Payment', 'count' => $row['for_payment'], 'icon' => 'fa-credit-card', 'bg' => 'blue-bg', 'style' => 'color: #000000 !important'],
                                            ['title' => 'For Claiming', 'count' => $row['for_claiming'], 'icon' => 'fa-handshake-o', 'bg' => 'lazur-bg', 'style' => 'color: #000000 !important'],
                                            ['title' => 'Claimed', 'count' => $row['claimed'], 'icon' => 'fa-check-circle', 'bg' => 'red-bg', 'style' => 'color: #000000 !important'],
                                        ],
                                    ];
                                }

                                if (!empty($dashboardData)) {
                                    foreach ($dashboardData as $data) { ?>
                                        <div class="row m-b-lg">
                                            <div class="col-lg-12">
                                                <div class="ibox-title">
                                                    <h5><?php echo $data['document_type']; ?></h5>
                                                </div>
                                                <div class="row">
                                                    <?php foreach ($data['statuses'] as $status) { ?>
                                                        <div class="col-lg-2">
                                                            <div class="widget style1 <?php echo $status['bg']; ?>">
                                                                <div class="row vertical-align">
                                                                    <div class="col-xs-3">
                                                                        <i class="fa <?php echo $status['icon']; ?> fa-2x"></i>
                                                                    </div>
                                                                    <div class="col-xs-9 text-right">
                                                                        <h3 class="font-bold"><?php echo $status['count']; ?></h3>
                                                                        <span><?php echo $status['title']; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div class="text-center">
                                        <h3>No data available for the dashboard.</h3>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>


            <?php } elseif ($_SESSION['user_type'] == 'Client') { ?>
                <?php
                $id = $_SESSION['id'];
                $summary_query = mysqli_query($connection, "
                        SELECT 
                            COUNT(*) as total_requests,
                            SUM(CASE WHEN status = 'CLAIMED' THEN 1 ELSE 0 END) as completed_requests,
                            SUM(CASE WHEN status != 'CLAIMED' THEN 1 ELSE 0 END) as pending_requests
                        FROM request_type 
                        WHERE id = $id
                    ") or die(mysqli_error($connection));

                $summary = mysqli_fetch_assoc($summary_query);
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>My Documents Summary</h5>
                                <div class="ibox-tools">
                                <a href="application_list.php" class="btn btn-danger btn-xs" style="background-color: #8B0000; border-color: #8B0000;">View All Applications</a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="widget style1 navy-bg">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <i class="fa fa-file-text fa-4x"></i>
                                                </div>
                                                <div class="col-xs-8 text-right">
                                                    <span>Total Requests</span>
                                                    <h2 class="font-bold"><?php echo $summary['total_requests']; ?></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="widget style1 yellow-bg">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <i class="fa fa-refresh fa-4x"></i>
                                                </div>
                                                <div class="col-xs-8 text-right">
                                                    <span>Pending Requests</span>
                                                    <h2 class="font-bold"><?php echo $summary['pending_requests']; ?></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="widget style1 red-bg">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <i class="fa fa-check-circle fa-4x"></i>
                                                </div>
                                                <div class="col-xs-8 text-right">
                                                    <span>Completed Requests</span>
                                                    <h2 class="font-bold"><?php echo $summary['completed_requests']; ?></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row m-t-lg">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Recent Applications
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Document Type</th>
                                                                <th>Date Requested</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $recent_query = mysqli_query($connection, "
                                                                    SELECT id, document_type, date_requested, status
                                                                    FROM request_type
                                                                    WHERE id = $id
                                                                    ORDER BY date_requested DESC
                                                                    LIMIT 5
                                                                ") or die(mysqli_error($connection));

                                                            while ($row = mysqli_fetch_assoc($recent_query)) {
                                                                echo "<tr>";
                                                                echo "<td>{$row['document_type']}</td>";
                                                                echo "<td>" . date('M d, Y', strtotime($row['date_requested'])) . "</td>";
                                                                echo "<td><span class='label label-" .
                                                                    ($row['status'] == 'CLAIMED' ? 'primary' : 'warning') .
                                                                    "'>{$row['status']}</span></td>";
                                                                echo "<td><a href='view_request.php?id=" . $row['id'] .
                                                                    "' class='btn btn-xs btn-info'>View Details</a></td>";
                                                                echo "</tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>


            <?php include('../includes/footer.php'); ?>
        </div>
    </div>

    <?php include('../includes/scripts.php'); ?>


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