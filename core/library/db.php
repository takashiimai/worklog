<?php

class db {

    protected $db = NULL;

    /**
     * construct
     *
     * @param
     * @return
     */
    public function __construct() {
    }

    /**
     * deconstruct
     *
     * @param
     * @return
     */
    public function __destruct () {
    }

    /**
     * データベース接続
     *
     * @param
     * @return
     */
    public function connect($key = 'default') {
        $dsn  = sprintf("mysql:dbname=%s;host=%s;charset=%s",
                    $GLOBALS['databases'][ $key ]['database'],
                    $GLOBALS['databases'][ $key ]['hostname'],
                    $GLOBALS['databases'][ $key ]['char_set']
                 );
        $user = $GLOBALS['databases'][ $key ]['username'];
        $pwd  = $GLOBALS['databases'][ $key ]['password'];
        $this->db = new PDO($dsn, $user, $pwd);
//        $this->pdo->query('SET NAMES utf8');
    }

    /**
     * データベースからSELECTする
     *
     * @param   string  クエリー
     * @param   array   WHEREのパラメータ ※キーはプレースホルダで指定
     * @return  array
     */
    public function select($sql = NULL, $parameters = array()) {
        $stmt = $this->db->prepare(str_replace(array("SELECT ", "select "), "SELECT SQL_CALC_FOUND_ROWS ", $sql));
        $ret = $stmt->execute($parameters);
        if ($ret) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $sql = 'SELECT FOUND_ROWS() AS count';
            $stmt = $this->db->query($sql);
            $result2 = $stmt->fetch();
            $this->found_rows = $result2['count'];

            return $result;
        } else {
            return array();
        }
    }

    /**
     * データベースにINSERTする
     *
     * @param   string  テーブル名
     * @param   array   INSERTする内容 ※キーは ":".カラム名 の形式
     * @return
     */
    public function insert($tblname = NULL, $parameters = array()) {
        $fmt = "INSERT INTO %s (%s) VALUES(%s);";
        $sql = sprintf(
                $fmt,
                $tblname,
                implode(",", array_map(create_function('$e', 'return "`".trim($e, ":")."`";'), array_keys($parameters))),
                implode(",", array_keys($parameters))
        );
        $stmt = $this->db->prepare($sql);
        $stmt->execute($parameters);

        $sql = 'SELECT last_insert_id() AS id FROM ' . $tblname;
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        $this->last_id = $result['id'];
    }

    /**
     * データベースをUPDATEする
     *
     * @param   string  テーブル名
     * @param   array   UPDATEする時の条件 ※キーは ":".カラム名 の形式
     * @param   array   UPDATEする内容     ※キーは ":".カラム名 の形式
     * @return
     */
    public function update($tblname = NULL, $key = array(), $parameters = array()) {
        $fmt = "UPDATE %s SET %s WHERE %s;";
        $sql = sprintf(
                $fmt,
                $tblname,
                implode(",", array_map(create_function('$e', 'return "`".trim($e, ":")."`" . "=" . $e;'), array_keys($parameters))),
                implode(",", array_map(create_function('$e', 'return "`".trim($e, ":")."`" . "=" . $e;'), array_keys($key)))
        );
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_merge($key, $parameters));
    }
}

