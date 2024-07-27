<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-graduation-cap"></i> Estudiantes</h1>
    </div>
</div>
<button class="btn btn-primary mb-2" type="button" onclick="frmEstudiante()"><i class="fa fa-plus"></i> Estudiante </button>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4" id="tblEst">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Matricula</th>
                                <th>Correo</th>
                                <th>Nombre</th>
                                <th>Modalidad</th>
                                <th>Carrera</th>
                                <th>Semestre / Cuatrimestre</th>
                                <th>Teléfono</th>
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
    </div>
</div>
<div id="nuevoEstudiante" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="title">Registro Estudiante</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEstudiante" class="row" onsubmit="registrarEstudiante(event)">
                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="matricula">Matrícula</label>
                                <input type="hidden" id="id" name="id">
                                <input id="matricula" class="form-control" type="text" name="matricula" required placeholder="Matrícula del estudiante">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sem">Semestre / Cuatri.</label>
                                <input id="sem" class="form-control" type="text" name="sem" required placeholder="Sem. / cuat. del estudiante">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" required placeholder="Nombre completo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modalidad">Modalidad</label>
                                <select id="modalidad" class="form-control" name="modalidad" required style="width: 100%;">
                                    <option value="">Selecciona una opción</option>
                                    <option value="1">Licenciatura</option>
                                    <option value="2">Doctorado</option>
                                    <option value="3">Maestría</option>
                                    <option value="4">Duales</option>
                                    <option value="5">Ejecutivas</option>
                                    <option value="6">Preparatoria</option>
                                    <option value="7">Docente</option>
                                    <option value="8">Administrativos</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="carrera">Carrera</label>
                                <select id="carrera" class="form-control" name="carrera" required style="width: 100%;">
                                
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Teléfono">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" id="btnAccion">Registrar</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Atras</button>
                            </div>
                        </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>