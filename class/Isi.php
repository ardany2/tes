<?php

class Isi {
    private $_db1 = null;
    private $_db2 = null;
    private $_jenis_perkara_id = null;
    private $_var_nomor = null, 
            $_var_model= null;
    
    private static $_instance = null;
    private static $_perkara_id = null;

    
  public function __construct(){
    $this->_db1 = \Pixie\DB::getNewDB();
    $this->_db2 = \Pixie\DB2::getNewDB();
  }  

  private function setPerkara(){
    $perkara = $this->_db1->table('perkara')->find(self::$_perkara_id,'perkara_id');
    $this->_jenis_perkara_id = $perkara->jenis_perkara_id;
  }

  public static function getInstance($perkara_id){   
    if(!isset(self::$_instance)) {          
      self::$_instance = new Isi;
      self::$_perkara_id = $perkara_id;
      self::$_instance->setPerkara();
    }
    return self::$_instance;
  }

  private function getDataTeks($var_nomor = null){
    $q = $this->_db2->table('data_teks')->where('perkara_id',self::$_perkara_id)->where('var_nomor', $var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

  //Belum dibuat tabelnya
  private function getDataAngka($var_nomor = null){
    $q = $this->_db2->table('data_angka')->where('perkara_id',self::$_perkara_id)->where('var_nomor', $var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

  //Belum dibuat tabelnya
  private function getDataTanggal($var_nomor = null){
    $q = $this->_db2->table('data_tanggal')->where('perkara_id',self::$_perkara_id)->where('var_nomor', $var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

  //Belum dibuat tabelnya
  //Parameter: id,jenis_perkara_id,judul,urutan
  private function getDataPihaks(){
    $q = $this->_db1->table('perkara_pihak1')->where('perkara_id',self::$_perkara_id)->get();    
    $s = json_encode(@$q);
    $t = json_decode($s, true);
    $u='';
    foreach ($t as $k=>$v){
      $u .= $v; 
    }
    return $u;
  }

  //Belum dibuat tabelnya
  //Parameter: id,jenis_perkara_id,judul,urutan
  private function getDataPosita($var_nomor = null){
    $q = $this->_db2->table('data_posita')->where('perkara_id',self::$_perkara_id)->where('var_nomor', $var_nomor);
    $r = $q->first();

    return @$r->DATA;
  }

  //Belum dibuat tabelnya
  //Parameter: sidang_id, pihak_saksi
  private function getDataTanyaJawab($var_nomor = null){
    $q = $this->_db2->table('data_tanyajawab')->where('perkara_id',self::$_perkara_id)->where('var_nomor', $var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

   //Belum dibuat tabelnya
   private function getDataAmar($var_nomor = null){
    $q = $this->_db2->table('data_posita')->where('perkara_id',self::$_perkara_id)->where('var_nomor', $var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

  private function getDataSql($var_nomor, $sidang_id){
    $q = $this->_db2->table('master_variabel')->where('var_nomor',$var_nomor);
    $r = $q->first();
    $var = new Variabel;
    $variabel = $var->getVariabels($r->var_sql_data);
    $datanya = $r->var_sql_data;
    foreach ($variabel as $k=>$var){
      $cq = $this->_db2->table('master_variabel')->find($var,'var_nomor');
      $isi = Isi::getInstance(self::$_perkara_id);
      @$data = $isi->preData($var, $cq->var_model, null, null, $sidang_id);
      $datanya = str_replace("#id_sidang#",$sidang_id,$datanya);
      $datanya = str_replace("#sidang_id#",$sidang_id,$datanya);
      $datanya = str_replace("#perkara_id#",self::$_perkara_id,$datanya);
      $datanya = str_replace("#{$var}#","'{$data}'",$datanya);
    }
    $cr = $this->_db1->query($datanya)->get();
    if ($cr){
      $data = @$cr[0]->DATA;
    } 
    else {
      $data = '';
    }
    return $data;
  }

  private function getDataSIPP($var_nomor){
    $q = $this->_db2->table('master_variabel')->where('var_nomor',$var_nomor);
    $r = $q->first();
    $field = trim($r->var_field);

    $cq = $this->_db1->table(trim($r->var_tabel))->where('perkara_id',self::$_perkara_id);//->where('urutan', $r->var_urutan);
    $cr = $cq->first();
    return $cr->$field;
  }

  //Mau tak tambahkan fungsi if default datanya dari master.
  private function preDefaultData($var_nomor, $var_model){
    $q = $this->_db2->table('master_variabel')->find($var_nomor,'var_nomor');    
    $predefault = $q->var_default_data;
    $judul_id = $q->var_referensi;
    if($var_model == 10){
      $r = $this->_db2->table('template_posita')->where('judul_id',$judul_id)->where('jenis_perkara_id', $this->_jenis_perkara_id);
      $s = $r->first();       
      $predefault = "Ini data posita {$this->_jenis_perkara_id} {$judul_id} {$s->posita}";
    }
    return $predefault;
  }

  private function getDataDefault($var_nomor, $sidang_id, $var_model){    
    $predefault = $this->preDefaultData($var_nomor, $var_model);
    $var = new Variabel;
    @$variabels = $var->getVariabels($predefault);
    @$default   = $predefault;
    foreach ($variabels as $k=>$var){
      $cq = $this->_db2->table('master_variabel')->find($var,'var_nomor');
      $isi = Isi::getInstance(self::$_perkara_id);
      @$predata = $isi->preData($var, $cq->var_model, null, null, $sidang_id);
      if($predata || !empty($predata)){
        $data = $predata;
      } else {$data = "[$var]";}          
      $default = str_replace("#{$var}#",trim($data),$default);
    }    
    return $default;
  }


  //var_jenis = pilihan
  //Untuk data teks dengan jenis pilihan.
  //Jika isi kosong mengembalikan defaul data pilihan.
  


  private function preData($var_nomor, $var_model, $var_fungsi = null, $var_jenis = null, $sidang_id)
  {
    $f = new Fungsi;
    $predata = 'oo';
    if ($var_model == 1) { //Data SQL
      $hasil = $this->getDataSql($var_nomor, $sidang_id);
      $predata = $hasil;
      
      if ($hasil && $var_fungsi == 'tanggal_indonesia') {
        $predata = $f->tanggal_indonesia($hasil);
      }
      /* if ($hasil == null){
        $predata = "[{$var_nomor}]";
      } */
    } else if ($var_model == 2) { //Data SIPP
      $hasil = $this->getDataSIPP($var_nomor);
      $predata = $hasil;
      if ($var_fungsi == 'tanggal_indonesia') {
        $predata = $f->tanggal_indonesia($hasil);
      }
    } else if ($var_model == 3) { //Data Teks
      $predata = $this->getDataTeks($var_nomor);
    } else if ($var_model == 4) { //Data Tanggal      
      $tanggal = $this->getDataTanggal($var_nomor);
      if($tanggal){        
      $predata = $f->tanggal_indo_short($tanggal);
      if ($var_fungsi == 'tanggal_indonesia') {
        $predata = $f->tanggal_indonesia($tanggal);
      }} else {$predata = '';} 
    } else if ($var_model == 10) { //Data Posita
      $predata = $this->getDataPosita($var_nomor);
    }else if ($var_model == 13) { //Data Angka
      $predata = $this->getDataAngka($var_nomor);
    }
    return $predata;
  }

  //Tipe Data
/* id	nama	value
0	  pilih tipe data -	\N
1	  Query MySql	data_sql
2	  Data SIPP	data_sipp
3	  Data Teks	data_teks
4	  Data Tanggal	data_tanggal
5	  Hari Tanggal	tanggal_hari
6	  Hijriah Tanggal	tanggal_hijriah
7	  Terbilang	terbilang
8	  Multi Sidang	multi_sidang
9	  Tanya Jawab	tanya_jawab
10	Posita	data_posita
11	Data Pihak	data_pihak
12	Data Html	data_html
13	Data Angka	data_angka
14	Data Petitum	data_petitum
15	Data Amar	data_amar */

  private function pilihan($predata, $var_nomor, $var_model, $var_jenis){
    $str = preg_replace("/\r\n|\r|\n/", '<br/>', $predata);
    $explode = explode('<br/>',$str);
    $hasil = "<td class=\"px-0\" ><div id=\"{$var_nomor}\" class=\"select is-danger\"><select onChange=\"old_val(oldv=''), post_data(form_data=$(this).val(),var_nomor='{$var_nomor}',var_model='{$var_model}',var_jenis='data_teks')\">";
    $hasil .= "<option>Pilih</option>";    
    foreach ($explode as $v){      
      $hasil .= "<option value=\"{$v}\">{$v}</option>";
    }
    $hasil .= "</select></div></td>";
    return $hasil;    
  }

  public function data($var_nomor, $var_model = null, $var_fungsi = null, $var_jenis = null, $sidang_id){    
    $data = '<td class=\"tes\">Mbuh. Ofdasra ruh.</td>';
    $predata = $this->preData($var_nomor, $var_model, $var_fungsi, $var_jenis, $sidang_id);
    $default = $this->getDataDefault($var_nomor, $sidang_id, $var_model);
    $f = new Fungsi; 
    
    switch ($var_model) {
      case 4:
        $js = "";
        break;
      case 10:
        $js = "onFocus=\"old_val(oldv=$(this).html().trim())\" onBlur=\"post_data(form_data=$(this).html().trim(),var_nomor='{$var_nomor}',var_model='{$var_model}',var_jenis='{$var_jenis}')\"";
        break;
      case 13:
        $js = "onFocus=\"old_val(oldv=$(this).inputmask('unmaskedvalue'))\" onBlur=\"post_data(form_data=$(this).inputmask('unmaskedvalue'),var_nomor='{$var_nomor}',var_model='{$var_model}',var_jenis='{$var_jenis}')\"";        
        $js2 = ""; 
        break;

    }
    if ($predata==''){
      //Jika data isi bernilai kosongan.
      if ($var_model == 1) {
        //Data dari query sql. 
        $data = "<td style='background: red;'>Isi data di SIPP atau variabel tertentu.</td>";
      }
       
      if ($var_model == 3) {
        //Data Text.
        $data = "<td>Semoga taimu atos.</td>";

        if ($var_jenis == 'pilihan') {
          $data = $this->pilihan($default, $var_nomor, $var_model, $var_jenis);
        }
        if ($var_jenis == 'textarea') {
          $data = "
        <td class=\"px-0\" style=\"border-color: red; background-color: white;\">
        <textarea id=\"{$var_nomor}\" >{$default}</textarea>
          <div id=\"form-{$var_nomor}\" class=\"isi content px-2 pb-2\" contenteditable=\"true\" onFocus=\"inline('{$var_nomor}')\" onBlur=\"post_data(form_data=$(this).html().trim(),var_nomor='{$var_nomor}',var_model='{$var_model}',var_jenis='{$var_jenis}')\">{$default}</div>
        </td>";
        }
        if ($var_jenis == 'text') {
          $data = "
        <td class=\"px-0\">
        <input id=\"{$var_nomor}\" class=\"input is-normal is-danger px-2\" type='text' value='{$default}' onFocus=\"old_val(oldv=$(this).val())\" onBlur=\"post_data(form_data=$(this).val(),var_nomor='{$var_nomor}',var_model='{$var_model}',var_jenis='{$var_jenis}')\">        
        </td>";
        }
      }

      if ($var_model == 4) { 
        //Data Tanggal        
        $tanggal = $this->getDataTanggal($var_nomor);
               
        $tanggal_indo_short = $f->tanggal_indo_short($tanggal);
        $data = "<td class=\"px-0\"><input id=\"{$var_nomor}\" type='text' value='{$default}' hidden>
        <span id=\"tanggal-{$var_nomor}\" class=\"input is-normal is-danger\" contenteditable=\"true\" onFocus=\"old_val(oldv=$(this).text().trim()), data_tanggal(var_nomor='{$var_nomor}',tanggal='{$tanggal_indo_short}')\" onBlur=\"post_data(form_data=$(this).text().trim(),var_nomor='{$var_nomor}',var_model='{$var_model}',var_jenis='{$var_jenis}')\">{$default}</span>
        </td>";}
      
        if ($var_model == 10) {
          //Data Posita
          $data = "
          <td class=\"px-0\" style=\"border-color: red; background-color: white;\">
          <textarea id=\"{$var_nomor}\" >{$default}</textarea>
          <div id=\"form-{$var_nomor}\" class=\"px-2 pb-2\" contenteditable=\"true\" {$js}>{$default}</div>
          <div class=\"content\">
          <ol type=\"1\">";
          $ps = preg_split('#<td([^>])*>#',$default);
          foreach ($ps as $v){
            $data .= "<li>{$v}</li>";
          }
          $data .= "
            
              <li>Coffee</li>
              <li>Tea</li>
              <ol type=\"a\">
              <li>Coffee</li>
              <li>Tea</li>
              <li>Milk</li>
            </ol>
              <li>Milk</li>
            </ol>
            
          </div>
          </td>";
          }

      if ($var_model == 13) {
      //Data Angka
       $data = "
      <td class=\"px-0\">
      
      <input id=\"{$var_nomor}\" class=\"{$var_fungsi} input is-normal is-danger px-2\" type='text' value='{$default}' onFocus=\"old_val(oldv=$(this).inputmask('unmaskedvalue'))\" onBlur=\"post_data(form_data=$(this).inputmask('unmaskedvalue'),var_nomor='{$var_nomor}',var_model='{$var_model}',var_jenis='{$var_jenis}')\">      
      </td>";
      }

    } else {

      //Jika data isi berisi nilai.
      if ($var_model == 1) {
        //Data dari query sql.        
        $data = "<td id=\"form-{$var_nomor}\" class=\"w3-padding-small w3-green\">{$predata}</td>";
        if(empty($predata) || !$predata || $predata == null){
          $data = "<td>Semoga taimu atos.</td>";
        }
      } else if ($var_model == 2) {
        //Data dari SIPP.        
        $data = "<td id=\"form-{$var_nomor}\" class=\"w3-padding-small w3-blue\">{$predata}</td>";
      } else if ($var_model == 3) { 
        //Data Teks        
        if ($var_jenis == 'text' || $var_jenis == 'pilihan') {
          $data = "
          <td class=\"px-0\" style=\"border-color: #00d1b2; background-color: white;\">
          <input id=\"{$var_nomor}\" class=\"input is-normal is-primary px-2\" type='text' value='{$predata}' onFocus=\"old_val(oldv=$(this).val())\" onBlur=\"post_data(form_data= $(this).val(),var_nomor='{$var_nomor}',var_model='{$var_model}',var_jenis='{$var_jenis}')\"></td>";        
        } else if ($var_jenis == 'textarea') {
          $data = "<td class=\"px-0\" style=\"border-color: #00d1b2; background-color: white;\">
          <textarea id=\"{$var_nomor}\" >{$predata}</textarea>
          <div id=\"form-{$var_nomor}\" class=\"isi content px-2 pb-2\" contenteditable=\"true\" onFocus=\"inline('{$var_nomor}',old_val(oldv=$(this).text()))\" onBlur=\"post_data(form_data=$(this).html().trim(),var_nomor='{$var_nomor}',var_model='{$var_model}',var_jenis='{$var_jenis}')\">{$predata}</div>
          </td>"; 
        }else if ($var_jenis == 'tanggal') {
          //Data Teks jenis Tanggal untuk variabel lama dari matoh. Kedepannya tidak terpakai.
          $data = "<td id=\"form-{$var_nomor}\" >Tanggalan {$predata}</td>";
        } else {
          $data = "<td id=\"form-{$var_nomor}\" >ini ada isinya</td>";
        }
      } else if ($var_model == 4) { 
        //Data Tanggal        
        $tanggal = $this->getDataTanggal($var_nomor);
        $f = new Fungsi;        
        $tanggal_indo_short = $f->tanggal_indo_short($tanggal);
        $data = "<td lang=\"id\"><input id=\"{$var_nomor}\" type='text' value='{$predata}' hidden>       
 
        <span id=\"tanggal-{$var_nomor}\" class=\"input is-normal is-primary\" contenteditable=\"true\" onFocus=\"old_val(oldv=$(this).text().trim()), data_tanggal(var_nomor='{$var_nomor}',tanggal='{$tanggal_indo_short}')\" onBlur=\"post_data(form_data=$(this).text().trim(),var_nomor='{$var_nomor}',var_model='{$var_model}',var_jenis='{$var_jenis}')\">{$predata}</span>
        </td>";
      } else if ($var_model == 10) {
        //Data Posita
        $tes = "
        <td class=\"px-0\" style=\"border-color: red; background-color: white;\">
        <textarea id=\"{$var_nomor}\" name=\"{$var_nomor}\" >{$predata}</textarea>
        <div id=\"form-{$var_nomor}\" class=\"px-2 pb-2\" contenteditable=\"true\" {$js}>{$predata}</div>
        <div class=\"content\">";

        $tes .= "<ol type=\"1\"><li>Coffee</li><ol type=\"a\">";        

        $contents = $f->tabletocontents($predata,'//p');
          foreach ($contents as $k => $v){
            if($k % 2 == 0){
              $r = preg_replace('%<p(.*?)>|</p>%s','',$v);
              //$r = preg_replace('#<p(.*?)>(.*?)</p>#is', '$2<br/>', $v);
              $tes .= "<li>{$r}</li>";}            
          }
          $tes .= "
            </ol>
              <li>Milk</li>
            </ol>
            
          </div>
          </td>";
          $data = $tes;
        
      } else if ($var_model == 11) { 
        //Data Pihak
        $pihaks = DataPihak::load(self::$_perkara_id);
        $predat = $pihaks->getDataPihaks($var_jenis);
        $data = "<td id=\"form-{$var_nomor}\">{$predat}</td>";
      } else if ($var_model == 13) {
        //Data Angka
        $data = "
        <td class=\"px-0\">
        
        <input class=\"{$var_fungsi} input is-normal is-primary px-2\" id=\"{$var_nomor}\" name=\"{$var_nomor}\" {$js} type='text' value='{$predata}'>
        
        <input id=\"{$var_nomor}\" class=\"input is-normal is-primary px-2\" type='number' step=\"1\" onkeypress='return event.charCode >= 48 && event.charCode <= 57' min='0' value='{$predata}' onFocus=\"old_val(oldv=$(this).val())\" onBlur=\"post_data(form_data=$(this).val(),var_nomor='{$var_nomor}',var_model='{$var_model}',var_jenis='{$var_jenis}')\">
        
        <input class=\"terbilang input is-normal px-2\" id=\"ter{$var_nomor}\" name=\"ter{$var_nomor}\" {$js2} type='text' value='{$predata}' readonly>
        </td>
        "; 
      } else {        
        $data = "<td class=\"tes\">Mbuh. Ora ruh.</td>";
      }
    }
    return $data;
  }
}