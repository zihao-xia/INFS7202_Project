<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Favourites extends CI_Controller
{
    public function index()
    {
        $this->load->view('template/header');
        $data['posts'] = $this->get_liked_posts();
        $this->load->view('favourites', $data);
        $this->load->view('template/footer');
    }

    public function get_liked_posts()
    {
        $this->load->model('post_model');
        $this->load->model('favourites_model');
        $username = $this->session->userdata('username');
        $favourites = $this->favourites_model->get_favourites($username);
        $posts = array();
        foreach ($favourites as $favourite) {
            $post_id = $favourite['post_id'];
            $post = $this->post_model->get_post($post_id);
            array_push($posts, $post);
        }
        return $posts;
    }
}
