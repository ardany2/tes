<?php

class Isi {
    private $_db1 = null;
    private $_db2 = null;
    private $_perkara_id = null,
            $_var_nomor = null, 
            $_var_model= null;
    
    private static $_instance = null;

    public function setParam($perkara_id, $var_nomor, $var_model){
      $this->_perkara_id = $perkara_id;
      $this->_var_nomor = $var_nomor;
      $this->_var_model = $var_model;  
    }

   

  public function __construct($perkara_id, $var_nomor, $var_model){
    $this->_perkara_id = $perkara_id;
    $this->_var_nomor = $var_nomor;
    $this->_var_model = $var_model;
    $this->_db1 = \Pixie\DB::getNewDB();
    $this->_db2 = \Pixie\DB2::getNewDB();
    
  } 

 public function getid(){
      $tes = 'var perkara:'.$this->_perkara_id.' var nomor: '.$this->_var_nomor.' var model: '.$this->_var_model;
      return $tes;
    }
 
 /*  public static function getInstance($perkara_id, $var_nomor, $var_model){   
    if(!isset(self::$_instance)) {          
      self::$_instance = new Isi($perkara_id, $var_nomor, $var_model);
      //$this->_perkara_id = $perkara_id;
    }
    return self::$_instance;
  } */


  private function getDataTeks(){
    $q = $this->_db2->table('data_teks')->where('perkara_id',$this->_perkara_id)->where('var_nomor', $this->_var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

  //Belum dibuat tabelnya
  private function getDataAngka($var_nomor = null){
    $q = $this->_db2->table('data_angka')->where('perkara_id',$this->_perkara_id)->where('var_nomor', $var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

  //Belum dibuat tabelnya
  private function getDataTanggal($var_nomor = null){
    $q = $this->_db2->table('data_tanggal')->where('perkara_id',$this->_perkara_id)->where('var_nomor', $var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

  //Belum dibuat tabelnya
  //Parameter: id,jenis_perkara_id,judul,urutan
  private function getDataPihaks($var_nomor = null){
    $q = $this->_db2->table('data_pihak')->where('perkara_id',$this->_perkara_id)->where('var_nomor', $var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

  //Belum dibuat tabelnya
  //Parameter: id,jenis_perkara_id,judul,urutan
  private function getDataPosita($var_nomor = null){
    $q = $this->_db2->table('data_posita')->where('perkara_id',$this->_perkara_id)->where('var_nomor', $var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

  //Belum dibuat tabelnya
  //Parameter: sidang_id, pihak_saksi
  private function getDataTanyaJawab($var_nomor = null){
    $q = $this->_db2->table('data_tanyajawab')->where('perkara_id',$this->_perkara_id)->where('var_nomor', $var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

   //Belum dibuat tabelnya
   private function getDataAmar($var_nomor = null){
    $q = $this->_db2->table('data_posita')->where('perkara_id',$this->_perkara_id)->where('var_nomor', $var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

  public function preSqlData(){
    $q = $this->_db2->table('master_variabel')->where('var_nomor',$this->_var_nomor);
    $r = $q->first();    
    return $r->var_sql_data;
  }

 
  public function getSqlData($content){
    $variabel = new Variabel;
    $vars = $variabel->getVariabels($content);
    foreach($vars as $var){
      $isi = Isi::getInstance();
      $cq = $isi->_db2->table('master_variabel')->find($var,'var_nomor');      
      $isi->setParam($this->_perkara_id,$var,@$cq->var_model);      
      $data = $isi->preData();      
      $datanya = str_replace("#perkara_id#",$this->_perkara_id,$content);
      $datanya = str_replace("#{$var}#","'{$data}'",$datanya);      
    }
    $cr = $this->_db1->query($datanya)->get();
    return @$cr[0]->DATA;
  }  

  
  public function preDefaultData(){
    $q = $this->_db2->table('master_variabel')->where('var_nomor',$this->_var_nomor);
    $r = $q->first();
    $predefault = @$r->var_default_data;
    return $predefault;
  }
  
  //Mau tak tambahkan fungsi if default model datanya ambil di db masternya.
  public function getDataDefault(){    
    $predefault = $this->preDefaultData();
    $var = new Variabel;
    @$variabels = $var->getVariabels($predefault);
    @$default   = $predefault;
    foreach ($variabels as $k=>$var){
      $cq = $this->_db2->table('master_variabel')->find($var,'var_nomor');
      $isis = Isi::getInstance();
      $isis->setParam($this->_perkara_id,$var,$cq->var_model);
      @$data = $isis->preData();      
      $default = str_replace("#{$var}#",trim($data),$default);
    }    
    return $default;
  }

  public function repData(){
      $perkara_id = $this->_perkara_id;  
      $isis = Isi::getInstance();
      $content = $isis->preDefaultData();            
      $variabel = new Variabel;
      $vars     = $variabel->getVariabels($content);
      foreach($vars as $var){      
               
        $cq = $isis->_db2->table('master_variabel')->find($var,'var_nomor');
        $model = $cq->var_model;
        //$isis->setParam($perkara_id,$var,$model);
        if ($cq->var_model = 'text'){           
          $data = str_replace("#perkara_id#",$perkara_id,$content);
          $data = str_replace("#{$var}#","'{$content}'",$data);
          $data = $cq->var_model.$var;          
        } else if($isis->_var_model = 'sql'){
          $contentsql = $isis->preSqlData();           
          $predata = str_replace("#perkara_id#",$perkara_id,$contentsql);
          $predata = str_replace("#{$var}#","' {$contentsql} '",$predata);
          //$cr = $isis->_db1->query($predata)->get();
          //$data=$cr[0]->DATA;
          $data = 'data sql';
        } else if($isis->_var_model = 'pilihan'){
          $data = 'data pilihan';

        }
        else {
          $data = "Model {$model} belum didefinisikan.";
        }
      }
      return $data;
  }

  
  
  public function preData(){     
    if ($this->_var_model =='text'){
      $predata = $this->getDataTeks();
    } else if($this->_var_model=='sql'){      
      $predata = $this->preSqlData();      
    } else if($this->_var_model=='pilihan'){
      $predata = 'pilihan';
    } else {
      $predata = 'lain-lain';
    }
    return $predata;
  }

  public function data(){    
    $predata = $this->preData(); 
    if ($predata==null){
      $predata = $this->repData();      
      $data = "<td id=\"form-{$this->_var_nomor}\" contenteditable=\"true\" class=\"w3-border w3-green w3-padding-small\"> {$predata} </td>";
    } else {
      $model = $this->_var_model;
      //if ($model =='text'){
      $data = "<td id=\"form-{$this->_var_nomor}\" contenteditable=\"true\" class=\"w3-border w3-black w3-padding-small\"> {$predata} {$model} {$this->_var_nomor}</td>";
      /* } else
      if ($model =='sql'){
        @$repdata = $this->getSqlData($predata);
        $data = "<td id=\"form-{$this->_var_nomor}\" class=\"w3-border w3-blue w3-padding-small\">{$repdata}</td>";
        } else
      if ($model =='pilihan'){
        $data = "<td id=\"form-{$this->_var_nomor}\" class=\"w3-border w3-red w3-padding-small\">{$predata}</td>";
        }
       */
      
    }
     
    
    return $data;
  }

  /* public function data(){
    
    $data = '';
    if ($this->preData()==null || $this->preData()=='' || $this->preData()=== false){
      $predata = $this->getDataDefault();
      $data = "<td id=\"form-{$this->_var_nomor}\" contenteditable=\"true\" class=\"w3-border w3-blue w3-padding-small\"> {$predata} </td>";
    } else {
      $predata = $this->preData();
      if ($this->_var_model =='text'){
        $data = "<td id=\"form-{$this->_var_nomor}\" contenteditable=\"true\" class=\"w3-border w3-padding-small\"> {$predata} </td>";
      } else if($this->_var_model=='sql'){
        $predata = $this->getDataSql();
        $data = "<td id=\"form-{$this->_var_nomor}\" class=\"w3-padding-small\"> {$predata} </td>";
      } else if($this->_var_model=='pilihan'){
        $predata = 'pilihan';
        $data = "<td id=\"form-{$this->_var_nomor}\" contenteditable=\"true\" class=\"w3-border w3-padding-small\"> {$predata} </td>";
      }

    }
    return $data;
  } */



}