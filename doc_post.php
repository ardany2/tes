<?php
include "component/header.php";

@$perkara_id = $_POST['perkara_id'];
@$var_nomor  = $_POST['var_nomor'];
@$var_model  = $_POST['var_model'];
@$var_jenis  = $_POST['var_jenis'];
@$form_data  = $_POST['form_data'];
@$sidang_id  = $_POST['sidang_id'];
$user = '';
$sekarang = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
if($var_model == 4){
    $date = $_POST['form_data'];
    function validateDate($date, $format = 'd-m-Y')
            {
                $d = DateTime::createFromFormat($format, $date);
                // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
                return $d && $d->format($format) === $date;
            }
    $tanggal = DateTime::createFromFormat('d-m-Y', $date);
    
    
    if(validateDate($date)){
        $form_data = $tanggal->format('Y-m-d');
    } else {
        $form_data = '0000-00-00';
    }
} 
//tanggal sekarang

$data = [
    'perkara_id'        => $perkara_id,
    'var_nomor'         => $var_nomor,
    'DATA'              => $form_data,
    'diinput_oleh'      => $user,
    'diinput_tanggal'   => $sekarang->format('Y-m-d H:i:s')  
];

$dataupdate = array(
    'perkara_id'        => $perkara_id,
    'var_nomor'         => $var_nomor,
    'DATA'              => $form_data,
    'diperbaharui_oleh'      => $user,
    'diperbaharui_tanggal'   => $sekarang->format('Y-m-d H:i:s')
);
    
$model = $db2->table('master_variabel_tipe')->where('id',$var_model)->first();
$table = $model->value;
$q = $db2->table($table)->where('perkara_id', $perkara_id)->where('var_nomor',$var_nomor);

//print_r($q->get());
//var_dump($form_data);
 
if ($q->get()){
    $q->update($dataupdate);
    $s = $q->get();
    $data = $s[0]->DATA;
    $pesan = "Update var: {$var_nomor} dengan data: {$data} berhasil.";
    if($s[0]->DATA == '' || $s[0]->DATA == '<p><br></p>' || $s[0]->DATA == '0' || $s[0]->DATA === 0 || $s[0]->DATA == '0000-00-00'){
        $q->delete();
        $pesan = "Hapus var: {$var_nomor} berhasil.";
    }
    echo $pesan;
} else {
    $db2->table($table)->insert($data);
    $pesan = "Insert var: {$var_nomor} dengan data: {$form_data} berhasil.";
    $s = $q->get();
    
    if($s[0]->DATA == '' || $s[0]->DATA == '<p><br></p>' || $s[0]->DATA == '0' || $s[0]->DATA === 0 || $s[0]->DATA == '0000-00-00'){ //|| $s[0]->DATA == 0
        $q->delete();
        $pesan = "Hapus var: {$var_nomor} berhasil.";
    }
    echo $pesan;
    //print_r($s);
}


