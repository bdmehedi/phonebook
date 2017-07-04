<?php
require_once "core/init.php";
$user = new User();
if (!$user->isLoggedIn()){
    Redirect::to('index.php');
}
// this page just for admin.........
if (!Permission::is('user')){
    Redirect::to('home.php');
}

$db = DB::getInstance();
// get All category...
$sql = "SELECT * FROM categories ORDER BY categories.category_name ASC";
$categoryData = $db->getAllWithSql($sql);
if ($categoryData->count()){
    $categories = $categoryData->results();
}

// get all numbers as category wise.......
if (isset($_REQUEST['category'])){
    $category_id = $_REQUEST['category'];

    $sql = "SELECT * FROM categories WHERE id = $category_id";
    $single_category_data = $db->getAllWithSql($sql);
    if ($single_category_data->count()){
        $single_category = $single_category_data->firstResult();
    }

    $user_id = Session::get(Config::get('session/session_name'));
    $mobile_data = $db->getAllWithSql("SELECT * FROM numbers JOIN categories ON numbers.category_id = categories.id WHERE numbers.category_id = {$category_id} AND numbers.added_by = {$user_id}");
    if ($mobile_data->count()){
        $numbers_category_wise = $mobile_data->results();
    }
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
                <h1 class="text-center text-temp">View numbers</h1>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="class">View Category Wise</label>
                    <select name="class" id="class" class="form-control" onchange="location = this.value;">
                        <option value="null">... Select Category ...</option>
                        <?php
                        if (isset($categories)){
                            foreach ($categories as $category){
                                ?>
                                <option value='view_numbers_as_user.php?category=<?php echo $category->id;?>'><?php echo $category->category_name;?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <h3 style="text-align: center;">
                    <?php
                    echo isset($_REQUEST['category']) ? 'Category :' : '';
                    ?>
                    <span>
                        <?php
                        echo isset($single_category)? $single_category->category_name : '';
                        ?>
                    </span>
                </h3>
            </div>

            <div class="panel-body">
                <table style="border: 1px" class="table table-bordered table-responsive table-hover table-striped">
                    <tr>
                        <th>Serial</th>
                        <th>Numbers</th>
                        <th>Category</th>
                    </tr>
                    <!--                    for category wise.........-->
                    <?php if (isset($numbers_category_wise)){
                        $serial = 1;
                        foreach ($numbers_category_wise as $number){
                            ?>
                            <tr>
                                <td><?php echo $serial;?></td>
                                <td><?php echo $number->number;?></td>
                                <td><?php echo $number->category_name;?></td>
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
