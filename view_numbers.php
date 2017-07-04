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
$sql = "SELECT * FROM categories ORDER BY categories.category_name ASC";
$categoryData = $db->getAllWithSql($sql);
if ($categoryData->count()){
    $categories = $categoryData->results();
}
// get All users.....
$sql = "SELECT * FROM users ORDER BY users.name ASC";
$usersData = $db->getAllWithSql($sql);
if ($usersData->count()){
    $users = $usersData->results();
}

// get all numbers as category wise.......
if (isset($_REQUEST['category'])){
    $category_id = $_REQUEST['category'];
    $sql = "SELECT * FROM categories WHERE id = $category_id";
    $single_category_data = $db->getAllWithSql($sql);
    if ($single_category_data->count()){
        $single_category = $single_category_data->firstResult();
    }
    $mobile_data = $db->getJoin_2_TableData('number', 'user',  'numbers.category_id = '.$category_id, 'added_by');
    if ($mobile_data->count()){
        $numbers_category_wise = $mobile_data->results();
//        echo "<pre>";
//        var_dump($numbers);
    }
}

// get All numbers as user wise..
if (isset($_REQUEST['user'])){
    $id = $_REQUEST['user'];

    $sql = "SELECT * FROM users WHERE id = $id";
    $single_user_data = $db->getAllWithSql($sql);
    if ($single_user_data->count()){
        $single_user = $single_user_data->firstResult();
    }

    $mobile_data = $db->getJoin_2_TableData('number', 'categorie',  'numbers.added_by = '.$id, 'category_id');
//    var_dump($mobile_data);ext();
    if ($mobile_data->count()){
        $numbers_user_wise = $mobile_data->results();
//        echo "<pre>";
//        var_dump($numbers);
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
                                    <option value='view_numbers.php?category=<?php echo $category->id;?>'><?php echo $category->category_name;?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="class">View User Wise</label>
                    <select name="class" id="class" class="form-control" onchange="location = this.value;">
                        <option value="null">... Select User ...</option>
                        <?php
                        if (isset($users)){
                            foreach ($users as $user){
                                ?>
                                <option value='view_numbers.php?user=<?php echo $user->id;?>'><?php echo $user->user_name;?></option>
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
                    echo isset($_REQUEST['user']) ? 'User :' : ''
                    ?>
                    <span>
                        <?php
                        echo isset($single_category)? $single_category->category_name : '';
                        echo isset($single_user)? $single_user->name : '';
                        ?>
                    </span>
                </h3>
            </div>

            <div class="panel-body">
                <table style="border: 1px" class="table table-bordered table-responsive table-hover table-striped">
                    <tr>
                        <th>Serial</th>
                        <th>Numbers</th>
                        <th><?php echo isset($numbers_category_wise) ? 'Added By' : 'Category' ?></th>
                    </tr>
<!--                    for category wise.........-->
                    <?php if (isset($numbers_category_wise)){
                        $serial = 1;
                        foreach ($numbers_category_wise as $number){
                        ?>
                            <tr>
                                <td><?php echo $serial;?></td>
                                <td><?php echo $number->number;?></td>
                                <td><?php echo $number->name;?></td>
                            </tr>
                    <?php $serial++; }} ?>

<!--                    for user wise.... -->

                    <?php if (isset($numbers_user_wise)){
                        $serial = 1;
                        foreach ($numbers_user_wise as $number){
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
