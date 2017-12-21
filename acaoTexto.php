<?php 
require_once 'gravarTexto.php';
require_once 'construirTexto.php';
require_once 'Tradutor.php';

$acao = $_POST["acao"];
$idioma = $_POST["idioma"];
$textoIngles = $_POST["textoIngles"];
$textoPortugues = $_POST["textoPortugues"];
$tituloIngles = $_POST["tituloIngles"];
$tituloPortugues = $_POST["tituloPortugues"];

//$palavra = "house";

if($acao == "gravar")
{
    $gravar = new Gravar();
    $gravar->fragmentarGravar($idioma,$textoIngles,$textoPortugues,$tituloPortugues,$tituloIngles);
}
else if($acao == "contruir")
{
    //$construir = new Construir();
    //$construir->construirTexto($idioma,$textoIngles,$textoPortugues,$tituloPortugues,$tituloIngles);
}

?>