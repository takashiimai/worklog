<?php

// コントローラの基底クラス
class core {

    public $config = array();
    public $directory = '';
    public $controller = '';
    public $action = '';

    /**
     * construct
     *
     * @param
     * @return
     */
    public function __construct() {
        $this->library('log');
        $this->library('db');
        $this->library('request');
        $this->library('session');
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
     * @param   string  モデル名
     * @return
     */
    public function model($model) {
        $fn = APP_PATH . "/model/{$model}.php";
        if (file_exists($fn)) {
            require_once($fn);
            if (strpos($model, '/') !== FALSE) {
                $model = preg_replace("/.*\//", '', $model);
            }
            $this->{$model} = new $model;
        }
    }

    /**
     * ライブラリロード
     *
     * @param   string  ライブラリ名
     * @param   string  ライブラリの別名
     * @return
     */
    public function library($library, $alias = NULL) {
        if (is_null($alias)) {
            $alias = $library;
        }
        $fn = APP_PATH . "/library/{$library}.php";
        if (file_exists($fn)) {
            require_once($fn);
            $this->{$alias} = new $library;
        } else {
            $fn = SYSTEM_PATH . "/library/{$library}.php";
            if (file_exists($fn)) {
                require_once($fn);
                $this->{$alias} = new $library;
            }
        }
    }

    /**
     * ビューロード
     *
     * @param   string  ビューファイル名(.php を除く)
     * @param   array   ビューファイルへ渡すパラメータ
     * @return
     */
    public function view($view, $params = array()) {
        $fn = APP_PATH . "/view/{$view}.php";
        if (file_exists($fn)) {
            extract($params);
            include_once($fn);
        }
    }

    /**
     * リダイレクト
     *
     * @param   string URL
     * @param   string ステータスコード
     * @return
     */
    public function redirect($url, $status = '301') {
        header('Location: ' . $url, true, $status);
        exit;
    }



}

