<?php
namespace Pixie;

class DB2 extends DB {
    private static $_db = null;

    public static function getNewDB(){
        $db = DB::getInstance();
        $conf = (array) $db->get_dbconfig(2);     
        if(!isset(self::$_db)) {
            $connection = new \Pixie\Connection('mysql', $conf);   
            self::$_db  = new \Pixie\QueryBuilder\QueryBuilderHandler($connection);
        }
        return self::$_db;
      }  
}