<?php require 'views/header.php'?>

<div id="solicitud_asistencia_form" class=" my-4 mx-sm-2 mx-md-4 mx-lg-5 justify-content-center p-5 bg-light rounded-3 ">
    <div class="mb-5">
        <h1><strong>Solicitud de Asistencia</strong></h1>
        <p> Formulario para participar por asistencias en la Facultad de Ingeniería</p>
    </div>
    <?php echo '<form id="datosPersonales" class="row g-3 was-validated" data-toggle="validator" method="POST" action="'.constant('dir').'/asistencia/formularioAsistente">';?>   
        <br> 
        <div>
            <h5 class="mb-3">Identificación</h5>
            <div class="row">
                <div class="mb-3 col">
                    <label for="seleccionIdentificacion" class="form-label">Seleccione</label>
                    <select class="form-select" aria-label="seleccionIdentificacion" name="seleccionIdentificacion" id="seleccionIdentificacion" onchange="cambioSeleccionIdentificacion(this)" required>
                        <option value="" selected>Seleccione su identificación</option>
                        <option value="nacionalResidente">Nacional o Residente</option>
                        <option value="extranjero">Extranjero</option>
                    </select>
                </div>

                <div class="mb-3 col">
                    <label for="identificacion" class="form-label">Identificación</label>
                    <input type="text" class="form-control" required name="identificacion" id="inpttxt_Cedula" disabled>
                </div>

                <input type="submit" class="btn btn-primary btn-lg my-4" value="Enviar" >
            </div>
    </form>
</div>

<?php echo "<input type = 'button' onclick = 'toggleFormularios()' value = 'Deseo modificar mi formulario'>";?>
</div>

<div id="solicitud_modificar_form" class=" my-4 mx-sm-2 mx-md-4 mx-lg-5 justify-content-center p-5 bg-light rounded-3" style="display: none;">
    <div class="mb-5">
    <?php echo "<input type = 'button' onclick = 'toggleFormularios()' value = 'Regresar'>";?>
        <h1><strong>Modificación de Formulario</strong></h1>
        <p>Por favor ingrese su identificación y el código de modificación que se le envió al correo institucional al enviar el formulario para participar por asistencias del Decanato de Ingeniería.</p>
    </div>
    <?php echo '<form id="formModificacion" class="row g-3 was-validated" data-toggle="validator" method="POST" action="'.constant('dir').'/asistencia/formularioModificacion">';?>
        <br> 
        <h5 class="mb-3">Verificación de Código</h5>
        <div class="row">

            <div class="mb-3 col">
                <label for="identificacion" class="form-label">Identificación</label>
                <input type="text" class="form-control" required name="identificacion" id="inpttxt_Cedula">
            </div>

            <div class="mb-3 col">
                <label for="codigoMod" class="form-label">Código de Modificación</label>
                <input type="text" class="form-control" required name="codigoMod" id="inpttxt_CodMod">
            </div>

            <input type="submit" class="btn btn-primary btn-lg my-4" value="Enviar" >
        </div>
    </form>
</div>
<?php require 'views/footer.php'?>
