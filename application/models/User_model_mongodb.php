<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//put your code here 
class User_model_mongodb extends CI_Model
{

    // Log in
    public function login($username, $password)
    {
        // Validate
        $this->mongo_db->where('username', $username);
        $this->mongo_db->where('password', $password);
        $result = $this->mongo_db->count('users');

        if ($result == 1) {
            return true;
        } else {
            return false;
        }
    }

    // Check username exists
    public function check_username_exists($username)
    {
        $this->mongo_db->where('username', $username);
        $result = $this->mongo_db->count('users');
        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Register an account
    public function register($username, $email, $password)
    {
        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        );
        return $this->mongo_db->insert('users', $data);
    }

    // Get user's email
    public function get_email($username)
    {
        $query = $this->mongo_db->select(['email'])->where('username', $username)->get('users');
        $email = $query[0]['email'];
        return $email;
    }

    // Update user's email
    public function update_email($username, $new_email)
    {
        $this->mongo_db->where('username', $username)->set('email', $new_email)->update('users');
    }
}
