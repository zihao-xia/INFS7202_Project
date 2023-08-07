<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Post_model extends CI_Model
{
    // create a new post
    public function create_post($author, $title, $category, $content)
    {
        $data = array(
            'author' => $author,
            'title' => $title,
            'category' => $category,
            'content' => $content
        );
        return $this->db->insert('posts', $data);
    }

    // get categories
    public function get_categories()
    {
        $query = $this->db->select('name')->get('category');
        $array = $query->result_array();
        return array_column($array, 'name');
    }

    // get posts
    public function get_posts($limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->order_by('createdAt', 'DESC')->get('posts');
        return $query->result_array();
    }

    // get post count
    public function get_post_count()
    {
        return $this->db->count_all_results('posts');
    }

    // get single post by id
    public function get_post($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('posts');
        if (count($query->result_array()) > 0) {
            $post = $query->result_array()[0];
            return $post;
        }
        return null;
    }

    // search posts
    public function search_posts($query)
    {
        if ($query == '') {
            return null;
        } else {
            $this->db->select("*");
            $this->db->from("posts");
            $this->db->like('title', $query);
            $this->db->or_like('author', $query);
            $this->db->order_by('createdAt', 'DESC');
            return $this->db->get();
        }
    }

    // comment on a post
    public function comment_post($post_id, $username, $content)
    {
        $floor = $this->get_comment_num($post_id) + 1;
        $data = array(
            'post_id' => $post_id,
            'floor' => $floor,
            'username' => $username,
            'content' => $content
        );
        return $this->db->insert('comments', $data);
    }

    // get comments of a post
    public function get_comments($post_id, $limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('post_id', $post_id);
        $query = $this->db->order_by('floor', 'ASC')->get('comments');
        return $query->result_array();
    }

    // get number of comments of a post
    public function get_comment_num($post_id)
    {
        $this->db->where('post_id', $post_id);
        $query = $this->db->get('comments');
        return count($query->result_array());
    }

    // get number of liked of a post
    public function get_liked_num($post_id)
    {
        $this->db->where('post_id', $post_id);
        $query = $this->db->get('favourites');
        return count($query->result_array());
    }
}
