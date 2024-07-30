<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-book"></i> Libros</h1>
    </div>
</div>
<button class="btn btn-primary mb-2" onclick="frmLibros()"><i class="fa fa-plus"></i> Libro </button>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4" id="tblLibros">
                        <thead class="thead-dark">
                            <tr>
                                <th hidden>Id</th>
                                <th>Clave</th>
                                <th>Clasificación</th>
                                <th hidden>ISBN</th>
                                <th>Titulo</th>
                                <th>Autor/es</th>
                                <th>Editorial</th>
                                <th hidden>Año</th>
                                <th hidden>Paginas</th>
                                <th>Adquisición</th>
                                <th>Materia</th>
                                <th>Descripción</th>
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

<div id="nuevoLibro" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title">Registro Libro</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmLibro" class="row" onsubmit="registrarLibro(event)">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="clasificacion">Clasificación *</label>
                            <input type="hidden" id="id" name="id">
                            <input id="clasificacion" class="form-control" type="text" name="clasificacion" placeholder="Clasificación del libro" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="isbn">ISBN *</label>
                            <input id="isbn" class="form-control" type="text" name="isbn" placeholder="ISBN" required>
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
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="materia">Materia *</label><br>
                            <select id="materia" class="form-control materia" name="materia" required style="width: 100%;">
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="adquisicion">Adquisición *</label><br>
                            <select id="adquisicion" class="form-control" name="adquisicion" required style="width: 100%;">
                                <option value="Compra">Compra</option>
                                <option value="Donación">Donación</option>                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="num_pagina">Páginas</label>
                            <input id="num_pagina" class="form-control" type="number" name="num_pagina" placeholder="Páginas" required>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input id="cantidad" class="form-control" type="number" name="cantidad" value="1" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" class="form-control" name="descripcion" rows="2" placeholder="Descripción"></textarea>
                            </div>
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