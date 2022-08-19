<?php
include "component/header.php";
//$tahun = $_GET['tahun'];
/* use PhpOffice\PhpWord\Settings;

date_default_timezone_set('UTC');
error_reporting(E_ALL);

Settings::loadConfig();
//$perkara    = $db1->table('v_perkara')->find($perkara_id, 'perkara_id');

$template   = $db2->table('template_dokumen')->find(723);
$source     = __DIR__ . "/doc/{$template->kode}.docx";

$var        = new Variabel;
$content    = $var->getContentDocx($source);
//$variabel   = $var->getVariabels($content); */
$variabel = json_decode($_POST["variabel"]);
@$perkara_id = $_POST['perkara_id'];
@$sidang_id = $_POST['sidang_id'];
$isi = Isi::getInstance($perkara_id);

foreach ($variabel as $k => $var) {

    $m_var = $db2->table('master_variabel')->find($var, 'var_nomor');
    if ($m_var) {
        $model  = @$m_var->var_model;
        $fungsi = @$m_var->var_fungsi_nama;
        $jenis  = @$m_var->var_jenis;
    } else {
        $model = 'N/A';
    }

    $data = $isi->data($var, $model, $fungsi, $jenis, $sidang_id);

    echo "<tr>";
    echo "<td class=\"\" style=\"text-align:center;font-weight: bold\">", $k + 1, ".</td>";
    echo "<td class=\"\"> {$var} {$model}";
    // {$sidang_id}
    echo "</td>";
    echo "<td class=\"\"> " . @$m_var->var_keterangan . " </td>";
    echo "<td> {$jenis} </td>";
    echo $data;
    echo "</tr>";
    $k++;
}


