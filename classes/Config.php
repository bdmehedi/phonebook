<?php

class Config
{
    public static function get($path = null)
    {
        if ($path){
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach ($path as $bit){
                if (isset($config[$bit])){
                    $config = $config[$bit];
                }
            }
            if (!is_array($config)) {
                return $config;
            }
        }

        return false;
    }
}