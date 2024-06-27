<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
class Tools extends Authcontroller { //testpurpose

	function __construct() 
    {
		parent::__construct();
    }

	function index() 
    {	
        $juml_data          = 0;
        $datasrc            = $this->_getDataSource();
        $lastno_arr         = array();
        for($a=0; $a<count($datasrc); $a++) {
            $id             = $datasrc[$a]['id'];
            $jenisbarang    = $datasrc[$a]['jenis_barang'];
            $merk           = $datasrc[$a]['merk_model'];
            $ukuran         = $datasrc[$a]['ukuran'];
            $bahan          = $datasrc[$a]['bahan'];
            $tahunpengadaan = $datasrc[$a]['tahunpengadaan'];
            $nomorkode      = $datasrc[$a]['nomor_kode'];
            $jumlah         = $datasrc[$a]['jumlah'];
            $keadaanbarang  = $datasrc[$a]['keadaan_barang'];
            $keterangan     = $datasrc[$a]['keterangan'];
            $lokasi         = $datasrc[$a]['lokasi'];
            $nama           = $datasrc[$a]['nama'];
            $prekode        = $datasrc[$a]['prekode'];
            //nama, jenis_barang, merk_model, keterangan 
            $keteranganSi   = $nama."\n".$jenisbarang."\n".$merk."\n".$keterangan;

            $prekode_arr        = explode('.',$prekode);
            $tahunpengadaan_arr = explode('-',$tahunpengadaan);            
            
            $katid          = $prekode_arr[1];
            $tglpr          = $tahunpengadaan;
            $golid          = $prekode_arr[0];
            $arrindex       = $golid.$katid.$tahunpengadaan_arr['0'];

            for($b=0; $b<$jumlah; $b++) {
                $last_urutan    = isset($lastno_arr[$arrindex])?$lastno_arr[$arrindex]:0;
                $nourut_str     = '00000'.($last_urutan+1);
                $nourut_str     = substr($nourut_str,-5,5);
                $assetno        = $golid.'.'.$katid.'.'.$tahunpengadaan_arr['0'].'-'.$nourut_str;                

                $datamaster	= array(
                    'GolID'			=> $golid,
                    'KatID'			=> $katid,
                    'AssetNo'		=> $assetno,
                    'UserID'		=> '1',
                    'TglPr'			=> $tglpr,
                    'Lokasi'        => $lokasi,
                    'Nama'          => $nama,
                    'NoKode'        => $nomorkode
                );
                $this->db->insert('itemmaster', $datamaster);
                $itemid		= $this->_getLastInsertID();
                $juml_data++;
                
                if($golid=='03') {
                    $datadetail	= array(
                        'ItemID'				=> $itemid,
                        'AssetOrder'			=> $nourut_str,
                        'JenisPerlengPeralatKatID'	=> null,//to be edit
                        'JenisID'				=> null,//to be edit
                        'NoDokumenPr'			=> '',
                        'NilaiPr'				=> 0,
                        'PenyusutanPs'			=> 0,
                        'LokasiIDPs'			=> 1,
                        'DivisionIDPs'			=> null,//to be edit
                        'LantaiPs'				=> '',//to be edit
                        'RuanganPs'				=> '',
                        'PenanggungJawabSi'		=> 'Divisi Umum dan SDM',
                        'KondisiKodeSi'			=> $keadaanbarang,
                        'HargaSi'				=> 0,
                        'KeteranganSi'			=> $keteranganSi
                    );
                    $this->db->insert('itemperlengperalatdetail', $datadetail);
                } else {
                    $datadetail	= array(
                        'ItemID'				=> $itemid,
                        'AssetOrder'			=> $nourut_str,
                        'JenisElkmesinKatID'	=> null,//to be edit
                        'JenisID'				=> null,//to be edit
                        'NoDokumenPr'			=> '',
                        'NilaiPr'				=> 0,
                        'PenyusutanPr'			=> 0,
                        'LokasiIDPr'			=> null,
                        'DivisionIDPs'			=> null,//to be edit
                        'PenanggungJawabPs'		=> 'Divisi Umum dan SDM',
                        'KondisiKodeSi'			=> $keadaanbarang,
                        'HargaSi'				=> 0,
                        'KeteranganSi'			=> $keteranganSi,
                        'PicLocationSi'			=> ''
                    );
                    $this->db->insert('itemelkmesindetail', $datadetail);
                }
                $lastno_arr[$arrindex]  = $last_urutan+1;                
            }
        
        }
        echo 'Edit ==>'.$juml_data;	
        // $data['datasrc']    = $datasrc;
        // $this->load->view('_test/index_tools',$data);
	}

