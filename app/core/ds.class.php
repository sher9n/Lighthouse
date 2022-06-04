<?php
namespace Core;
date_default_timezone_set('UTC');

class Ds
{
    public static function connect(){

        $conn = new \mysqli(AURORA_END_POINT,AURORA_UN, AURORA_PW);

        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);

        $conn->select_db(AURORA_DB);

        return $conn;
    }
}