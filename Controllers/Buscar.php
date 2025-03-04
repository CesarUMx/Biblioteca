<?php
class Buscar extends Controller
{
    public function __construct()
    {
        session_start(); // Inicia la sesión si no está iniciada
        parent::__construct(); // Llama al constructor de la clase padre
    }

    public function listar()
    {
        try {
            $data = $this->model->getLibros();
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]['cantidad'] == 1) {
                    $data[$i]['cantidad'] = '<span class="badge badge-success" style="font-size: 12px;">Disponible</span>';
                } else {
                    $data[$i]['cantidad'] = '<span class="badge badge-warning" style="font-size: 12px;">No disponible</span>';
                }
                if ($data[$i]['tipo'] == 1) {
                    $data[$i]['tipo'] = '<span class="badge badge-dark" style="font-size: 12px;">Fisico</span>';
                } else {
                    $data[$i]['tipo'] = '<span class="badge badge-info" style="font-size: 12px;">E-Book</span>';
                }
            }
            // Verifica si $data es un array o un resultado válido
            if (!is_array($data)) {
                throw new Exception("Error al recuperar los datos.");
            }

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            // Devuelve una respuesta JSON con el error
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
        die();
    }
}
?>
