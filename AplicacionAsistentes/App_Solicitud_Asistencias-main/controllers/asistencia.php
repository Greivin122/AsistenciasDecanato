<?php

require_once "models/semestremodel.php";
require_once "models/estudiantemodel.php";
require_once "libs/plantillas/plantillaCorreoConfirmacion.php";

if(!isset($_SESSION)) 
{ 
    session_start(); 
}


class Asistencia extends Controller{
    
    function __construct(){
        parent::__construct();
    }

    function render(){
        
        $this->view->title = "Asistencias FI";

        date_default_timezone_set('America/Costa_Rica');
        $fecha = date('Y-m-d H:i:s');
        $semestreModel = new SemestreModel();
        $semestre = $semestreModel->getSemestreActual($fecha);
        
        if($semestreModel->getformularioActivo($semestre)){
            $this->view->render('asistencia/index');
        } else {
            $this->view->render('asistencia/notAvailable');
        }
    }

    public function formularioAsistente(){
        if(isset($_POST['identificacion']) && isset($_POST['seleccionIdentificacion'])){
            $cedula = $_POST['identificacion'];
            $tipoCed = $_POST['seleccionIdentificacion'];
    
            $_SESSION['cedIngresada'] = $cedula;
            $_SESSION['tipoCedIngresada'] = $tipoCed;
            
            $semestreModel = new SemestreModel();

            date_default_timezone_set('America/Costa_Rica');
            $fecha = date('Y-m-d H:i:s');
            $semestre = $semestreModel->getSemestreActual($fecha);

            $ingresoAsistente = new AsistenciaModel();

            if($semestreModel->getformularioActivo($semestre)){
                if(!$ingresoAsistente->haParticipado($cedula, $semestre)){

                    $this->view->title = "Formulario Asistentes | Facultad de Ingeniería";
    
                    if($this->model->haSidoAsistente($cedula)){
                        $this->view->render('asistenciaForm/formViejoAsistente');
                    } else {
                        $this->view->render('asistenciaForm/formNuevoAsistente');
                    }
                } else {
                    echo '<script> alert("Su formulario ya se encuentra registrado en el sistema.\\n\\nEn caso de querer modificarlo, utilice el código de modificación brindado en su correo institucional."); window.location.href="'.dir.'/asistencia"; </script>';
                }
            } else {
                echo '<script> alert("El formulario actualmente no se encuentra disponible."); window.location.href="'.dir.'/asistencia"; </script>';
            }
            
        } else {
            echo '<script> window.location.href="'.dir.'/asistencia" </script>';
        }
    }

    // Método encargado de verificar el codigo de modificacion y cargar la vista si es correcto. En caso contrario, redirecciona a la página principal
    public function formularioModificacion(){
        if(isset($_POST['identificacion']) && isset($_POST['codigoMod'])){
            $cedula = $_POST['identificacion'];
            $codigoMod = $_POST['codigoMod'];
    
            $_SESSION['cedIngresada'] = $cedula;
            $_SESSION['formModificado'] = true;
            
            if($codigoMod == $this->model->getCodigodeModificacion($cedula)){
                $this->getDatosFormularioModificacion($cedula);
                $this->view->title = "Formulario Modificación Asistencia | Facultad de Ingeniería";
                $this->view->render('asistenciaModificacion/index');    
            } else {
                echo '<script> alert("Número de Identidad o Código Incorrecto");  window.location.href="'.dir.'/asistencia"; </script>';
            }
        } else {
            echo '<script> window.location.href="'.dir.'/asistencia" </script>';
        }
    }

