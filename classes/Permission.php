<?php

class Permission
{
    private static $_db = null;
    private static $_sessionData = null;
    private static $_userName = null;

    public function __construct()
    {
        if (!self::$_db){
            self::$_db = DB::getInstance();
        }
        if (!self::$_sessionData){
            self::$_sessionData = Session::get(Config::get('session/session_name'));
        }
    }

    public static function is ($permission)
    {
        new Permission();
        $getPermissionData = self::$_db->getJoin_2_TableData('user', 'group', 'users.id = '.self::$_sessionData);
        if (!$getPermissionData->count()){
            return false;
        }
        self::$_userName = self::$_db->firstResult()->name;
        if (self::$_db->firstResult()->group_name == $permission){
            return self::$_db->firstResult()->user_name;
        }
        return false;
    }

    public static function getUserName()
    {
        return self::$_userName;
    }
}