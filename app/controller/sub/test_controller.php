<?php

    class test_controller extends app_controller {

        public function index($a = "", $b = '', $c = '') {
            $cnt = $this->session->get('count');
            $cnt++;
            $this->session->set('count', $cnt);

            echo "subXメソッド";
            $this->model("test_model");
            $this->test_model->make();
            echo $this->test_model->abc;

            $this->library('db', 'asobi');
            $this->asobi->connect('asobi');
            $ret = $this->asobi->select('SELECT * FROM plan');
            $this->log->info($ret);

            $params['controller'] = $this->controller;
            $params['action'] = $this->action;
            $params['param1'] = $a;
            $params['param2'] = $b;
            $params['param3'] = $cnt;
            $params['member'] = $ret;
            $this->view('test_aaa', $params);
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
        public function bbb($a = "", $b = '', $c = '') {
            $this->model("sub/test99_model");
            $this->test99_model->make2();
            echo $this->test99_model->abc;
            exit;
        }
    }

