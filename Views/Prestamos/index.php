<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Prestamos</h1>
    </div>
</div>
<button class="btn btn-primary mb-2" onclick="frmPrestar()"><i class="fa fa-plus"></i> Prestamo </button>
<div class="tile">
    <div class="tile-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mt-4" id="tblPrestar">
                <thead class="thead-dark">
                    <tr>
                        <th hidden>Id</th>
                        <th>Clave</th>
                        <th>Titulo</th>
                        <th>Matricula</th>
                        <th hidden>Carrera</th>
                        <th>Estudiante</th>
                        <th>Fecha Prestamo</th>
                        <th>Fecha Devolución</th>
                        <th>Observación</th>
                        <th hidden>Prestador</th>
                        <th hidden>Ultimo renovador</th>
                        <th hidden>Recibe</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="prestar" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title"></h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmPrestar" onsubmit="registroPrestamos(event)">
                    <div class="row">
                        <input type="hidden" id="id" name="id">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estudiante">Matricula</label><br>
                                <input id="estudiante" name="estudiante" class="form-control" list="Matriculas_list">
                                <datalist id="Matriculas_list">
                                </datalist>
                            </div>
                        </div>
                        <div class="col-md-8">
                        <div class="form-group">
                            <label>Nombre</label><br>
                            <input id="estudianteN" class="form-control" type="text" value="" disabled>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Carrera</label><br>
                                <input id="estudianteC" class="form-control" type="text" value="" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Modalidad</label><br>
                                <input id="estudianteM" class="form-control" type="text" value="" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_prestamo">Fecha de Prestamo</label>
                                <?php if ($data['fecha'] || $_SESSION['id_usuario'] == 1) : ?>
                                    <input id="fecha_prestamo" class="form-control" type="date" name="fecha_prestamo" value="<?php echo date("Y-m-d"); ?>" required>
                                <?php else : ?>
                                    <input id="fecha_prestamo" class="form-control" type="date" name="fecha_prestamo" value="<?php echo date("Y-m-d"); ?>" readonly>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_devolucion">Fecha de Devolución</label>
                                <input id="fecha_devolucion" class="form-control" type="date" name="fecha_devolucion" value="<?php echo date("Y-m-d", strtotime("+1 day")); ?>" min="<?php echo date("Y-m-d", strtotime("+1 day")); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="librosContainer">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="libro">Clave del libro</label><br>
                                <input id="libro1" name="libro[]" class="form-control libro-clave" list="Claves">
                                <datalist id="Claves">
                                </datalist>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                            <label>Titulo</label><br>
                            <input id="libroT1" class="form-control libro-titulo" type="text" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addBookBtn" class="btn btn-primary">Agregar otro libro</button>
                    <button class="btn btn-primary" type="submit" id="btnAccion">Prestar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>