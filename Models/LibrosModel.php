<?php
class LibrosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getLibros()
    {
        $sql = "SELECT l.*, m.materia FROM libro l INNER JOIN materia m ON l.id_materia = m.id WHERE l.tipo = 1";
        $res = $this->selectAll($sql);
        return $res;
    }
    public function insertarLibros($clasificacion, $isbn, $titulo, $autor, $editorial, $materia, $num_pagina, $anio_edicion, $descripcion, $clave, $adquisicion)
    {
        $sql_materia = "SELECT id FROM materia WHERE materia = :materia";
        $res_sql = $this->selectBind($sql_materia, [":materia" => $materia]);
        $materia_id = $res_sql['id'];
        $verificar = "SELECT * FROM libro WHERE clave = :clave";
        $existe = $this->selectBind($verificar, [":clave" => $clave]);
        if (empty($existe)) {
             // Insertar nuevo libro
            $query = "INSERT INTO libro (titulo, autores, editorial, id_materia, num_pagina, anio_edicion, descripcion, clasificacion, clave, isbn, adquisicion ) 
                    VALUES (:titulo, :autor, :editorial, :materia, :num_pagina, :anio_edicion, :descripcion, :clasificacion, :clave, :isbn, :adquisicion)";

            // Asignar valores a los parámetros
            $datos = [
            ":titulo" => $titulo,
            ":autor" => $autor,
            ":editorial" => $editorial,
            ":materia" => $materia_id,
            ":num_pagina" => $num_pagina,
            ":anio_edicion" => $anio_edicion,
            ":descripcion" => $descripcion,
            ":clasificacion" => $clasificacion,
            ":clave" => $clave,
            ":isbn" => $isbn,
            ":adquisicion" => $adquisicion
            ];

            // Guardar en la base de datos
            $data = $this->saveBind($query, $datos);
            return ($data == 1) ? "ok" : "error";

        } else {
            return "existe";
        }
    }
    public function editLibros($id)
    {
        $sql = "SELECT libro.*, materia.materia 
            FROM libro 
            INNER JOIN materia ON libro.id_materia = materia.id 
            WHERE libro.id = :id";
        $res = $this->selectBind($sql, [":id" => $id]);
        return $res;
    }
    public function getLibroClave($clave)
    {
        $sql = "SELECT * FROM libro WHERE clave = $clave";
        $res = $this->select($sql);
        return $res;
    }

    public function actualizarLibros($clave, $clasificacion, $isbn, $titulo, $autor, $editorial, $materia, $num_pagina, $anio_edicion, $descripcion, $id, $adquisicion)
    {
        $sql_materia = "SELECT id FROM materia WHERE materia = '$materia'";
        $res_sql = $this->select($sql_materia);
        $materia = $res_sql['id'];
        $query = "UPDATE libro SET clave = ?, titulo = ?, autores = ?, editorial = ?, id_materia = ?, anio_edicion = ?, num_pagina = ?, descripcion = ?, clasificacion = ?, isbn = ?, adquisicion = ? WHERE id = ?";
        $datos = array($clave, $titulo, $autor, $editorial, $materia, $anio_edicion, $num_pagina, $descripcion, $clasificacion, $isbn, $adquisicion, $id);

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
        $sql = "SELECT clave FROM libro WHERE tipo = 1";
        $res = $this->selectAll($sql);
        return $res;
    }

    public function getAll()
    {
        $sql = "SELECT l.*, m.materia FROM libro l INNER JOIN materia m ON l.id_materia = m.id ";
        $res = $this->selectAll($sql);
        return $res;
    }
    
}
