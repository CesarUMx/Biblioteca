<?php
class Etiquetas extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "Etiquetas");
        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getEtiquetas();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] = '<div class="d-flex">
            <button class="btn btn-danger" type="button" onclick="btnEliminarEtiqueta(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
            <div/>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $libro = strClean($_POST['libro']);
     
        if (empty($libro)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        } else {
           
            $data = $this->model->insertarEtiquetas(1, $libro);
                    
            if ($data == "ok") {
                $clave++;
                $msg = array('msg' => 'Libro agregado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al registrar', 'icono' => 'error', 'clave' => $clave);
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar($id)
    {
        $data = $this->model->estadoEtiquetas(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Libro descartado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function pdf()
    {
        $data = $this->model->getEtiquetas();
        // $datos = $this->model->selectDatos();
        // $prestamo = $this->model->selectPrestamoDebe();
        // if (empty($prestamo)) {
        //     header('Location: ' . base_url . 'Configuracion/vacio');
        // }
        require_once 'Libraries/pdf/fpdf.php';
        $pdf = new FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(7.6, 12.7, 7.6);
        $pdf->SetTitle("Etiquetas portada");
        $pdf->SetFont('Arial', 'B', 18);
        
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetFillColor(220, 220, 220);

        // Calculamos el número de cuadros que caben horizontalmente y verticalmente en la página
        $cuadro_ancho = 45; // 4.4 cm
        $cuadro_alto = 13;  // 1.3 cm
        $margen_derecho = 6; 

       // Calculamos el número de cuadros por fila y por columna
        $ancho_total = $pdf->GetPageWidth() - 15.2; // Ancho de la página menos márgenes laterales
        $num_cuadros_fila = floor($ancho_total / ($cuadro_ancho + $margen_derecho));
        $num_cuadros_columna = floor(($pdf->GetPageHeight() - 20) / $cuadro_alto); // -20 mm (10 mm de margen superior e inferior)

        // Generar los cuadros
        for ($fila = 0; $fila < $num_cuadros_columna; $fila++) {
            for ($columna = 0; $columna < $num_cuadros_fila; $columna++) {
                $pdf->Cell($cuadro_ancho, $cuadro_alto, '', 1, 0, 'C', true); // Crea un cuadro
                if ($columna < $num_cuadros_fila - 1) {
                    $pdf->Cell($margen_derecho, $cuadro_alto, '', 0, 0); // Espacio entre cuadros
                }
            }
            $pdf->Ln(); // Mover a la siguiente línea
        }
        // foreach ($prestamo as $row) {
        //     $pdf->Cell(14, 5, $contador, 1, 0, 'L');
        //     $pdf->Cell(50, 5, $row['nombre'], 1, 0, 'L');
        //     $pdf->Cell(87, 5, utf8_decode($row['titulo']), 1, 0, 'L');
        //     $pdf->Cell(30, 5, $row['fecha_prestamo'], 1, 0, 'L');
        //     $pdf->Cell(15, 5, $row['cantidad'], 1, 1, 'L');
        //     $contador++;
        // }
        $pdf->Output("prestamos.pdf", "I");
    }
}
