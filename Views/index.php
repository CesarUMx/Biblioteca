<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>Assets/css/main.css">
    <link href="<?php echo base_url; ?>Assets/css/datatables.min.css" rel="stylesheet" crossorigin="anonymous" />
	<link href="<?php echo base_url; ?>Assets/css/estilos.css" rel="stylesheet" />
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>Assets/css/font-awesome.min.css">
    <title>Buscador de libros</title>
</head>

<body>

    <div class="login-button-container">
        <a href="<?php echo base_url; ?>Login" class="btn btn-primary">Iniciar Sesión</a>
    </div>

    <section class="material-half-bg">
        <div class="cover">
            <img class="app-sidebar__user-avatar" src="<?php echo base_url; ?>Assets/img/logo_blanco.png" alt="Universidad Mondragon Mexico" width="250">
        </div>
    </section>
    <section class="login-content">
        <div class="logo">
            <img src="<?php echo base_url; ?>/Assets/img/image.png" alt="Biblioteca UXx" width="400" >
        </div>
        <div class="login-box1 row">
            <div class="col-md-11">
                <h4 class="text-center" >Coloca en el buscador el Titulo, el Autor, la Editorial o la Materia que desee...</h4>
                <p class="text-center">Ejemplo: derecho julio MC GRAW 1996</p>
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-light table-striped mt-4 w-100" id="tblBusqueda">
                                <thead class="thead-dark">
                                    <tr>
                                        <th hidden>Id</th>
                                        <th>Clave</th>
                                        <th>Titulo</th>
                                        <th>Autor/es</th>
                                        <th>Editorial</th>
                                        <th>Año</th>
                                        <th>Materia</th>
                                        <th>Disponibilidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


            
    </section>
    <!-- Essential javascripts for application to work-->
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/js/main.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/js/datatables.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/js/sweetalert2.all.min.js"></script>

    <!-- The javascript plugin to display page loading on top-->
    <script src="<?php echo base_url; ?>Assets/js/pace.min.js"></script>
    <script>
        const base_url = '<?php echo base_url; ?>';
    </script>
    <script src="<?php echo base_url; ?>Assets/js/buscador.js"></script>
    <script src="<?php echo base_url; ?>Assets/js/tablas.js"></script>

</body>

</html>