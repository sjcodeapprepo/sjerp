<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class SertKarytrns extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "101");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid, MENU_ID);
		$this->isusermodify = $this->isUserAuthModify($userid, MENU_ID);
	}

	function index()
	{
		$this->load->library('pagination');
		$this->load->helper('text');
		$urisegment	= 6;
		$keyword	= $this->uri->segment($urisegment - 2);
		$keywordurl = $keyword;
		$keywordurl2 = $this->uri->segment($urisegment - 1);

		if (($keyword == '') || ($keyword == 'nokeyword')) {
			$keyword	= '';
			$keywordurl = 'nokeyword';
			$keywordurl2 = 'nokeyword';
		}
		if ($this->input->post('submit') == 'Cari') {
			$keyword    = $this->input->post('optionValue');
			$keywordurl2 = $this->input->post('option');
			if ($keyword == '') {
				$keywordurl = 'nokeyword';
				$keywordurl2 = 'nokeyword';
			} else {
				$keywordurl = $keyword;
			}
		}
		$dataperpage				= 11;
		$config['per_page']         = $dataperpage;
		$config['base_url']         = site_url() . "/hr/sertkarytrns/index/$keywordurl/$keywordurl2/";
		$config['uri_segment']      = $urisegment;
		$config['total_rows']       = $this->_view_data(false, 0, 0, $keyword, $keywordurl2);

		$this->pagination->initialize($config);
		$fromurisegment				= $this->uri->segment($urisegment);
		$data['view_data']			= $this->_view_data(true, $dataperpage, $fromurisegment, $keyword, $keywordurl2);
		$this->load->view('hr/sertkarytrns/sertkarytrns_index', $data);
	}

	function _view_data($isviewdata, $num, $offset, $key, $category)
	{
		if ($offset != '')
			$offset = $offset . ',';

		$sql = "SELECT 
						k.ID AS KaryawanID, k.Nama, k.NIK, k.IsActive, 
						c.ID, c.CertNo, c.ValidYear, c.CertName, c.CertTypeID, c.Notes,
						t.CertTypeName
				FROM karyawanmst k, certkaryawantrn c, certtypemst t
				WHERE k.ID=c.ID_karyawanmst AND c.CertTypeID=t.CertTypeID AND k.IsActive=1";
		if ($key !== '')
			$sql .= " AND $category LIKE '%$key%'";
		if ($isviewdata) {
			$sql .= " ORDER BY ";
			if ($key !== '')
				$sql .= "k.Nama, k.ID, t.CertTypeID, c.ID ";
			else
				$sql .= "c.ID DESC ";
			$sql .= "LIMIT $offset $num";
		}
		//---------------------------------------------------
		$query = $this->db->query($sql);

		if ($isviewdata) {
			$result = $query->result_array();
		} else {
			$result = $query->num_rows();
		}

		return $result;
	}

	function input()
	{
		$this->load->helper('text');
		$id					= null;
		$data['data']		= $this->_getData($id);
		$data['certypemst']	= $this->_getCertTypemst();
		$data['urlsegment']	= $this->uri->uri_string();
		$this->load->view('hr/sertkarytrns/sertkarytrns_input', $data);
	}

	function _getData($id)
	{
		$datakosong	= array(
			'ID'			=> null,
			'KaryawanID'	=> '',
			'Nama'			=> '',
			'NIK'			=> '',
			'CertNo'		=> '',
			'CertName'		=> '',
			'ValidYear'		=> '',
			'CertTypeID'	=> '0',
			'Notes'			=> ''
		);

		$sql = "SELECT k.ID AS KaryawanID, k.Nama, k.NIK, k.IsActive, 
						c.ID, c.CertNo, c.ValidYear, c.CertName, c.CertTypeID, c.Notes, c.FileLocation,
						t.CertTypeName
				FROM karyawanmst k, certkaryawantrn c, certtypemst t
				WHERE k.ID=c.ID_karyawanmst AND c.CertTypeID=t.CertTypeID AND c.ID='$id'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]) ? $result[0] : $datakosong;

		return $retval;
	}

	function _getCertTypemst()
	{
		$sql = "SELECT CertTypeID, CertTypeName FROM certtypemst";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function getKaryawanMst()
	{
		$searchkey	= $this->input->post('keyword');
		$sql	= "SELECT ID, Nama, NIK FROM karyawanmst 
					WHERE IsActive=1
					AND CONCAT(Nama,' ',NIK) LIKE '%$searchkey%'
					ORDER BY Nama, NIK";

		$query	 = $this->db->query($sql);
		$details = $query->result_array();
		foreach ($details as $row) {

			$niknama	= $row['NIK'] . ' - ' . $row['Nama'];
			$karyawanid	= $row['ID'];
			$retval['results'][]	= array(
				'text'	=> $niknama,
				'id'	=> $karyawanid
			);
		}
		echo json_encode($retval);
	}

	function inputeditproc($id = null)
	{
		if (is_null($id)) {
			$this->_inputproc();
		} else {
			$this->_editproc($id);
		}
	}

	function _getCertData($id)
	{
		$sql = "SELECT  c.ID, c.FileLocation, c.CertNo, c.ValidYear, c.CertName, c.CertTypeID, c.Notes
				FROM certkaryawantrn c
				WHERE c.ID='$id'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= $result[0];

		return $retval;
	}

	function __delete()
	{
		$urlid		= $this->uri->segment(4);
		print_array($urlid);
		$str		= $this->uri->uri_string();
		$dfa	= explode('/', $str, 5);
		print_array($dfa);
	}

	function delete()
	{
		$urlid		= $this->uri->uri_string();
		$urldata	= explode('/', $urlid, 5);

		$urlback	= $urldata[4];
		$id			= $urldata[3];
		$certdata	= $this->_getCertData($id);
		$filelocation	= $certdata['FileLocation'];

		unlink($filelocation);

		$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI
		$this->db->delete('certkaryawantrn', array('ID' => $id));
		$this->db->trans_complete(); //----------------------------------------------------END TRANSAKSI
		redirect($urlback, 'refresh');
	}

	function _inputproc()
	{
		$submit			= $this->input->post('submit');
		if ($submit) {


			$config['upload_path']		= FCPATH . 'application/tempdir/';
			$config['file_name']		= 'sertijs' . rand(5, 16);
			// $config['overwrite']		= TRUE;
			$config['allowed_types']	= 'gif|jpg|png|pdf|doc|docx';
			$config['max_size']			= 5000;
			$config['max_width']		= 1500;
			$config['max_height']		= 1500;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('sertfile')) {
				$error					= array('error_info' => $this->upload->display_errors());
				print_array($error);
			} else {
				$data			= $this->upload->data();
				$certno			= $this->input->post('certno');
				$validyear		= $this->input->post('validyear');
				$certname		= $this->input->post('certname');
				$certtypeid		= $this->input->post('certtypeid');
				$idkaryawan		= $this->input->post('idkaryawan');
				$notes			= $this->input->post('notes');
				$filelocation	= $data['full_path'];

				$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI

				$data	= array(
					'CertNo'			=> $certno,
					'ValidYear'			=> $validyear,
					'CertName'			=> $certname,
					'CertTypeID'		=> $certtypeid,
					'ID_karyawanmst'	=> $idkaryawan,
					'FileLocation'		=> $filelocation,
					'Notes'				=> $notes
				);
				$this->db->insert('certkaryawantrn', $data);

				$this->db->trans_complete(); //----------------------------------------------------END TRANSAKSI
			}
		}
		redirect('hr/sertkarytrns', 'refresh');
	}

	function edit($id)
	{
		$this->load->helper('text');
		$data['data']		= $this->_getData($id);
		$data['certypemst']	= $this->_getCertTypemst();
		$data['urlsegment']	= $this->uri->uri_string();
		$this->load->view('hr/sertkarytrns/sertkarytrns_edit', $data);
	}

	function dlview($id) {
		$datafile	= $this->_getData($id);
		$filelocation = $datafile['FileLocation'];
		$data['namanik']	= $datafile['NIK'].' - '.$datafile['Nama'];
		copy($filelocation, FCPATH.'publicfolder/tempfolder/test.pdf');
		$this->load->view('hr/sertkarytrns/sertkarytrns_preview',$data);
	}


	function _editproc($id)
	{
		$certno						= $this->input->post('certno');
		$urlsegment					= $this->input->post('urlsegment');
		$validyear					= $this->input->post('validyear');
		$certname					= $this->input->post('certname');
		$certtypeid					= $this->input->post('certtypeid');
		// $idkaryawan					= $this->input->post('idkaryawan');
		$notes						= $this->input->post('notes');
		$filelocation				= $this->input->post('filelocation');

		$config['upload_path']		= FCPATH . 'application/tempdir/';
		$config['file_name']		= 'sertijs' . rand(5, 16);
		// $config['overwrite']		= TRUE;
		$config['allowed_types']	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= 5000;
		$config['max_width']		= 1500;
		$config['max_height']		= 1500;

		$this->load->library('upload', $config);
		$submit	= $this->input->post('submit');

		if ($submit) {
			if ($this->upload->do_upload('sertfile')) {
				unlink($filelocation);
				$data	= $this->upload->data();
				$filelocation = $data['full_path'];
			}

			$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI

			$dataupdate	= array(
				'CertNo'			=> $certno,
				'ValidYear'			=> $validyear,
				'CertName'			=> $certname,
				'CertTypeID'		=> $certtypeid,
				// 'ID_karyawanmst'	=> $idkaryawan,
				'FileLocation'		=> $filelocation,
				'Notes'				=> $notes
			);
			$this->db->where('ID', $id);
			$this->db->update('certkaryawantrn', $dataupdate);

			$this->db->trans_complete(); //----------------------------------------------------END TRANSAKSI

		}
		$urldata	= explode('/', $urlsegment, 5);
		$urlback	= $urldata[4];
		redirect($urlback,'refresh');
	}

	function test()
	{
		$config['upload_path'] = FCPATH . 'application/tempdir/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
		$config['max_size'] = 2000;
		$config['max_width'] = 1500;
		$config['max_height'] = 1500;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('sertfile')) {
			$error = array('error' => $this->upload->display_errors());

			print_array($error);
		} else {
			$data = array('image_metadata' => $this->upload->data());

			print_array($data);
		}
	}
}
