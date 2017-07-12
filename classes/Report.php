<?php

class Report
{
    private static $_db = null;
    private static $_usrId = null;

    public function __construct()
    {
        if (!self::$_db){
            self::$_db = DB::getInstance();
        }
        if (!self::$_usrId){
            self::$_usrId = Session::get(Config::get('session/session_name'));
        }
    }

    // for total numbers for specific user.
    public static function getTotalNumber($user_id = null)
    {
        new Report();
        $user = $user_id ? $user_id : self::$_usrId;
        $sql = "SELECT COUNT(number)as total FROM numbers where added_by = {$user}";
        $totalData = self::$_db->getAllWithSql($sql);
        return $totalData->firstResult()->total;
    }

    // get row count for numbers table....
    public static function getTotalNumberAmount($count = null, $where = null)
    {
        new Report();
        $where = $where ? $where : '';
        $count = $count ? $count: '';
        $where = $where ? "WHERE {$where}" : '';
        $sql = "SELECT COUNT({$count})as total FROM numbers {$where}";
        $totalData = self::$_db->getAllWithSql($sql);
        if (gettype($totalData) != 'string'){
            return $totalData->firstResult()->total;
        }
        return false;
    }


    // get today added numbers for specific user.....
    public static function getTotalTodayNumber($user = null)
    {
        new Report();
        $user = $user ? $user : self::$_usrId;
        $today = "'".date('Y-m-d')."%'";
        $sql = "SELECT COUNT(number) as total FROM numbers where added_by = {$user} AND created_at LIKE {$today}";
        $totalData = self::$_db->getAllWithSql($sql);
        return $totalData->firstResult()->total;
    }

    // for total numbers for specific user.
    public static function getCategoryById($category_id = null)
    {
        new Report();
        $sql = "SELECT * FROM `categories` WHERE id = {$category_id}";
        $totalData = self::$_db->getAllWithSql($sql);
        if ($totalData){
            return $totalData->firstResult();
        }
        return false;
    }

    // get category sms with id.....
    public static function getCategorySmsById($category_id = null)
    {
        new Report();
        $sql = "SELECT * FROM `categories` WHERE id = {$category_id}";
        $totalData = self::$_db->getAllWithSql($sql);
        if ($totalData){
            return $totalData->firstResult()->message;
        }
        return false;
    }

    // get category sms sender ID with id.....
    public static function getCategorySmsSenderById($category_id = null)
    {
        new Report();
        $sql = "SELECT * FROM `categories` WHERE id = {$category_id}";
        $totalData = self::$_db->getAllWithSql($sql);
        if ($totalData){
            return $totalData->firstResult()->sender_id;
        }
        return false;
    }

    // get user mobile with id.....
    public static function getUserMobileById($user_id = null)
    {
        new Report();
        $user = $user_id ? $user_id : self::$_usrId;
        $sql = "SELECT * FROM users where id = {$user}";
        $totalData = self::$_db->getAllWithSql($sql);
        return $totalData->firstResult()->mobile;
    }

    // get user Name with id.....
    public static function getUserNameById($user_id = null)
    {
        new Report();
        $user = $user_id ? $user_id : self::$_usrId;
        $sql = "SELECT * FROM users where id = {$user}";
        $totalData = self::$_db->getAllWithSql($sql);
        return $totalData->firstResult()->name;
    }

}