    function _getDataSource()
    {
        $sql = "SELECT 
                    id, jenis_barang, merk_model, ukuran, 
                    bahan, tahunpengadaan, nomor_kode, jumlah, 
                    keadaan_barang, keterangan, lokasi, nama, prekode
                FROM asetdivisi_detail WHERE prekode !=''";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
    }

    function _getLastInsertID()
	{
		$sql	= "SELECT LAST_INSERT_ID() AS lii";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result[0]['lii'];
	}
		
	function goex() 
    {
        $this->_tanah();
        // $this->_gdBang();
        // $this->_perlengLat();
        // $this->_elmes();
        // $this->_kendaraan();
    }
    //------------------------------05. Kendaraan----
    function _kendaraan()
    {
        //-- Elmes
        $dataKend           = $this->_getDataKendaraan();
        $dataupdated        = 0;
        $this->db->update('itemkendaraandetail', array('AssetOrder'=> '00000'));
        foreach ($dataKend as $kend) 
        {
            $itemid     = $kend['ItemID'];
            $katid      = $kend['KatID'];
            $thnpr      = substr($kend['TglPr'], 0, 4);;

            $assetorder	= $this->_getLastAsetOrderPlusOneV3_kend($katid, $thnpr);
            $assetno	= '05.'.$katid.'.'.$thnpr.'-'.$assetorder;

            
            $this->db->update('itemmaster', array('AssetNo'=> $assetno), array('ItemID'	=> $itemid));
            $this->db->update('itemkendaraandetail', array('AssetOrder'=> $assetorder), array('ItemID'	=> $itemid));
            $dataupdated++;
        }
        echo 'Kendaraan '.$dataupdated."\n<br />";
        
    }

    function _getDataKendaraan()
    {
        $sql = "SELECT 
                    m.ItemID, m.KatID, m.AssetNo, m.TglPr, d.AssetOrder
                FROM
                    itemmaster m, itemkendaraandetail d
                WHERE
                    m.ItemID=d.ItemID AND m.GolID='05'
                ORDER BY m.ItemID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
    }

