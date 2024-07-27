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
}
