<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Upload extends CI_Controller
{
	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('file', array('error' => ' '));
		$this->load->view('template/footer');
	}
	public function upload_avatar()
	{
		$this->load->model('user_model');
		$config['upload_path'] = './uploads/avatar';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = 10000;
		$config['max_width'] = 2000;
		$config['max_height'] = 2000;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('userfile')) {
			$this->load->view('template/header');
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('file', $error);
			$this->load->view('template/footer');
		} else {
			$this->user_model->update_avatar($this->session->userdata('username'), $this->upload->data('file_name'), $this->upload->data('full_path'));
			$this->load->view('template/header');
			$this->load->view('update_success');
			$this->load->view('template/footer');
		}
	}
}
