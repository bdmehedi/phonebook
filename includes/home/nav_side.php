<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse" >
        <ul class="nav" id="main-menu" style="">
            <li class="text-center hidden-xs hidden-sm">
                <img src="assets/home/img/igl-logo.png" class="user-image img-responsive"/>
            </li>


            <li>
                <a class="active-menu"  href="home.php"><i class="fa fa-dashboard fa-2x" ></i> Dashboard</a>
            </li>
            <?php if (Permission::is('admin')) {?>
                <li  >
                    <a  href="register.php"><i class="fa fa-sitemap fa-2x"></i>Add user</a>
                </li>
                <li  >
                    <a  href="view_users.php"><i class="fa fa-sitemap fa-2x"></i>View users</a>
                </li>
                <li  >
                    <a  href="add_category.php"><i class="fa fa-sitemap fa-2x"></i>Add Category</a>
                </li>
                <li  >
                    <a  href="view_category.php"><i class="fa fa-sitemap fa-2x"></i>View Category</a>
                </li>
                <li  >
                    <a  href="view_numbers.php"><i class="fa fa-sitemap fa-2x"></i>View Mobile Number</a>
                </li>
            <?php } ?>
            <li  >
                <a  href="add_mobile.php"><i class="fa fa-sitemap fa-2x"></i>Add Mobile Number</a>
            </li>
            <?php if (Permission::is('user')) {?>
                <li  >
                    <a  href="view_numbers_as_user.php"><i class="fa fa-sitemap fa-2x"></i>View Mobile Number</a>
                </li>
            <?php } ?>
<!--            <li>-->
<!--                <a href="#"><i class="fa fa-sitemap fa-2x"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>-->
<!--                <ul class="nav nav-second-level">-->
<!--                    <li>-->
<!--                        <a href="com_reg.jsp">Company Registration</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="branch_regis.jsp">Branch Registration</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="user_reg.jsp">User Registration</a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </li>-->
        </ul>

    </div>

</nav>