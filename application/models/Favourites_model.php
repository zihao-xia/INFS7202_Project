<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Favourites_model extends CI_Model
{
    // like a post
    public function like_post($username, $post_id)
    {
        $data = array(
            'username' => $username,
            'post_id' => $post_id
        );
        return $this->db->insert('favourites', $data);
    }

    // get status whether the post is liked or not
    public function is_liked($username, $post_id)
    {
        $this->db->where('username', $username)->where('post_id', $post_id);
        $query = $this->db->get('favourites');
        if (count($query->result_array()) == 0) {
            return false;
        }
        return true;
    }

    // remove a post from favourites
    public function unlike_post($username, $post_id)
    {
        $this->db->where('username', $username)->where('post_id', $post_id);
        return $this->db->delete('favourites');
    }

    // get user's favourites
    public function get_favourites($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('favourites');
        return array_reverse($query->result_array());
    }
}
