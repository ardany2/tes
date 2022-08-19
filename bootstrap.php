<?php
require_once __DIR__ . "/vendor/autoload.php";

$db = new \Pixie\DB();
$db1 = $db->getDB1();
$db2 = $db->getDB2();

$phpWord = new \PhpOffice\PhpWord\PhpWord();
$row = $db2::table('perkara_kontrol_relaas')->find(3);
echo '<pre>';
print_r($row);
echo '</pre>';