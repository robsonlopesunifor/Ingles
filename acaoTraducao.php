<?php 
require_once 'Tradutor.php';

$acao = $_GET["acao"];
$lista_De_Palavras = $_GET["palavras"];
$frase = $_GET["frase"];
$chave = $_GET["chave"];

if($acao == "retornarPalavras")
{
    $tradutor = new Tradutor();
    echo $tradutor->imprimir_Palavras_Nao_Traduzidas();
}
else if($acao == "gravarPalavras")
{
    $tradutor = new Tradutor();
    echo $tradutor->fragmentar_Lista_De_Palavras_e_gravar($lista_De_Palavras);
}
else if($acao == "gravarFrase")
{
    $tradutor = new Tradutor();
    echo $tradutor->gravar_frase($chave,$frase);
}else if($acao == "dadosDaPalavra")
{
    $tradutor = new Tradutor();
    echo $tradutor->retornar_dados_da_palavra($chave);
}

?>