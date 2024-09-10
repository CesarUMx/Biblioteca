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
                        <th>Estudiante</th>
                        <th>Clave</th>
                        <th>Libro</th>
                        <th>Dias de atraso</th>
                        <th>Multa</th>
                        <th>Fecha creacion</th>
                        <th hidden>Recibe</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>