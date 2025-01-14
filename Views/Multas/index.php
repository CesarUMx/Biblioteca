<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-exclamation-triangle"></i> Multas</h1>
    </div>
</div>

<div class="tile">
    <div class="tile-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mt-4" id="tblMultas">
                <thead class="thead-dark">
                    <tr>
                        <th hidden>Id</th>
                        <th>Matricula</th>
                        <th hidden>Carrera</th>
                        <th>Estudiante</th>
                        <th>Clave</th>
                        <th>Libro</th>
                        <th>Dias de atraso</th>
                        <th>Multa</th>
                        <th hidden>Fecha devolucion</th>
                        <th>Fecha creacion</th>
                        <th hidden>Recibe</th>
                        <th></th>
                        <th hidden>Motivo / Donativo</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="cancelarMulta" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title">Cancelar Multa</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmMulta" class="row" onsubmit="cancelaMulta(event)">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" id="idMulta" name="idMulta">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="motivo">Motivo de cancelacion</label>
                                <textarea id="motivo" class="form-control" name="motivo" rows="2" placeholder="Breve descripción del motivo"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Aceptar</button>
                            <button class="btn btn-danger" data-dismiss="modal" type="button">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="pagoMulta" class="modal fade" role="dialog" aria-labelledby="my-modal-pago" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title">Pago de Multa</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmPago" class="row" onsubmit="pagoMultas(event)">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" id="idPago" name="idPago">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="formaPago">Forma de pago</label><br>
                            <select id="formaPago" class="form-control" name="formaPago" required style="width: 100%;" onchange="toggleTextarea()">
                                <option value="Efectivo">Efectivo</option>
                                <option value="Condonacion">Condonación</option>                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" id="donativoContainer" style="display: none;">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="donativo">Donativo</label>
                                <textarea id="donativo" class="form-control" name="donativo" rows="2" placeholder="Ejemplo: libro de textos"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Aceptar</button>
                            <button class="btn btn-danger" data-dismiss="modal" type="button">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>