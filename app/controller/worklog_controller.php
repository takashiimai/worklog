<?php

class worklog_controller extends app_controller {

    // 工数読み出し
    public function index() {

        $this->model('worklog_model');
        $worklog = $this->worklog_model->get($this->request->get('user_id'), $this->request->get('date'));

        $this->log->info($worklog);

        echo json_encode($worklog, JSON_UNESCAPED_UNICODE);
    }

    // 工数を保存
    public function put() {

        $this->model('project_model');
        $this->model('worklog_model');

        // 送信されたデータを読み込み
        $worklogs = json_decode(file_get_contents('php://input'), true);
        $this->log->info($worklogs);


        $user_id = $this->request->get('user_id');
        $date    = $this->request->get('date');

        // プロジェクト読み込み
        $_project = $this->project_model->get();
        $project = array();
        foreach ($_project as $key => $value) {
            $project[ $value['name'] ] = $value;
        }
        $this->log->info($project);


        // 工数保存
        foreach ($worklogs as $key => $value) {
            if (!isset($project[ $value['project_name'] ]['id'])) continue;
            $params = array(
                ':id'           => $value['id'],
                ':user_id'      => $user_id,
                ':section_id'   => 1,
                ':project_id'   => $project[ $value['project_name'] ]['id'],
                ':type'         => $value['type'],
                ':work_date'    => $date,
                ':work_time'    => $value['work_time'],
                ':memo'         => $value['memo'],
            );

            $this->log->info($params);
            $this->worklog_model->put($params);
        }

    }

}

