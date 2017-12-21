<?php
require_once 'Texto.php';
require_once 'Paragrafo.php';
require_once 'Frase.php';
require_once 'Palavra.php';
require_once 'Piramide.php';

class Leitor{
 
    private $texto;
    private $paragrafo;
    private $frase;
    private $palavra;
    private $montar_texto = '';
    private $chave_texto = 133;
    
    public function Leitor(){
        $this->texto = new Texto();
        $this->paragrafo = new Paragrafo();
        $this->frase = new Frase();
        $this->palavra = new Palavra();
        $this->piramide = new Piramide();
        $this->empilhar_texto();
    }
    
    private function empilhar_texto(){
        
        $this->piramide->retornar_piramide_por_paragrafo(222);
        
        //echo $this->palavra->setar_chave_da_frase_e_repeticao_e_retornar_conjunto_de_palavras(853,5,false);
        //echo $this->palavra->setar_chave_e_repeticao_e_retornar_texto($this->chave_texto,5,true);
        
        //echo $this->frase->setar_chave_da_frase_repeticao_e_retornar_frase(853,5,1,false);
        //echo $this->frase->setar_chave_e_repeticao_e_retornar_texto($this->chave_texto,4,1,true);
        
        
        //echo $this->paragrafo->setar_chave_e_repeticao_e_retornar_texto($this->chave_texto,1,1,false);
        //echo $this->paragrafo->setar_chave_e_repeticao_e_retornar_texto($this->chave_texto,1,1,true);
        
        //echo $this->texto->setar_chave_e_repeticao_e_retornar_texto($this->chave_texto,1);
    }
    
    private function retornar_palavras_e_frases(){
        
        
        echo $this->palavra->setar_chave_da_frase_e_repeticao_e_retornar_conjunto_de_palavras(853,5,false);
        //echo $this->palavra->setar_chave_e_repeticao_e_retornar_texto($this->chave_texto,5,true);
        
        echo $this->frase->setar_chave_da_frase_repeticao_e_retornar_frase(853,5,1,false);
        //echo $this->frase->setar_chave_e_repeticao_e_retornar_texto($this->chave_texto,4,1,true);
    }
    
}

    $leitor = new Leitor();

?>