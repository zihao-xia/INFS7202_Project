<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model
{

    // Log in
    public function login($username, $password)
    {
        if (!$this->check_username_exists($username)) {
            return false;
        }

        $password_hashed = $this->get_password($username);
        return password_verify($password, $password_hashed);
    }

    // Check username exists
    public function check_username_exists($username)
    {
        $query = $this->db->get_where('users', array('username' => $username));
        if (!empty($query->row_array())) {
            return true;
        } else {
            return false;
        }
    }

    // Register an account
    public function register($username, $email, $password, $code, $active)
    {
        $data = array(
            'username'  => $username,
            'email'     => $email,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'code'      => $code,
            'active'    => $active
        );
        return $this->db->insert('users', $data);
    }

    // Get user's email
    public function get_email($username)
    {
        $email = $this->db->select('email')->where('username', $username)->get('users')->row()->email;
        return $email;
    }

    // Update user's email
    public function update_email($username, $new_email)
    {
        $this->db->set('email', $new_email)->where('username', $username)->update('users');
    }

    // Get user's password
    public function get_password($username)
    {
        $password = $this->db->select('password')->where('username', $username)->get('users')->row()->password;
        return $password;
    }

    // Update user's password
    public function update_password($username, $new_password)
    {
        $this->db->set('password', password_hash($new_password, PASSWORD_DEFAULT))->where('username', $username)->update('users');
    }

    // Update user's avatar
    public function update_avatar($username, $filename, $path)
    {
        $data = array(
            'username' => $username,
            'filename' => $filename,
            'path' => $path
        );
        return $this->db->replace('avatar', $data);
    }

    // Get user's avatar
    public function get_avatar($username)
    {
        $query = $this->db->get_where('avatar', array('username' => $username));
        if (empty($query->row_array())) {
            return 'default_avatar.png';
        }
        $avatar = $this->db->select('filename')->where('username', $username)->get('avatar')->row()->filename;
        return $avatar;
    }

    // Activate user's account
    public function activate($data, $username)
    {
        $this->db->where('users.username', $username);
        return $this->db->update('users', $data);
    }

    // Get user's all attributes
    public function get_user($username)
    {
        $query = $this->db->get_where('users', array('username' => $username));
        return $query->row_array();
    }
}