    function _getLastAsetOrderPlusOneV3_kend($katid, $thnpr)
    {
        $sql	= "SELECT LPAD(d.AssetOrder+1, 5, 0) AS AO 
					FROM itemkendaraandetail d, itemmaster i 
					WHERE i.ItemID=d.ItemID AND i.KatID='$katid' AND YEAR(i.TglPr)='$thnpr'
					ORDER BY d.AssetOrder DESC
					LIMIT 1";
		$query	= $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['AO'])?$result[0]['AO']:'00001';
		return $retval;
    }
    //------------------------------04. Elmes----
    function _elmes()
    {
        //-- Elmes
        $dataElmes           = $this->_getDataElmes();
        $dataupdated        = 0;
        $this->db->update('itemelkmesindetail', array('AssetOrder'=> '00000'));
        foreach ($dataElmes as $elmes) 
        {
            $itemid     = $elmes['ItemID'];
            $katid      = $elmes['KatID'];
            $thnpr      = substr($elmes['TglPr'], 0, 4);;

            $assetorder	= $this->_getLastAsetOrderPlusOneV3_elmes($katid, $thnpr);
            $assetno	= '04.'.$katid.'.'.$thnpr.'-'.$assetorder;

            
            $this->db->update('itemmaster', array('AssetNo'=> $assetno), array('ItemID'	=> $itemid));
            $this->db->update('itemelkmesindetail', array('AssetOrder'=> $assetorder), array('ItemID'	=> $itemid));
            $dataupdated++;
        }
        echo 'Elmes '.$dataupdated."\n<br />";
    }

    function _getDataElmes()
    {
        $sql = "SELECT 
                    m.ItemID, m.KatID, m.AssetNo, m.TglPr, d.AssetOrder
                FROM
                    itemmaster m, itemelkmesindetail d
                WHERE
                    m.ItemID=d.ItemID AND m.GolID='04'
                ORDER BY m.ItemID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
    }

    function _getLastAsetOrderPlusOneV3_elmes($katid, $thnpr)
    {
        $sql	= "SELECT LPAD(d.AssetOrder+1, 5, 0) AS AO 
					FROM itemelkmesindetail d, itemmaster i 
					WHERE i.ItemID=d.ItemID AND i.KatID='$katid' AND YEAR(i.TglPr)='$thnpr'
					ORDER BY d.AssetOrder DESC
					LIMIT 1";
		$query	= $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['AO'])?$result[0]['AO']:'00001';
		return $retval;
    }
    //------------------------------03.Perlengkapan Peralatan----
    function _perlengLat()
    {
        //-- Perlengkapan Peralatan
        $dataPerlengLat     = $this->_getDataPerlengLat();
        $dataupdated        = 0;
        $this->db->update('itemperlengperalatdetail', array('AssetOrder'=> '00000'));
        foreach ($dataPerlengLat as $perlengLat) 
        {
            $itemid     = $perlengLat['ItemID'];
            $katid      = $perlengLat['KatID'];
            $thnpr      = substr($perlengLat['TglPr'], 0, 4);;

            $assetorder	= $this->_getLastAsetOrderPlusOneV3_perlenglat($katid, $thnpr);
            $assetno	= '03.'.$katid.'.'.$thnpr.'-'.$assetorder;


            $this->db->update('itemmaster', array('AssetNo'=> $assetno), array('ItemID'	=> $itemid));
            $this->db->update('itemperlengperalatdetail', array('AssetOrder'=> $assetorder), array('ItemID'	=> $itemid));
            $dataupdated++;
        }
        echo 'Perlengkapan peralatan '.$dataupdated."\n<br />";
    }

    function _getDataPerlengLat()
    {
        $sql = "SELECT 
                    m.ItemID, m.KatID, m.AssetNo, m.TglPr, d.AssetOrder
                FROM
                    itemmaster m, itemperlengperalatdetail d
                WHERE
                    m.ItemID=d.ItemID AND m.GolID='03'
                ORDER BY m.ItemID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
    }

    function _getLastAsetOrderPlusOneV3_perlenglat($katid, $thnpr)
    {
        $sql	= "SELECT LPAD(d.AssetOrder+1, 5, 0) AS AO 
					FROM itemperlengperalatdetail d, itemmaster i 
					WHERE i.ItemID=d.ItemID AND i.KatID='$katid' AND YEAR(i.TglPr)='$thnpr'
					ORDER BY d.AssetOrder DESC
					LIMIT 1";
		$query	= $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['AO'])?$result[0]['AO']:'00001';
		return $retval;
    }
    //------------------------------02.Gd.Bangunan----
    function _gdBang()
    {
        //-- Gedung BangunAN
        $dataGdBang         = $this->_getDataGdBang();
        $dataupdated        = 0;
        $this->db->update('itemgdgbangdetail', array('AssetOrder'=> '00000'));
        foreach ($dataGdBang as $gdBang) 
        {
            $itemid     = $gdBang['ItemID'];
            $katid      = $gdBang['KatID'];
            $thnpr      = substr($gdBang['TglPr'], 0, 4);;

            $assetorder	= $this->_getLastAsetOrderPlusOneV3_gdbang($katid, $thnpr);
            $assetno	= '02.'.$katid.'.'.$thnpr.'-'.$assetorder;


            $this->db->update('itemmaster', array('AssetNo'=> $assetno), array('ItemID'	=> $itemid));
            $this->db->update('itemgdgbangdetail', array('AssetOrder'=> $assetorder), array('ItemID'	=> $itemid));
            $dataupdated++;
        }
        echo 'Gd Bangunan '.$dataupdated."\n<br />";
    }

    function _getDataGdBang()
    {
        $sql = "SELECT 
                    m.ItemID, m.KatID, m.AssetNo, m.TglPr, d.AssetOrder
                FROM
                    itemmaster m, itemgdgbangdetail d
                WHERE
                    m.ItemID=d.ItemID AND m.GolID='02'
                ORDER BY m.ItemID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
    }

    function _getLastAsetOrderPlusOneV3_gdbang($katid, $thnpr)
    {
        $sql	= "SELECT LPAD(d.AssetOrder+1, 5, 0) AS AO 
					FROM itemgdgbangdetail d, itemmaster i 
					WHERE i.ItemID=d.ItemID AND i.KatID='$katid' AND YEAR(i.TglPr)='$thnpr'
					ORDER BY d.AssetOrder DESC
					LIMIT 1";
		$query	= $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['AO'])?$result[0]['AO']:'00001';
		return $retval;
    }
