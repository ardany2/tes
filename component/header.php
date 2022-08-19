<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../init.php";

$db1        = \Pixie\DB::getNewDB();
$db2        = \Pixie\DB2::getNewDB();

//$db2_nama = $db2->get_dbnama(2);

$phpWord = new \PhpOffice\PhpWord\PhpWord();