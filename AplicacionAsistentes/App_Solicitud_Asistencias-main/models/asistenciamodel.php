<?php

    class AsistenciaModel extends Model {
        private $asistentes;
        //private $db;

        private $tipoAsistencia;
        private $creditosAprobados;
        private $creditosMatriculados;
        private $ponderadoAnual;
        private $beca;
        private $asistenciasOtrosLados;
        private $asistenciasOtrosLadosDonde;
        private $asistenciasOtrosLadosLabores;
        private $horario;
        private $informeMatricula;

        public function __construct(){
            parent::__construct();
        }

        public function getTipoAsistencia(){
            return $this->tipoAsistencia;
        }

        public function getCantidadCreditos(){
            return $this->creditosAprobados;
        }

        public function getCreditosMatriculados(){
            return $this->creditosMatriculados;
        }

        public function getPonderadoAnual(){
            return $this->ponderadoAnual;
        }

        public function getseleccionBecaEstimulo(){
            return $this->beca;
        }

        public function getAsistenciasOtrosLados(){
            return $this->asistenciasOtrosLados;
        }

        public function getDondeAsistencias(){
            return $this->asistenciasOtrosLadosDonde;
        }

        public function getLaboresAsistencias(){
            return $this->asistenciasOtrosLadosLabores;
        }

        public function getHorarioDisponible(){
            return $this->horario;
        }

        public function getInformeMatricula(){
            return $this->informeMatricula;
        }

        //metodo que ingresa asistentes
        public function setIngresoAsistente($asistente){
            if($asistente[10]  != " "){
                $sqlAsistente = $this->db->connection()->query("INSERT INTO tbl_asistente (Cedula_Astnt_Estdt, Semestre_Astnt_Smstr, TipoAsistencia_Astnt, CreditosAprobados_Astnt, CreditosMatriculados_Astnt, PromedioAnual_Astnt, BecaEstimulo_Astnt, HorarioDisponibilidad_Astnt, InformeMatricula_Astnt, HaSidoAsistente_Astnt, DondeAsistencia_Astnt, Labores_Astnt, Codigo_Astnt) VALUES ('$asistente[0]', '$asistente[1]', '$asistente[2]', '$asistente[3]', '$asistente[4]', '$asistente[5]', '$asistente[6]', '$asistente[7]', '$asistente[8]', '$asistente[9]', '$asistente[10]', '$asistente[11]', '$asistente[12]')");	
            } else {
                $sqlAsistente = $this->db->connection()->query("INSERT INTO tbl_asistente (Cedula_Astnt_Estdt, Semestre_Astnt_Smstr, TipoAsistencia_Astnt, CreditosAprobados_Astnt, CreditosMatriculados_Astnt, PromedioAnual_Astnt, BecaEstimulo_Astnt, HorarioDisponibilidad_Astnt, InformeMatricula_Astnt, HaSidoAsistente_Astnt, DondeAsistencia_Astnt, Labores_Astnt, Codigo_Astnt) VALUES ('$asistente[0]', '$asistente[1]', '$asistente[2]', '$asistente[3]', '$asistente[4]', '$asistente[5]', '$asistente[6]', '$asistente[7]', '$asistente[8]', '$asistente[9]', NULL, NULL, '$asistente[12]')");
            }
        }

        public function actualizarAsistente($asistente)
        {
            if($asistente[9]  == "Si"){
                $sqlAsistente = $this->db->connection()->query("UPDATE tbl_asistente SET TipoAsistencia_Astnt = '" .$asistente[2]. "', CreditosAprobados_Astnt = '" .$asistente[3]. "', CreditosMatriculados_Astnt = '" .$asistente[4]. "', PromedioAnual_Astnt = '" .$asistente[5]. "', BecaEstimulo_Astnt ='" .$asistente[6]. "', HorarioDisponibilidad_Astnt ='" .$asistente[7]. "', InformeMatricula_Astnt ='" .$asistente[8]. "', HaSidoAsistente_Astnt = '" .$asistente[9]. "', DondeAsistencia_Astnt ='" .$asistente[10]. "', Labores_Astnt = '" .$asistente[11]. "' WHERE Cedula_Astnt_Estdt = '" .$asistente[0]. "' ;");
            } else {
                $sqlAsistente = $this->db->connection()->query("UPDATE tbl_asistente SET TipoAsistencia_Astnt = '" .$asistente[2]. "', CreditosAprobados_Astnt = '" .$asistente[3]. "', CreditosMatriculados_Astnt = '" .$asistente[4]. "', PromedioAnual_Astnt = '" .$asistente[5]. "', BecaEstimulo_Astnt ='" .$asistente[6]. "', HorarioDisponibilidad_Astnt ='" .$asistente[7]. "', InformeMatricula_Astnt ='" .$asistente[8]. "', HaSidoAsistente_Astnt = '" .$asistente[9]. "', DondeAsistencia_Astnt = NULL, Labores_Astnt = NULL WHERE Cedula_Astnt_Estdt = '" .$asistente[0]. "' ;");
            }
        }

        public function haParticipado($cedula, $semestre){
            $sql = $this->db->connection()->query("SELECT * FROM tbl_asistente WHERE Cedula_Astnt_Estdt = '" .$cedula. "' AND Semestre_Astnt_Smstr = '" .$semestre. "';" );
            $cantidad = mysqli_num_rows($sql);

            if($cantidad == 1)
            {
                return true;
            }
            return false;
        }

        public function esAsistente($semestre, $cedulaAsistente){
            $sql = $this->db->connection()->query("SELECT * FROM tbl_asistente WHERE Aprobado_Astnt = 1 AND Semestre_Astnt_Smstr = '" .$semestre. "' AND Cedula_Astnt_Estdt = '" .$cedulaAsistente. "';");

            $cantidad = mysqli_num_rows($sql);

            if($cantidad == 1)
            {
                return true;
            }
            return false;
        }

        public function getCedula(){
            $sql = $this->db->connection()->query("SELECT Cedula_Ssn_Astnt_Estdt FROM tbl_sesion A WHERE HoraFin_Ssn IS NULL; ");
            $asistente = mysqli_fetch_row($sql);
            return $asistente[0];
        }

        public function getCodigodeModificacion($cedula){
            $sql = $this->db->connection()->query("SELECT Codigo_Astnt FROM tbl_asistente Asist WHERE Asist.Cedula_Astnt_Estdt = ".$cedula."; ");
            $codigo = mysqli_fetch_row($sql);
            $cantidad = mysqli_num_rows($sql);
            if($cantidad != 1){
                return -1;
            }
            return $codigo[0];
        }

        public function setCodigodeModificacion($cedula, $codigo){
            $sqlCodigo  = $this->db->connection()->query("UPDATE tbl_asistente SET Codigo_Astnt = '".$codigo."' WHERE Cedula_Ssn_Astnt_Estdt = '" .$cedula."' ;");
        }

        public function getNombre($cedula){
            $sql = $this->db->connection()->query("SELECT CONCAT(E.Nombre_Estdt, ' ', E.Apellido1_Estdt,' ', E.Apellido2_Estdt) FROM tbl_asistente A JOIN tbl_estudiante E ON A.Cedula_Astnt_Estdt = E.Cedula_Estdt WHERE A.Cedula_Astnt_Estdt = ".$cedula."; ");
            $asistente = mysqli_fetch_row($sql);
            return $asistente[0];
        }

        public function haSidoAsistente($cedula){
            $sql = $this->db->connection()->query("SELECT Cedula_Astnt_Estdt FROM tbl_asistente WHERE Aprobado_Astnt = 1 AND Cedula_Astnt_Estdt = '" .$cedula. "';");
            $cantidad = mysqli_num_rows($sql);
            if($cantidad == 1) {
                return true;
            }
            return false;
        }

        public function getListaCodigos(){
            $sql = $this->db->connection()->query("SELECT Codigo_Astnt FROM tbl_asistente WHERE Codigo_Astnt IS NOT NULL;");
            $codigos = mysqli_fetch_row($sql);
            return $codigos;
        }

        public function getAsistentes(){
            foreach($this->db->connection()->query("SELECT Cedula_Astnt_Estdt, Semestre_Astnt_Smstr, TipoAsistencia_Astnt, CreditosAprobados_Astnt, CreditosMatriculados_Astnt, PromedioAnual_Astnt, BecaEstimulo_Astnt, HaSidoAsistente_Astnt, DondeAsistencia_Astnt, Labores_Astnt, HorarioDisponibilidad_Astnt, InformeMatricula_Astnt, Aprobado_Astnt, HorasAsignadas_Astnt FROM tbl_asistente") as $response){
                $this->asistentes[] = $response;
            };
            return $this->asistentes;
        }

        
        public function getDatosAsistente($cedula, $semestre){
            
            $sql = $this->db->connection()->query("SELECT * FROM tbl_asistente asist WHERE asist.Cedula_Astnt_Estdt = '" .$cedula. "' AND asist.Semestre_Astnt_Smstr = '" .$semestre. "';");
            $sqlAsistente = mysqli_fetch_row($sql);
            $this->tipoAsistencia = $sqlAsistente[2];
            $this->creditosAprobados = $sqlAsistente[4];
            $this->creditosMatriculados = $sqlAsistente[5];
            $this->ponderadoAnual = $sqlAsistente[6];
            $this->beca = $sqlAsistente[7];
            $this->asistenciasOtrosLados = $sqlAsistente[8];
            $this->asistenciasOtrosLadosDonde = $sqlAsistente[9];
            $this->asistenciasOtrosLadosLabores = $sqlAsistente[10];
            $this->horario = $sqlAsistente[11];
            $this->informeMatricula = $sqlAsistente[12];
            
        }

    }

?>