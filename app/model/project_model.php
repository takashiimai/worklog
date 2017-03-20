<?php

class project_model extends app_model {

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

    public function get() {
        $query  = 'SELECT * FROM project ';
        $result = $this->db->select($query);
        return $result;
    }

}

