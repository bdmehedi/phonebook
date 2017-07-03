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

if (Input::exists()){
    if (Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'category_name' => array('required' => true),
        ));

        if ($validate->passed()){
            $db = DB::getInstance();
            try{
                $category = '"'.Input::get('category_name').'"';
                // unique check.....
                $sql = "SELECT * FROM `categories` WHERE category_name = {$category}";
                $categoryData = $db->getAllWithSql($sql);
                if ($categoryData->count()){
                    throw new Exception('Opps, Category already exist !');
                }
                 $insert_category = $db->insert('categories', array('category_name' => Input::get('category_name')));
                if ($insert_category){
                    Session::flash('home', 'Category successfully added !');
                }else {
                    throw new Exception('Something going wrong !');
                }
            }catch (Exception $e){
                $errors = $e->getMessage();
            }
        }else{
            foreach ($validate->errors() as $error) {
                echo $error . '<br>';
            }
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
                <h1 class="text-center text-temp">Add Category</h1>
            </div>
            <div class="panel-body">
                <form action="add_category.php" method="post">
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
                                <label class="" for="name">Category Name</label>
                                <div class="">
                                    <input class="form-control" type="text" name="category_name" id="name" placeholder="Category Name">
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
            </div>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<?php require_once "includes/home/footer.php"?>
