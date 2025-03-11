<?php
class LecturaModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function selectDatos($id_prestamo)
    {
        $sql = "SELECT p.id, e.nombre, p.fecha_devolucion, l.archivo_pdf FROM prestamo p INNER JOIN libro l ON p.id_libro = l.id INNER JOIN estudiante e ON p.id_estudiante = e.id WHERE p.id = $id_prestamo";
        $res = $this->select($sql);
        return $res;
    }
    public function selectPDF($id_prestamo)
    {
        $sql = "SELECT l.archivo_pdf, p.fecha_devolucion FROM prestamo p INNER JOIN libro l ON p.id_libro = l.id WHERE p.id = $id_prestamo";
        $res = $this->select($sql);
        return $res;
    }
}