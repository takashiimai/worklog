<?php

class app_model extends core {

    /**
     * construct
     *
     * @param
     * @return
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * deconstruct
     *
     * @param
     * @return
     */
    public function __destruct () {
        parent::__destruct();
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
        }
    }

}

