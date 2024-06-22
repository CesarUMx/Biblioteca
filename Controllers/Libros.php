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
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getLibros();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div class="d-flex">
                <button class="btn btn-primary" type="button" onclick="btnEditarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                <div/>';
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
        $id = strClean($_POST['id']);
        if (empty($titulo) || empty($autor) || empty($editorial) || empty($materia) || empty($clasificacion) || empty($isbn)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        } else {
            if ($id == "") {
                // generar la variable $clave preguntando el ultimo id de la tabla libro (usar la funcion del modelo lastId) y sumarle 1 y al fiNAL colocar 01 y esete valor se incrementara con el campo cantidad
                $clave = $this->model->lastId();
                $clave = $clave['id'] + 1;
                $nuevosDigitos = '01';
                $clave = $clave . $nuevosDigitos;


                for ($i = 0; $i < $cantidad; $i++) {
                    $data = $this->model->insertarLibros($clasificacion, $isbn, $titulo, $autor, $editorial, $materia, $num_pagina, $anio_edicion, $descripcion, $clave);
                    
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
                $data = $this->model->actualizarLibros($clasificacion, $isbn, $titulo, $autor, $editorial, $materia, $num_pagina, $anio_edicion, $descripcion, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Libro modificado', 'icono' => 'success');
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
        $data = $this->model->editLibros($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar($id)
    {
        $data = $this->model->estadoLibros(0, $id);
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
        $data = $this->model->estadoLibros(1, $id);
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
}
