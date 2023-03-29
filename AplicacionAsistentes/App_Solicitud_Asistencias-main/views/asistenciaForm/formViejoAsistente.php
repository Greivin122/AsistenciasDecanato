<?php
 header("Cache-Control: private, must-revalidate, max-age=0");
 header("Pragma: no-cache");
 header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

 if(!isset($_SESSION)) 
 { 
    session_start(); 
 }
?>

<?php require 'views/header.php'?>

<nav class="navbar navbar-light" style="background-color: #00264d;">
    <div class="container-fluid">
    <span class="navbar-brand mb-0 h1" style="color: white;">Solicitud para horas asistente y estudiante</span>
    </div>
</nav>

<div class="container-lg" style="background-color: white; padding: 20px;" >
    <?php echo '<form id="datosPersonales" class="row g-3 was-validated" data-toggle="validator" method="POST" action="'.constant('dir').'/asistencia/AsistenteViejo">';?>
    <div class="mb-3 mt-4">
        <h5 class="mb-3"><u>Seleccione el tipo de horas por las que quiere aplicar</u></h5>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="seleccionHoras" id="seleccionHorasEstudiante" value="2" onchange="mostrarAsisEst(this)" checked>
            <label class="form-check-label" for="seleccionHorasEstudiante"> Horas Estudiante </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="seleccionHoras" id="seleccionHorasAsistente" value="1" onchange="mostrarAsisEst(this)" >
            <label class="form-check-label" for="seleccionHorasAsistente"> Horas Asistente </label>
        </div>

    </div>
        <div id="formulario-asist-est" >
            <h5><u>Datos personales</u></h5>
            <div class="row">
                <div class="mb-3 col">
                    <label for="seleccionIdentificacion" class="form-label">Tipo de Identificación</label>
                    <select class="form-select" aria-label="seleccionIdentificacion" id="seleccionIdentificacion" value=<?php echo $_SESSION['tipoCedIngresada'];?> disabled required>
                        <option <?= $_SESSION['tipoCedIngresada']== "" ? 'selected="selected"': ''; ?> value="" selected>Seleccione su identificación</option>
                        <option <?= $_SESSION['tipoCedIngresada']== "nacionalResidente" ? 'selected="selected"': ''; ?> value="nacionalResidente">Nacional o Residente</option>
                        <option <?= $_SESSION['tipoCedIngresada']== "extranjero" ? 'selected="selected"': ''; ?> value="extranjero">Extranjero</option>
                    </select>
                </div>

                <div class="mb-3 col">
                    <label for="identificacion" class="form-label">Identificación</label>
                    <input type="text" class="form-control" required name="identificacion" id="inpttxt_Cedula" value=<?php echo $_SESSION['cedIngresada'];?> disabled>
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col">
                    <label for="" class="form-label">Créditos aprobados</label>
                    <input type="number" class="form-control" name="aprobado" id="aprobado" required>
                </div>

                <div class="mb-3 col">
                    <label for="matriculados" class="form-label">Créditos matriculados</label>
                    <input type="number" class="form-control" required min="9" name="matriculados" id="matriculados">
                </div>

                <div class="mb-3 col">
                    <label for="promedioAnual" class="form-label">Promedio anual de matrícula</label>
                    <input type="number" class="form-control" required step="0.0001" min="7" id="promedioAnual" name="promedioAnual">
                </div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Solicita beca de estímulo</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="beca" id="becaSi" value="Si" checked>
                    <label class="form-check-label" for="becaSi">
                    Sí
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="beca" id="becaNo" value="No">
                    <label class="form-check-label" for="becaNo">
                    No
                    </label>
                </div>
            </div>

            <h5><u>Informe de matrícula</u></h5>
            <div class="mb-3">
                <label for="informeMatricula" class="form-label">Adjunte el informe de matrícula con su nombre completo como título en formato PDF</label>
                <p >Ejemplo: Nombre_Apellido_Apellido.PDF </p>
                <input class="form-control" type="file" id="informeMatricula" accept="application/pdf" name="informe" required>
            </div>

            <h5><u>Horario</u></h5>
            <p>Seleccione con un <i>check</i> las horas que tiene disponibles<br></p>
            <div class="row">
                <div class="col-1"></div>
                <div class="col mb-3">
                    <span class="border-start-0">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="table-active">
                            <th scope="col" class="p-3 text-center text-uppercase">Días</th>
                            <th scope="col" colspan="2" class="p-3 text-center text-uppercase">Horas</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row" class="text-center p-4">Lunes</th>
                            <td class="text-center p-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="lunesAM" id="lunesAM" name="horario[]" >
                                <label class="form-check-label" for="lunesAM">8am - 12pm</label>
                            </div></td>
                            <td class="text-center p-4"><div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="lunesPM" id="lunesPM" name="horario[]" >
                                <label class="form-check-label" for="lunesPM">1pm - 5pm</label>
                            </div></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-center p-4">Martes</th>
                            <td class="text-center p-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="martesAM" id="martesAM" name="horario[]" >
                                <label class="form-check-label" for="martesAM">8am - 12pm</label>
                            </div></td>
                            <td class="text-center p-4"><div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="martesPM" id="martesPM" name="horario[]" >
                                <label class="form-check-label" for="martesPM">1pm - 5pm</label>
                            </div></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-center p-4">Miércoles</th>
                            <td class="text-center p-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="miercolesAM" id="miercolesAM" name="horario[]" >
                                <label class="form-check-label" for="miercolesAM">8am - 12pm</label>
                            </div></td>
                            <td class="text-center p-4"><div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="miercolesPM" id="miercolesPM" name="horario[]" >
                                <label class="form-check-label" for="miercolesPM">1pm - 5pm</label>
                            </div></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-center p-4">Jueves</th>
                            <td class="text-center p-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="juevesAM" id="juevesAM" name="horario[]" >
                                <label class="form-check-label" for="juevesAM">8am - 12pm</label>
                            </div></td>
                            <td class="text-center p-4"><div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="juevesPM" id="juevesPM" name="horario[]" >
                                <label class="form-check-label" for="juevesPM">1pm - 5pm</label>
                            </div></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-center p-4">Viernes</th>
                            <td class="text-center p-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="viernesAM" id="viernesAM" name="horario[]" >
                                <label class="form-check-label" for="viernesAM">8am - 12pm</label>
                            </div></td>
                            <td class="text-center p-4"><div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="viernesPM" id="viernesPM" name="horario[]" >
                                <label class="form-check-label" for="viernesPM">1pm - 5pm</label>
                            </div></td>
                        </tr>
                        </tbody>
                    </table>
                    </span>
                </div>
                <div class="col-1"></div>
            </div>

            <input type="submit" class="btn btn-primary btn-lg" value="Enviar" onclick="location.href='http://localhost/index.php?c=asistente&a=ingresarAsistente'" >
        </div>
    </form>
</div>
<?php require 'views/footer.php'?>