    private function getDatosFormularioModificacion($cedula){
        $ingresoEstudiante = new EstudianteModel();
        $semestreModel = new SemestreModel();

        date_default_timezone_set('America/Costa_Rica');
        $fecha = date('Y-m-d H:i:s');
        $semestre = $semestreModel->getSemestreActual($fecha);

        $ingresoEstudiante->getDatosEstudiante($cedula);
        $this->model->getDatosAsistente($cedula, $semestre);

        $this->view->tipoAsistencia             = $this->model->getTipoAsistencia();
        $this->view->creditosAprobados          = $this->model->getCantidadCreditos();
        $this->view->creditosMatriculados       = $this->model->getCreditosMatriculados();
        $this->view->ponderadoAnual             = $this->model->getPonderadoAnual();
        $this->view->beca                       = $this->model->getseleccionBecaEstimulo();
        $this->view->asistenciaOtrosLados       = $this->model->getAsistenciasOtrosLados();
        $this->view->asistenciaOtrosLadosDonde  = $this->model->getDondeAsistencias();
        $this->view->asistenciaOtrosLadosLabores= $this->model->getLaboresAsistencias();
        $this->view->informeMatricula           = $this->model->getInformeMatricula();
        $horarioSeleccionado                    = $this->model->getHorarioDisponible();

        $this->view->nombre                     = $ingresoEstudiante->getNombre();
        $this->view->apellido1                  = $ingresoEstudiante->getApellido1();
        $this->view->apellido2                  = $ingresoEstudiante->getApellido2();
        $this->view->carne                      = $ingresoEstudiante->getCarnet();
        $this->view->carrera                    = $ingresoEstudiante->getCarrera();
        $this->view->correo                     = $ingresoEstudiante->getCorreo();
        $this->view->telefono                   = $ingresoEstudiante->getTelefono();
        $this->view->direccion                  = $ingresoEstudiante->getDireccion();
        $this->view->numeroCuenta               = $ingresoEstudiante->getNumCuenta();
        $this->view->informeCuenta              = $ingresoEstudiante->getInformeCuenta();
        $experienciaEstudiante                  = $ingresoEstudiante->getExperiencia();

        $lunesAM = preg_match('/lunesAM/', $horarioSeleccionado);         $lunesPM = preg_match('/lunesPM/', $horarioSeleccionado);
        $martesAM = preg_match('/martesAM/', $horarioSeleccionado);       $martesPM = preg_match('/martesPM/', $horarioSeleccionado);
        $miercolesAM = preg_match('/miercolesAM/', $horarioSeleccionado); $miercolesPM = preg_match('/miercolesPM/', $horarioSeleccionado);
        $juevesAM = preg_match('/juevesAM/', $horarioSeleccionado);       $juevesPM = preg_match('/juevesPM/', $horarioSeleccionado);
        $viernesAM = preg_match('/viernesAM/', $horarioSeleccionado);     $viernesPM = preg_match('/viernesPM/', $horarioSeleccionado);

        
        $hardware = preg_match('/hardware/', $experienciaEstudiante); $software = preg_match('/software/', $experienciaEstudiante);
        $redes = preg_match('/redes/', $experienciaEstudiante); $mantenimiento = preg_match('/mantenimiento/', $experienciaEstudiante);
        $cableado = preg_match('/cableado/', $experienciaEstudiante); $otros = preg_match('/(?<=Otros:).*(?=.)/', $experienciaEstudiante, $otrosmatch);

        $horario = [$lunesAM, $lunesPM, $martesAM, $martesPM, $miercolesAM, $miercolesPM, $juevesAM, $juevesPM, $viernesAM, $viernesPM];
        
        $experiencia = [$hardware, $software, $redes, $mantenimiento, $cableado, $otrosmatch[0]];

        $this->view->experiencia = $experiencia;
        $this->view->horario = $horario;
    }

