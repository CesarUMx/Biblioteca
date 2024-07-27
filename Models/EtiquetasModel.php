<?php
class EtiquetasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getEtiquetas()
    {
        $sql = "SELECT l.*, m.materia FROM libro l INNER JOIN materia m ON l.id_materia = m.id WHERE l.etiqueta = 1";
        $res = $this->selectAll($sql);
        return $res;
    }
    public function insertarEtiquetas($estado, $libro)
    {
        $query = "UPDATE libro SET etiqueta = ? WHERE clave = ?";
        $datos = array($estado, $libro);
        $data = $this->save($query, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editEtiquetas($id)
    {
        $sql = "SELECT * FROM libro WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }
    public function estadoEtiquetas($estado, $id)
    {
        $query = "UPDATE libro SET etiqueta = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($query, $datos);
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
    
}
