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

// get all category.....
$db = DB::getInstance();
$sql = "SELECT * FROM categories ORDER BY categories.category_name ASC";
$categoryData = $db->getAllWithSql($sql);
$categories = $categoryData->results();

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
                <h1 class="text-center text-temp">View Category</h1>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">

                        <?php
                        if (Session::exists('home')){
                            echo "<p style='color: green'>". Session::get('home') ."</p>";
                            Session::delete('home');
                        }
                        ?>

                        <table style="border: 1px" class="table table-bordered table-responsive table-hover table-striped">
                            <tr>
                                <th>Serial</th>
                                <th>Category Name</th>
                                <th class="col-sm-2" ">Total Numbers</th>
                                <th>Category SMS</th>
                                <th>Sender</th>
                                <th>Action</th>
                            </tr>
                            <!--                    for category wise.........-->
                            <?php if (isset($categories)){
                                $serial = 1;
                                foreach ($categories as $category){
                                    ?>
                                    <tr>
                                        <td><?php echo $serial;?></td>
                                        <td><?php echo $category->category_name;?></td>
                                        <td><?php echo Report::getTotalNumberAmount('number', 'category_id = '.$category->id);?></td>
                                        <td><?php echo $category->message;?></td>
                                        <td><?php echo $category->sender_id;?></td>
                                        <td><a href="edit_category.php?category=<?php echo $category->id?>"><i class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a></td>
                                    </tr>
                                    <?php $serial++; }} ?>
                            <tr>
                                <td></td>
                                <th></th>
                                <td>Total =  <?php echo Report::getTotalNumberAmount('number')?></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<?php require_once "includes/home/footer.php"?>
