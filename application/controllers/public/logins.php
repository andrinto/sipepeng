<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logins extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('users_model');
    }

    public function index() {
        $data['title'] = "Login | SIPEPENG";
        $this->load->view('public/login', $data);
    }

    public function process_login() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_error_delimiters('', '<br/>');

        if ($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

//            $user = $this->users_model->check_login($username, $password);
            $user = $this->users_model->checkLogin($username, $password);
            if (!empty($user)) {
//                $query = $this->users_model->get_users($username, $password);
//                $data = $query->row_array();
                $sessionData['id_pengguna'] = $user['id_pengguna'];
                $sessionData['username'] = $user['username'];
                $sessionData['nama'] = $user['nama'];
                $sessionData['id_jenis_pengguna'] = $user['id_jenis_pengguna'];
                $sessionData['is_login'] = TRUE;

                $this->session->set_userdata($sessionData);
                //$this->users_model->updateLastLogin($user['id_pengguna']);

                if ($this->session->userdata('id_jenis_pengguna') == 1) {
                    redirect('admin/homes');
                } else {
                    redirect('public/homes');
                }
            } else {
                $this->session->set_flashdata('message', 'Login Failed!, username and password combination was wrong '. $this->session->userdata('id_jenis_pengguna'));
                redirect('public/logins');
            }
        } else {
            $this->session->set_flashdata('message', 'Login Failed!, username and password combination was wrong ');
            $data['title'] = "Login | SIPEPENG";
            $this->load->view('public/login', $data);
        }
    }

    public function process_logout() {
        $this->session->sess_destroy();
        redirect('public/homes');
    }
}
?>