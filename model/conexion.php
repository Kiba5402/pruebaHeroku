<?php

/**
 * Description of conexion
 *
 * @author CristianDesk
 */
class conexion {

    private $conn;
    private $tipoConn;

    const PG_SQL = 'PG_SQL';

    public function __construct($tipoConn) {
        $this->setTipoConn($tipoConn);
        $this->createConn();
    }

    private function createConn() {
        switch ($this->getTipoConn()) {
            case self::PG_SQL :
                $this->setConn($this->creaConnPGSQL());
                break;
            default:
                break;
        }
    }

    function clearConn() {
        $this->setTipoConn(null);
        $this->setConn(null);
    }

    private function creaConnPGSQL() {
        try {
            
            $host = "ec2-54-235-92-244.compute-1.amazonaws.com";
            $dbname = "dbs23v1rd2lkgv";
            $user = "rhsqpjwdszlryx";
            $passwd = "83df7aee1c7d701ba74a7f3686fc522477caf035afc6f2c9326e3790ff1a9439";
            return pg_connect("host=$host dbname=$dbname user=$user password=$passwd");
        } catch (PDOException $e) {
            $this->clearConn();
            echo "¡Error!: " . $e->getMessage() . "<br/>";
            return null;
        }
    }

    function getConn() {
        return $this->conn;
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

    