    public function AsistenteViejo(){
        $identificacion     = $_SESSION['cedIngresada'];
        $aprobado           = $_POST['aprobado'];
        $seleccionHoras     = $_POST['seleccionHoras'];
        $matriculados       = $_POST['matriculados'];
        $promedioAnual      = $_POST['promedioAnual'];
        $beca               = $_POST['beca'];
        $informe            = $_POST['informe'];
        $horarioo           = $_POST['horario'];
        $HaSidoAsistente    = "Si";
        $dondeAsistencia    = "Decanato de Ingeniería";
        $labores            = ' ';
        $horario            = ' ';

        if(!empty($horarioo)){
            $cuenta = count($horarioo);

            for($i = 0; $i < $cuenta; $i++){
                $horario .= $horarioo[$i] . ",";
            }
        }
        else {
            echo '<script> alert("Debe ingresar su horario de disponibilidad para realizar las horas"); location.replace(document.referrer); </script>';
        }

        date_default_timezone_set('America/Costa_Rica');
        $fecha = date('Y-m-d H:i:s');
        $obtenerSemestre = new SemestreModel();
        $semestre = $obtenerSemestre->getSemestreActual($fecha);
        $codigoModificacion = $this->generarNuevoCodigo();

        $asistente = array($identificacion, $semestre,  $seleccionHoras, $aprobado, $matriculados, $promedioAnual, $beca, $horario, $informe, $HaSidoAsistente, $dondeAsistencia, $labores, $codigoModificacion);

        $ingresoEstudiante = new EstudianteModel();
        $ingresoAsistente = new AsistenciaModel();

        //si se encuentra en el sistema
        if($ingresoAsistente->haSidoAsistente($identificacion)){
            if($ingresoAsistente->haParticipado($identificacion, $semestre)){
                //Ya se encontraba inscrito para dichas horas
                echo '<script> alert("Ya se encuentra inscrito"); location.replace(document.referrer); </script>';
            }
            else {
                $ingresoAsistente->setIngresoAsistente($asistente);

                $this->sendConfirmationEmail($correo, $codigoModificacion);

                echo '<script> alert("Se ha inscrito correctamente.\\n\\n Por favor revise en en correo institucional la confirmación de la solicitud. "); window.location.href="'.dir.'/asistencia;  </script>';

                unset($_SESSION['cedIngresada']);
                unset($_SESSION['tipoCedIngresada']);

            }
        } else {    //si no esta en el sistema
            echo '<script> alert("No se encuentra en el sistema, se redirecciona para el ingreso de nuevo asistente"); window.location.href="http://'.dir.'/index.php?c=asistente&a=asistenteNuevo" </script>';
        }
    }

    public function ingresarAsistente(){
        $identificacion     = $_SESSION['cedIngresada'];
        $aprobado           = $_POST['aprobado'];
        $seleccionHoras     = $_POST['seleccionHoras'];
        $nombre             = $_POST['nombre'];
        $apellido1          = $_POST['apellido1'];
        $apellido2          = $_POST['apellido2'];
        $correo             = $_POST['correo'];
        $direccion          = $_POST['direccion'];
        $telefono           = $_POST['telefono'];
        $carnet             = strtoupper($_POST['carnet']);
        $carrera            = $_POST['carrera'];
        $matriculados       = $_POST['matriculados'];
        $promedioAnual      = $_POST['promedioAnual'];
        $beca               = $_POST['beca'];
        $HaSidoAsistente    = $_POST['HaSidoAsistente'];
        $dondeAsistencia    = $_POST['dondeAsistencia'];
        $labores            = $_POST['labores'];
        $numCuenta          = $_POST['numeroCuenta'];
        $informeBanco       = $_POST['informeBanco'];
        $informe            = $_POST['informe'];
        $experienciaa       = $_POST['experiencia'];
        $horarioo           = $_POST['horario'];
        $experiencia        = ' ';
        $horario            = '';

        if(!empty($seleccionHoras)){
            $cuenta = count($seleccionHoras);
            if ($cuenta < 3 && $cuenta > 0 ){
                if($cuenta == 2){
                    $seleccionHoras = '3';
                } else {
                    $seleccionHoras = $seleccionHoras[0];
                }
            }
        }

        if(!empty($experienciaa)){
            $cuenta = count($experienciaa);

            for($i = 0; $i < $cuenta; $i++){
                if($i == $cuenta -1){
                    $experiencia .= 'Otros:'. $experienciaa[$i] . ".";
                } else {
                    $experiencia .= $experienciaa[$i] . ",";
                }
            }
        }

        if(!empty($horarioo)){
            $cuenta = count($horarioo);

            for($i = 0; $i < $cuenta; $i++){
                $horario .= $horarioo[$i] . ",";
            }
        } else {
            echo '<script> alert("Debe ingresar su horario de disponibilidad para realizar las horas"); location.replace(document.referrer); </script>';
        }

        date_default_timezone_set('America/Costa_Rica');
        $fecha = date('Y-m-d H:i:s');
        $obtenerSemestre = new SemestreModel();
        $semestre = $obtenerSemestre->getSemestreActual($fecha);
        $codigoModificacion = $this->generarNuevoCodigo();

        $estudiante = array($identificacion, $carnet, $nombre, $apellido1, $apellido2, $carrera, $correo, $telefono, $direccion, $numCuenta, $informeBanco, $experiencia);
        $asistente = array($identificacion, $semestre,  $seleccionHoras, $aprobado, $matriculados, $promedioAnual, $beca, $horario, $informe, $HaSidoAsistente, $dondeAsistencia, $labores, $codigoModificacion);

        $ingresoEstudiante = new EstudianteModel();
        $ingresoAsistente = new AsistenciaModel();

        //si todavia no ha sido asistente
        if(!$ingresoAsistente->haSidoAsistente($identificacion)){
            //Se verifica si ya participó para las horas dichas
            if($ingresoAsistente->haParticipado($identificacion, $semestre, $seleccionHoras)){
                //Ya se encontraba inscrito para dichas horas
                if(isset($_SESSION['formModificado']) and $_SESSION['formModificado'] == true){
                    $ingresoEstudiante->actualizarEstudiante($estudiante);
                    $ingresoAsistente->actualizarAsistente($asistente);
                    echo '<script> alert("Formulario Modificado Correctamente"); window.location.href="'.dir.'/asistencia" </script>';
                } else {
                    echo '<script> alert("Ya se encuentra inscrito"); location.replace(document.referrer); </script>';
                }
            } else {
                if($ingresoEstudiante->enSistemaPeticion($identificacion)){
                    $ingresoEstudiante->actualizarEstudiante($estudiante);
                    $ingresoAsistente->actualizarAsistente($asistente);
                } else {
                    $ingresoEstudiante->ingresoEstudianteAsistente($estudiante);
                    $ingresoAsistente->setIngresoAsistente($asistente);
                    
                    $this->sendConfirmationEmail($correo, $codigoModificacion);
                    
                    echo '<script> alert("Se ha inscrito correctamente.\\n\\n Por favor revise en en correo institucional la confirmación de la solicitud. "); window.location.href="'.dir.'/asistencia; </script>';

                }
            }

            unset($_SESSION['cedIngresada']);
            unset($_SESSION['formModificado']);
        } else {    //si ya fue asistente
            echo '<script> alert("Ya se encuentra en el sistema, se redirecciona para el ingreso de un asistente del Decanato"); window.location.href="http://'.dir.'/index.php?c=asistente&a=siAsistente" </script>';
        }

    }

