<?php
class BuscarModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLibros()
    {
        try {
            $sql = "SELECT l.*, m.materia FROM libro l INNER JOIN materia m ON l.id_materia = m.id";
            $res = $this->selectAll($sql);
            
            if (!$res) {
                throw new Exception("No se encontraron libros.");
            }

            return $res;
        } catch (Exception $e) {
            // Devuelve un array con el error en lugar de interrumpir la ejecución
            return ["success" => false, "error" => $e->getMessage()];
        }
    }
}