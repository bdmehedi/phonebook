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

// see all numbers as category wise.......
if (isset($_REQUEST['category'])){
    $category_id = $_REQUEST['category'];
    $sql = "SELECT * FROM categories WHERE id = $category_id";
    $single_category_data = $db->getAllWithSql($sql);
    if ($single_category_data->count()){
        $single_category = $single_category_data->firstResult();
    }

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = isset($_GET['per_page']) && $_GET['per_page'] <= 50 ? (int)$_GET['per_page'] : 50;
    $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

    $sql = "SELECT * FROM `numbers` JOIN users ON numbers.added_by = users.id WHERE numbers.category_id = {$category_id} ORDER BY numbers.id DESC LIMIT {$start}, {$perPage}";
    $mobile_data = $db->getAllWithSql($sql);
    if ($mobile_data->count()){
        $numbers_category_wise = $mobile_data->results();
    }
    //get all page for numbers.
    $pages = ceil($db->getPages('numbers', 'number', 'numbers.category_id = '.$category_id) / $perPage);
}

// see All numbers as user wise..
if (isset($_REQUEST['user'])){
    $id = $_REQUEST['user'];

    $sql = "SELECT * FROM users WHERE id = $id";
    $single_user_data = $db->getAllWithSql($sql);
    if ($single_user_data->count()){
        $single_user = $single_user_data->firstResult();
    }

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = isset($_GET['per_page']) && $_GET['per_page'] <= 50 ? (int)$_GET['per_page'] : 50;
    $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

    $sql = "SELECT * FROM `numbers` JOIN categories ON numbers.category_id = categories.id WHERE numbers.added_by = {$id} ORDER BY numbers.id DESC LIMIT {$start}, {$perPage}";
    $mobile_data = $db->getAllWithSql($sql);
//    $mobile_data = $db->getJoin_2_TableData('number', 'categorie',  'numbers.added_by = '.$id, 'category_id', null, 'ORDER BY numbers.id DESC');
    if ($mobile_data->count()){
        $numbers_user_wise = $mobile_data->results();
    }
    //get all page for numbers.
    $pages = ceil($db->getPages('numbers', 'number', 'numbers.added_by = '.$id) / $perPage);
}

// see all numbers .........
if (isset($_GET['all'])){
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = isset($_GET['per_page']) && $_GET['per_page'] <= 50 ? (int)$_GET['per_page'] : 50;
    $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

    $sql = "SELECT * FROM (SELECT * FROM numbers LIMIT {$start}, {$perPage}) `numbers` JOIN users ON numbers.added_by = users.id JOIN categories ON numbers.category_id = categories.id ORDER BY numbers.id DESC ";
    $all_numbers_data = $db->getAllWithSql($sql);
    if ($all_numbers_data->count()){
        $numbers = $all_numbers_data->results();
    }
    //get all page for numbers.
    $pages = ceil($db->getPages('numbers', 'number') / $perPage);
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
                <a href="view_numbers.php?all=1&page=1&per_page=50" name="all" class="btn btn-primary">View All</a>
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
                                    <option value='view_numbers.php?category=<?php echo $category->id;?>&page=1&per_page=50'><?php echo $category->category_name;?></option>
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
                                <option value='view_numbers.php?user=<?php echo $user->id;?>&page=1&per_page=50'><?php echo $user->user_name. ' ('. $user->name. ') ';?></option>
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
                        <?php echo isset($numbers) ? '<th>Added By</th>' : '' ?>
                    </tr>
<!--                    for category wise.........-->
                    <?php if (isset($numbers_category_wise)){
                        $serial = ($_GET['page'] > 1) ? ((int)$_GET['page'] * (int)$_GET['per_page']) - ((int)$_GET['per_page'] - 1) : 1;
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
                        $serial = ($_GET['page'] > 1) ? ((int)$_GET['page'] * (int)$_GET['per_page']) - ((int)$_GET['per_page'] - 1) : 1;
                        foreach ($numbers_user_wise as $number){
                        ?>
                            <tr>
                                <td><?php echo $serial;?></td>
                                <td><?php echo $number->number;?></td>
                                <td><?php echo $number->category_name;?></td>
                            </tr>
                    <?php $serial++; }} ?>

<!--                    for all numbers view -->
                    <?php if (isset($numbers)){
                        $serial = ($_GET['page'] > 1) ? ((int)$_GET['page'] * (int)$_GET['per_page']) - ((int)$_GET['per_page'] - 1) : 1;
                        foreach ($numbers as $number){
                            ?>
                            <tr>
                                <td><?php echo $serial;?></td>
                                <td><?php echo $number->number;?></td>
                                <td><?php echo $number->category_name;?></td>
                                <td><?php echo $number->name;?></td>
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
                                    href="<?php echo isset($_GET['all']) ? '?all=' . $_GET['all'] : '';
                                    echo isset($_GET['category']) ? '?category=' . $_GET['category'] : '';
                                    echo isset($_GET['user']) ? '?user=' . $_GET['user'] : ''; ?>&page=<?php echo --$previous_page; ?>&per_page=50">Previous
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
                                        href="<?php echo isset($_GET['all']) ? '?all=' . $_GET['all'] : '';
                                        echo isset($_GET['category']) ? '?category=' . $_GET['category'] : '';
                                        echo isset($_GET['user']) ? '?user=' . $_GET['user'] : ''; ?>&page=<?php echo $page ?>&per_page=50"><?php echo $page . ' ' ?>
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
                                        href="<?php echo isset($_GET['all']) ? '?all=' . $_GET['all'] : '';
                                        echo isset($_GET['category']) ? '?category=' . $_GET['category'] : '';
                                        echo isset($_GET['user']) ? '?user=' . $_GET['user'] : ''; ?>&page=<?php echo $page ?>&per_page=50"><?php echo $page . ' ' ?>
                                </a>&nbsp;
                                <?php
                            }
                        }
                        if ($pages > $max_page && $_GET['page'] < $pages) {
                            ?>
                            <a
                                    href="<?php echo isset($_GET['all']) ? '?all=' . $_GET['all'] : '';
                                    echo isset($_GET['category']) ? '?category=' . $_GET['category'] : '';
                                    echo isset($_GET['user']) ? '?user=' . $_GET['user'] : ''; ?>&page=<?php echo isset($_GET['page']) ? ++$_GET['page'] : '' ?>&per_page=50">Next
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
