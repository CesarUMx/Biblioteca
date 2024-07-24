<?php
class Prestamos extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "Prestamos");
        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }

    //boton de tiket pendiente de momento
    //<a class="btn btn-danger" target="_blank" href="'.base_url.'Prestamos/ticked/'. $data[$i]['id'].'"><i class="fa fa-file-pdf-o"></i></a>
    public function listar()
    {
        $data = $this->model->getPrestamos();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                //validar fecha de devolucion con fecha actual
                $fecha_actual = date("Y-m-d");
                if ($fecha_actual > $data[$i]['fecha_devolucion']) {
                    $data[$i]['estado'] = '<span class="badge badge-danger">Atrasado</span>';
                    $renovation = false;
                } else {
                    $renovation = true;
                    if ($data[$i]['renovacion'] == 0) {
                        $data[$i]['estado'] = '<span class="badge badge-info">Prestado</span>';
                    } else {
                        $data[$i]['estado'] = '<span class="badge badge-warning">Renovado</span>';
                    }
                }
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-success" type="button" onclick="btnEntregar(' . $data[$i]['id'] . ');"><i class="fa fa-check-square"></i></button>';

                if ($renovation && $data[$i]['renovacion'] < 3) {
                    $data[$i]['acciones'] .= '<button class="btn btn-primary" type="button" onclick="btnRenovar(' . $data[$i]['id'] . ');"><i class="fa fa-refresh" aria-hidden="true"></i></button>';
                }

                $data[$i]['acciones'] .= '</div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-success">Devuelto</span>';
                $data[$i]['acciones'] = '';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        try {
            $libro = strClean($_POST['libro']);
            $estudiante = strClean($_POST['estudiante']);
            $cantidad = 1;
            $fecha_prestamo = strClean($_POST['fecha_prestamo']);
            $fecha_devolucion = strClean($_POST['fecha_devolucion']);
            $id = strClean($_POST['id']);

            // Validación de campos
            if (empty($libro)) {
                throw new Exception('El campo "libro" es requerido' . $_POST['libro']);
            }
            if (empty($estudiante)) {
                throw new Exception('El campo "estudiante" es requerido');
            }
            if (empty($cantidad)) {
                throw new Exception('El campo "cantidad" es requerido');
            }
            if (empty($fecha_prestamo)) {
                throw new Exception('El campo "fecha de préstamo" es requerido');
            }
            if (empty($fecha_devolucion)) {
                throw new Exception('El campo "fecha de devolución" es requerido');
            }

            if ($id == "") {
                $verificar_cant = $this->model->getCantLibro($libro);
                if ($verificar_cant['cantidad'] >= $cantidad) {
                    $data = $this->model->insertarPrestamo($estudiante, $libro, $cantidad, $fecha_prestamo, $fecha_devolucion);
                    if ($data === "existe") {
                        throw new Exception('El libro ya está prestado');
                    } elseif ($data > 0) {
                        $msg = array('msg' => 'Libro Prestado', 'icono' => 'success', 'id' => $data);
                    } else {
                        throw new Exception('Error al prestar el libro');
                    }
                } else {
                    throw new Exception('El libro ya está prestado');
                }
            } else {
                $renovacion = $this->model->getPrestamoLibro($id);
                if ($renovacion['renovacion'] < 3) {
                    $n_renovaciones = $renovacion['renovacion'] + 1;
                    $fecha_actual = date("Y-m-d");
                    if ($fecha_actual > $renovacion['fecha_devolucion']) {
                        throw new Exception('No se puede renovar un libro atrasado');
                    }

                    $observacion = $renovacion['observacion'] . "Renovación $n_renovaciones: $fecha_actual <br>";
                    $data = $this->model->renovarPrestamo($id, $fecha_devolucion, $observacion, $n_renovaciones);
                    if ($data == "ok") {
                        $msg = array('msg' => 'Fecha renovada', 'icono' => 'success', 'id' => $id);
                    } else {
                        throw new Exception('Error al renovar el préstamo');
                    }
                } else {
                    throw new Exception('No se puede renovar más de 3 veces');
                }
            }
        } catch (Exception $e) {
            $msg = array('msg' => $e->getMessage(), 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function entregar($id)
    {
        $datos = $this->model->actualizarPrestamo(0, $id);
        if ($datos == "ok") {
            $msg = array('msg' => 'Libro recibido', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al recibir el libro', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();

    }

    //GET PRESTAMO ID
    public function getPrestamo($id)
    {
        $data = $this->model->getPrestamoLibro($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function pdf()
    {
        $datos = $this->model->selectDatos();
        $prestamo = $this->model->selectPrestamoDebe();
        if (empty($prestamo)) {
            header('Location: ' . base_url . 'Configuracion/vacio');
        }
        require_once 'Libraries/pdf/fpdf.php';
        $pdf = new FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle("Prestamos");
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(195, 5, utf8_decode($datos['nombre']), 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode("Teléfono: "), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $datos['telefono'], 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode("Dirección: "), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, utf8_decode($datos['direccion']), 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, "Correo: ", 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, utf8_decode($datos['correo']), 0, 1, 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(196, 5, "Detalle de Prestamos", 1, 1, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(14, 5, utf8_decode('N°'), 1, 0, 'L');
        $pdf->Cell(50, 5, utf8_decode('Estudiantes'), 1, 0, 'L');
        $pdf->Cell(87, 5, 'Libros', 1, 0, 'L');
        $pdf->Cell(30, 5, 'Fecha Prestamo', 1, 0, 'L');
        $pdf->Cell(15, 5, 'Cant.', 1, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $contador = 1;
        foreach ($prestamo as $row) {
            $pdf->Cell(14, 5, $contador, 1, 0, 'L');
            $pdf->Cell(50, 5, $row['nombre'], 1, 0, 'L');
            $pdf->Cell(87, 5, utf8_decode($row['titulo']), 1, 0, 'L');
            $pdf->Cell(30, 5, $row['fecha_prestamo'], 1, 0, 'L');
            $pdf->Cell(15, 5, $row['cantidad'], 1, 1, 'L');
            $contador++;
        }
        $pdf->Output("prestamos.pdf", "I");
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
