<?php

namespace App;

class DB
{
    public static function connect()
    {
        $dir = $_SERVER['DOCUMENT_ROOT'];
        $params = include("$dir/config/db.php");
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new \PDO($dsn, $params['user'], $params['password']);
        $db->exec("set names utf8");
        return $db;
    }
}