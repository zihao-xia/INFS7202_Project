<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->model('favourites_model');
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        // pagination
        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = base_url() . 'home';
        $config['total_rows'] = $this->post_model->get_post_count();
        $config['per_page'] = 10;
        $config["uri_segment"] = 2;
        
        // add bootstrap pagination style
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['links'] = $this->pagination->create_links();

        $this->load->view('template/header');
        $data['username'] = $this->session->userdata('username');
        $data['posts'] = $this->post_model->get_posts($config['per_page'], $page);
        $this->load->view('home', $data);
        $this->load->view('template/footer');
    }

    public function create_post()
    {
        $this->load->view('template/header');
        $data['categories'] = $this->post_model->get_categories();
        $author = $this->session->userdata('username');
        $title = $this->input->post('post_title');
        $category = $this->input->post('post_category');
        $content = $this->input->post('post_content');
        if ($title && $category && $content) {
            $this->post_model->create_post($author, $title, $category, $content);
            $this->load->view('post_created');
        } else {
            $this->load->view('create_post', $data);
        }
        $this->load->view('template/footer');
    }

    public function read_post($id = NULL)
    {
        // pagination
        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = base_url('home/read_post/' . $id);
        $config['total_rows'] = $this->post_model->get_comment_num($id);
        $config['per_page'] = 5;
        $config["uri_segment"] = 4;
        
        // add bootstrap pagination style
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['links'] = $this->pagination->create_links();

        $this->load->view('template/header');
        $data['post'] = $this->post_model->get_post($id);
        if (empty($data['post'])) {
            show_404();
        }
        $data['comments'] = $this->post_model->get_comments($id, $config['per_page'], $page);
        $this->load->view('read', $data);
        $this->load->view('template/footer');
    }

    public function like_post($id = NULL)
    {
        $username = $this->session->userdata('username');
        $this->favourites_model->like_post($username, $id);
    }

    public function comment($post_id)
    {
        $username = $this->session->userdata('username');
        $content = $this->input->post('comment');
        $this->post_model->comment_post($post_id, $username, $content);
        redirect('home/read_post/' . $post_id);
    }
}
