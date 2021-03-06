<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_wisuda extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logged_in_umk')) redirect(base_url());
		$this->load->library('template');
		date_default_timezone_set('Asia/Jakarta');		
		$this->load->model('panel/laporan_model');	
	}
	
	public function index(){
		if($this->session->userdata('logged_in_umk')) {
			$data['progdi'] = $this->laporan_model->select_progdi()->result();
			$this->template->display('panel/lapwisuda_v', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}	
	
	public function preview($progdi = false) {  
		$progdi 	= $this->input->post('lstProgdi');		
		$tgl1 		= $this->input->post('tgl1', 'true');
		$tgl2 		= $this->input->post('tgl2', 'true');        

		if ($progdi == 'all') { // Jika Progdi dan Kegiatan Semua
			$data = array(
					'tgl1' => $tgl1,
					'tgl2' => $tgl2
				);
			$data['preview'] = $this->laporan_model->select_wisuda_all()->result();	
		} else { // Jika Progdi by ID dan Semua Kegiatan
			$data = array(			
					'lstProgdi' => $progdi,					
					'tgl1' => $tgl1,
					'tgl2' => $tgl2
				);
			$data['preview'] = $this->laporan_model->select_wisuda_progdi()->result();			
		}		       
		$data['lastPost'] = $data;		
		$this->template->display('panel/tampil_report_wisuda_v', $data); 				                   
	}
	
	public function cetak_all() {
		$tgl1 		= $this->uri->segment(4);
		$tgl2 		= $this->uri->segment(5);

		$data = array(				
				'tgl1' => $tgl1,
				'tgl2' => $tgl2
			);

		$data['preview'] = $this->laporan_model->cetak_all_alumni($data);
		$this->load->view('panel/r_print_alumni_html', $data); 
	}

	public function cetak_by_kegiatan($kegiatan = '') {
		$kegiatan 	= $this->uri->segment(4);
		$tgl1 		= $this->uri->segment(5);
		$tgl2 		= $this->uri->segment(6);
		
		$data = array(
				'lstKegiatan' => $kegiatan,
				'tgl1' => $tgl1,
				'tgl2' => $tgl2
			);

		$data['preview'] = $this->laporan_model->cetak_kegiatan_alumni($data);
		$this->load->view('panel/r_print_alumni_html', $data); 
	}

	public function cetak_by_progdi($progdi = '') {
		$progdi 	= $this->uri->segment(4);
		$tgl1 		= $this->uri->segment(5);
		$tgl2 		= $this->uri->segment(6);
		
		$data = array(
				'lstProgdi' => $progdi,
				'tgl1' => $tgl1,
				'tgl2' => $tgl2
			);

		$data['preview'] = $this->laporan_model->cetak_progdi_alumni($data);
		$this->load->view('panel/r_print_alumni_html', $data); 
	}

	public function cetak_by_id($progdi = '', $kegiatan = '') {
		$progdi 	= $this->uri->segment(4);
		$kegiatan 	= $this->uri->segment(5);
		$tgl1 		= $this->uri->segment(6);
		$tgl2 		= $this->uri->segment(7);
		
		$data = array(
				'lstProgdi' => $progdi,
				'lstKegiatan' => $kegiatan,
				'tgl1' => $tgl1,
				'tgl2' => $tgl2
			);

		$data['preview'] = $this->laporan_model->cetak_alumni_by_id($data);
		$this->load->view('panel/r_print_alumni_html', $data); 
	}
}
/* Location: ./application/controllers/panel/lap_progdi.php */
?>