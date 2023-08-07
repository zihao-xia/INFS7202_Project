<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller
{
    public function fetch()
    {
        $this->load->model('post_model');
        $output = '';
        $query = '';
        if ($this->input->get('query')) {
            $query = $this->input->get('query');
        }
        $data = $this->post_model->search_posts($query);
        if ($data) {
            echo json_encode($data->result());
        } else {
            $output .= 'No Data Found';
        }
        echo  $output;
    }

    public function update_avatar()
    {
        $this->load->helper(array('form', 'url'));
        $isvalidate = $this->validate(['avatar' => 'uploaded[avatar]|max_size[avatar,4096]|is_image',]);
        $response = [
            'success' => false,
            'data' => '',
            'msg' => "Avatar has not been uploaded successfully"
        ];
        if ($isvalidate) {
            $avatar = $this->request->getFile('avatar');
            $avatar->move(WRITEPATH . 'uploads');
            $username = $this->input->post('username');
            $data = $this->user_model->update_avatar($username, $avatar);
            $response = [
                'success' => true,
                'data' => $data,
                'msg' => "Avatar has been uploaded successfully"
            ];
        }
        return $this->response->setJSON($response);
    }

    public function update_email()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('user_model');
        $this->form_validation->set_rules('new_email', 'New Email', 'trim|required|valid_email');
        $username = $this->input->post('username');
        $new_email = $this->input->post('new_email');
        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $this->user_model->update_email($username, $new_email);
            $this->load->view('template/header');
            $this->load->view('update_success');
            $this->load->view('template/footer');
        }
    }

    public function update_password()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('user_model');
        $this->form_validation->set_rules('current_password', 'Current Password', 'callback_password_check', array('password_check' => '%s is incorrect.'));
        $this->form_validation->set_rules('new_password', 'New Passowrd', 'trim|required|min_length[6]|max_length[20]');
        $username = $this->input->post('username');
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $this->user_model->update_password($username, $new_password);
            $this->load->view('template/header');
            $this->load->view('update_success');
            $this->load->view('template/footer');
        }
    }

    public function password_check($password)
    {
        $this->load->model('user_model');
        $username = $this->session->userdata('username');
        $current_password = $this->user_model->get_password($username);
        return password_verify($password, $current_password);
    }

    public function like_post()
    {
        $this->load->model('favourites_model');
        $username = $this->input->post('username');
        $post_id = $this->input->post('post_id');
        $this->favourites_model->like_post($username, $post_id);
    }

    public function unlike_post()
    {
        $this->load->model('favourites_model');
        $username = $this->input->post('username');
        $post_id = $this->input->post('post_id');
        $this->favourites_model->unlike_post($username, $post_id);
    }
}
