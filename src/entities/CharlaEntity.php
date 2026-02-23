<?php
    namespace Mgj\ProyectoBlog2025\Entities;

    class CharlaEntity {
        private $ID_Charla;
        private $Titulo;
        private $Fecha_Charla;
        private $Lugar;

        public function getIDCharla() { return $this->ID_Charla; }
        public function setIDCharla($ID_Charla) { $this->ID_Charla = $ID_Charla; }

        public function getTitulo() { return $this->Titulo; }
        public function setTitulo($Titulo) { $this->Titulo = $Titulo; }

        public function getFechaCharla() { return $this->Fecha_Charla; }
        public function setFechaCharla($Fecha_Charla) { $this->Fecha_Charla = $Fecha_Charla; }

        public function getLugar() { return $this->Lugar; }
        public function setLugar($Lugar) { $this->Lugar = $Lugar; }
}