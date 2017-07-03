<?php
require_once "core/init.php";
$user = new User();
if (!$user->isLoggedIn()){
    Redirect::to('index.php');
}
$db = DB::getInstance();
$categoryData = $db->getAll('categories');
$categories = $db->results();
//if (Input::exists()){
//    if (Token::check(Input::get('token'))){
//        var_dump($_POST);exit();
//        $validate = new Validate();
//        $validation = $validate->check($_POST, array(
//            'mobile' => array('required' => true),
//            'category' => array('required' => true),
//        ));
//
//        if ($validate->passed()){
//            var_dump($_POST);exit();
//            $db = DB::getInstance();
//            try{
//                $insert_mobile = $db->insert('numbers', array(
//                        'number' => Input::get('mobile'),
//                        'category_id' => Input::get('cetegory')
//                    ));
//                if ($insert_mobile){
//                    Session::flash('home', 'Mobile successfully added !');
//                }else {
//                    throw new Exception('Something going wrong !');
//                }
//            }catch (Exception $e){
//                die($e->getMessage());
//            }
//        }else{
////            foreach ($validate->errors() as $error) {
////                echo $error . '<br>';
////            }
//        }
//    }else {
//
//    }
//}

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
                <h1 class="text-center text-temp">Add Mobile Number</h1>
                <?php 
                    if (isset($validate)){
                        foreach ($validate->errors() as $error) {
                            echo "<p style='color: red; text-align: center; padding-top: 5px; margin-bottom: 7px'>*$error</p>";
                        }
                    }

                    if (Session::exists('home')){
                        echo "<p style='color: green'>". Session::get('home') ."</p>";
                        Session::delete('home');
                    }
                ?>
                <p id="success_message" style="display: none; color: #8702A8"></p>
            </div>
            <div class="panel-body">
                <form id="add_number" name="validate" action="add_mobile.php" method="post">

                    <div class="row">
                        <!-- Button trigger modal -->
                        <div class="col-sm-8">
                            <button style="margin-bottom: 15px;" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                                Select Category
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Select Class</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="" for="category_id">Select Category <span class="star">*</span></label>
                                            <select style="width: 78% !important;" name="category_id" id="category" class="form-control">
                                                <?php
                                                    foreach ($categories as $category) {
                                                        ?>
                                                        <option value="<?php echo $category->id; ?>"><?php echo $category->category_name; ?></option>
                                                        <?php 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="category_btn" type="button" class="btn btn-primary" data-dismiss="modal"><span class=" glyphicon glyphicon-ok"></span></button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="row">
                        <div class="col-sm-6">

                            <div class="row" style="display: none" id="category_block">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <p class="form-control" id="show_category"></p>
                                        <input type="hidden" class="form-control" id="category_id" name="category">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <p id="error_mobile" style="display: none; color: red;"></p>
                                <label for="mobile">Phone</label> <span style="display: none; color: green" id="mobile_valid" class="glyphicon glyphicon-ok"></span> <span style="display: none; color: red" id="mobile_not_valid">Not valid</span>
                                <div class="">
                                    <input id="add_mobile" name="mobile" type="text" class="form-control" placeholder="Phone" autocomplete="none">
                                </div>
                            </div>
                            <input type="hidden" id="token" name="token" value="<?php echo Token::generate();?>">
                            <input type="hidden" id="added_by" name="added_by" value="<?php echo Session::get('user') ? Session::get('user') : '';?>">
                        </div>
                    </div>
                    <hr>
                    <div class="">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <button id="submit_btn" type="submit" class="btn btn-block btn-info">Save</button>
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
