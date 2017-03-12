<?php

class login_controller extends app_controller {

    public function index() {

        $this->model('user_model');
        $user = $this->user_model->login($this->request->get('email'), $this->request->get('password'));

        echo json_encode($user, JSON_UNESCAPED_UNICODE);
    }
}

