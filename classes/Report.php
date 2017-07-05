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

    public static function getTotalNumber()
    {
        new Report();
        $user = self::$_usrId;
        $sql = "SELECT COUNT(number)as total FROM numbers where added_by = {$user}";
        $totalData = self::$_db->getAllWithSql($sql);
        return $totalData->firstResult()->total;
    }

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

    public static function getTotalTodayNumber()
    {
        new Report();
        $user = self::$_usrId;
        $today = "'".date('Y-m-d')."%'";
        $sql = "SELECT COUNT(number) as total FROM numbers where added_by = {$user} AND created_at LIKE {$today}";
        $totalData = self::$_db->getAllWithSql($sql);
        return $totalData->firstResult()->total;
    }

}