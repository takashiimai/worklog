<?php

class user_model extends app_model {

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

    public function login($email, $password) {
        $params = array(
            ':email'    => $email,
            ':password' => $password,
        );
        $result = $this->db->select('SELECT * FROM user WHERE email = :email && password = :password', $params);
        if ($this->db->get_found_rows() == 1) {
            return $result[0];
        } else {
            return array();
        }
    }

}

