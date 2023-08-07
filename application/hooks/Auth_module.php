<?php

class Auth_module
{
    private $CI;

    public function __construct()
    {

        $this->CI = &get_instance();
    }

    function check_user_login()
    {
        if (!$this->CI->session->userdata('logged_in')) {
            if (get_class($this->CI) != 'Users') {
                redirect(base_url('users/login'));
            }
        }
    }
}
