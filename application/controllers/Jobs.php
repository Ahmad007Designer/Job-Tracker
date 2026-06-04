<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Job_model');
        $this->_check_login();
    }

    private function _check_login() {
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }
    public function dashboard() {
        $user_id = $this->session->userdata('user_id');

        $data['title']         = 'Dashboard - JobTracker';
        $data['total']         = $this->Job_model->count_all($user_id);
        $data['shortlisted']   = $this->Job_model->count_by_status($user_id, 'Shortlisted');
        $data['interviews']    = $this->Job_model->count_by_status($user_id, 'Interview');
        $data['offers']        = $this->Job_model->count_by_status($user_id, 'Offer');
        $data['rejected']      = $this->Job_model->count_by_status($user_id, 'Rejected');
        $data['recent_jobs']   = $this->Job_model->get_recent($user_id, 5);
        $data['status_counts'] = $this->Job_model->get_status_counts($user_id);
        $data['followups']     = $this->Job_model->get_followups_today($user_id);

        $this->load->view('partials/header', $data);
        $this->load->view('jobs/dashboard', $data);
        $this->load->view('partials/footer');
    }
    public function index() {
        $user_id = $this->session->userdata('user_id');

        $filters = [
            'status'   => $this->input->get('status'),
            'search'   => $this->input->get('search'),
            'job_type' => $this->input->get('job_type'),
        ];

        $data['title']    = 'My Applications - JobTracker';
        $data['jobs']     = $this->Job_model->get_all($user_id, $filters);
        $data['filters']  = $filters;
        $data['statuses'] = ['Applied','Shortlisted','Interview','Offer','Rejected','Withdrawn'];
        $data['types']    = ['Full-time','Part-time','Internship','Remote','Contract'];

        $this->load->view('partials/header', $data);
        $this->load->view('jobs/index', $data);
        $this->load->view('partials/footer');
    }

    public function add() {
        $data['title']    = 'Add Application - JobTracker';
        $data['statuses'] = ['Applied','Shortlisted','Interview','Offer','Rejected','Withdrawn'];
        $data['types']    = ['Full-time','Part-time','Internship','Remote','Contract'];
        $data['error']    = '';
        $data['job']      = NULL;

        if ($this->input->post()) {
            $this->form_validation->set_rules('company_name', 'Company Name', 'required|max_length[150]');
            $this->form_validation->set_rules('job_title',    'Job Title',    'required|max_length[150]');
            $this->form_validation->set_rules('applied_date', 'Applied Date', 'required');
            $this->form_validation->set_rules('status',       'Status',       'required');

            if ($this->form_validation->run() === FALSE) {
                $data['error'] = validation_errors('<div class="alert alert-danger">', '</div>');
            } else {
                $this->Job_model->create([
                    'user_id'        => $this->session->userdata('user_id'),
                    'company_name'   => $this->input->post('company_name', TRUE),
                    'job_title'      => $this->input->post('job_title', TRUE),
                    'location'       => $this->input->post('location', TRUE),
                    'job_type'       => $this->input->post('job_type', TRUE),
                    'salary_range'   => $this->input->post('salary_range', TRUE),
                    'status'         => $this->input->post('status', TRUE),
                    'applied_date'   => $this->input->post('applied_date', TRUE),
                    'follow_up_date' => $this->input->post('follow_up_date', TRUE) ?: NULL,
                    'job_url'        => $this->input->post('job_url', TRUE),
                    'notes'          => $this->input->post('notes', TRUE),
                    'resume_version' => $this->input->post('resume_version', TRUE),
                ]);

                $this->session->set_flashdata('success', 'Application added successfully!');
                redirect('jobs');
            }
        }

        $this->load->view('partials/header', $data);
        $this->load->view('jobs/form', $data);
        $this->load->view('partials/footer');
    }

    public function edit($id) {
        $user_id = $this->session->userdata('user_id');
        $job     = $this->Job_model->get_by_id($id, $user_id);

        if (!$job) { redirect('jobs'); }

        $data['title']    = 'Edit Application - JobTracker';
        $data['job']      = $job;
        $data['statuses'] = ['Applied','Shortlisted','Interview','Offer','Rejected','Withdrawn'];
        $data['types']    = ['Full-time','Part-time','Internship','Remote','Contract'];
        $data['error']    = '';

        if ($this->input->post()) {
            $this->form_validation->set_rules('company_name', 'Company Name', 'required|max_length[150]');
            $this->form_validation->set_rules('job_title',    'Job Title',    'required|max_length[150]');
            $this->form_validation->set_rules('applied_date', 'Applied Date', 'required');

            if ($this->form_validation->run() === FALSE) {
                $data['error'] = validation_errors('<div class="alert alert-danger">', '</div>');
            } else {
                $this->Job_model->update($id, $user_id, [
                    'company_name'   => $this->input->post('company_name', TRUE),
                    'job_title'      => $this->input->post('job_title', TRUE),
                    'location'       => $this->input->post('location', TRUE),
                    'job_type'       => $this->input->post('job_type', TRUE),
                    'salary_range'   => $this->input->post('salary_range', TRUE),
                    'status'         => $this->input->post('status', TRUE),
                    'applied_date'   => $this->input->post('applied_date', TRUE),
                    'follow_up_date' => $this->input->post('follow_up_date', TRUE) ?: NULL,
                    'job_url'        => $this->input->post('job_url', TRUE),
                    'notes'          => $this->input->post('notes', TRUE),
                    'resume_version' => $this->input->post('resume_version', TRUE),
                ]);

                $this->session->set_flashdata('success', 'Application updated!');
                redirect('jobs');
            }
        }

        $this->load->view('partials/header', $data);
        $this->load->view('jobs/form', $data);
        $this->load->view('partials/footer');
    }

    public function view($id) {
        $user_id = $this->session->userdata('user_id');
        $job     = $this->Job_model->get_by_id($id, $user_id);

        if (!$job) { redirect('jobs'); }

        $data['title'] = $job->company_name . ' - JobTracker';
        $data['job']   = $job;

        $this->load->view('partials/header', $data);
        $this->load->view('jobs/view', $data);
        $this->load->view('partials/footer');
    }

    public function delete($id) {
        $user_id = $this->session->userdata('user_id');
        $this->Job_model->delete($id, $user_id);
        $this->session->set_flashdata('success', 'Application deleted.');
        redirect('jobs');
    }

    public function update_status() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id      = $this->input->post('id');
        $status  = $this->input->post('status');
        $user_id = $this->session->userdata('user_id');

        $valid = ['Applied','Shortlisted','Interview','Offer','Rejected','Withdrawn'];
        if (!in_array($status, $valid)) {
            echo json_encode(['success' => false, 'msg' => 'Invalid status']);
            return;
        }

        $this->Job_model->update_status($id, $user_id, $status);
        echo json_encode(['success' => true, 'msg' => 'Status updated to ' . $status]);
    }

    public function get_stats() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $user_id = $this->session->userdata('user_id');
        $counts  = $this->Job_model->get_status_counts($user_id);
        echo json_encode($counts);
    }
}