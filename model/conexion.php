<?php

/**
 * Description of conexion
 *
 * @author CristianDesk
 */
class conexion {

    private $user;
    private $pass;
    private $conn;
    private $tipoConn;

    const MY_SQL = 'MY_SQL';

    public function __construct($user, $pass, $tipoConn) {
        $this->setUser($user);
        $this->setPass($pass);
        $this->setTipoConn($tipoConn);
        $this->createConn();
    }

    private function createConn() {
        switch ($this->getTipoConn()) {
            case self::MY_SQL :
                $this->setConn($this->creaConnMysql());
                break;
            default:
                break;
        }
    }

    function clearConn() {
        $this->setUser(null);
        $this->setPass(null);
        $this->setTipoConn(null);
        $this->setConn(null);
    }

    private function creaConnMysql() {
        try {
            return new PDO('mysql:host=localhost;dbname=certificacion', $this->getUser(), $this->getPass());
        } catch (PDOException $e) {
            $this->clearConn();
            echo "¡Error!: " . $e->getMessage() . "<br/>";
            return null;
        }
    }

    function getUser() {
        return $this->user;
    }

    function getPass() {
        return $this->pass;
    }

    function getConn() {
        return $this->conn;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function setConn($conn) {
        $this->conn = $conn;
    }

    function getTipoConn() {
        return $this->tipoConn;
    }

    function setTipoConn($tipoConn) {
        $this->tipoConn = $tipoConn;
    }

}

    
