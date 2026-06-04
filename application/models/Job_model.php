<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_model extends CI_Model {

    protected $table = 'job_applications';

    // Get all jobs with optional filters
    public function get_all($user_id, $filters = []) {
        $this->db->where('user_id', $user_id);

        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        if (!empty($filters['job_type'])) {
            $this->db->where('job_type', $filters['job_type']);
        }
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $this->db->group_start();
            $this->db->like('company_name', $search);
            $this->db->or_like('job_title', $search);
            $this->db->or_like('location', $search);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result();
    }

    // Get single job by id (verify ownership)
    public function get_by_id($id, $user_id) {
        return $this->db->get_where($this->table, [
            'id'      => $id,
            'user_id' => $user_id
        ])->row();
    }

    // Create new job application
    public function create($data) {
        return $this->db->insert($this->table, $data);
    }

    // Update job application
    public function update($id, $user_id, $data) {
        $this->db->where('id', $id)->where('user_id', $user_id);
        return $this->db->update($this->table, $data);
    }

    // AJAX: update only status
    public function update_status($id, $user_id, $status) {
        $this->db->where('id', $id)->where('user_id', $user_id);
        return $this->db->update($this->table, ['status' => $status]);
    }

    // Delete job application
    public function delete($id, $user_id) {
        return $this->db->delete($this->table, ['id' => $id, 'user_id' => $user_id]);
    }

    // Count all applications
    public function count_all($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results($this->table);
    }

    // Count by status
    public function count_by_status($user_id, $status) {
        return $this->db->where('user_id', $user_id)
                        ->where('status', $status)
                        ->count_all_results($this->table);
    }

    // Get count for each status (for chart)
    public function get_status_counts($user_id) {
        $statuses = ['Applied','Shortlisted','Interview','Offer','Rejected','Withdrawn'];
        $result   = [];
        foreach ($statuses as $s) {
            $result[$s] = $this->count_by_status($user_id, $s);
        }
        return $result;
    }

    // Get recent applications
    public function get_recent($user_id, $limit = 5) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get($this->table)->result();
    }

    // Get follow-ups due today or overdue
    public function get_followups_today($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('follow_up_date <=', date('Y-m-d'));
        $this->db->where('follow_up_date IS NOT NULL', NULL, FALSE);
        $this->db->where_in('status', ['Applied','Shortlisted','Interview']);
        $this->db->order_by('follow_up_date', 'ASC');
        return $this->db->get($this->table)->result();
    }
}