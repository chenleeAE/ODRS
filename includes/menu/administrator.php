<li class="<?php if($title == 'Dashboard') echo 'active' ?>">
    <a href="dashboard.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
</li>

<li class="<?php if($title == 'Marriage License' || $title == 'Groom Details' || $title == 'Bride Details') echo 'active' ?>">
    <a href="marriage_license.php"><i class="fa fa-file"></i> <span class="nav-label">Marriage License</span></a>
</li>

<li class="<?php if($title == 'Pending Payment' || $title == 'For Verification' || $title == 'For Processing' || $title == 'For Claiming' || $title == 'Claimed') echo 'active' ?>">
    <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Application List</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="<?php if($title == 'Pending Payment') echo 'active' ?>">
            <a href="for_payment.php"><i class="fa fa-money"></i> <span class="nav-label">Pending Payment</span></a>
        </li>
        <li class="<?php if($title == 'For Verification') echo 'active' ?>">
            <a href="for_verification.php"><i class="fa fa-check"></i> <span class="nav-label">For Verification</span></a>
        </li>
        <li class="<?php if($title == 'For Processing') echo 'active' ?>">
            <a href="for_processing.php"><i class="fa fa-tasks"></i> <span class="nav-label">For Processing</span></a>
        </li>
        <li class="<?php if($title == 'For Claiming') echo 'active' ?>">
            <a href="for_claiming.php"><i class="fa fa-file-text"></i> <span class="nav-label">For Claiming</span></a>
        </li>
        <li class="<?php if($title == 'Claimed') echo 'active' ?>">
            <a href="claimed.php"><i class="fa fa-check-square-o"></i> <span class="nav-label">Claimed</span></a>
        </li>
    </ul>
</li>

<li class="<?php if($title == 'Clients') echo 'active' ?>">
    <a href="clients.php"><i class="fa fa-vcard"></i> <span class="nav-label">Clients</span></a>
</li>

<li class="<?php if($title == 'Staff') echo 'active' ?>">
    <a href="staff.php"><i class="fa fa-users"></i> <span class="nav-label">Staff</span></a>
</li>

<li class="<?php if($title == 'Activity Logs') echo 'active' ?>">
    <a href="activity_logs.php"><i class="fa fa-vcard"></i> <span class="nav-label">Activity Logs</span></a>
</li>

<li class="<?php if($title == 'Change Password') echo 'active' ?>">
    <a href="change_password.php"><i class="fa fa-lock"></i> <span class="nav-label">Change Password</span></a>
</li>

<li class="<?php if($title == 'Payment Type') echo 'active' ?>">
    <a href="#"><i class="fa fa-database"></i> <span class="nav-label">References</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="<?php if($title == 'Payment Type') echo 'active' ?>">
            <a href="payment_type.php"><i class="fa fa-money"></i> <span class="nav-label">Payment Type</span></a>
        </li>
    </ul>
</li>

<li class="<?php if($title == 'Statistics') echo 'active' ?>">
    <a href="statistics.php"><i class="fa fa-pie-chart"></i> <span class="nav-label">Statistics</span></a>
</li>
<li class="<?php if($title == 'Report') echo 'active' ?>">
    <a href="report.php"><i class="fa fa-folder"></i> <span class="nav-label">Report</span></a>
</li>