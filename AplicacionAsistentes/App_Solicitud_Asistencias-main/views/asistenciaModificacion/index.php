<?php
 header("Cache-Control: private, must-revalidate, max-age=0");
 header("Pragma: no-cache");
 header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

 if(!isset($_SESSION)) { 
    session_start(); 
 }

?>

<?php require 'views/header.php'?>

<!-- <nav class="navbar navbar-light" style="background-color: #00264d;">
    <div class="container-fluid">
    <span class="navbar-brand mb-0 h1" style="color: white;">Modificación de la Solicitud para horas asistente y estudiante</span>
    </div>
</nav> -->

<div class="container-lg" style="background-color: white; padding: 20px;" >


<?php echo '<form id="datosPersonales" class="row g-3 was-validated" data-toggle="validator" method="POST" action="'.constant('dir').'/asistencia/ingresarAsistente">';?>
    
<!-- <select class="form-select" aria-label="seleccionHoras" id="seleccionHoras" name="seleccionHoras" onchange="mostrarAsisEst(this)" autocomplete="off">
    <option selected>Seleccione las horas que quiere realizar</option>
    <option value="1">Horas asistente</option>
    <option value="2">Horas estudiante</option>
</select> -->

<div class="mb-3 mt-4">
    <h5><u>Seleccione el tipo de horas por las que quiere aplicar</u></h5>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="seleccionHoras[]" id="seleccionHorasEstudiante" value="2" onchange="mostrarAsisEst()" <?php echo $this->tipoAsistencia == "1" || $this->tipoAsistencia == "3" ? 'checked': '' ?>>
        <label class="form-check-label" for="seleccionHorasEstudiante"> Horas Estudiante </label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="seleccionHoras[]" id="seleccionHorasAsistente" value="1" onchange="mostrarAsisEst()" <?php echo $this->tipoAsistencia == "1" || $this->tipoAsistencia == "3" ? '': 'checked' ?> >
        <label class="form-check-label" for="seleccionHorasAsistente"> Horas Asistente </label>
    </div>

</div>

