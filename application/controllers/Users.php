<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); // enable session
        $this->load->helper(array('form', 'url'));
        $this->load->model('user_model');
        $this->load->library('form_validation');
    }

    public function login()
    {
        $data['error'] = "";
        $this->load->view('template/header');
        if (!$this->session->userdata('logged_in')) // check if user already login
        {
            if (get_cookie('remember')) { // check if user activate the "remember me" feature  
                $username = get_cookie('username'); // get the username from cookie
                $password = get_cookie('password'); // get the username from cookie
                if ($this->user_model->login($username, $password)) // check username and password correct
                {
                    $user_data = array(
                        'username' => $username,
                        'logged_in' => true     // create session variable
                    );
                    $this->session->set_userdata($user_data); // set user status to login in session
                    redirect('home'); // if user already logined show main page
                }
            } else {
                $this->load->view('login', $data);    // if there is no 'remember' cookie, show login page
            }
        } else {
            redirect('home'); // if user already logined show main page
        }
        $this->load->view('template/footer');
    }

    public function check_login()
    {
        $this->load->view('template/header');
        $username = $this->input->post('username'); // getting username from login form
        $password = $this->input->post('password'); // getting password from login form
        $remember = $this->input->post('remember'); // getting remember checkbox from login form
        if (!$this->session->userdata('logged_in')) {    // check if user already login
            if ($this->user_model->login($username, $password)) // check username and password
            {
                $user_data = array(
                    'username' => $username,
                    'logged_in' => true     // create session variable
                );
                if ($remember) { // if remember me is activated create cookie
                    set_cookie("username", $username, '300'); // set cookie username
                    set_cookie("password", password_hash($password, PASSWORD_DEFAULT), '300'); // set cookie password
                    set_cookie("remember", $remember, '300'); // set cookie remember
                }
                $this->session->set_userdata($user_data); // set user status to login in session
                redirect('home'); // direct user home page
            } else {
                if (!$this->user_model->check_username_exists($username)) {
                    $data['error'] =
                        "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect username. </div> ";
                    $this->load->view('login', $data);    // if username incorrect, show error msg and ask user to login   
                } else {
                    $data['error'] =
                        "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect password. </div> ";
                    $this->load->view('login', $data);    // if password incorrect, show error msg and ask user to login
                }
            }
        } else {
            redirect('home'); // if user already logined direct user to home page
        }
        $this->load->view('template/footer');
    }

    public function logout()
    {
        $this->session->unset_userdata('logged_in'); // delete login status
        $this->session->unset_userdata('username');
        if (get_cookie('remember')) { // delete cookie remember if it exists
            set_cookie("remember", time() - 3600);
        }
        redirect('users/login'); // redirect user back to login
    }

    public function registration()
    {
        $this->load->helper('captcha');
        $this->load->view('template/header');
        $this->form_validation->set_rules(
            'username',
            'Username',
            'trim|required|min_length[5]|max_length[20]|is_unique[users.username]',
            array('is_unique' => 'This %s already exists.')
        );
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[20]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('captcha', 'Captcha', 'callback_validate_captcha');
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = $this->input->post('password');



        if ($this->form_validation->run() === FALSE) {
            // captcha configuration
            $config = array(
                'img_path'      => './uploads/captcha_image/',
                'img_url'       => base_url() . './uploads/captcha_image/',
                'font_path'     => base_url() . 'system/fonts/texb.ttf',
                'img_width'     => 170,
                'img_height'    => 50,
                'expiration'    => 7200,
                'word_length'   => 4,
                'font_size'     => 25,
                'colors'        => array(
                    'background' => array(171, 194, 177),
                    'border' => array(10, 51, 11),
                    'text' => array(0, 0, 0),
                    'grid' => array(185, 234, 237)
                )
            );
            $captcha = create_captcha($config);
            // unset previous captcha and set new captcha word
            $this->session->unset_userdata('captchaCode');
            $this->session->set_userdata('captchaCode', $captcha['word']);
            // pass captcha image to view
            $data['captchaImg'] = $captcha['image'];
            $this->load->view('registration', $data);
        } else { // if the registration is completed
            // generate simple random code
            $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $code = substr(str_shuffle($set), 0, 12);
            $active = false;
            $this->user_model->register($username, $email, $password, $code, $active);
            // set email verification
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
            // set user login session
            $user_data = array(
                'username' => $username,
                'logged_in' => true
            );
            $this->session->set_userdata($user_data);
            $this->load->view('register_success');
        }
        $this->load->view('template/footer');
    }

    public function validate_captcha()
    {
        if ($this->input->post('captcha') != $this->session->userdata('captchaCode')) {
            $this->form_validation->set_message('validate_captcha', 'The captcha code is wrong.');
            return false;
        } else {
            return true;
        }
    }

    public function refresh()
    {
        $this->load->helper('captcha');
        $config = array(
            'img_path'      => './uploads/captcha_image/',
            'img_url'       => base_url() . './uploads/captcha_image/',
            'font_path'     => base_url() . 'system/fonts/texb.ttf',
            'img_width'     => 170,
            'img_height'    => 50,
            'expiration'    => 7200,
            'word_length'   => 4,
            'font_size'     => 25,
            'colors'        => array(
                'background' => array(171, 194, 177),
                'border' => array(10, 51, 115),
                'text' => array(0, 0, 0),
                'grid' => array(185, 234, 237)
            )
        );
        $captcha = create_captcha($config);
        // Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);
        // Display captcha image
        echo $captcha['image'];
    }

    public function forgot_password()
    {
        $this->load->view('template/header');
        $this->form_validation->set_rules(
            'username',
            'Username',
            'callback_username_check',
            array('username_check' => 'This %s does not exist.')
        );
        $this->form_validation->set_rules('email', 'Email', 'callback_email_check', array('email_check' => 'This %s does not match the user.'));
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|min_length[6]|max_length[20]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|matches[new_password]');
        $username = $this->input->post('username');
        $new_password = $this->input->post('new_password');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('forgot_password');
        } else { // if the password successfully changed
            $this->user_model->update_password($username, $new_password);
            $user_data = array(
                'username' => $username,
                'logged_in' => true
            );
            $this->session->set_userdata($user_data);
            $this->load->view('update_success');
        }
        $this->load->view('template/footer');
    }

    public function username_check($username)
    {
        return $this->user_model->check_username_exists($username);
    }

    public function email_check($email)
    {
        $username = $this->input->post('username');
        $true_email = $this->user_model->get_email($username);
        return $email == $true_email ? true : false;
    }

    public function activate()
    {
        $username =  $this->uri->segment(3);
        $code = $this->uri->segment(4);
        $user = $this->user_model->get_user($username);
        if ($user['code'] == $code) {
            $data['active'] = true;
            $query = $this->user_model->activate($data, $username);

            if ($query) {
                $this->session->set_flashdata('message', 'User activated successfully');
            } else {
                $this->session->set_flashdata('message', 'Something went wrong in activating account');
            }
        } else {
            $this->session->set_flashdata('message', 'Cannot activate account. Code didnt match');
        }

        redirect('profile');
    }
}
