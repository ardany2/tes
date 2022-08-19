<?php

class Fungsi {

  
  private $_tanggal = null;

  private function tanggal($date){   
    $this->_tanggal = new DateTime($date, new DateTimeZone('Asia/Jakarta'));
  }


    public function tanggal_indonesia($date)
  {    
    $this->tanggal($date);
    $tanggal = $this->_tanggal;
    $n = $tanggal->format('n');
    switch ($n) {
      case 1:
        $b = 'Januari';
        break;
      case 2:
        $b = 'Februari';
        break;
      case 3:
        $b = 'Maret';
        break;
      case 4:
        $b = 'April';
        break;
      case 5:
        $b = 'Mei';
        break;
      case 6:
        $b = 'Juni';
        break;
      case 7:
        $b = 'Juli';
        break;
      case 8:
        $b = 'Agustus';
        break;
      case 9:
        $b = 'September';
        break;
      case 10:
        $b = 'Oktober';
        break;
      case 11:
        $b = 'November';
        break;
      case 12:
        $b = 'Desember';
        break;
    }
    $tanggal_indo = "{$tanggal->format('j')} {$b} {$tanggal->format('Y')}";
    return $tanggal_indo;
  }

  public function tanggal_indo_short($date){
    //dd-mm-yyyy
    $this->tanggal($date);
    $tanggal = $this->_tanggal;
    $n = $tanggal->format('d-m-Y');
    return $n;
  }

  public function umur($tgl_lahir,$tgl_daftar){
    $date1 = new DateTime($tgl_lahir);
    $date2 = new DateTime($tgl_daftar);
    if($date1>=$date2){
        $u = "Tanggal lahir tidak boleh lebih besar dari pendaftaran.";
    } else {
        $interval = $date1->diff($date2);
        $u = $interval->format('%y tahun');
    }
    return $u;
  }

  public function umur_anak($tgl_lahir,$tgl_daftar){
    $date1 = new DateTime($tgl_lahir);
    $date2 = new DateTime($tgl_daftar);
    if($date1>=$date2){
        $u = "Tanggal lahir tidak boleh lebih besar dari pendaftaran.";
    } else {
        $interval = $date1->diff($date2);
        $u = $interval->format('%y tahun %m bulan');
    }
    return $u;
  }

  public function tabletotexts($htmltable, $tag){
    $dom = new DOMDocument;
        $dom->loadHTML($htmltable);
        $cells = $dom->getElementsByTagName($tag);
        $contents = array();
        foreach($cells as $cell)
        {
            $contents[] = $cell->nodeValue;
        }
    return $contents;
  }

public function tabletocontents($htmltable, $tag){ 
  $dom = new DOMDocument();
  $dom->loadHtml($htmltable);
  $x = new DOMXpath($dom);
  $datas = $x->query($tag);
  foreach($datas as $atr){
      $data[] =  $atr->C14N();
  }
  return $data;
}

}