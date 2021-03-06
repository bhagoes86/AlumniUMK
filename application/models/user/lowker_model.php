<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lowker_model extends CI_Model {
	
	function __construct() {
		parent::__construct();	
	}

	function select_all($progdi_id) {
		$this->db->select('l.*, u.user_username');
		$this->db->from('umk_lowker l');		
		$this->db->join('umk_users u', 'l.user_id = u.user_id');
		$this->db->where('l.lowker_trash', 0);
		$this->db->where('l.progdi_id', $progdi_id);
		$this->db->order_by('l.lowker_id','desc');
		
		return $this->db->get();
	}


	function select_all_komentar($lowker_id) {
		$this->db->select('*');
		$this->db->from('umk_lowker as l');
		$this->db->join('umk_progdi as p', 'l.progdi_id=p.progdi_id');
		$this->db->join('umk_users as u', 'l.user_id = u.user_id');
		$this->db->where('l.lowker_trash', 0);
		$this->db->where('l.progdi_id', $progdi_id);
		$this->db->order_by('l.lowker_id','desc');
		
		return $this->db->get();
	}
	
	function select_progdi() {
		$user_id = $this->session->userdata('a_user_id');

		$this->db->select('*');
		$this->db->from('umk_user_akses a');
		$this->db->join('umk_progdi p', 'a.progdi_id = p.progdi_id');
		$this->db->join('umk_m_fakultas f', 'p.fakultas_id = f.fakultas_id');
		$this->db->where('a.user_id', $user_id);
		$this->db->order_by('a.progdi_id','asc');
		
		return $this->db->get();
	}

	function insert_data() {
		if (!empty($_FILES['userfile']['name'])) {
			$data = array(
				'user_id' => $this->session->userdata('a_user_id'),
				'progdi_id' => $this->uri->segment(4),				
				'lowker_title' => trim($this->input->post('title')),
				'lowker_seo' => seo_title(trim($this->input->post('title'))),
				'lowker_short' => trim($this->input->post('short')),
				'lowker_desc' => trim($this->input->post('deskripsi')),
				'lowker_image' => $this->upload->file_name,					
				'lowker_tgl_post' => date('Y-m-d'),
				'lowker_jam_post' => date('Y-m-d H:i:s'),
				'lowker_tgl_deadline' => $this->input->post('tgl_deadline')
			);
		} else {
			$data = array(
				'user_id' => $this->session->userdata('a_user_id'),
				'progdi_id' => $this->uri->segment(4),				
				'lowker_title' => trim($this->input->post('title')),
				'lowker_seo' => seo_title(trim($this->input->post('title'))),
				'lowker_short' => trim($this->input->post('short')),
				'lowker_desc' => trim($this->input->post('deskripsi')),
				'lowker_tgl_post' => date('Y-m-d'),
				'lowker_jam_post' => date('Y-m-d H:i:s'),
				'lowker_tgl_deadline' => $this->input->post('tgl_deadline')
			);
		}		
		
		$this->db->insert('umk_lowker', $data);
	}
	
	function select_by_id($lowker_id) {
		$this->db->select('*');
		$this->db->from('umk_lowker');
		$this->db->where('lowker_id', $lowker_id);
		
		return $this->db->get();
	}

	function update_data() {
		$lowker_id     = $this->input->post('lowker_id');
		
		if (!empty($_FILES['userfile']['name'])) {
			$data = array(
				'user_id' => $this->session->userdata('a_user_id'),							
				'lowker_title' => trim($this->input->post('title')),
				'lowker_seo' => seo_title(trim($this->input->post('title'))),
				'lowker_short' => trim($this->input->post('short')),
				'lowker_desc' => trim($this->input->post('deskripsi')),
				'lowker_image' => $this->upload->file_name,						
				'lowker_tgl_update' => date('Y-m-d'),
				'lowker_jam_update' => date('Y-m-d H:i:s'),
				'lowker_tgl_deadline' => $this->input->post('tgl_deadline')
			);
		} else {
			$data = array(
				'user_id' => $this->session->userdata('a_user_id'),						
				'lowker_title' => trim($this->input->post('title')),
				'lowker_seo' => seo_title(trim($this->input->post('title'))),
				'lowker_short' => trim($this->input->post('short')),
				'lowker_desc' => trim($this->input->post('deskripsi')),
				'lowker_tgl_update' => date('Y-m-d'),
				'lowker_jam_update' => date('Y-m-d H:i:s'),
				'lowker_tgl_deadline' => $this->input->post('tgl_deadline')
			);
		}

		$this->db->where('lowker_id', $lowker_id);
		$this->db->update('umk_lowker', $data);
	}

	function delete_data($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(5));

		$data = array('lowker_trash' => 1);
						
		$this->db->where('lowker_id', $kode);
		$this->db->update('umk_lowker', $data);
	}

	function select_progdi2($progdi_id) {
		$this->db->select('*');
		$this->db->from('umk_progdi');
		$this->db->where('progdi_trash', 0);		
		$this->db->where('progdi_id', $progdi_id);		
		
		return $this->db->get();
	}
}

/* Location: ./application/model/user/lowker_model.php */
?>