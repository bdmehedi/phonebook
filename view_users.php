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

// show maximum page number ....
$max_page = 20;

$db = DB::getInstance();
// get All users.....
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['per_page']) && $_GET['per_page'] <= 20 ? (int)$_GET['per_page'] : 20;
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

$usersData = $db->getAllWithSql("SELECT * FROM users ORDER BY users.id DESC LIMIT {$start}, {$perPage}");
if ($usersData->count()){
    $users = $usersData->results();
}
//$usersData = $db->getAll('users');
//if ($usersData->count()){
//    $users = $usersData->results();
//}

//get all page for numbers.
$pages = ceil($db->getPages('users', 'user_name') / $perPage);

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
                        <th>Added</th>
                    </tr>
                    <?php if (isset($users)){
                        $serial = ($_GET['page'] > 1) ? ((int)$_GET['page'] * (int)$_GET['per_page']) - ((int)$_GET['per_page'] - 1) : 1;
                        foreach ($users as $user){
                    ?>
                            <tr>
                                <td><?php echo $serial;?></td>
                                <td><?php echo $user->user_name;?></td>
                                <td><?php echo $user->name;?></td>
                                <td><?php echo $user->mobile;?></td>
                                <td><?php echo Report::getTotalNumber($user->id);?></td>
                            </tr>
                    <?php $serial++; }} ?>
                </table>
                <div class="col-md-12" style="text-align: right">
                    <?php
                    if (isset($pages)) {
                        if ($pages > $max_page && $_GET['page'] > 1) {
                            $previous_page = $_GET['page'] > 1 ? $_GET['page'] : '';
                            ?>
                            <a
                                    href="?page=<?php echo --$previous_page; ?>&per_page=20">Previous
                            </a>&nbsp;
                            <?php
                        }

                        for ($page = 1; $page <= $pages; $page++) {
                            if ($pages == 1) {
                                break;
                            }
                            if ($pages < $max_page) {
                                ?>
                                <a
                                    <?php echo $page == $_GET['page'] ? 'class="selected"' : '' ?>
                                        href="?page=<?php echo $page ?>&per_page=20"><?php echo $page . ' ' ?>
                                </a>&nbsp;
                                <?php
                            }

                            if ($pages > $max_page) {
                                if ($page > 10 && $page != $pages && $page != $pages - 1) {
                                    continue;
                                }
                                if ($page == $pages - 1)
                                    echo '....';
                                ?>
                                <a
                                    <?php echo $page == $_GET['page'] ? 'class="selected"' : '' ?>
                                        href="?page=<?php echo $page ?>&per_page=20"><?php echo $page . ' ' ?>
                                </a>&nbsp;
                                <?php
                            }
                        }
                        if ($pages > $max_page && $_GET['page'] < $pages) {
                            ?>
                            <a
                                    href="?page=<?php echo isset($_GET['page']) ? ++$_GET['page'] : '' ?>&per_page=20">Next
                            </a>&nbsp;
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<?php require_once "includes/home/footer.php"?>
