<?php
    namespace Mgj\ProyectoBlog2025\Helpers;

	class DateConversions{

        public static function formatearCastellano($fecha){
            // Desde AÑO-MES-DIA (Year-Month-Day) --> A DIA/MES/AÑO
            return date('d/m/Y', strtotime($fecha));
        }

        public static function formatearMysql($fecha){
            // Desde DIA-MES-AÑO (d/m/Y) --> A AÑO-MES-DIA (Y-m-d)
            return date('Y-m-d', strtotime($fecha));
        }
    }