<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Panel de Administración</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Usuarios">
                <h4>Usuarios</h4>
                <p><b><?php echo $data['usuarios']['total'] ?></b></p>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-book fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Libros">
                <h4>Libros</h4>
                <p><b><?php echo $data['libros']['total'] ?></b></p>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-book fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Ebook">
                <h4>Ebooks</h4>
                <p><b><?php echo $data['ebooks']['total'] ?></b></p>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-graduation-cap fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Estudiantes">
                <h4>Estudiantes</h4>
                <p><b><?php echo $data['estudiantes']['total'] ?></b></p>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-hourglass-start fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Prestamos">
                <h4>Prestamos</h4>
                <p><b><?php echo $data['prestamos']['total'] ?></b></p>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-list-alt fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Materia">
                <h4>Materias</h4>
                <p><b><?php echo $data['materias']['total'] ?></b></p>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-cogs fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Configuracion">
                <h6>Configuracion</h6>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Libros y Ebook</h3>
            <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-light table-striped mt-4 w-100" id="tblReportes">
                                <thead class="thead-dark">
                                    <tr>
                                        <th hidden>Id</th>
                                        <th>Clave</th>
                                        <th>Clasificación</th>
                                        <th>Titulo</th>
                                        <th>Autor/es</th>
                                        <th>Editorial</th>
                                        <th>Año</th>
                                        <th>Categoría</th>
                                        <th>Disponibilidad</th>
                                        <th>Tipo</th>
                                        <th>Adquisición</th>
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
<?php include "Views/Templates/footer.php"; ?>