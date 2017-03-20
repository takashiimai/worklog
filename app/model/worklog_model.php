<?php

class worklog_model extends app_model {

    /**
     * construct
     *
     * @param
     * @return
     */
    public function __construct() {
        parent::__construct();
        $this->library('db');
        $this->db->connect();
    }

    public function get($user_id, $date) {
        $params = array(
            ':user_id'    => $user_id,
            ':work_date' => $date,
        );
        $query  = 'SELECT w.*, p.name AS project_name FROM worklog w ';
        $query .= 'LEFT JOIN project p ON p.id = w.project_id ';
        $query .= 'WHERE w.user_id = :user_id && w.work_date = :work_date ';
        $result = $this->db->select($query, $params);
        if ($this->db->get_found_rows() >= 1) {
            return $result;
        } else {
            return array();
        }
    }


    public function put($params) {

        $query  = 'INSERT INTO worklog (id, user_id, section_id, project_id, type, work_date, work_time, memo) ';
        $query .= 'values (:id, :user_id, :section_id, :project_id, :type, :work_date, :work_time, :memo) ';
        $query .= 'ON DUPLICATE KEY UPDATE ';
        $query .= 'user_id = :user_id, section_id = :section_id, project_id = :project_id, type = :type, work_date = :work_date, work_time = :work_time, memo = :memo ';
        $result = $this->db->query($query, $params);

    }

}

