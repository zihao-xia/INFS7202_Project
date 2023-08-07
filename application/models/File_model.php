<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class File_model extends CI_Model{

    public function upload_avatar($username, $avatar){

        $data = array(
            'username' => $username,
            'avatar' => $avatar
        );
        $query = $this->db->insert('files', $data);

    }
}
