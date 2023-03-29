<?php 

    class SemestreModel extends Model{

        //private $db;
        private $semestre;
        private $fechaInicio;
        private $fechaFin;

        public function __construct()
        {
            parent::__construct();
        }

        //sets y gets de la clase semestre
        public function getSemestre()
        {
            return $this->semestre;
        }

        public function setSemestre($semestre)
        {
            $this->semestre = $semestre;
        }

        public function getFechaInicio()
        {
            return $this->fechaInicio;
        }

        public function setFechaInicio($fechaInicio)
        {
            $this->fechaInicio = $fechaInicio;
        }

        public function getFechaFin()
        {
            return $this->fechaFin;
        }

        public function setFechaFin($fechaFin)
        {
            $this->fechaFin = $fechaFin;
        }

        //obtener semestre actual
        public function getSemestreActual($fecha)
        {
            $sql = $this->db->connection()->query("SELECT Semestre_Smstr FROM `tbl_semestre` WHERE '" .$fecha. "' BETWEEN FechaIni_Smstr AND FechaFin_Smstr;");
            $semestreActual = mysqli_fetch_row($sql);
            if (isset($semestreActual[0])){
                return $semestreActual[0];
            } else {
                return 0;
            }
        }

        public function getformularioActivo($semestre)
        {
            $sql = $this->db->connection()->query("SELECT Formulario_Activo FROM `tbl_semestre` WHERE Semestre_Smstr = '".$semestre."';");
            $semestreActivo = mysqli_fetch_row($sql);
            if(isset($semestreActivo[0]) && $semestreActivo[0] == 1){
                return true;
            } else {
                return false;
            }

        }
    }
    
?>