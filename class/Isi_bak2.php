<?php



class Isi
{
  private $_db1 = null;
  private $_db2 = null;
  private 
    $_perkara_id = null,
    $_var_nomor  = null,
    $_var_model  = null;

  public function __construct($perkara_id, $var_nomor, $var_model)
  {
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

  

  public function preDataTeks(){
    $q = $this->_db2->table('data_teks')->where('perkara_id',$this->_perkara_id)->where('var_nomor', $this->_var_nomor);
    $r = $q->first();
    return @$r->DATA;
  }

  public function preDefaultData(){
    $q = $this->_db2->table('master_variabel')->where('var_nomor',$this->_var_nomor);
    $r = $q->first();
    $predefault = @$r->var_default_data;
    return $predefault;
  }

  
  public function getidnew(){
    $predefault = $this->preDefaultData();
    $var = new Variabel;
    @$variabels = $var->getVariabels($predefault);
    @$default   = $predefault;
    foreach ($variabels as $k=>$var){
      $cq = $this->_db2->table('master_variabel')->find($var,'var_nomor');
      $isis = new Isi($this->_perkara_id,$var,$cq->var_model);
      $isi = $isis->preDataTeks();
      $tes = str_replace("#perkara_id#",'ini perkara id', $predefault);
      $tes = str_replace("#{$var}#",trim($isi), $tes);
      //$default .=$k;
      $default = $default.'<br> perkara:'.$isis->_perkara_id.' nomor: '.$isis->_var_nomor.' model: '.$isis->_var_model.'<br><span class="w3-red">'.$tes.'</span>'.'<br><span class="w3-blue">'.$isi.'</span>';
    }    
      
      return $default;
    }

}
