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
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getEstudiantes();
        for ($i = 0; $i < count($data); $i++) {
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
            if (array_key_exists($data[$i]['modalidad'], $modalidades)) {
                $data[$i]['modalidad'] = $modalidades[$data[$i]['modalidad']];
            } 

            if ($data[$i]['estado'] == 1) {
                if  ($data[$i]['n_ingreso'] == 1) {
                    $data[$i]['estado'] = '<span class="badge badge-success">Nuevo Ingreso</span>';
                } else {
                    $data[$i]['estado'] = '<span class="badge badge-success">Reinscrito</span>';
                }
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarEst(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarEst(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Baja</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarEst(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $matricula = strClean($_POST['matricula']);
        $semestre = strClean($_POST['sem']);
        $nombre = strClean($_POST['nombre']);
        $modalidad = strClean($_POST['modalidad']);
        $carrera = strClean($_POST['carrera']);
        $telefono = strClean($_POST['telefono']);
        $id = strClean($_POST['id']);
        if (empty($matricula) || empty($semestre) ||  empty($nombre) ||  empty($modalidad) || empty($carrera)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        } else {
            if ($id == "") {
                    $data = $this->model->insertarEstudiante($matricula, $nombre, $carrera, $telefono, $semestre, $modalidad);
                    if ($data == "ok") {
                        $msg = array('msg' => 'Estudiante registrado', 'icono' => 'success');
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'El estudiante ya existe', 'icono' => 'warning');
                    } else {
                        $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                    }
            } else {
                $data = $this->model->actualizarEstudiante($matricula, $nombre, $carrera, $telefono, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Estudiante modificado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
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
        if (is_numeric($id_estu)) {
            $data = $this->model->getEstudianteMatricula($id_estu);
            if (!empty($data)) {
                $msg = array('nombre' => $data['nombre'], 'carrera' => $data['carrera'], 'icono' => 'success');
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
