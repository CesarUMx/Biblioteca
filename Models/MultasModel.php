<?php
class MultasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getMultas()
    {
        $sql = "SELECT m.id AS id, e.matricula, e.nombre, l.clave, l.titulo, m.dias, m.c_multa, m.Estado, p.fecha_devolucion, m.fecha_create, m.recibe, m.obs FROM multas m INNER JOIN prestamo p ON m.id_prestamo = p.id INNER JOIN 
        estudiante e ON p.id_estudiante = e.id INNER JOIN libro l ON p.id_libro = l.id";
        try {
            $res = $this->selectAll($sql);
            return $res;
        } catch (Exception $e) {
            // Manejo de errores
            echo "Error: " . $e->getMessage(); 
        }
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

    public function pagarMulta($estado, $id, $user)
    {
        $query = "UPDATE multas SET Estado = ? , recibe = ? WHERE id = ?";
        $datos = array($estado, $user, $id);
        $data = $this->save($query, $datos);
        return $data;
    }

    public function donarMulta($estado, $id, $user, $donativo)
    {
        $query = "UPDATE multas SET Estado = ? , obs = ?, recibe = ? WHERE id = ?";
        $datos = array($estado, $donativo, $user, $id);
        $data = $this->save($query, $datos);
        return $data;
    }

    public function cancelarMulta($id, $motivo, $user)
    {
        $query = "UPDATE multas SET Estado = 3 , obs = ?, recibe = ? WHERE id = ?";
        $datos = array($motivo, $user, $id);
        $data = $this->save($query, $datos);
        return $data;
    }

    
}
