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
    public function insertarEstudiante($matricula, $nombre, $carrera, $telefono, $semestre, $modalidad)
    {
        
        $verificar = "SELECT * FROM estudiante WHERE matricula = '$matricula'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $query = "INSERT INTO estudiante(matricula, nombre, id_carrera, telefono, semestre, modalidad) VALUES (?,?,?,?,?,?)";
            $datos = array($matricula, $nombre, $carrera, $telefono, $semestre, $modalidad);
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
        $sql = "SELECT e.*, c.nombre as carrera FROM estudiante e INNER JOIN carreras c ON e.id_carrera = c.id WHERE e.id = $id";
        $res = $this->select($sql);
        return $res;
    }
    public function getEstudianteMatricula($matricula)
    {
        $sql = "SELECT e.*, c.nombre as carrera FROM estudiante e INNER JOIN carreras c ON e.id_carrera = c.id WHERE e.matricula = '$matricula'";
        $res = $this->select($sql);
        return $res;
    }
    public function actualizarEstudiante($matricula, $nombre, $carrera, $telefono, $semestre, $modalidad, $id)
    {
        $query = "UPDATE estudiante SET matricula = ?, nombre = ?, id_carrera = ?, telefono = ?, semestre = ?, modalidad = ?  WHERE id = ?";
        $datos = array($matricula, $nombre, $carrera, $telefono, $semestre, $modalidad, $id);
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

    public function getMatriculas()
    {
        $sql = "SELECT matricula FROM estudiante";
        $res = $this->selectAll($sql);
        return $res;
    }
}
