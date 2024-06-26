<?php
class PrestamosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPrestamos()
    {
        $sql = "SELECT e.matricula, e.nombre, l.clave, l.titulo, p.id, p.fecha_prestamo, p.fecha_devolucion, p.observacion, p.estado FROM estudiante e INNER JOIN libro l INNER JOIN prestamo p ON p.id_estudiante = e.id WHERE p.id_libro = l.id";
        $res = $this->selectAll($sql);
        return $res;
    }
    public function insertarPrestamo($estudiante,$libro, $cantidad, string $fecha_prestamo, string $fecha_devolucion, string $observacion)
    {
        $sql_est = "SELECT id FROM estudiante WHERE matricula = $estudiante"; 
        $res_sql = $this->select($sql_est);
        $id_estudiante = $res_sql['id'];
        $sql_lib = "SELECT id FROM libro WHERE clave = $libro";
        $res_sql_lib = $this->select($sql_lib);
        $id_libro = $res_sql_lib['id'];
        $verificar = "SELECT * FROM prestamo WHERE id_libro = '$libro' AND estado = 1";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $query = "INSERT INTO prestamo(id_estudiante, id_libro, fecha_prestamo, fecha_devolucion, cantidad, observacion) VALUES (?,?,?,?,?,?)";
            $datos = array($id_estudiante, $id_libro, $fecha_prestamo, $fecha_devolucion, $cantidad, $observacion);
            $data = $this->insert($query, $datos);
            if ($data > 0) {
                $lib = "SELECT * FROM libro WHERE id = $libro";
                $resLibro = $this->select($lib);
                $total = $resLibro['cantidad'] - $cantidad;
                $libroUpdate = "UPDATE libro SET cantidad = ? WHERE id = ?";
                $datosLibro = array($total, $libro);
                $this->save($libroUpdate, $datosLibro);
                $res = $data;
            } else {
                $res = 0;
            }
        } else {
            $res = "existe";
        }
        return $res;
    }
    public function actualizarPrestamo($estado, $id)
    {
        $sql = "UPDATE prestamo SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $lib = "SELECT * FROM prestamo WHERE id = $id";
            $resLibro = $this->select($lib);
            $id_libro = $resLibro['id_libro'];
            $lib = "SELECT * FROM libro WHERE id = $id_libro";
            $residLibro = $this->select($lib);
            $total = $residLibro['cantidad'] + $resLibro['cantidad'];
            $libroUpdate = "UPDATE libro SET cantidad = ? WHERE id = ?";
            $datosLibro = array($total, $id_libro);
            $this->save($libroUpdate, $datosLibro);
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function selectDatos()
    {
        $sql = "SELECT * FROM configuracion";
        $res = $this->select($sql);
        return $res;
    }
    public function getCantLibro($libro)
    {
        $sql = "SELECT * FROM libro WHERE clave = $libro";
        $res = $this->select($sql);
        return $res;
    }
    public function selectPrestamoDebe()
    {
        $sql = "SELECT e.id, e.nombre, l.id, l.titulo, p.id, p.id_estudiante, p.id_libro, p.fecha_prestamo, p.fecha_devolucion, p.cantidad, p.observacion, p.estado FROM estudiante e INNER JOIN libro l INNER JOIN prestamo p ON p.id_estudiante = e.id WHERE p.id_libro = l.id AND p.estado = 1 ORDER BY e.nombre ASC";
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
        $sql = "SELECT e.id, e.matricula, e.nombre, c.nombre as carrera, l.clave, l.titulo, p.id, p.id_estudiante, p.id_libro, p.fecha_prestamo, p.fecha_devolucion, p.cantidad, p.observacion, p.estado FROM estudiante e INNER JOIN libro l INNER JOIN carreras c INNER JOIN prestamo p ON p.id_estudiante = e.id WHERE p.id_libro = l.id AND e.id_carrera = c.id AND p.id = $id_prestamo";
        $res = $this->select($sql);
        return $res;
    }

    //renovar fecha de devolucion y observacion
    public function renovarPrestamo($id, string $fecha_devolucion, string $observacion)
    {
        $sql = "UPDATE prestamo SET fecha_devolucion = ?, observacion = ? WHERE id = ?";
        $datos = array($fecha_devolucion, $observacion, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
}
