<?php

class DataPihak
{
  private $_db1 = null;
  private $_db2 = null;

  private
    $_pihak1 = "SELECT a.perkara_id,a.pihak_id, '1' AS pihak_ke, a.urutan, a.jenis_pihak_id, a.keterangan, b.* FROM perkara_pihak1 a LEFT JOIN pihak b ON a.pihak_id=b.id WHERE a.perkara_id = ?",
    $_pihak2 = "SELECT a.*,a.perkara_id,a.pihak_id, '2' AS pihak_ke, a.urutan, a.jenis_pihak_id, a.keterangan, a.pangkat, a.nrp, a.jabatan,a.kesatuan,a.ghaib, b.* 
    FROM perkara_pihak2 a LEFT JOIN pihak b ON a.pihak_id=b.id WHERE a.perkara_id = ?",
    $_pihak3 = null, $_pihak4 = null, $_pihak5 = null;

  public $_alur_perkara = null;

  private static $_instance = null;
  private static $_perkara_id = null;


  public function __construct()
  {
    $this->_db1 = \Pixie\DB::getNewDB();
    $this->_db2 = \Pixie\DB2::getNewDB();
  }

  public static function load($perkara_id)
  {
    if (!isset(self::$_instance)) {
      self::$_instance = new DataPihak;
      self::$_perkara_id = $perkara_id;
    }
    return self::$_instance;
  }

  private function perkara()
  {
    $q = $this->_db1->table('perkara')->find(self::$_perkara_id, 'perkara_id');
    return $q;
  }

  public function sebutan_pihak($pihak_ke, $tahapan_id)
  {
    $perkara = $this->perkara();
    $q = $this->_db1->table('status_pihak')->where('alur_perkara_id', $perkara->alur_perkara_id)->where('pihak_ke', $pihak_ke)->where('tahapan_id', $tahapan_id);
    $r = $q->first();
    $this->_alur_perkara = 'gugatan';
    if ($perkara->jenis_perkara_id == 346 || $perkara->jenis_perkara_id == 341) {
      $this->_alur_perkara = 'permohonan';
      if ($pihak_ke == 1) {
        $r->nama = 'Pemohon';
        
      } else if ($pihak_ke == 2) {
        $r->nama = 'Termohon';
      }
    } 
    return $r;
  }

  private function agama($id)
  {
    $q = $this->_db1->table('agama')->find($id);
    return $q->nama;
  }

  private function pendidikan($id)
  {
    $q = $this->_db1->table('tingkat_pendidikan')->find($id);
    return $q->nama;
  }

  public function tabelPendaftaranTemplate($urutan, $nama, $tempat, $tgl_lahir, $umur = null, $nik, $tgl_ktp = null, $agama, $pendidikan, $pekerjaan, $no_hp = null, $alamat, $sebagai = null, $pihak_ke)
  {
    $perkara    = $this->perkara();
    $agama      = $this->agama($agama);
    $pendidikan = $this->pendidikan($pendidikan);
    $fungsi     = new Fungsi;
    $tgl_lahir_indo  = $fungsi->tanggal_indonesia($tgl_lahir);
    $umur       = $fungsi->umur($tgl_lahir, $perkara->tanggal_pendaftaran);
    $sebutan    = $this->sebutan_pihak($pihak_ke, 10);
    $sebagai  = $sebutan->nama;

    $tabel  = "";
    $tabel .= "<tr><td style=\"width: 28px\">{$urutan}</td><td style=\"width: 150px\">Nama</td><td>:</td><td><strong>{$nama}</strong></td></tr>";
    $tabel .= "<tr><td></td><td>Tempat, Tanggal Lahir</td><td>:</td><td>{$tempat}, {$tgl_lahir_indo} (umur {$umur})</td></tr>";    
    if (!empty($nik)) {
      $tabel .= "<tr><td></td><td>No. Identitas</td><td>:</td><td>{$nik}</td></tr>";
    }
    if (!empty($tgl_ktp)) {
      $tabel .= "<tr><td></td><td>Tanggal KTP</td><td>:</td><td>{$tgl_ktp}</td></tr>";
    }
    $tabel .= "<tr><td></td><td>Agama</td><td>:</td><td>{$agama}</td></tr>";
    $tabel .= "<tr><td></td><td>Pendidikan</td><td>:</td><td>{$pendidikan}</td></tr>";
    $tabel .= "<tr><td></td><td>Pekerjaan</td><td>:</td><td>{$pekerjaan}</td></tr>";
    if (!empty($no_hp)) {
      $tabel .= "<tr><td></td><td>Nomor HP</td><td>:</td><td>{$no_hp}</td></tr>";
    }
    $tabel .= "<tr><td></td><td>Alamat</td><td>:</td><td>{$alamat}, sebagai <strong>{$sebagai} {$urutan}</strong>;</td></tr>";

    return $tabel;
  }

  public function getP1()
  {
    $p = $this->_db1->query($this->_pihak1, [self::$_perkara_id])->get();
    return $p;
  }

  public function getP2()
  {
    $p = $this->_db1->query($this->_pihak2, [self::$_perkara_id])->get();
    return $p;
  }

  private function urutanPihak($arr, $urutan)
  {
    $r = '';
    if (count($arr) > 1) {
      $r = $urutan . '.';
    }
    return $r;
  }

  public function getDataPihaks($var_jenis)
  {
    $p1s = $this->getP1();
    $p2s = $this->getP2();
    $perkara = $this->perkara();

    //Pihak Pendaftaran
    if ($var_jenis == "pihak_pendaftaran") {
      $data = "<table class=\"table is-narrow\" style=\"border: 0px;\">";
      foreach ($p1s as $k => $p1) {
        $urutan = $this->urutanPihak($p1s, $p1->urutan);
        $data .= $this->tabelPendaftaranTemplate($urutan, $p1->nama, $p1->tempat_lahir, $p1->tanggal_lahir, $umur = null, $p1->nomor_indentitas, $tgl_ktp = null, $p1->agama_id, $p1->pendidikan_id, $p1->pekerjaan, $p1->telepon, $p1->alamat, $sebagai = null, $p1->pihak_ke);
        $k++;
      }
      $data .= "</table>";
      if ($p2s) {
        $data .= "<p>dengan ini mengajukan {$this->_alur_perkara} {$perkara->jenis_perkara_nama} berlawanan dengan:</p>";
        $data .= "<table class=\"table is-narrow\" style=\"border: 0px;\">";
        foreach ($p2s as $k => $p2) {
          $urutan = $this->urutanPihak($p2s, $p2->urutan);
          $data .= $this->tabelPendaftaranTemplate($p2->urutan . ".", $p2->nama, $p2->tempat_lahir, $p2->tanggal_lahir, $umur = null, $p2->nomor_indentitas, $tgl_ktp = null, $p2->agama_id, $p2->pendidikan_id, $p2->pekerjaan, $p2->telepon, $p2->alamat, $sebagai = null, $p2->pihak_ke);
          $k++;
        }
        $data .= "</table>";
      }
    }

    return $data;
  }
}
