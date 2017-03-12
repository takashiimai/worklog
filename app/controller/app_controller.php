<?php

// コントローラの基底クラス
class app_controller extends core {

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
    public function __destruct() {
        parent::__destruct();
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
            include_once(APP_PATH . "/view/header.php");
            include_once($fn);
            include_once(APP_PATH . "/view/footer.php");
        }
    }

}

// コントローラの基底クラス 管理画面用
class admin_controller extends core {

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
    public function __destruct() {
        parent::__destruct();
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
            include_once(APP_PATH . "/view/admin/header.php");
            include_once($fn);
            include_once(APP_PATH . "/view/admin/footer.php");
        }
    }
}

