<?php
class Login extends Controller
{
    public function __construct()
    {
        session_start(); // Inicia la sesión si no está iniciada
        parent::__construct(); // Llama al constructor de la clase padre
    }

    public function index()
    {
        // Si el usuario ya está autenticado, lo redirige a otra página (ejemplo: Dashboard)
        if (!empty($_SESSION['activo'])) {
            header("location: " . base_url . "Prestamos");
            exit();
        }

        // Cargar la vista del login
        $this->views->getView($this, "index");
    }
}
?>
