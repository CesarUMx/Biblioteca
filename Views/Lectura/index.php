<?php
$currentUrl = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ebook</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link href="<?php echo base_url; ?>Assets/css/main.css" rel="stylesheet" />
	<link href="<?php echo base_url; ?>Assets/css/estilos.css" rel="stylesheet" />
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>Assets/css/font-awesome.min.css">
</head>

<body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="#">Biblioteca UMx</a>
        <p class="app-header__title">Hola <?php echo $data['nombre']; ?></p>
    </header>
    <!-- Sidebar menu-->
    
    <main class="app-content1">
    
        <!-- Agregar iframe para ver PDF de forma segura -->
        <?php if (!empty($data['id']) && $data['fecha_devolucion'] > date("Y-m-d H:i:s")): ?>
            <div class="row">
                <div class="col-md-2 d-flex justify-content-center align-items-center">
                    <button id="prev" class="nav-button left">&#9664;</button>
                </div>
                <div class="col-md-8 d-flex justify-content-center">
                    <canvas id="the-canvas"></canvas>
                </div>
                <div class="col-md-2 d-flex justify-content-center align-items-center">
                    <button id="next" class="nav-button right">&#9654;</button>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
            </div>

        <?php else: ?>
            <div>
                <div class="row d-flex justify-content-center mt-3">
                    <h3>Archivo PDF No disponible.</h3>
                </div>
                <div class="row d-flex justify-content-center mt-3">
                    <p>Renueva la fecha de devolucion para poder ver el PDF o solicite nuevamente el Ebook.</p>
                </div>
            </div>
        <?php endif; ?>
        

    </main>
    <!-- Essential javascripts for application to work-->
    <script src="//mozilla.github.io/pdf.js/build/pdf.mjs" type="module"></script>

    
    <script src="<?php echo base_url; ?>Assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/js/main.js"></script>
    <script>
        const base_url = "<?php echo base_url; ?>";
        var url = "<?php echo base_url; ?>Lectura/pdf/<?php echo $data['id']; ?>";
    </script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/js/vfs_fonts.js"></script>
    <script type="module" src="<?php echo base_url; ?>Assets/js/api/Lectura.js"></script>

</body>

</html>