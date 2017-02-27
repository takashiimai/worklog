<?php

class index_controller extends app_controller {

    public function index($a = "", $b = '', $c = '') {
        $this->model('sub/member_model');
        $result = $this->member_model->get_all();
        var_dump($result);

        $this->model('sub/account_model');
        $result = $this->account_model->get_all();
        var_dump($result);
    }
}

