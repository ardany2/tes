<?php
require_once __DIR__ . "/vendor/autoload.php";

$db1 = \Pixie\DB::getInstance();print_r($db1);
$db2 = \Pixie\DB::getInstance();
$get_db = $db1->get_dbnama(1);
$db1 = $db1->getDB('YY',1);

$perkara = $db1::table('perkara')->find(3000, 'perkara_id');


//$db2 = $db->getDB2();

//echo '<pre>';

echo '<br>';

//print_r($db2);
//echo '</pre>';

$phpWord = new \PhpOffice\PhpWord\PhpWord();
?>

<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>
<h1>This is a Heading</h1>
<?php 


$db2 = $db2->getDB('QQ',2);
print_r($db2);

$perkara_kontrol_relaas = $db2::table('perkara_kontrol_relaas')->find(3);
echo "<p>{$perkara->nomor_perkara} Oye: {$perkara_kontrol_relaas->sidang_id}.</p>";


?>





</body>
</html>

