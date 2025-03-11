<?php
class Ebook extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "Ebook");
        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }
    }
    
    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $create = $this->model->verificarPermisos($id_user, "crearEbook");
        $data = ['create' => $create];
        $this->views->getView($this, "index", $data);
    }

    public function registrarEbook() {
        try {
            // Habilitar registros de error
            ini_set('log_errors', 1);
            ini_set('error_log', 'error_log.txt'); // Guarda errores en este archivo
    
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Inicializar variables de respuesta
                $msg = ["msg" => "Error desconocido", "icono" => "error"];
    
                // 📌 Validar y limpiar datos de entrada
                $id = isset($_POST["id"]) ? strClean($_POST["id"]) : "";
                $titulo = strClean($_POST["titulo"] ?? "");
                $clasificacion = strClean($_POST["clasificacion"] ?? "");
                $autor = strClean($_POST["autor"] ?? "");
                $editorial = strClean($_POST["editorial"] ?? "");
                $materia = strClean($_POST["materia"] ?? "");
                $anio_edicion = strClean($_POST["anio_edicion"] ?? "");
                $tipo = 2; // 2 = Ebook
    
                // Validar campos requeridos
                if (empty($titulo) || empty($autor) || empty($editorial) || empty($materia) || empty($clasificacion)) {
                    throw new Exception("Todos los campos son requeridos");
                }
    
                // 📌 Manejo del archivo PDF
                $ruta_destino = null;

                if (!empty($id)) {
                    $ebook_actual = $this->model->obtenerEbook($id); // Función para obtener datos del ebook
                    if ($ebook_actual) {
                        $ruta_destino = $ebook_actual["archivo_pdf"]; // Mantener el archivo actual
                    }
                }

                if (isset($_FILES["archivo_pdf"]) && $_FILES["archivo_pdf"]["error"] == 0) {
                    $directorio = "uploads/ebooks/";

                    // eliminar archivo actual
                    if (!empty($ruta_destino)) {
                        unlink($ruta_destino);
                    }
                    
                    if (!file_exists($directorio)) {
                        if (!mkdir($directorio, 0777, true)) {
                            throw new Exception("No se pudo crear la carpeta $directorio");
                        }
                    }  
                    
                    $extension = pathinfo($_FILES["archivo_pdf"]["name"], PATHINFO_EXTENSION); // Obtener la extensión
                    if (strtolower($extension) !== "pdf") {
                        throw new Exception("El archivo debe ser un PDF");
                    }
                    $nombre_unico = uniqid('pdf_', true) . "_" . bin2hex(random_bytes(4)); // Generar ID único
                    $archivo_nombre = $nombre_unico . "." . $extension; // Concatenar con la extensión original
                    $ruta_destino = $directorio . $archivo_nombre;
    
                    // Mover el archivo
                    if (!move_uploaded_file($_FILES["archivo_pdf"]["tmp_name"], $ruta_destino)) {
                        throw new Exception("Error al mover el archivo PDF. Código de error: " . $_FILES["archivo_pdf"]["error"]);
                    }
                }

                // 📌 REGISTRO O ACTUALIZACIÓN
                if ($id == "") {
                    // Generar clave única
                    $clave = $this->model->lastId();
                    if (!isset($clave["id"])) {
                        throw new Exception("Error obteniendo el último ID");
                    }
                    $clave = 'D-' . ($clave["id"] + 1) . "01";
    
                    // Insertar ebook
                    $data = $this->model->insertarEbook($clave, $titulo, $clasificacion, $autor, $editorial, $materia, $anio_edicion, $tipo, $ruta_destino);
                    if ($data !== "ok") {
                        throw new Exception("Error al registrar el ebook en la base de datos");
                    }
    
                    $msg = ["msg" => "Ebook registrado correctamente", "icono" => "success", "clave" => $clave];
                } else {
                    // Actualizar ebook
                    $data = $this->model->actualizarEbook($id, $titulo, $clasificacion, $autor, $editorial, $materia, $anio_edicion, $ruta_destino);
                    if ($data !== "modificado") {
                        throw new Exception("Error al modificar el ebook");
                    }
    
                    $msg = ["msg" => "Ebook actualizado correctamente", "icono" => "success"];
                }
    
                echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            } else {
                throw new Exception("Método no permitido");
            }
        } catch (Exception $e) {
            error_log("Error en registrarEbook: " . $e->getMessage());
            echo json_encode(["icono" => "error", "msg" => $e->getMessage()]);
        }
        die();
    }

    public function listar()
    {
        $data = $this->model->getEbooks();
        $id_user = $_SESSION['id_usuario'];
        $edit = $this->model->verificarPermisos($id_user, "editarEbook");
        $delete = $this->model->verificarPermisos($id_user, "eliminarEbook");

        for ($i = 0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {

                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                // vista pdf
                // $data[$i]['pdf'] = '<iframe src="' . $data[$i]['archivo_pdf'] . '" width="100" height="100"></iframe>';
                $data[$i]['pdf'] = '<a href="' . $data[$i]['archivo_pdf'] . '" target="_blank" class="btn btn-info"><i class="fa fa-file-pdf-o"></i></a>';

                $data[$i]['acciones'] = '<div class="d-flex">';
                if ($edit || $id_user == 1) {
                    $data[$i]['acciones'] .= '<button class="btn btn-primary" type="button" onclick="btnEditarEbook(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>';
                }
                if ($delete || $id_user == 1) {
                    $data[$i]['acciones'] .= '<button class="btn btn-danger" type="button" onclick="btnEliminarEbook(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>';
                }
                $data[$i]['acciones'] .= '</div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['pdf'] = '<a href="' . $data[$i]['archivo_pdf'] . '" target="_blank" class="btn btn-info"><i class="fa fa-file-pdf-o"></i></a>';

                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarEbook(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    function generarNombreArchivo($archivo_original) {
        $extension = pathinfo($archivo_original, PATHINFO_EXTENSION); // Obtener la extensión
        $nombre_unico = uniqid('pdf_', true) . "_" . bin2hex(random_bytes(4)); // Generar ID único
        return $nombre_unico . "." . $extension; // Concatenar con la extensión original
    }

    public function editar($id)
    {
        $data = $this->model->editEbooks($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    public function eliminar($id)
    {
        $id_limpio = strClean($id);
        $data = $this->model->estadoEbooks(0, $id_limpio);
        if ($data == 1) {
            $msg = array('msg' => 'Ebook dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar($id)
    {
        $id_limpio = strClean($id);
        $data = $this->model->estadoEbooks(1, $id_limpio);
        if ($data == 1) {
            $msg = array('msg' => 'Ebook restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
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

    public function verificar($id_ebook)
    {
        $id_limpio = strClean($id_ebook);

        $data = $this->model->getEbookClave($id_limpio);
        if (!empty($data)) {
            $msg = array('titulo' => $data['titulo'], 'icono' => 'success');
        }
        
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }


    
}

?>