<?php

    class EstudianteModel extends Model {
        private $estudiantes;
        //private $db;

        private $cedula;
        private $carnet;
        private $nombre;
        private $apellido1;
        private $apellido2;
        private $carrera;
        private $correo;
        private $telefono;
        private $direccion;
        private $numeroCuenta;
        private $informeCuenta;
        private $experienciaEstudiante;

        public function __construct()
        {
            $this->estudiantes = array();
            parent::__construct();
        }

        //gets y sets de la clase estudiante
        public function getCedula(){
            return $this->cedula;
        }

        public function getCarnet(){
            return $this->carnet;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function getApellido1(){
            return $this->apellido1;
        }

        public function getApellido2(){
            return $this->apellido2;
        }

        public function getCarrera(){
            return $this->carrera;
        }

        public function getCorreo(){
            return $this->correo;
        }

        public function getTelefono(){
            return $this->telefono;
        }

        public function getDireccion(){
            return $this->direccion;
        }

        public function getNumCuenta(){
            return $this->numeroCuenta;
        }

        public function getInformeCuenta(){
            return $this->informeCuenta;
        }

        public function getExperiencia(){
            return $this->experienciaEstudiante;
        }

        //ingresar estudiante con caracteristicas simples
        public function ingresoEstudiante($cedulaEstdt, $carnetEstdt, $nombre, $apellido1, $apellido2, $carrera, $correo){
            $sql = $this->db->connection()->query("INSERT INTO tbl_estudiante (Cedula_Estdt, Carnet_Estdt, Nombre_Estdt, Apellido1_Estdt, Apellido2_Estdt, Carrera_Estdt, Correo_Estdt) 
                VALUES ('$cedulaEstdt', '$carnetEstdt', '$nombre', '$apellido1', '$apellido2', '$carrera', '$correo')");
            
            if($sql == 1)
            {    
                echo '<script> alert("Se ha agregado al estudiante con éxito"); history.back(); </script>';
            }

        }

        //ingresar estudiante con todas sus caracteristicas (es un asistente)
        public function ingresoEstudianteAsistente($estudiante){    
            if($estudiante[9] == " ") {
                if($estudiante[11] == " ") {
                    $sqlEstudiante = $this->db->connection()->query("INSERT INTO tbl_estudiante VALUES 
                    ('$estudiante[0]', '$estudiante[1]', '$estudiante[2]', '$estudiante[3]', '$estudiante[4]', '$estudiante[5]', '$estudiante[6]', '$estudiante[7]', '$estudiante[8]',
                    NULL, NULL, NULL)");
                } else {
                    if($estudiante[11] == " ")
                    $sqlEstudiante = $this->db->connection()->query("INSERT INTO tbl_estudiante VALUES 
                    ('$estudiante[0]', '$estudiante[1]', '$estudiante[2]', '$estudiante[3]', '$estudiante[4]', '$estudiante[5]', '$estudiante[6]', '$estudiante[7]', '$estudiante[8]',
                    NULL, NULL, '$estudiante[11]')");	
                }
            } else {
                if($estudiante[11] == " "){
                    $sqlEstudiante = $this->db->connection()->query("INSERT INTO tbl_estudiante VALUES 
                    ('$estudiante[0]', '$estudiante[1]', '$estudiante[2]', '$estudiante[3]', '$estudiante[4]', '$estudiante[5]', '$estudiante[6]', '$estudiante[7]', '$estudiante[8]',
                    '$estudiante[9]', '$estudiante[10]', NULL)");	
                } else {
                    $sqlEstudiante = $this->db->connection()->query("INSERT INTO tbl_estudiante VALUES 
                    ('$estudiante[0]', '$estudiante[1]', '$estudiante[2]', '$estudiante[3]', '$estudiante[4]', '$estudiante[5]', '$estudiante[6]', '$estudiante[7]', '$estudiante[8]',
                    '$estudiante[9]', '$estudiante[10]', '$estudiante[11]')");	
                }
            }
        }

        //verifica si el estudiante ya esta dentro del sistema
        public function enSistemaPeticion($cedulaEstdt){
            $sql = $this->db->connection()->query("SELECT * FROM tbl_estudiante WHERE Cedula_Estdt = '$cedulaEstdt' ;" );
            $cantidad = mysqli_num_rows($sql);

            if($cantidad == 1){
                return true;
            }

            return false;
        }

        public function actualizarEstudianteAdmin($estudiante){
            $sql = $this->db->connection()->query("UPDATE tbl_estudiante SET Carnet_Estdt = '" .$estudiante[1]. "', Nombre_Estdt= '" .$estudiante[2]. "', Apellido1_Estdt = '" .$estudiante[3]. "', Apellido2_Estdt = '" .$estudiante[4]. "', Carrera_Estdt = '" .$estudiante[5]. "', Telefono_Estdt = '" .$estudiante[7]. "', Direccion_Estdt = '" .$estudiante[8]. "' WHERE Cedula_Estdt = '" .$estudiante[0]. "' ;");
            return $sql;
        }

        public function actualizarEstudiante($estudiante)
        {
            if($estudiante[9] == " ") {
                if($estudiante[11] == " ") {
                    $sql = $this->db->connection()->query("UPDATE tbl_estudiante SET Carnet_Estdt = '" .$estudiante[1]. "', Nombre_Estdt= '" .$estudiante[2]. "', Apellido1_Estdt = '" .$estudiante[3]. "', Apellido2_Estdt = '" .$estudiante[4]. "', Carrera_Estdt = '" .$estudiante[5]. "', Telefono_Estdt = '" .$estudiante[7]. "', Direccion_Estdt = '" .$estudiante[8]. "', NumeroCuenta_Estdt = NULL, InformeCuenta_Estdt = NULL, Experiencia_Estdt = NULL WHERE Cedula_Estdt = '" .$estudiante[0]. "' ;");
                } else {
                    $sql = $this->db->connection()->query("UPDATE tbl_estudiante SET Carnet_Estdt = '" .$estudiante[1]. "', Nombre_Estdt= '" .$estudiante[2]. "', Apellido1_Estdt = '" .$estudiante[3]. "', Apellido2_Estdt = '" .$estudiante[4]. "', Carrera_Estdt = '" .$estudiante[5]. "', Telefono_Estdt = '" .$estudiante[7]. "', Direccion_Estdt = '" .$estudiante[8]. "', NumeroCuenta_Estdt = NULL, InformeCuenta_Estdt = NULL, Experiencia_Estdt = '".$estudiante[11]."' WHERE Cedula_Estdt = '" .$estudiante[0]. "' ;");
                }
            } else {
                if($estudiante[11] == " ") {
                    $sql = $this->db->connection()->query("UPDATE tbl_estudiante SET Carnet_Estdt = '" .$estudiante[1]. "', Nombre_Estdt= '" .$estudiante[2]. "', Apellido1_Estdt = '" .$estudiante[3]. "', Apellido2_Estdt = '" .$estudiante[4]. "', Carrera_Estdt = '" .$estudiante[5]. "', Telefono_Estdt = '" .$estudiante[7]. "', Direccion_Estdt = '" .$estudiante[8]. "', NumeroCuenta_Estdt = '".$estudiante[9]."', InformeCuenta_Estdt = '".$estudiante[10]."', Experiencia_Estdt = NULL WHERE Cedula_Estdt = '" .$estudiante[0]. "' ;");
                } else {
                    $sql = $this->db->connection()->query("UPDATE tbl_estudiante SET Carnet_Estdt = '" .$estudiante[1]. "', Nombre_Estdt= '" .$estudiante[2]. "', Apellido1_Estdt = '" .$estudiante[3]. "', Apellido2_Estdt = '" .$estudiante[4]. "', Carrera_Estdt = '" .$estudiante[5]. "', Telefono_Estdt = '" .$estudiante[7]. "', Direccion_Estdt = '" .$estudiante[8]. "', NumeroCuenta_Estdt = '".$estudiante[9]."', InformeCuenta_Estdt = '".$estudiante[10]."', Experiencia_Estdt = '".$estudiante[11]."' WHERE Cedula_Estdt = '" .$estudiante[0]. "' ;");
                }
            }


        }

        public function datosCorrectos($identificacion, $carnet)
        {
            $sql = $this->db->connection()->query("SELECT * FROM tbl_estudiante WHERE Carnet_Estdt = '".$carnet."' AND Cedula_Estdt = '".$identificacion."';");
            
            $cantidad = mysqli_num_rows($sql);

            if($cantidad == 1)
            {
                return true;
            }
            return false;
        }
        
        public function getEstudiantes(){
            foreach($this->db->connection()->query("SELECT * FROM tbl_estudiante") as $response){
                $this->estudiantes[] = $response;
            };
            return $this->estudiantes;
        }

        public function getArchivosyXpEstudianteAdmin($identificacion){
            $sql = $this->db->connection()->query("SELECT Nombre_Estdt, Apellido1_Estdt, Apellido2_Estdt, NumeroCuenta_Estdt, InformeCuenta_Estdt FROM tbl_estudiante WHERE Cedula_Estdt = '".$identificacion."';");
            $sqlEstudiante = mysqli_fetch_array($sql);
            return $sqlEstudiante;
        }

        public function eliminarEstudianteAdmin($estudiante){
            $sql = $this->db->connection()->query("DELETE FROM tbl_estudiante WHERE Cedula_Estdt = '" .$estudiante[0]. "' ;");
            return $sql;
        }

        public function getDatosEstudiante($cedula){
            
            $sql = $this->db->connection()->query("SELECT * FROM tbl_estudiante estud WHERE estud.Cedula_Estdt = '" .$cedula. "';");
            $sqlEstudiante = mysqli_fetch_row($sql);
            $this->cedula = $sqlEstudiante[0];
            $this->carnet = $sqlEstudiante[1];
            $this->nombre = $sqlEstudiante[2];
            $this->apellido1 = $sqlEstudiante[3];
            $this->apellido2 = $sqlEstudiante[4];
            $this->carrera = $sqlEstudiante[5];
            $this->correo = $sqlEstudiante[6];
            $this->telefono = $sqlEstudiante[7];
            $this->direccion = $sqlEstudiante[8];
            $this->numeroCuenta = $sqlEstudiante[9];
            $this->informeCuenta = $sqlEstudiante[10];
            $this->experienciaEstudiante = $sqlEstudiante[11];
            
        }
    }

?>