<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Setting extends CI_Controller
{
    public function index()
    {
        $this->load->model('user_model');
        $this->load->view('template/header');
        $data['username'] = $this->session->userdata('username');
        $username = $this->session->userdata('username');
        $data['email'] = $this->user_model->get_email($username);
        $this->load->view('setting', $data);
        $this->load->view('template/footer');
    }
}
