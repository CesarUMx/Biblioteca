<?php
class EstudiantesModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }
    public function getEstudiantes()
    {
        $sql = "SELECT e.*, c.nombre as carrera FROM estudiante e INNER JOIN carreras c ON e.id_carrera = c.id";
        $res = $this->selectAll($sql);
        return $res;
    }
    public function insertarEstudiante($matricula, $nombre, $carrera, $telefono)
    {
        
        $verificar = "SELECT * FROM estudiante WHERE matricula = '$matricula'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $query = "INSERT INTO estudiante(matricula,nombre,carrera,telefono) VALUES (?,?,?,?)";
            $datos = array($matricula, $nombre, $carrera, $telefono);
            $data = $this->save($query, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        return $res;
    }
    public function editEstudiante($id)
    {
        $sql = "SELECT * FROM estudiante WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }
    public function actualizarEstudiante($matricula, $nombre, $carrera, $telefono, $id)
    {
        $query = "UPDATE estudiante SET matricula = ?, nombre = ?, carrera = ?, telefono = ?  WHERE id = ?";
        $datos = array($matricula, $nombre, $carrera, $telefono, $id);
        $data = $this->save($query, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function estadoEstudiante($estado, $id)
    {
        $query = "UPDATE estudiante SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($query, $datos);
        return $data;
    }
    public function buscarEstudiante($valor)
    {
        $sql = "SELECT id, matricula, nombre AS text FROM estudiante WHERE matricula LIKE '%" . $valor . "%' AND estado = 1 OR nombre LIKE '%" . $valor . "%'  AND estado = 1 LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function buscarCarrera($valor)
    {
        $sql = "SELECT id, nombre AS text FROM carreras WHERE nombre LIKE '%" . $valor . "%' LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
        
    }
    public function verificarPermisos($id_user, $permiso)
    {
        $tiene = false;
        $sql = "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'";
        $existe = $this->select($sql);
        if ($existe != null || $existe != "") {
            $tiene = true;
        }
        return $tiene;
    }
    public function getCarreras($modalidad)
    {
        $sql = "SELECT * FROM carreras WHERE id_modalidad = $modalidad";
        $res = $this->selectAll($sql);
        return $res;    
    }
}