<div id="formulario-asist-est">
    <h5><u>Datos personales</u></h5>
        <div class="row">
                <div class="mb-3 col">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value=<?php echo $this->nombre; ?> required>
                </div>

                <div class="mb-3 col">
                    <label for="nombre" class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" id="apellido1" name="apellido1" value=<?php echo $this->apellido1; ?> required>
                </div>

                <div class="mb-3 col">
                    <label for="nombre" class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" id="apellido2" name="apellido2" value=<?php echo $this->apellido2; ?> required>
                </div>
        </div>

        <div class="row">

            <div class="mb-3 col">
                <label for="correo" class="form-label">Correo electrónico institucional</label>
                <input type="email" id="correo" class="form-control" name="correo" value=<?php echo $this->correo; ?> required pattern="[a-zA-Z0-9._%+-]+@[uU][Cc][Rr]\.[Aa][Cc]\.[Cc][Rr]$" readonly>
            </div>


            <div class="mb-3 col">
                <label for="identificacion" class="form-label">Identificación</label>
                <input type="text" class="form-control" required name="identificacion" id="inpttxt_Cedula" value=<?php echo $_SESSION['cedIngresada'];?> readonly>
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col">
                <label for="direccion" class="form-label">Dirección donde vive</label>
                <textarea required id="direccion" type="text" class="form-control" minlength="1" maxlength="80" name="direccion"><?php echo $this->direccion;?></textarea>
            </div>
        </div>

        <div class="row">

            <div class="mb-3 col">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" id="telefono" class="form-control" pattern="\d{8}" required name="telefono" value=<?php echo $this->telefono; ?>>
            </div>

            <div class="mb-3 col">
                <label for="carne" class="form-label">Carné Universitario</label>
                <input type="text" id="carne" class="form-control" required maxlength="6" minlength="6" name="carnet" value=<?php echo $this->carne; ?>>
            </div>

            <div class="mb-3 col">
                <label for="carrera" class="form-label">Carrera</label>
                <input type="text" class="form-control" required name="carrera" id="carrera" value=<?php echo $this->carrera; ?>>
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col">
                <label for="" class="form-label">Créditos aprobados</label>
                <input type="number" class="form-control" name="aprobado" id="aprobado" value=<?php echo $this->creditosAprobados; ?> onchange="mostrarAsisEst()" required>
            </div>

            <div class="mb-3 col">
                <label for="matriculados" class="form-label">Créditos matriculados</label>
                <input type="number" class="form-control" required min="9" name="matriculados" id="matriculados" value=<?php echo $this->creditosMatriculados; ?>>
            </div>

            <div class="mb-3 col">
                <label for="promedioAnual" class="form-label">Promedio anual de matrícula</label>
                <input type="number" class="form-control" required step="0.0001" min="7" id="promedioAnual" name="promedioAnual" value=<?php echo $this->ponderadoAnual; ?>>
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
            <input class="form-control" type="file" id="informeMatricula" accept="application/pdf" name="informe" required value=" echo $this->informeMatricula;">
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
                            <input class="form-check-input" type="checkbox" value="lunesAM" id="lunesAM" name="horario[]" <?php echo $this->horario[0] == 1 ? 'checked': '' ?>>
                            <label class="form-check-label" for="lunesAM">8am - 12pm</label>
                        </div></td>
                        <td class="text-center p-4"><div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="lunesPM" id="lunesPM" name="horario[]" <?php echo $this->horario[1] == 1 ? 'checked': '' ?>>
                            <label class="form-check-label" for="lunesPM">1pm - 5pm</label>
                        </div></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center p-4">Martes</th>
                        <td class="text-center p-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="martesAM" id="martesAM" name="horario[]" <?php echo $this->horario[2] == 1 ? 'checked': '' ?>>
                            <label class="form-check-label" for="martesAM">8am - 12pm</label>
                        </div></td>
                        <td class="text-center p-4"><div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="martesPM" id="martesPM" name="horario[]" <?php echo $this->horario[3] == 1 ? 'checked': '' ?> >
                            <label class="form-check-label" for="martesPM">1pm - 5pm</label>
                        </div></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center p-4">Miércoles</th>
                        <td class="text-center p-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="miercolesAM" id="miercolesAM" name="horario[]" <?php echo $this->horario[4] == 1 ? 'checked': '' ?> >
                            <label class="form-check-label" for="miercolesAM">8am - 12pm</label>
                        </div></td>
                        <td class="text-center p-4"><div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="miercolesPM" id="miercolesPM" name="horario[]" <?php echo $this->horario[5] == 1 ? 'checked': '' ?>>
                            <label class="form-check-label" for="miercolesPM">1pm - 5pm</label>
                        </div></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center p-4">Jueves</th>
                        <td class="text-center p-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="juevesAM" id="juevesAM" name="horario[]" <?php echo $this->horario[6] == 1 ? 'checked': '' ?>>
                            <label class="form-check-label" for="juevesAM">8am - 12pm</label>
                        </div></td>
                        <td class="text-center p-4"><div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="juevesPM" id="juevesPM" name="horario[]" <?php echo $this->horario[7] == 1 ? 'checked': '' ?>>
                            <label class="form-check-label" for="juevesPM">1pm - 5pm</label>
                        </div></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center p-4">Viernes</th>
                        <td class="text-center p-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="viernesAM" id="viernesAM" name="horario[]" <?php echo $this->horario[8] == 1 ? 'checked': '' ?>>
                            <label class="form-check-label" for="viernesAM">8am - 12pm</label>
                        </div></td>
                        <td class="text-center p-4"><div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="viernesPM" id="viernesPM" name="horario[]" <?php echo $this->horario[9] == 1 ? 'checked': '' ?>>
                            <label class="form-check-label" for="viernesPM">1pm - 5pm</label>
                        </div></td>
                    </tr>
                    </tbody>
                </table>
                </span>
            </div>
            <div class="col-1"></div>
        </div>

        <br><h5><u>Asistencias</u></h5>

        <div class="mb-3 mt-4">
            <p>¿Ha sido asistente antes?</p>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="HaSidoAsistente" id="seleccionSiAsistencia" value="Si" onchange="mostrarInfoAsistencia()" <?php echo $this->asistenciaOtrosLados == 'Si' ? 'checked': '' ?>>
                <label class="form-check-label" for="seleccionSiAsistencia"> Sí </label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="HaSidoAsistente" id="seleccionNoAsistencia" value="No" onchange="mostrarInfoAsistencia()" <?php echo $this->asistenciaOtrosLados == 'No' ? 'checked': '' ?> >
                <label class="form-check-label" for="seleccionNoAsistencia"> No </label>
            </div>
        </div>


        <div id="informacionAsistencias" style="<?php echo $this->asistenciaOtrosLados == 'Si' ? '': 'display: none' ?>">
            <div class="row">
                <div class="col mb-3">
                    <label for="dondeAsistencia" class="form-label">¿Dónde?</label>
                    <input type="text" class="form-control" name="dondeAsistencia" id="dondeAsistencia" required value=<?php echo $this->asistenciaOtrosLadosDonde; ?>>
                </div>
            </div> 

            <div class="row">
                <div class="col mb-3">
                    <label for="labores" class="form-label">¿Qué labores realizaba?</label>
                    <textarea required type="text" class="form-control" name="labores" id="labores"><?php echo $this->asistenciaOtrosLadosLabores;?></textarea>
                </div>
            </div>
        </div>

        <div id="informacionBanco" style="<?php echo $this->asistenciaOtrosLados == 'No' ? '': 'display: none' ?>">
            <div class="row">
                <div class="col mb-3">
                    <label for="numeroCuenta" class="form-label">Ingrese el número de cuenta</label>
                    <input type="text" class="form-control" name="numeroCuenta" id="numeroCuenta" value=<?php echo $this->numeroCuenta; ?> >
                </div>
            </div> 

            <div class="row">
                <div class="mb-3">
                    <label for="informeBanco" class="form-label">Suba informe de la cuenta bancaria</label>
                    <input class="form-control" type="file" id="informeBanco" accept="application/pdf" name="informeBanco" value=" echo $this->asistenciaOtrosLadosDonde">
                </div>
            </div>
        </div>

        <br><h5><u>Experiencia</u></h5>

        <div class="mb-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="hardware" id="hardware" name="experiencia[]" <?php echo $this->experiencia[0] == 1 ? 'checked': '' ?>>
                <label class="form-check-label" for="hardware">Instalación de hardware</label>  
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="software" id="software" name="experiencia[]" <?php echo $this->experiencia[1] == 1 ? 'checked': '' ?>>
                <label class="form-check-label" for="software">Instalación de software</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="redes" id="redes" name="experiencia[]" <?php echo $this->experiencia[2] == 1 ? 'checked': '' ?>>
                <label class="form-check-label" for="redes">Manejo de redes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="mantenimiento" id="mantenimiento" name="experiencia[]" <?php echo $this->experiencia[3] == 1 ? 'checked': '' ?>>
                <label class="form-check-label" for="mantenimiento">Mantenimiento</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="cableado" id="cableado" name="experiencia[]" <?php echo $this->experiencia[4] == 1 ? 'checked': '' ?>>
                <label class="form-check-label" for="cableado">Cableado</label>
            </div>

            <div class="row">
                <div class="col">
                    <label for="" class="form-label"><br>Otros</label>
                    <textarea type="text" class="form-control" name="experiencia[]"><?php echo $this->experiencia[5];?></textarea>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 col-2 mx-auto float-end my-3">
            <input type="submit" class="btn btn-primary btn-lg" style="--bs-btn-padding-x: .25rem;" value="Enviar" >
        </div>
    </form>
    </div>
</div>

<?php require 'views/footer.php'?>