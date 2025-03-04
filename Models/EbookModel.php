<?php
class EbookModel extends Query
{
    public function __construct()
    {
        parent::__construct();
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

    public function lastId()
    {
        $sql = "SELECT MAX(id) AS id FROM libro";
        $res = $this->select($sql);
        return $res;
    }

    public function insertarEbook($clave, $titulo, $clasificacion, $autor, $editorial, $materia, $anio_edicion, $tipo, $archivo_pdf)
    {
        $sql_materia = "SELECT id FROM materia WHERE materia = :materia";
        $res_sql = $this->selectBind($sql_materia, [":materia" => $materia]);
        $materia_id = $res_sql['id'];
        $verificar = "SELECT * FROM libro WHERE clave = :clave";
        $existe = $this->selectBind($verificar, [":clave" => $clave]);
        if (empty($existe)) {
            $query = "INSERT INTO libro (clave, titulo, clasificacion, autores, editorial, id_materia, anio_edicion, tipo, archivo_pdf) 
            VALUES (:clave, :titulo, :clasificacion, :autor, :editorial, :materia, :anio_edicion, :tipo, :archivo_pdf)";
            $datos = [
                ":clave" => $clave,
                ":titulo" => $titulo,
                ":clasificacion" => $clasificacion,
                ":autor" => $autor,
                ":editorial" => $editorial,
                ":materia" => $materia_id,
                ":anio_edicion" => $anio_edicion,
                ":tipo" => $tipo,
                "archivo_pdf" => $archivo_pdf
            ];

            // Guardar en la base de datos
            $data = $this->saveBind($query, $datos);
            return ($data == 1) ? "ok" : "error";
        } else {
            return "existe";
        }
    }

    public function getEbooks()
    {
        $sql = "SELECT l.*, m.materia FROM libro l INNER JOIN materia m ON l.id_materia = m.id WHERE l.tipo = 2";
        $res = $this->selectAll($sql);
        return $res;
    }

    public function editEbooks($id)
    {
        $sql = "SELECT libro.*, materia.materia 
            FROM libro 
            INNER JOIN materia ON libro.id_materia = materia.id 
            WHERE libro.id = :id";
        $res = $this->selectBind($sql, [":id" => $id]);
        return $res;
    }

    public function obtenerEbook($id) {
        $sql = "SELECT archivo_pdf FROM libro WHERE id = :id LIMIT 1";
        $res = $this->selectBind($sql, [":id" => $id]);
        return $res;
    }

    public function actualizarEbook($id, $titulo, $clasificacion, $autor, $editorial, $materia, $anio_edicion, $ruta_destino)
    {
        $sql_materia = "SELECT id FROM materia WHERE materia = :materia";
        $res_sql = $this->selectBind($sql_materia, [":materia" => $materia]);
        $materia_id = $res_sql['id'];
        $query = "UPDATE libro SET titulo = ?, autores = ?, editorial = ?, id_materia = ?, anio_edicion = ?, clasificacion = ?, archivo_pdf = ? WHERE id = ?";
        $datos = array($titulo, $autor, $editorial, $materia_id, $anio_edicion, $clasificacion, $ruta_destino, $id);

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

    public function estadoEbooks($estado, $id)
    {
        $query = "UPDATE libro SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($query, $datos);
        return $data;
    }
    
}