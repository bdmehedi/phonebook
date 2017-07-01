
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
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <!--                <h1 class="text-center login-title login_welcome">Welcome to University of Washington</h1>-->
            <div class="account-wall">
                <img class="profile-img" src="assets/img/phonebook.png"
                         alt="LOGO">
                <form action="" method="post" class="form-signin">
                    <div class="">
                        <input name="email" type="text" class="form-control" placeholder="Email or Phone"  autofocus autocomplete="none">
                    </div>

                    <div class="">
                        <input name="password" type="password" class="form-control" placeholder="Password"  autocomplete="none">
                    </div>

                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                    <hr>
                    <label class="checkbox pull-left">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value="remember-me">
                        Remember me
                    </label>
                    <label style="float: right"><a href="register.php" class="btn btn-primary">Register</a></label>
                </form>
            </div>
            <!--                <a href="#" class="text-center new-account">Create an account </a>-->
        </div>
    </div>
</div>

<script src="assets/js/jquery-3.1.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>
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
