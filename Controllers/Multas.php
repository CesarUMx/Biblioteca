<?php
class Multas extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "Multas");
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
        $data = $this->model->getMultas();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['dias'] = $data[$i]['dias'] . " días";
            $data[$i]['c_multa'] = "$ " . $data[$i]['c_multa'] . ".00";
            $data[$i]['acciones'] = '<div class="d-flex">
            <button class="btn btn-success" type="button" onclick="btnPagado(' . $data[$i]['id'] . ');" ><i class="fa fa-money"></i></button>
            <div/>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function pagada($id)
    {
        $data = $this->model->pagarMulta(0, $id);
        if ($data == "1") {
            $msg = array('msg' => 'Multa pagada', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al registrar el pago', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ticked($id_prestamo)
    {
        // Habilitar el modo de depuración (para desarrollo)
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $datos = $this->model->selectDatos();
        $prestamo = $this->model->getPrestamoLibro($id_prestamo);

        if (empty($prestamo)) {
            header('Location: '.base_url. 'Configuracion/vacio');
            exit;
        }
        require_once 'Libraries/pdf/fpdf.php';
        //$pdf = new FPDF('P', 'mm', array(80, 200));
        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        //$pdf->SetMargins(5, 5, 5);
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle("Prestamos");
        $pdf->SetFont('Arial', 'B', 12);
    
         // Información del encabezado
        $pdf->Cell(0, 10, utf8_decode($datos['nombre']), 0, 1, 'C');

        // Información de contacto
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 10, utf8_decode("Teléfono: "), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, utf8_decode($datos['telefono']), 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 10, utf8_decode("Dirección: "), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, utf8_decode($datos['direccion']), 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 10, "Correo: ", 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, utf8_decode($datos['correo']), 0, 1, 'L');

        $pdf->Ln(5);

        // Detalle de Prestamos
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 10, "Detalle de Prestamos", 1, 1, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Cell(170, 10, 'Libros', 1, 0, 'L');
        $pdf->Cell(26, 10, 'Cant.', 1, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(170, 10, utf8_decode($prestamo['titulo']), 1, 0, 'L');
        $pdf->Cell(26, 10, $prestamo['cantidad'], 1, 1, 'L');
        $pdf->Ln(5);

        // Información del Estudiante
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 10, "Estudiante", 1, 1, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Cell(90, 10, 'Nombre', 1, 0, 'L');
        $pdf->Cell(106, 10, 'Carrera', 1, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(90, 10, utf8_decode($prestamo['nombre']), 1, 0, 'L');
        $pdf->Cell(106, 10, utf8_decode($prestamo['carrera']), 1, 1, 'L');
        $pdf->Ln(5);

        // Fecha de Prestamo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, utf8_decode('Fecha Devolución'), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $prestamo['fecha_devolucion'], 0, 1, 'C');

        // Salida del PDF
        $pdf->Output("prestamos.pdf", "I");
    }
    
}
