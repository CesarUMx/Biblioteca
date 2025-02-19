<?php
$currentUrl = $_SERVER['REQUEST_URI'];
?>

</main>
<div id="cambiarClave" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="my-modal-title">Modificar Contraseña</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="frmCambiarPass" onsubmit="modificarClave(event)">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="clave_actual">Contraseña Actual</label>
                        <input id="clave_actual" class="form-control" type="password" name="clave_actual" id="clave_actual" placeholder="Contraseña actual" required>
                    </div>
                    <div class="form-group">
                        <label for="clave_nueva">Nueva Contraseña</label>
                        <input id="clave_nueva" class="form-control" type="password" name="clave_nueva" placeholder="Contraseña nueva" id="clave_nueva" required>
                    </div>
                    <div class="form-group">
                        <label for="clave_confirmar">Confirmar Contraseña</label>
                        <input id="clave_confirmar" class="form-control" type="password" name="clave_confirmar" id="clave_confirmar" placeholder="Confirmar contraseña" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Cambiar</button>
                    <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Essential javascripts for application to work-->
<script src="<?php echo base_url; ?>Assets/js/jquery-3.6.0.min.js"></script>
<script src="<?php echo base_url; ?>Assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url; ?>Assets/js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="<?php echo base_url; ?>Assets/js/pace.min.js"></script>
<script src="<?php echo base_url; ?>Assets/js/chart.min.js" crossorigin="anonymous"></script>
<script>
    const base_url = "<?php echo base_url; ?>";
</script>
<script src="<?php echo base_url; ?>Assets/js/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="<?php echo base_url; ?>Assets/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo base_url; ?>Assets/js/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url; ?>Assets/js/datatables.min.js"></script>
<script src="<?php echo base_url; ?>Assets/js/tablas.js"></script>
<script src="<?php echo base_url; ?>Assets/js/funciones.js"></script>
<script src="<?php echo base_url; ?>Assets/js/api<?php echo ($currentUrl); ?>.js"></script>

</body>

</html>