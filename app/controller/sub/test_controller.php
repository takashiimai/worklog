<?php

    class test_controller extends app_controller {

        public function index() {
            echo "subXメソッド";
            $this->model("test_model");
            $this->test_model->make();
            echo $this->test_model->abc;
        }
        public function aaa($a = "", $b = '', $c = '') {
            $params['aaaa'] = $a;
            $params['bbbb'] = $b;
            $params['cccc'] = $c;
            $this->view('test_aaa', $params);
        }
    }

