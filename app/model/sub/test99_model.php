<?php

class test99_model extends app_model {

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

    public function make2() {
        $this->abc = "9999";
    }

}

