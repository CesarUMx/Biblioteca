<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-tags"></i> Etiquetas</h1>
    </div>
</div>
<button class="btn btn-primary mb-2" onclick="frmEtiquetas()"><i class="fa fa-plus"></i> Agregar libro </button>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4" id="tblEtiquetas">
                        <thead class="thead-dark">
                            <tr>
                                <th hidden>Id</th>
                                <th>Clave</th>
                                <th>Clasificación</th>
                                <th>ISBN</th>
                                <th>Titulo</th>
                                <th>Autor/es</th>
                                <th>Editorial</th>
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

<div id="nuevaEtiqueta" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title"></h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEtiqueta" onsubmit="agregarLibro(event)">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="libro">Clave del libro</label><br>
                                <input id="libro" name="libro" class="form-control" list="Claves">
                                <datalist id="Claves">
                                </datalist>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                            <label>Titulo</label><br>
                            <input id="libroT" class="form-control" type="text" value="" disabled>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" id="btnAccion"></button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>