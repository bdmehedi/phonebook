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
// for getting ....
if (isset($_GET['category'])){
    $category_id = $_GET['category'];
    $category_details = Report::getCategoryById($category_id);
}

// get all category.....
$db = DB::getInstance();
$sql = "SELECT * FROM categories ORDER BY categories.category_name ASC";
$categoryData = $db->getAllWithSql($sql);
$categories = $categoryData->results();

if (Input::exists()){
    if (Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'sms' => array('max' => 100),
        ));

        if ($validate->passed()){
            $db = DB::getInstance();
            try{
                $update_categorys_sms = $db->update('categories', isset($category_id) ? $category_id : '', array('message' => Input::get('sms'), 'sender_id' => Input::get('sender_id')));
                if ($update_categorys_sms){
                    Session::flash('home', 'Category message successfully updated !');
                    Redirect::to('view_category.php');
                }else {
                    throw new Exception('Something going wrong !');
                }
            }catch (Exception $e){
                $errors = $e->getMessage();
            }
        }else{
//            foreach ($validate->errors() as $error) {
//                echo $error . '<br>';
//            }
        }
    }else {
        $token_error = true;
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
                <h1 class="text-center text-temp">Edit Category Message</h1>
            </div>
            <div class="panel-body">
                <form action="edit_category.php?category=<?php echo $category_id?>" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <?php
                            if (isset($validate)){
                                foreach ($validate->errors() as $error) {
                                    echo "<p style='color: red'>$error</p>";
                                }
                            }
                            if (isset($token_error)){
                                echo "<p style='color: red'>Token not match</p>";
                            }
                            if (isset($errors)){
                                echo "<p style='color: red'>$errors</p>";
                            }
                            if (Session::exists('home')){
                                echo "<p style='color: green'>". Session::get('home') ."</p>";
                                Session::delete('home');
                            }
                            ?>
                            <div class="form-group">
                                <p>Category Name :  <span style="font-weight: bold"><?php echo isset($category_details) ? $category_details->category_name : ''?></span></p>
                            </div>

                            <div class="form-group">
                                <label class="" for="sender_id">Sender ID</label>
                                <div class="">
                                    <input value="<?php echo isset($category_details) ? $category_details->sender_id : ''?>" class="form-control" type="text" name="sender_id" id="sender_id" placeholder="SMS Sender Id">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="" for="sms">Category Message <span class="sms_char">Maximum 75 Character:</span></label>
                                <div class="">
                                    <textarea rows="4" class="form-control" maxlength="75" name="sms" id="sms" placeholder="Category Message"><?php echo isset($category_details) ? $category_details->message : ''?></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                        </div>
                    </div>
                    <hr>
                    <div class="">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-info">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <div class="row">
                    <div class="col-sm-6">
                        <table style="border: 1px" class="table table-bordered table-responsive table-hover table-striped">
                            <tr>
                                <th>Serial</th>
                                <th>Category Name</th>
                                <th>Total Numbers</th>
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
                                    </tr>
                                    <?php $serial++; }} ?>
                            <tr>
                                <td></td>
                                <th></th>
                                <td>Total =  <?php echo Report::getTotalNumberAmount('number')?></td>
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
