<?php
class LibrosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getLibros()
    {
        $sql = "SELECT l.*, m.materia FROM libro l INNER JOIN materia m ON l.id_materia = m.id";
        $res = $this->selectAll($sql);
        return $res;
    }
    public function insertarLibros($clasificacion, $isbn, $titulo, $autor, $editorial, $materia, $num_pagina, $anio_edicion, $descripcion, $clave, $adquisicion)
    {
        $verificar = "SELECT * FROM libro WHERE clave = '$clave'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
             $query = "INSERT INTO libro(titulo, autores, editorial, id_materia, anio_edicion, num_pagina, descripcion, clasificacion, clave, isbn, adquisicion) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
             $datos = array($titulo, $autor, $editorial, $materia, $anio_edicion, $num_pagina, $descripcion, $clasificacion, $clave, $isbn, $adquisicion);
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
    public function editLibros($id)
    {
        $sql = "SELECT * FROM libro WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }
    public function getLibroClave($clave)
    {
        $sql = "SELECT * FROM libro WHERE clave = $clave";
        $res = $this->select($sql);
        return $res;
    }
    public function actualizarLibros($clasificacion, $isbn, $titulo, $autor, $editorial, $materia, $num_pagina, $anio_edicion, $descripcion, $id)
    {
        $query = "UPDATE libro SET titulo = ?, autores = ?, editorial = ?, id_materia = ?, anio_edicion = ?, num_pagina = ?, descripcion = ?, clasificacion = ?, isbn = ? WHERE id = ?";
        $datos = array($titulo, $autor, $editorial, $materia, $anio_edicion, $num_pagina, $descripcion, $clasificacion, $isbn, $id);

        // Intentar ejecutar la consulta
        try {
            $data = $this->save($query, $datos);
        } catch (Exception $e) {
            // Capturar cualquier excepción y mostrar el mensaje de error
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return "error";
        }

        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function estadoLibros($estado, $id)
    {
        $query = "UPDATE libro SET estado = ? WHERE id = ?";
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
    // funcion para obtener el ultimo id de la tabla libro
    public function lastId()
    {
        $sql = "SELECT MAX(id) AS id FROM libro";
        $res = $this->select($sql);
        return $res;
    }

    public function getClaves()
    {
        $sql = "SELECT clave FROM libro";
        $res = $this->selectAll($sql);
        return $res;
    }
    
}
