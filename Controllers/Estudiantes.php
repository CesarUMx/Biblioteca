<?php
class Estudiantes extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "Estudiantes");
        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }
    }
    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $create = $this->model->verificarPermisos($id_user, "crearEstudiante");
        $data = ['create' => $create];
        $this->views->getView($this, "index", $data);
    }
    public function listar()
{
    $data = $this->model->getEstudiantes();
    $modalidades = [
        1 => 'Licenciatura',
        2 => 'Doctorado',
        3 => 'Maestría',
        4 => 'Duales',
        5 => 'Ejecutivas',
        6 => 'Preparatoria',
        7 => 'Docente',
        8 => 'Administrativos'
    ];

    for ($i = 0; $i < count($data); $i++) {
        // Asignar modalidad si existe en el array de modalidades
        if (array_key_exists($data[$i]['modalidad'], $modalidades)) {
            $data[$i]['modalidad'] = $modalidades[$data[$i]['modalidad']];
        }

        $estado = $data[$i]['estado'];
        $modalidad = $data[$i]['modalidad'];
        $n_ingreso = $data[$i]['n_ingreso'];
        $id = $data[$i]['id'];
        $id_user = $_SESSION['id_usuario'];
        $edit = $this->model->verificarPermisos($id_user, "editarEstudiante");
        $delete = $this->model->verificarPermisos($id_user, "eliminarEstudiante");

        if ($estado == 1) {
            if ($modalidad != 'Administrativos' && $modalidad != 'Docente') {
                $data[$i]['estado'] = $n_ingreso == 1 ? '<span class="badge badge-success">Nuevo Ingreso</span>' : '<span class="badge badge-success">Reinscrito</span>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
            }

            $data[$i]['acciones'] = '<div>';
            if ($edit || $id_user == 1) {
                $data[$i]['acciones'] .= '<button class="btn btn-primary" type="button" onclick="btnEditarEst(' . $id . ');"><i class="fa fa-pencil-square-o"></i></button>';
            }
            if ($delete || $id_user == 1) {
                $data[$i]['acciones'] .= '<button class="btn btn-danger" type="button" onclick="btnEliminarEst(' . $id . ');"><i class="fa fa-trash-o"></i></button>';
            }
            $data[$i]['acciones'] .= '<div/>';
        } else {
            $data[$i]['estado'] = '<span class="badge badge-danger">Baja</span>';
            $data[$i]['acciones'] = '<div>
            <button class="btn btn-success" type="button" onclick="btnReingresarEst(' . $id . ');"><i class="fa fa-reply-all"></i></button>
            <div/>';
        }
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
}

    public function registrar()
    {
        try {
            $matricula = strClean($_POST['matricula']);
            $semestre = strClean($_POST['sem']);
            $nombre = strClean($_POST['nombre']);
            $modalidad = strClean($_POST['modalidad']);
            $carrera = strClean($_POST['carrera']);
            $telefono = strClean($_POST['telefono']);
            $id = strClean($_POST['id']);

            // Validación de campos
            if (empty($matricula)) {
                throw new Exception('El campo "matrícula" es requerido');
            }
            if (empty($nombre)) {
                throw new Exception('El campo "nombre" es requerido');
            }
            if (empty($modalidad)) {
                throw new Exception('El campo "modalidad" es requerido');
            }
            if (empty($carrera)) {
                throw new Exception('El campo "carrera" es requerido');
            }

            if ($id == "") {
                // Inserción de nuevo estudiante
                $data = $this->model->insertarEstudiante($matricula, $nombre, $carrera, $telefono, $semestre, $modalidad);
                if ($data == "ok") {
                    $msg = array('msg' => 'Estudiante registrado', 'icono' => 'success');
                } elseif ($data == "existe") {
                    throw new Exception('El estudiante ya existe');
                } else {
                    throw new Exception('Error al registrar el estudiante');
                }
            } else {
                // Actualización de estudiante existente
                $data = $this->model->actualizarEstudiante($matricula, $nombre, $carrera, $telefono, $semestre, $modalidad, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Estudiante modificado', 'icono' => 'success');
                } else {
                    throw new Exception('Error al modificar el estudiante');
                }
            }
        } catch (Exception $e) {
            $msg = array('msg' => $e->getMessage(), 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($id)
    {
        $data = $this->model->editEstudiante($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar($id)
    {
        $data = $this->model->estadoEstudiante(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Estudiante dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar($id)
    {
        $data = $this->model->estadoEstudiante(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Estudiante restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscarCarrera()
    {

        if (isset($_GET['q'])) {
            $valor = $_GET['q'];
            $data = $this->model->buscarCarrera($valor);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function carreras()
    {
        $modalidad = isset($_GET['modalidad']) ? $_GET['modalidad'] : '';
        $data = $this->model->getCarreras($modalidad);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function verificar($id_estu)
    {
        // modalidades
        $modalidades = [
            1 => 'Licenciatura',
            2 => 'Doctorado',
            3 => 'Maestría',
            4 => 'Duales',
            5 => 'Ejecutivas',
            6 => 'Preparatoria',
            7 => 'Docente',
            8 => 'Administrativos'
            
        ];
        
        if ($id_estu != "") {
            $data = $this->model->getEstudianteMatricula($id_estu);
            if (array_key_exists($data['modalidad'], $modalidades)) {
                $data['modalidad'] = $modalidades[$data['modalidad']];
            } 
            if (!empty($data)) {
                $msg = array('nombre' => $data['nombre'], 'carrera' => $data['carrera'], 'modalidad' => $data['modalidad'],'icono' => 'success');
            }
        }else{
            $msg = array('msg' => 'Error Fatal', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // crear un componente datalist con todas las matriculas de los estudiantes
    public function matriculas()
    {
        $data = $this->model->getMatriculas();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
