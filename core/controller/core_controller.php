<?php

// コントローラの基底クラス
class core_controller {

    public $config = array();

    /**
     * construct
     *
     * @param
     * @return
     */
    public function __construct() {
        $this->library('log');
    }

    /**
     * deconstruct
     *
     * @param
     * @return
     */
    public function __destruct() {
    }

    /**
     * モデルロード
     *
     * @param
     * @return
     */
    public function model($model) {
        $fn = APP_PATH . "/model/{$model}.php";
        if (file_exists($fn)) {
            require_once($fn);
            $this->{$model} = new $model;
        }
    }

    /**
     * ライブラリロード
     *
     * @param
     * @return
     */
    public function library($library) {
        $fn = APP_PATH . "/library/{$library}.php";
        if (file_exists($fn)) {
            require_once($fn);
            $this->{$library} = new $library;
        } else {
            $fn = SYSTEM_PATH . "/library/{$library}.php";
            if (file_exists($fn)) {
                require_once($fn);
                $this->{$library} = new $library;
            }
        }
    }

    /**
     * ビューロード
     *
     * @param
     * @return
     */
    public function view($view, $params = array()) {
        $fn = APP_PATH . "/view/{$view}.php";
        if (file_exists($fn)) {
            extract($params);
            include_once($fn);
        }
    }
}

