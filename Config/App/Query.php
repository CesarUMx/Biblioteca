<?php
class Query extends Conexion{
    private $pdo, $con, $sql, $datos;
    public function __construct() {
        $this->pdo = new Conexion();
        $this->con = $this->pdo->conect();
    }
    public function select(string $sql)
    {
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        $resul->execute();
        $data = $resul->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public function selectBind(string $sql, array $params = []) {
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        // Vincular parámetros si existen
        foreach ($params as $key => &$val) {
            $resul->bindParam($key, $val);
        }
        $resul->execute();
        $data = $resul->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    
    public function selectAll(string $sql)
    {
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        $resul->execute();
        $data = $resul->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function save(string $sql, array $datos)
    {
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql);
        $data = $insert->execute($this->datos);
        if ($data) {
            $res = 1;
        }else{
            $res = 0;
        }
        return $res;
    }
    public function saveBind(string $sql, array $datos) {
        $this->sql = $sql;
        $this->datos = $datos;
        
        $insert = $this->con->prepare($this->sql);
    
        // Vincular parámetros con bindParam
        foreach ($this->datos as $key => &$val) {
            $insert->bindParam($key, $val);
        }
    
        $data = $insert->execute();
    
        return ($data) ? 1 : 0;
    }
    
    public function insert(string $sql, array $datos)
    {
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql);
        $data = $insert->execute($this->datos);
        if ($data) {
            $res = $this->con->lastInsertId();;
        } else {
            $res = 0;
        }
        return $res;
    }
}


?>