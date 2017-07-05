<?php
require_once "core/init.php";
$user = new User();
if (!$user->isLoggedIn()){
    Redirect::to('index.php');
}


 require_once "includes/home/header.php";
 ?>
<body>
<div id="wrapper">
    <?php require_once "includes/home/nav_top.php"?>
    <!-- /. NAV TOP  -->
    <?php require_once "includes/home/nav_side.php"?>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper" >
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo Permission::is('admin') ? 'Admin Dashboard' : 'User Dashboard'?></h2>
                    <h5>Welcome <?php echo Permission::getUserName()?> , Love to see you back. </h5>
                </div>
            </div>
            <!-- /. ROW  -->
            <hr />
            <div class="row">
                <?php if (1) {?>
                    <a href="add_mobile.php">
                        <div class="col-md-4 col-sm-8 col-xs-12">
                            <div class="panel panel-back noti-box">
                            <span class="icon-box bg-color-red set-icon">
                                <i class="fa fa-phone"></i>

                            </span>
                                <div class="text-box" >
                                    <p class="main-text"> <span><?php echo Permission::is('user')? 'Your total numbers '.Report::getTotalNumber() : 'Total Number of System '. Report::getTotalNumberAmount('number') ?></span></p>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php }?>
                <?php if (0){ ?>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-green set-icon">
                    <i class="fa fa-bars"></i>
                </span>
                            <div class="text-box" >
                                <p class="main-text">30 Tasks</p>
                                <p class="text-muted">Remaining</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <i class="fa fa-bell-o"></i>
                </span>
                            <div class="text-box" >
                                <p class="main-text">240 New</p>
                                <p class="text-muted">Notifications</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-brown set-icon">
                    <i class="fa fa-rocket"></i>
                </span>
                            <div class="text-box" >
                                <p class="main-text">3 Orders</p>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- /. ROW  -->
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<?php require_once "includes/home/footer.php"?>
