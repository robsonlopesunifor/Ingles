<?php 
class Palavra
{ 
    private $link = null;
    private $sql = "";
    private $array_palavras = array();
    private $array_palavras_acumuladas = array();
    private $conjunto_de_palavras = " ";
    private $quantidade_de_repetição = 5;
    private $embaralhar = false;
    
    public function Palavra() {
        $this->link = new mysqli('localhost', 'root', '', 'idioma');
        mysqli_query($this->link,"SET NAMES 'utf8'");
        if (!$this->link) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error()); 
        }
    }
    
    public function setar_chave_da_frase_e_repeticao_e_retornar_conjunto_de_palavras($chave_frase, $quantidade_de_repetição, $embaralhar){
        $this->array_palavras = array();
        $this->conjunto_de_palavras = " ";
        $this->chave_frase = $chave_frase;
        $this->quantidade_de_repetição = $quantidade_de_repetição;
        $this->embaralhar = $embaralhar;
        $this->construir_palavras_da_frase();
        return $this->conjunto_de_palavras;
    }
    
    public function construir_palavras_da_frase(){
        $this->sql_retorna_palavras_por_chave_da_frase();
        $this->preencher_array_paragrafo();
        $this->embaralhar_array();
        $this->montar_conjunto_de_palavras();
    }
    
    public function retornar_palavras_acumuladas($repeticoes_palavras_correntes){
        $palavras = '';
        for($i = 0; $i < count($this->array_palavras_acumuladas); $i++){
            for($j = 0; $j < $repeticoes_palavras_correntes; $j++)
                $palavras .= $this->array_palavras_acumuladas[$i][0].". ".$this->array_palavras_acumuladas[$i][1].".<br/>";
        }
        return $palavras;
    }
    
    private function sql_retorna_palavras_por_chave_da_frase(){
        
        $this->sql = "SELECT palavra.TRADUCAO_PAL,palavra.PALAVRA_PAL,palavra.FRASE_PAL,palavra.FRASE_TRADUZIDA_PAL ";
        $this->sql .= "from  frase inner join minelmonico inner join palavra ON  ";
        $this->sql .= "frase.KEY_FRASE_FRA = minelmonico.KEY_FRASE_MIN && minelmonico.KEY_PALAVRA_MIN = palavra.KEY_PALAVRA_PAL ";
        $this->sql .= "where frase.KEY_FRASE_FRA = ".$this->chave_frase." && palavra.FRASE_PAL != 'null';";    
    }
    
    private function preencher_array_paragrafo(){
        $RespostaDaQuery = $this->link->query($this->sql);
        $contador = 0;
        while($RF = $RespostaDaQuery->fetch_assoc()) {
            $this->array_palavras[$contador] = array();
            $this->array_palavras[$contador][0] = $RF['PALAVRA_PAL'];
            $this->array_palavras[$contador][1] = $RF['FRASE_PAL'];
            $contador++;
        }
        $this->preencher_array_palavras_acumuladas($this->array_palavras);
    }
    private function embaralhar_array(){
        if($this->embaralhar == true)
        shuffle($this->array_palavras);
    }
    private function montar_conjunto_de_palavras(){
        $quantidade_de_palavras = count($this->array_palavras);
        for($i = 0;$i < $quantidade_de_palavras;$i++){
            $this->conjunto_de_palavras .= "";
            for($j = 0;$j < $this->quantidade_de_repetição;$j++)
                $this->conjunto_de_palavras .= $this->array_palavras[$i][0].". ".$this->array_palavras[$i][1].".<br/>";
        }
    }
    
    private function preencher_array_palavras_acumuladas($array_palavras){
        for($i = 0;$i < count($array_palavras);$i++)
            $this->array_palavras_acumuladas[] = $array_palavras[$i];
    }
}

?>