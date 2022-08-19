<?php
include "component/header.php";

$p = $db1->table('pihak')->where('id', 64665)->get();
$p = (array) $p[0];
$p1 = $db1->table('perkara_pihak1')->where('perkara_id', 20000)->get();
$p1 = (array) $p1[0];
$p2 = $db1->table('perkara_pihak2')->where('perkara_id', 20000)->get();
$p2 = (array) $p2[0];
$p3 = $db1->table('perkara_pihak3')->where('perkara_id', 1)->get();
$p3 = (array) $p3[0];
$p4 = $db1->table('perkara_pihak4')->where('perkara_id', 14349)->get();
$p4 = (array) $p4[0];
$p5 = $db1->table('perkara_pihak5')->where('perkara_id', 20000)->get();
$p5 = (array) $p5[0];

$pall = array_merge($p,$p1,$p2,$p3,$p4,$p5);

//INSERT KE DATABASE
/* foreach(array_keys($pall) as $k=>$v){
    //echo $v;
    $data = [
        'id' => $k+1,
        'tabel' => 'data_pihak',
        'kolom' => $v

    ];
    $db2->table('conf_tabel')->insert($data);
    $k++;
} */
//$flip = array_flip($a);

/* $s = '';
foreach ($a as $k=>$v){
    if (empty($v)){
        $r = '';
    } else {
        $r = $v;
    }

   
    $s .= $r.'<br>';

} */



$tabel = $db2->table('conf_tabel')->where('tabel', 'data_pihak')->get();
$form = '<form>';
foreach ($tabel as $k=>$v){
    $visibilitas = '';
    $required   = 'disabled';
    $form .= "<input type='{$v->tipe_data}' id={$v->kolom} placeholder='{$v->kolom}' {$visibilitas} {$required}><br>";
}

$form .="</form>";

//echo $form;

$pihaks = DataPihak::load(13240);
$p = $pihaks->getDataPihaks('pihak_pendaftaran');

//echo $p;

$t = $pihaks->sebutan_pihak(1,10);
$model = $db2->table('master_variabel_tipe')->where('id',3)->first();



$date = DateTime::createFromFormat('d/m/Y', "01/02/2012");

$html = '<table >
<tbody>
    <tr>
        <td>
        <p><strong>Bold Teks</strong></p>
        </td>
        <td>
        <p><strong>Bold Teks</strong> Tergugat tidak dapat memberi nafkah secara layak kepada Penggugat karena Tergugat cenderung menikmati sendiri hasil kerjanya tanpa memperhatikan kebutuhan sehari-hari Penggugat dan anak-anak Penggugat dengan Tergugat, sedangkan untuk memenuhi kebutuhan sehari-hari keluarga ditopang sendiri oleh Penggugat fdasfdas</p>
        </td>
    </tr>
    <tr>
        <td>
        <p>oiko8</p>
        </td>
        <td>
        <p>Tergugat tidak dapat memberi nafkah secara layak kepada Penggugat karena Tergugat tidak mempunyai penghasilan tetap, sedangkan untuk memenuhi kebutuhan sehari-hari ditopang oleh Penggugat</p>
        </td>
    </tr>
    <tr>
        <td>
        <p> ee</p>
        </td>
        <td>
        <p>Tergugat tidak dapat  memberi nafkah secara layak kepada Penggugat karena Tergugat tidak mau mencari kerja, sehingga untuk memenuhi kebutuhan sehari-hari ditopang oleh Penggugat</p>
        </td>
    </tr>
    <tr>
        <td>
        <p> dfasfdsa</p>
        </td>
        <td>
        <p>Tergugat tidak ada keterbukaan kepada Penggugat mengenai pekerjaannya dan juga tempat tinggal dia selama bekerja</p>
        </td>
    </tr>
    <tr>
        <td>
        <p> f</p>
        </td>
        <td>
        <p>Tergugat terlalu cemburu buta terhadap Penggugat dan menuduh Penggugat ada hubungan dengan laki-laki lain tanpa alasan yang jelas dan tanpa bukti</p>
        </td>
    </tr>
    <tr>
        <td>
        <p> sfsaf</p>
        </td>
        <td>
        <p>Tergugat bersifat temperamental dan sering berbicara kasar, mengucapkan kata-kata hinaan seperti ....... bahkan mengucapkan kata-kata cerai yang sampai melukai hati dan perasaan Penggugat, bahkan sesekali disertai tindak kekerasan fisik terhadap Penggugat dan di samping memiliki emosi yang tidak terkendali, Tergugat sering pula mengancam diri Penggugat seperti mengeluarkan kata-kata ingin membunuh Penggugat yang tentunya semua itu sangat mengancam keselamatan jiwa Penggugat dan membahayakan diri Penggugat</p>
        </td>
    </tr>
</tbody>
</table>';

$f = new Fungsi;
$g = $f->tabletocontents($html, '//p');
 
echo "<textarea>".implode($g). "</textarea>";
echo '<pre>';
//print_r(array_keys($pall));
//print_r($model->value);
print_r($g);
echo '</pre>';

