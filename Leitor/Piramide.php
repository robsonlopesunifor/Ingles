<?php 
require_once 'Frase.php';
require_once 'Palavra.php';

class Piramide
{ 
    private $link = null;
    private $sql = "";
    private $array_de_chave_de_frase = array();
    private $array_frases = array();
    private $array_palavras = array();
    private $chave_texto = 98;
    private $texto = " ";
    private $frase;
    private $palavra;
    private $paragrafo_anterior = 0;
    
    public function Piramide() {
        $this->frase = new Frase();
        $this->palavra = new Palavra();
        $this->link = new mysqli('localhost', 'root', '', 'idioma');
        mysqli_query($this->link,"SET NAMES 'utf8'");
        if (!$this->link) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }
        
    }
    
    public function retornar_piramide_por_paragrafo($chave_paragrafo){
        $this->sql_retorna_relacao_paragrafo_frase();
        $this->preencher_array_paragrafo();
        $this->montar_texto();
    }
    
    private function sql_retorna_relacao_paragrafo_frase(){
        
        $this->sql  = "SELECT texto.KEY_TEXTO_TEX, paragrafo.KEY_PARAGRAFO_PAR, frase.KEY_FRASE_FRA "; 
        $this->sql .= "from texto inner join paragrafo inner join frase ON ";
        $this->sql .= "texto.KEY_TEXTO_TEX = paragrafo.KEY_TEXTO_PAR && paragrafo.KEY_PARAGRAFO_PAR = frase.KEY_PARAGRAFO_FRA ";
        $this->sql .= "where texto.KEY_TEXTO_TEX = 133";
        
    }
    
    private function preencher_array_paragrafo(){
        $RespostaDaQuery = $this->link->query($this->sql);
        $this->array_de_chave_de_frase = array();
        
        $i = 0;
        while($RF = $RespostaDaQuery->fetch_assoc()) {
            if($this->paragrafo_anterior != $RF['KEY_PARAGRAFO_PAR']){
               $i++;
               $j = 0; 
               $this->array_de_chave_de_frase[$i][$j] = $RF['KEY_PARAGRAFO_PAR'];
               $this->paragrafo_anterior = $RF['KEY_PARAGRAFO_PAR'];
            }
            $this->array_de_chave_de_frase[$i][++$j] = $RF['KEY_FRASE_FRA'];
        }
    }
    
    private function montar_texto(){
        $quantidade_de_paragrafos = count($this->array_de_chave_de_frase);
        
        for($i = 1;$i <= $quantidade_de_paragrafos;$i++){
            $quantidade_de_frase = count($this->array_de_chave_de_frase[$i]);
            
            echo "<h2>PARAGRAFO ".$i."</h2>";
            for($j = 1;$j < $quantidade_de_frase;$j++)
                $this->setar_paragrafo_retornar_conjunto_de_palavras_e_frases($this->array_de_chave_de_frase[$i][$j]);
        }
    }
    
    private function setar_paragrafo_retornar_conjunto_de_palavras_e_frases($chave_frase)
    {    
        //echo "<h4>PALAVRAS</h4>";
        //echo $this->palavra->setar_chave_da_frase_e_repeticao_e_retornar_conjunto_de_palavras($chave_frase,15,false);
        echo "<h4>FRSASE</h4>";
        echo $this->frase->setar_chave_da_frase_repeticao_e_retornar_frase($chave_frase,20,1,false); 
        //echo "<h4>PALAVRAS CORRENTES</h4>";
        //echo $this->palavra->retornar_palavras_acumuladas(10);
        //echo "<h4>FRASES CORRENTES</h4>";
        //echo $this->frase->retornar_frases_acumuladas(10);
    }
}
?>