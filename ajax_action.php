<?php
//header('Content-type: text/javascript');
require_once "core/init.php";
$jsonData = array(
    'success' => false,
    'result' => ''
);
// for user name unique....
if (isset($_POST['user'])){
    $user_name = Input::get('user_name');
    $db = DB::getInstance();
    $userData = $db->get('users', array('user_name', '=', $user_name));
    if ($userData->count()){
        $jsonData['success'] = true;
        $jsonData['result'] = $userData->firstResult()->user_name;
    }
}

// for mobile unique.....
if (isset($_POST['phone'])){
    $mobile = Input::get('mobile');
    $db = DB::getInstance();
    $getMobile = $db->get('users', array('mobile', '=', $mobile));
    if ($getMobile->count()){
        $jsonData['success'] = true;
        $jsonData['result'] = $getMobile->firstResult()->mobile;
    }
}

// for mobile add ........
if (isset($_POST['add_mobile'])){
    $mobile = Input::get('mobile');
    $db = DB::getInstance();
    $getMobile = $db->get('numbers', array('number', '=', $mobile));
    if ($getMobile->count()){
        $jsonData['success'] = true;
        $jsonData['result'] = $getMobile->firstResult()->number;
    }
}

// get category name for show in add mobile numbers .......
if (isset($_POST['get_category'])){
    $category_id = Input::get('category_id');
    $db = DB::getInstance();
    $getCategory = $db->get('categories', array('id', '=', $category_id));
    if ($getCategory->count()){
        $jsonData['success'] = true;
        $jsonData['result'] = $getCategory->firstResult()->category_name;
    }
}



echo json_encode($jsonData);