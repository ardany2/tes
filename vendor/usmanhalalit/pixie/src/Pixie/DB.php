<?php
namespace Pixie;
use PDO;

class DB {


private static $_instance = null;
private static $_db = null;

private $_configdb1 = [
    'driver'    => 'mysqli', // Db driver
    'host'      => 'localhost',
    'database'  => 'sipp',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8', // Optional
    'collation' => 'utf8_unicode_ci', // Optional
    'prefix'    => '', // Table prefix, optional
    'options'   => [ // PDO constructor options, optional
        PDO::ATTR_TIMEOUT => 5,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];

private $_configdb2 = [
    'driver'    => 'mysqli', // Db driver
    'host'      => 'localhost',
    'database'  => 'sipp_matoh',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8', // Optional
    'collation' => 'utf8_unicode_ci', // Optional
    'prefix'    => '', // Table prefix, optional
    'options'   => [ // PDO constructor options, optional
        PDO::ATTR_TIMEOUT => 5,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];

protected function get_dbconfig($int){
    $nama = '_configdb'.$int;
    $obj = (object) $this->$nama;
    return $obj;
}

public function get_dbnama($int){
    $nama = $this->get_dbconfig($int);
    return $nama->database;
}

//pakai yang ini saja kayaknya
public function getDB($class, $int){    
    $conf = (array) $this->get_dbconfig($int);
    $db = new \Pixie\Connection('mysql', $conf, $class);
    return $class;
}

public static function getInstance(){   
    if(!isset(self::$_instance)) {          
      self::$_instance = new DB;
    }
    return self::$_instance;
  }

  public static function getNewDB(){
    $db = DB::getInstance();
    $conf = (array) $db->get_dbconfig(1);     
    if(!isset(self::$_db)) {
        $connection = new \Pixie\Connection('mysql', $conf);   
        self::$_db  = new \Pixie\QueryBuilder\QueryBuilderHandler($connection);
    }
    return self::$_db;
  }  

}
