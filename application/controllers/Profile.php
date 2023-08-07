<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends CI_Controller
{
    public function index()
    {
        $this->load->model('user_model');
        $this->load->view('template/header');
        $data['username'] = $this->session->userdata('username');
        $username = $this->session->userdata('username');
        $user = $this->user_model->get_user($username);
        $data['email'] = $user['email'];
        $data['avatar'] = $this->user_model->get_avatar($username);
        $data['active'] = $user['active'];
        $this->load->view('profile', $data);
        $this->load->view('template/footer');
    }

    public function send_verification_email() {
        $this->load->model('user_model');
        $this->load->helper('url');
        $username = $this->session->userdata('username');
        $user = $this->user_model->get_user($username);
        $email = $user['email'];
        $code = $user['code'];
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'mailhub.eait.uq.edu.au',
            'smtp_port' => 25,
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1',
            'wordwrap'  => TRUE,
            'newline'   => "\r\n"
        );
        $message =     "
					<html>
					<head>
						<title>Verification Code</title>
					</head>
					<body>
						<h2>Thank you for Registering.</h2>
						<p>Your Account:</p>
						<p>Username: " . $username . "</p>
						<p>Email: " . $email . "</p>
						<p>Please click the link below to activate your account.</p>
						<h4><a href='" . base_url() . "users/activate/" . $username . "/" . $code . "'>Activate My Account</a></h4>
					</body>
					</html>
					";
        $this->email->initialize($config);
        $this->email->from(get_current_user().'@student.uq.edu.au', get_current_user());
        $this->email->to($email);
        $this->email->subject('Email Verification');
        $this->email->message($message);
        if ($this->email->send()) {
            $this->session->set_flashdata('message', 'Activation code sent to email');
        } else {
            $this->session->set_flashdata('message', $this->email->print_debugger());
        }
        redirect('profile');
    }
}
