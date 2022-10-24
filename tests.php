<?php

$filtro="";
$FechaCargaHoy = date('Y-m-d H:i:s');
//resto 7 días
$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 7 days")); 
$filtro=" and fechaCarga >= $FechaCargaHoyTexto ";
echo $filtro."<br>";

$FechaCargaHoy = date('Y-m-d H:i:s');
//resto 15 días
$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 2 weeks")); 
$filtro=" and fechaCarga >= $FechaCargaHoyTexto ";
echo $filtro."<br>";


$FechaCargaHoy = date('Y-m-d H:i:s');
//resto 15 días
$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 1 month")); 
$filtro=" and fechaCarga >= $FechaCargaHoyTexto ";
echo $filtro."<br>";

$FechaCargaHoy = date('Y-m-d H:i:s');
//resto 15 días
$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 3 months")); 
$filtro=" and fechaCarga >= $FechaCargaHoyTexto ";
echo $filtro."<br>";

$FechaCargaHoy = date('Y-m-d H:i:s');
//resto 15 días
$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 6 months")); 
$filtro=" and fechaCarga >= $FechaCargaHoyTexto ";
echo $filtro."<br>";

$FechaCargaHoy = date('Y-m-d H:i:s');
//resto 15 días
$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 1 year")); 
$filtro=" and fechaCarga >= $FechaCargaHoyTexto ";
echo $filtro."<br>";


?>