<?php
include "component/header.php";
$tahun = $_GET['tahun'];
$perkara    = $db1->table('v_perkara');
$arsip   = $db1->table('arsip');
$perkara_date = $db1->table('perkara');
//$perkara_kontrol_relaas = $db2->table('perkara_kontrol_relaas')->find(3);
?>

<!DOCTYPE html>
<html>
<head>
<title>Aplikasi</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
</style>
</head>
<body class="w3-theme-l5">

<h3>Arsip Tidak Teridentifikasi/Belum Diupload Tahun <?php echo $tahun ?></h3>
<table class="w3-table-all w3-small w3-padding-small">
<thead>
    <th>No.</th><th>No. Perkara</th><th>Proses Terakhir</th><th>Panitera Pengganti</th><th>Status Putusan</th><th>Tanggal Putusan</th>
</thead>
<tbody>    
<?php 
//$p = $perkara->where('perkara_id', '<', 3)->get();
//print_r($p);

$q = $perkara->select('v_perkara.perkara_id','v_perkara.nomor_perkara','v_perkara.proses_terakhir_text','v_perkara.panitera_pengganti_text','v_perkara.status_putusan_kode','v_perkara.tanggal_putusan', 'arsip.id')->leftjoin('arsip','v_perkara.perkara_id','=','arsip.perkara_id')->where('tahun_pendaftaran',$tahun)->where('v_perkara.proses_terakhir_id','>=',220)->where($db1->raw('arsip.id IS NULL'))->get();
//$a = $arsip->select('perkara_id')->whereNotIn('perkara_id', array($q))->get();
//print_r($q);
foreach($q as $k=>$p){
    $n=$k+1;
    $pp=str_replace('Panitera Pengganti:','',$p->panitera_pengganti_text);
    echo "
    <tr>
    <td style='padding-top:0px;padding-bottom:0px'>{$n}.</td>
    <td style='padding-top:0px;padding-bottom:0px'>{$p->nomor_perkara}</td>
    <td style='padding-top:0px;padding-bottom:0px'>{$p->proses_terakhir_text}</td>
    <td style='padding-top:0px;padding-bottom:0px'>{$pp}</td>
    <td style='padding-top:0px;padding-bottom:0px'>{$p->status_putusan_kode}</td>
    <td style='padding-top:0px;padding-bottom:0px'>{$p->tanggal_putusan}</td>
    </tr>";
    $k++;
}


//echo "<p>{$p->nomor_perkara} Oye: {$perkara_kontrol_relaas->sidang_id}.</p>";




?>
</tbody>
</table>




</body>
</html>

