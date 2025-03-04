<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-tablet"></i> Ebooks</h1>
    </div>
</div>
<?php if ($data['create'] || $_SESSION['id_usuario'] == 1) : ?>
    <button class="btn btn-primary mb-2" onclick="frmEbooks()"><i class="fa fa-plus"></i> Ebook </button>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4" id="tblEbooks">
                        <thead class="thead-dark">
                            <tr>
                                <th hidden>Id</th>
                                <th>Clave</th>
                                <th>Clasificación</th>
                                <th>Titulo</th>
                                <th>Autor/es</th>
                                <th>Editorial</th>
                                <th>Año</th>
                                <th>Materia</th>
                                <th>PDF</th>
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

<div id="nuevoEbook" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title">Registro Libro</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEbook" class="row" onsubmit="registrarEbook(event)" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="clasificacion">Clasificación *</label>
                            <input type="hidden" id="id" name="id">
                            <input id="clasificacion" class="form-control" type="text" name="clasificacion" placeholder="Clasificación del libro" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="materia">Materia *</label><br>
                            <input id="materia" name="materia" class="form-control" list="MateriaList">
                            <datalist id="MateriaList">
                            </datalist>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="titulo">Título *</label>
                            <input id="titulo" class="form-control" type="text" name="titulo" placeholder="Título del libro" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="anio_edicion">Año Edición</label>
                            <input id="anio_edicion" class="form-control" type="number" name="anio_edicion" value="<?php echo date("Y"); ?>" min="1900" max="<?php echo date("Y"); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="autor">Autor / Autores *</label><br>
                            <input id="autor" class="form-control" type="text" name="autor" placeholder="Autor / es del libro" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="editorial">Editorial *</label><br>
                            <input id="editorial" class="form-control" type="text" name="editorial" placeholder="Editorial del libro" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="archivo_pdf">Archivo PDF *</label>
                            <input id="archivo_pdf" class="form-control" type="file" name="archivo_pdf" accept="application/pdf">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" id="btnAccion">Registrar</button>
                            <button class="btn btn-danger" data-dismiss="modal" type="button">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
<?php include "Views/Templates/footer.php"; ?>