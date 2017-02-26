<?php

    class test_controller extends app_controller {

        public function index() {
            echo "INDEXメソッド";
            $this->model("test_model");
            $this->test_model->make();
            echo $this->test_model->abc;
        }
        public function aaa($a = "", $b = '', $c = '') {
            $params['controller'] = $this->controller;
            $params['action'] = $this->action;
            $params['param1'] = $a;
            $params['param2'] = $b;
            $params['param3'] = $c;
            $params['member'] = $ret;
            $this->view('test_aaa', $params);
        }
    }

