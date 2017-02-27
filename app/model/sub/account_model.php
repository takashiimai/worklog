<?php

class account_model extends app_model {

    /**
     * construct
     *
     * @param
     * @return
     */
    public function __construct() {
        parent::__construct();
        $this->library('db');
        $this->db->connect('asobi');
    }

    public function get_all() {
        return $this->db->select('SELECT * FROM account');
    }
}

