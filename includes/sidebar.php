<style>
    .custom-sidebar {
        background-color: rgb(68, 4, 4) !important;
    }

    .custom-sidebar ul.nav > li > a {
        color: white !important;
    }

    .custom-sidebar ul.nav > li > a:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .custom-sidebar .nav-header,
    .custom-sidebar .profile-element {
        background-color: rgb(68, 4, 4) !important;
        color: white;
    }

    .custom-sidebar .text-muted {
        color: #ccc !important;
    }

	.navbar-default {
    background-color:rgb(68, 4, 4) !important;
}

.sidebar-collapse {
    background-color:rgb(68, 4, 4) !important;
}
.nav-header{
    background-color: rgb(68, 4, 4) !important;
    background-image: url(sidebar.png);
}

#side-menu,
#side-menu li,
#side-menu li a {
    background-color:rgb(68, 4, 4) !important;
    color: white !important;
}
#side-menu li a:hover,
#side-menu li.active > a {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: white !important;
}

.nav-header,
.profile-element {
    background-color:rgb(68, 4, 4) !important;
    color: white !important;
}

.text-muted,
.text-xs {
    color: #ccc !important;
}

#side-menu li.active > a {
    background-color: black !important;
    color: white !important;
}

#side-menu li.active > a i {
    color: white !important;
}
#side-menu li.active ul {
    background-color: #111 !important;
}

  /* Ensure the full sidebar is colored */
.navbar-default.navbar-static-side {
    background-color:rgb(68, 4, 4)!important;
}

/* Make sure submenu backgrounds are also colored */
#side-menu li {
    background-color:rgb(68, 4, 4) !important;
}

/* Style dropdown menu items */
#side-menu .nav-second-level li a {
    background-color: rgb(68, 4, 4) !important;
    color: white !important;
}

/* Remove weird background color on hover */
#side-menu li a:hover {
    background-color:rgb(68, 4, 4) !important;
}

/* Fix active tab background issue */
#side-menu li.active > a {
    background-color: black !important;
    color: white !important;
}

/* If some sections are still blue, override Bootstrap defaults */
.metismenu, .nav, .nav-second-level, .nav-third-level {
    background-color: rgb(68, 4, 4) !important;
}

/* Ensure spacing doesn’t break the color */
.sidebar-collapse {
    background-color:rgb(68, 4, 4) !important;
    height: 100vh; /* Makes sure it covers the full height */
}

/* Fix any last remaining blue parts */
body, html {
    background-color:rgb(68, 4, 4) !important;
}

</style>

<nav class="navbar-default navbar-static-side custom-sidebar" role="navigation">
    <div class="sidebar-collapse custom-sidebar">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <center>
                    <div class="dropdown profile-element">
                        <span>
                            <img alt="image" class="img-circle" src="../public/img/user.png" width="40" height="40"/>
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold">
                                        <?php if (!empty($_SESSION['first_name'])) echo $_SESSION['first_name'].' '.$_SESSION['last_name']; else echo 'No data'; ?>
                                    </strong>
                                </span>
                                <span class="text-muted text-xs block">
                                    <?php echo ucwords($_SESSION['user_type']); ?>
                                </span>
                            </span>
                        </a>
                    </div>
                </center>
                <div class="logo-element">LCRO</div>
            </li>

            <?php if($_SESSION['user_type'] == 'Administrator') { ?> 
                <?php include ('menu/administrator.php'); ?>
            <?php } else if($_SESSION['user_type'] == 'Staff') { ?>
                <?php include ('menu/staff.php'); ?>
            <?php } else if($_SESSION['user_type'] == 'Client') { ?>
                <?php include ('menu/client.php'); ?>
            <?php } ?>
        </ul>
    </div>
</nav>