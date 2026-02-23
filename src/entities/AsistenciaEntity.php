<?php
    namespace Mgj\ProyectoBlog2025\Entities;

    class AsistenciaEntity {
        private $ID_Asistencia;
        private $ID_Charla;
        private $ID_Alumno;
        private $Fecha_Registro;

        public function getIDAsistencia() { return $this->ID_Asistencia; }
        public function setIDAsistencia($ID_Asistencia) { $this->ID_Asistencia = $ID_Asistencia; }

        public function getIDCharla() { return $this->ID_Charla; }
        public function setIDCharla($ID_Charla) { $this->ID_Charla = $ID_Charla; }

        public function getIDAlumno() { return $this->ID_Alumno; }
        public function setIDAlumno($ID_Alumno) { $this->ID_Alumno = $ID_Alumno; }

        public function getFechaRegistro() { return $this->Fecha_Registro; }
        public function setFechaRegistro($Fecha_Registro) { $this->Fecha_Registro = $Fecha_Registro; }
}