//-----------------------------------01.Tanah----
    function _tanah()
    {
        //-- Tanah
        $dataTanah          = $this->_getDataTanah();
        $dataupdated        = 0;
        $this->db->update('itemtanahdetail', array('AssetOrder'=> '00000'));
        foreach ($dataTanah as $tanah) 
        {
            $itemid     = $tanah['ItemID'];
            $katid      = $tanah['KatID'];
            $thnpr      = substr($tanah['TglPr'], 0, 4);;

            // $assetorder	= $this->_getLastAsetOrderPlusOneV2($katid, $jenisid);
            $assetorder	= $this->_getLastAsetOrderPlusOneV3_tanah($katid, $thnpr);
			$assetno	= '01.'.$katid.'.'.$thnpr.'-'.$assetorder;

            $this->db->update('itemmaster', array('AssetNo'=> $assetno), array('ItemID'	=> $itemid));
            $this->db->update('itemtanahdetail', array('AssetOrder'=> $assetorder), array('ItemID'	=> $itemid));
            $dataupdated++;
        }
        echo 'Tanah '.$dataupdated."\n<br />";
    }

    function _getDataTanah()
    {
        $sql = "SELECT 
					m.ItemID, m.KatID, m.AssetNo, m.TglPr, d.AssetOrder, d.JenisDokumenTanahIDPr, d.TglDokumenPr,
					d.NomorDokumenPr, d.LuasPr, d.NilaiPr, d.ApresiasiPr, d.LokasiPs,
					d.LatPs, d.LongPs, d.PenanggungJawabSi, d.StatusIDSi, d.JenisDokumenTanahIDSi, d.NoDokumenSi, 
					d.TglDokumenSi, d.PeruntukanIDSi, d.LuasSi, d.NilaiSi, d.KeteranganSi, d.PicLocationSi
				FROM
					itemmaster m, itemtanahdetail d
				WHERE
					m.ItemID=d.ItemID AND m.GolID='01'
                ORDER BY m.ItemID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
    }

    function _getLastAsetOrderPlusOneV3_tanah($katid, $thnpr)
    {
        $sql	= "SELECT LPAD(d.AssetOrder+1, 5, 0) AS AO 
					FROM itemtanahdetail d, itemmaster i 
					WHERE i.ItemID=d.ItemID AND i.KatID='$katid' AND YEAR(i.TglPr)='$thnpr'
					ORDER BY d.AssetOrder DESC
					LIMIT 1";
		$query	= $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['AO'])?$result[0]['AO']:'00001';
		return $retval;
    }
}
?>