    private function sendConfirmationEmail($correo, $codigo){
        $mailer = new Mailer();
        $plantilla = new PlantillaCorreoConfirmacion();
        $mailSubject = 'Confirmacion de Formulario Asistencia Decanato Ingenieria';
        $mailBody = $plantilla->getPlantilla($codigo);
        $mailer->sendEmail($correo, $mailSubject, $mailBody);
    }

    private function generarNuevoCodigo(){
        
        $cantidadDigitos = 8;
        $codigoNuevo = $this->generarCodigoAlfanumericoAleatorio($cantidadDigitos);
        $unico = $this->verificarCodigoUnico($codigoNuevo);
        while(!$unico){
            $codigoNuevo = $this->generarCodigoAlfanumericoAleatorio($cantidadDigitos);
            $unico = $this->verificarCodigoUnico($codigoNuevo);
        }
        return $codigoNuevo;
    }

    private function verificarCodigoUnico($codigo){
        $asistente = new AsistenciaModel();
        $listaCodigos = $asistente->getListaCodigos();
        if($listaCodigos != null){
            $cantidadCodigos = count($listaCodigos);
            for($i = 0; $i < $cantidadCodigos; $i++){
                if($listaCodigos[$i] == $codigo){
                    return false;
                }
            }
        }
        
        return true;
    }

    public function generarCodigoAlfanumericoAleatorio($cantidadDigitos){
        $caracteresValidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cantidadCaracteres = strlen($caracteresValidos);
        $codigoAleatorio = '';
        for($i = 0; $i < $cantidadDigitos; $i++){
            $charAleatorio = $caracteresValidos[mt_rand(0, $cantidadCaracteres - 1)];
            $codigoAleatorio .= $charAleatorio;
        }
    
        return $codigoAleatorio;
    }
}

?>