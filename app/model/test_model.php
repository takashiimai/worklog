<?php

class test_model extends app_model {

    public $abc = "";
    /**
     * construct
     *
     * @param
     * @return
     */
    public function __construct() {
        $this->abc = "__construct";
    }

    public function make() {
        $this->abc = "ABCABCABC";
    }

}

