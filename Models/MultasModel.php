<?php
class MultasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getMultas()
    {
        $sql = "SELECT m.*, p.* FROM multas m INNER JOIN prestamo p ON m.id_prestamo = p.id WHERE m.Estado = 1";
        $res = $this->selectAll($sql);
        return $res;
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
    public function getPrestamoLibro($id_prestamo)
    {
        $sql = "SELECT e.id, e.matricula, e.nombre, c.nombre as carrera, l.clave, l.titulo, p.id, p.id_estudiante, p.id_libro, p.fecha_prestamo, p.fecha_devolucion, p.cantidad, p.observacion, p.renovacion, p.estado FROM estudiante e INNER JOIN libro l INNER JOIN carreras c INNER JOIN prestamo p ON p.id_estudiante = e.id WHERE p.id_libro = l.id AND e.id_carrera = c.id AND p.id = $id_prestamo";
        $res = $this->select($sql);
        return $res;
    }

    //renovar fecha de devolucion y observacion
    public function renovarPrestamo($id, string $fecha_devolucion, string $observacion, $renovacion)
    {
        $sql = "UPDATE prestamo SET fecha_devolucion = ?, observacion = ?, renovacion = ? WHERE id = ?";
        $datos = array($fecha_devolucion, $observacion, $renovacion, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    
}
