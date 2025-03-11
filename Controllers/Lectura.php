<?php
class Lectura extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($id_prestamo)
    {
        $id_prestamo = strClean($id_prestamo);
        $data = $this->model->selectDatos($id_prestamo);
        $this->views->getView($this, "index", $data);
    }

    public function pdf($id_prestamo)
    {
        $id_prestamo = strClean($id_prestamo);
        $data = $this->model->selectPDF($id_prestamo);

        if (empty($data)) {
            die(json_encode(["error" => "No se encontró el libro"]));
        }

        // fecha de devolucion
        $fecha_devolucion = $data["fecha_devolucion"];
        $fecha_actual = date("Y-m-d H:i:s");

        if ($fecha_devolucion < $fecha_actual) {
            die(json_encode(["error" => "Feccha de devolucion vencida"]));
        }

        if (!file_exists($data["archivo_pdf"])) {
            die(json_encode(["error" => "El archivo PDF no existe"]));
        }

        // 📌 Enviar el PDF sin exponer la ruta real
        readfile($data["archivo_pdf"]);
        exit();
    }

}
