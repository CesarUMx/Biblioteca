<?php
class Libros extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "Libros");
        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }
    }
    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $create = $this->model->verificarPermisos($id_user, "crearLibro");
        $data = ['create' => $create];
        $this->views->getView($this, "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getLibros();
        $id_user = $_SESSION['id_usuario'];
        $edit = $this->model->verificarPermisos($id_user, "editarLibro");
        $delete = $this->model->verificarPermisos($id_user, "eliminarLibro");

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                if ($data[$i]['cantidad'] == 1) {
                    $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $data[$i]['estado'] = '<span class="badge badge-warning">No disponible</span>';
                }
                $data[$i]['acciones'] = '<div class="d-flex">';
                if ($edit || $id_user == 1) {
                    $data[$i]['acciones'] .= '<button class="btn btn-primary" type="button" onclick="btnEditarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>';
                }
                if ($delete || $id_user == 1) {
                    $data[$i]['acciones'] .= '<button class="btn btn-danger" type="button" onclick="btnEliminarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>';
                }
                $data[$i]['acciones'] .= '</div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $clasificacion = strClean($_POST['clasificacion']);
        $isbn = strClean($_POST['isbn']);
        $titulo = strClean($_POST['titulo']);
        $autor = strClean($_POST['autor']);
        $editorial = strClean($_POST['editorial']);
        $materia = strClean($_POST['materia']);
        $cantidad = strClean($_POST['cantidad']);
        $num_pagina = strClean($_POST['num_pagina']);
        $anio_edicion = strClean($_POST['anio_edicion']);
        $descripcion = strClean($_POST['descripcion']);
        $adquisicion = strClean($_POST['adquisicion']);
        $clave = strClean($_POST['clave']);
        $id = strClean($_POST['id']);
        if (empty($titulo) || empty($autor) || empty($editorial) || empty($materia) || empty($clasificacion) || empty($isbn) || empty($adquisicion)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        } else {
            if ($id == "") {
                // generar la variable $clave preguntando el ultimo id de la tabla libro (usar la funcion del modelo lastId) y sumarle 1 y al fiNAL colocar 01 y esete valor se incrementara con el campo cantidad
                $clave = $this->model->lastId();
                $clave = $clave['id'] + 1;
                $nuevosDigitos = '01';
                $clave = $clave . $nuevosDigitos;


                for ($i = 0; $i < $cantidad; $i++) {
                    $data = $this->model->insertarLibros($clasificacion, $isbn, $titulo, $autor, $editorial, $materia, $num_pagina, $anio_edicion, $descripcion, $clave, $adquisicion);
                    
                    if ($data == "ok") {
                        $clave++;
                        $msg = array('msg' => 'Libro registrado', 'icono' => 'success');
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'El libro ya existe', 'icono' => 'warning', 'clave' => $clave);
                    } else {
                        $msg = array('msg' => 'Error al registrar', 'icono' => 'error', 'clave' => $clave);
                    }
                }
            } else {
                if (empty($clave)) {
                    $msg = array('msg' => 'La clave es requerida', 'icono' => 'warning');
                }else{
                    $data = $this->model->actualizarLibros($clave, $clasificacion, $isbn, $titulo, $autor, $editorial, $materia, $num_pagina, $anio_edicion, $descripcion, $id, $adquisicion);
                    if ($data == "modificado") {
                        $msg = array('msg' => 'Libro modificado', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                    }
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar($id)
    {
        $data = $this->model->editLibros($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar($id)
    {
        $id_limpio = strClean($id);
        $data = $this->model->estadoLibros(0, $id_limpio);
        if ($data == 1) {
            $msg = array('msg' => 'Libro dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar($id)
    {
        $id_limpio = strClean($id);
        $data = $this->model->estadoLibros(1, $id_limpio);
        if ($data == 1) {
            $msg = array('msg' => 'Libro restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function verificar($id_libro)
    {
        if (is_numeric($id_libro)) {
            $data = $this->model->getLibroClave($id_libro);
            if (!empty($data)) {
                $msg = array('titulo' => $data['titulo'], 'icono' => 'success');
            }
        }else{
            $msg = array('msg' => 'Error Fatal', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function claves()
    {
        $data = $this->model->getClaves();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function pdf()
    {
        $data = $this->model->getAll();
        
        require_once('Libraries/PDF.php');
        
        $pdf = new PDF('L', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle("Libros");
        $pdf->SetFont('Arial', 'B', 8);
        
        // Configurar anchos de columnas
        $pdf->SetWidths(array(25, 50, 40, 35, 15, 35, 25, 20));
        $pdf->SetAligns(array('C', 'L', 'L', 'L', 'C', 'C', 'C', 'C'));
        
        // Encabezados
        $pdf->SetFillColor(233, 229, 235);
        $pdf->Cell(25, 8, 'Clasificacion', 1, 0, 'C', true);
        $pdf->Cell(50, 8, 'Titulo', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Autor/es', 1, 0, 'C', true);
        $pdf->Cell(35, 8, 'Editorial', 1, 0, 'C', true);
        $pdf->Cell(15, 8, utf8_decode('Año'), 1, 0, 'C', true);
        $pdf->Cell(35, 8, 'Categoria', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'Disponibilidad', 1, 0, 'C', true);
        $pdf->Cell(20, 8, 'Tipo', 1, 1, 'C', true);
        
        $pdf->SetFont('Arial', '', 7);
        foreach ($data as $row) {
            $disponibilidad = ($row['estado'] == 1) ? 'Disponible' : 'Prestado';
            $tipo = ($row['tipo'] == 1) ? 'Libro' : 'Ebook';
            
            $pdf->Row(array(
                $row['clasificacion'],
                utf8_decode($row['titulo']),
                utf8_decode($row['autores']),
                utf8_decode($row['editorial']),
                $row['anio_edicion'],
                utf8_decode($row['materia']),
                $disponibilidad,
                $tipo
            ));
        }
        
        $pdf->Output('Libros.pdf', 'I');
    }
}
