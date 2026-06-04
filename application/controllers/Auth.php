<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    // Redirect logged-in users to dashboard
    private function _redirect_if_logged_in() {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
    }

    public function index() {
        $this->login();
    }

    public function login() {
        $this->_redirect_if_logged_in();

        $data['title']  = 'Login - JobTracker';
        $data['error']  = '';

        if ($this->input->post()) {
            $email    = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            $this->form_validation->set_rules('email',    'Email',    'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === FALSE) {
                $data['error'] = validation_errors('<p class="text-danger">', '</p>');
            } else {
                $user = $this->User_model->get_by_email($email);
                if ($user && password_verify($password, $user->password)) {
                    $this->session->set_userdata('user_id',   $user->id);
                    $this->session->set_userdata('user_name', $user->name);
                    $this->session->set_userdata('user_email',$user->email);
                    redirect('dashboard');
                } else {
                    $data['error'] = '<p class="text-danger">Invalid email or password.</p>';
                }
            }
        }

        $this->load->view('auth/login', $data);
    }

    public function register() {
        $this->_redirect_if_logged_in();

        $data['title'] = 'Register - JobTracker';
        $data['error'] = '';

        if ($this->input->post()) {
            $this->form_validation->set_rules('name',             'Full Name', 'required|min_length[3]|max_length[100]');
            $this->form_validation->set_rules('email',            'Email',     'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password',         'Password',  'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

            if ($this->form_validation->run() === FALSE) {
                $data['error'] = validation_errors('<p class="text-danger">', '</p>');
            } else {
                $insert = $this->User_model->create([
                    'name'     => $this->input->post('name', TRUE),
                    'email'    => $this->input->post('email', TRUE),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                ]);

                if ($insert) {
                    $this->session->set_flashdata('success', 'Account created! Please log in.');
                    redirect('login');
                } else {
                    $data['error'] = '<p class="text-danger">Registration failed. Try again.</p>';
                }
            }
        }

        $this->load->view('auth/register', $data);
    }
    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}