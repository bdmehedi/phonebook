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

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'user_name' => array(
                'required' => true,
                'min' => 1,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 1
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
        ));

        if ($validate->passed()) {
//            echo "<pre>";
//            var_dump($_POST); exit();
            $user = new User();

            try {
                $user->create(array(
                    'user_name' => Input::get('user_name'),
                    'mobile' => Input::get('mobile'),
                    'password' => Hash::make(Input::get('password')),
                    'name' => Input::get('name'),
                    'group_id' => Input::get('group_id'),
                ));

                Session::flash('home', 'User successfully registered !');
                //Redirect::to('home.php');

            } catch (Exception $e){
                $errors = $e->getMessage();
            }
        }else {
//            foreach ($validate->errors() as $error) {
//                echo $error . '<br>';
//            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | IGL Phone book</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/phonebook.png" />
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">

    <!--  for bootstrap  -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <h1 class="text-center login-title login_welcome">IGL Phone Book App</h1>

        <?php
        if (isset($validate)){
            foreach ($validate->errors() as $error){
                echo "<p style='color: red; text-align: center'>$error</p>";
            }
        }
        if (isset($errors)){
            echo "<p style='color: red; text-align: center'>$errors</p>";
        }
        if (Session::exists('home')){
            echo "<p style='color: royalblue; text-align: center'>" . Session::get('home') ."</p>";
            Session::delete('home');
        }
        ?>

        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <!--                <h1 class="text-center login-title login_welcome">Welcome to University of Washington</h1>-->
            <div class="account-wall">
                <img class="profile-img" src="assets/img/phonebook.png"
                     alt="LOGO">
                <form name="validate" action="register.php" method="post" class="form-signin">
                    <div class="">
                        <p id="error_user_name" style="display: none; color: red;"></p>
                        <label for="user_name">User Name</label> <span style="display: none; color: green" id="user_name_valid" class="glyphicon glyphicon-ok"></span>
                        <input id="user_name" value="<?php echo escape(Input::get('user_name')); ?>" name="user_name" type="text" class="form-control" autofocus placeholder="User Name"  autocomplete="none">
                    </div>

                    <div class="">
                        <label for="name">Name</label>
                        <input value="<?php echo escape(Input::get('name')); ?>" name="name" type="text" class="form-control" placeholder="name" autocomplete="none">
                    </div>

                    <div class="">
                        <p id="error_mobile" style="display: none; color: red;"></p>
                        <label for="mobile">Phone</label> <span style="display: none; color: green" id="mobile_valid" class="glyphicon glyphicon-ok"></span> <span style="display: none; color: red" id="mobile_not_valid">Not valid</span>
                        <input id="mobile" value="<?php echo escape(Input::get('mobile')); ?>" name="mobile" type="text" class="form-control" placeholder="Phone">
                    </div>

                    <div class="">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control" placeholder="Password"  autocomplete="none">
                    </div>

                    <input type="hidden" name="group_id" value="2">
                    <input type="hidden" name="token" value="<?php echo Token::generate() ?>">

                    <button id="submit_btn" style="margin-top: 10px;" class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
                    <hr>
                    <label style="float: right"><a href="home.php" class="btn btn-primary">Home</a></label>
                </form>
            </div>
            <!--                <a href="#" class="text-center new-account">Create an account </a>-->
        </div>
    </div>
</div>

<script src="assets/js/jquery-3.1.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/ajax_file.js"></script>
</body>
<footer style="margin-top: 30px">
    <div id="footer">
        <div id="container">
            <p align="center">
                CopyRight &copy; <color  style="color:red;">IGL Phone Book App</color> 2014 - <?=date('Y');?><br />
                <a href="http://iglweb.com" target="_blank" title="Domain Registration, Web Hosting and Web Design"> Domain Registration, Web Hosting and Web Design</a> by: <a target="_blank" href="http://iglweb.com/" style="padding:0 0 0 0;">IGL Web Ltd</a>
        </div>
    </div>
</footer>
</html>
