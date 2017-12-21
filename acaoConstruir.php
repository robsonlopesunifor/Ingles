<link rel="stylesheet" type="text/css" href="SMACSS/Base/padrao.css" >
<link rel="stylesheet" type="text/css" href="SMACSS/Layout/livro.css" >
<link rel="stylesheet" type="text/css" href="SMACSS/Modelo/cartoes.css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script> 
        $(document).ready(function(){
            $.getScript("minelmonico.js");
        });
        </script>
            
<?php
require_once 'construirTexto.php';

$acao = $_GET["acao"];
$chave_texto = $_GET["chave_texto"];

if($acao == "contruir")
{
    $construir = new Construir();
    echo $construir->montarBaralho($chave_texto,true);
}
else if($acao == "minelmonico")
{
    $construir = new Construir();
    echo $construir->getMinelmonicosReferenteAoParagrafo(310);
}

?>