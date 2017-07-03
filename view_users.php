<?php
require_once "core/init.php";
$user = new User();
if (!$user->isLoggedIn()){
    Redirect::to('index.php');
}
// this page just for admin.........
if (!Permission::is('admin')){
    Redirect::to('home.php');
}

$db = DB::getInstance();
// get All category...
$categoryData = $db->getAll('categories');
if ($categoryData->count()){
    $categories = $categoryData->results();
}
// get All users.....
$usersData = $db->getAll('users');
if ($usersData->count()){
    $users = $usersData->results();
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
        <div class="panel col-sm-12" style="margin-top: 15px; margin-bottom: 15px;">
            <div class="page-header">
                <h1 class="text-center text-temp">View Users</h1>
            </div>
            <div class="panel-body">
                <table style="border: 1px" class="table table-bordered table-responsive table-hover table-striped">
                    <tr>
                        <th>Serial</th>
                        <th>User Name</th>
                        <th>Name</th>
                        <th>Mobile</th>
                    </tr>
                    <?php if (isset($users)){
                        $serial = 1;
                        foreach ($users as $user){
                    ?>
                            <tr>
                                <td><?php echo $serial;?></td>
                                <td><?php echo $user->user_name;?></td>
                                <td><?php echo $user->name;?></td>
                                <td><?php echo $user->mobile;?></td>
                            </tr>
                    <?php $serial++; }} ?>
                </table>
                <span class="col-sm-2 col-sm-offset-10"></span>
            </div>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<?php require_once "includes/home/footer.php"?>
