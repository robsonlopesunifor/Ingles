<?php 
class Frase
{ 
    private $link = null;
    private $sql = "";
    private $array_frase = array();
    private $array_frase_acumuladas = array();
    private $chave_texto = 98;
    private $texto = " ";
    private $repeticao_de_frase = 2;
    private $repeticao_de_conjunto_de_frase = 2;
    private $embaralhar = false;
    
    public function Frase() {
        $this->link = new mysqli('localhost', 'root', '', 'idioma');
        mysqli_query($this->link,"SET NAMES 'utf8'");
        if (!$this->link) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error()); 
        }
        
    }
    
    
    public function setar_chave_do_texto_repeticao_e_retornar_texto($chave_texto, $repeticao_de_frase, $repeticao_de_conjunto_de_frase, $embaralhar){
        $this->texto = " ";
        $this->chave_texto = $chave_texto;
        $this->repeticao_de_frase = $repeticao_de_frase;
        $this->repeticao_de_conjunto_de_frase = $repeticao_de_conjunto_de_frase;
        $this->embaralhar = $embaralhar;
        $this->repitir_conjunto_de_frases();
        return $this->texto;
    }
    
    public function setar_chave_da_frase_repeticao_e_retornar_frase($chave_frase, $repeticao_de_frase, $repeticao_de_conjunto_de_frase, $embaralhar){
        $this->texto = " ";
        $this->chave_frase = $chave_frase;
        $this->repeticao_de_frase = $repeticao_de_frase;
        $this->repeticao_de_conjunto_de_frase = $repeticao_de_conjunto_de_frase;
        $this->embaralhar = $embaralhar;
        $this->repitir_conjunto_de_frases();
        return $this->texto;
    }
    
    public function retornar_frases_acumuladas($repeticoes_frases_correntes){
        $frases = '';
        $total_de_frases_acumuladas = count($this->array_frase_acumuladas);
        for($i = 0; $i < $total_de_frases_acumuladas; $i++){
            for($j = 0; $j < $repeticoes_frases_correntes; $j++)
                $frases .= "-".$this->array_frase_acumuladas[$i]."</br>";
        }
        return $frases;
    }
    
    private function repitir_conjunto_de_frases(){
        for($i = 0; $i < $this->repeticao_de_conjunto_de_frase;$i++)
            $this->construirFrases($i);
    }
    /*
    private function construirFrases($construir_texto){
        $this->sql_retorna_texto_pela_chave_do_texto();
        $this->preencher_array_paragrafo();
        $this->embaralhar_array();
        $this->texto .= "<h4>TEXT: ".$construir_texto."</h4> ";
        $this->montar_texto();
    }*/
    
    private function construirFrases($construir_texto){
        $this->sql_retorna_frase_pela_chave_da_frase();
        $this->preencher_array_paragrafo();
        $this->embaralhar_array();
        $this->montar_texto();
    }
    
    private function sql_retorna_texto_pela_chave_do_texto(){
        $this->sql = "SELECT texto.KEY_TEXTO_TEX, texto.TITULO_PT_TEX, paragrafo.KEY_PARAGRAFO_PAR, paragrafo.PARAGRAFO_1_PAR, frase.FRASE_1_FRA ";
        $this->sql .= "from paragrafo inner join texto inner join frase ON ";
        $this->sql .= "texto.KEY_TEXTO_TEX = paragrafo.KEY_TEXTO_PAR && paragrafo.KEY_PARAGRAFO_PAR = frase.KEY_PARAGRAFO_FRA ";
        $this->sql .= "where texto.KEY_TEXTO_TEX = ".$this->chave_texto;
    }
    
    private function sql_retorna_frase_pela_chave_da_frase(){
        $this->sql = "SELECT frase.FRASE_1_FRA from frase where frase.KEY_FRASE_FRA = ".$this->chave_frase;
    }
    
    private function preencher_array_paragrafo(){
        $RespostaDaQuery = $this->link->query($this->sql);
        $this->array_frase = array();
        
        while($RF = $RespostaDaQuery->fetch_assoc()) {
            $this->array_frase[] = $RF['FRASE_1_FRA'];
            $this->array_frase_acumuladas[] = $RF['FRASE_1_FRA'];
        }
    }
    private function embaralhar_array(){
        if($this->embaralhar == true)
        shuffle($this->array_frase);
    }
    private function montar_texto(){
        $quantidade_de_frase = count($this->array_frase);
        
        for($i = 0;$i < $quantidade_de_frase;$i++){
            $this->texto .= " ";
            for($j = 0;$j < $this->repeticao_de_frase;$j++)
                $this->texto .= $this->limpar_e_estrutura_frase($this->array_frase[$i]);
        }
    }
    private function limpar_e_estrutura_frase($frase){
        $paragrafo = str_replace('<','',$frase);
        $paragrafo = str_replace('>','',$frase);
        return $paragrafo."<br/>";
    }
    
}
?>