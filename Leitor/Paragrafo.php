<?php 
class Paragrafo
{ 
    private $link = null;
    private $sql = "";
    private $array_paragrafo = array();
    private $texto = " ";
    private $repeticao_de_paragrafo = 2;
    private $repeticao_de_conjunto_de_paragrafo = 2;
    private $embaralhar = false; 
    private $chave_texto;
    
    public function Paragrafo() {
        $this->link = new mysqli('localhost', 'root', '', 'idioma');
        mysqli_query($this->link,"SET NAMES 'utf8'");
        if (!$this->link) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error()); 
        }
        
    }

    public function setar_chave_e_repeticao_e_retornar_texto($chave_texto, $repeticao_de_paragrafo, $repeticao_de_conjunto_de_texto, $embaralhar){
        $this->texto = " ";
        $this->chave_texto = $chave_texto;
        $this->repeticao_de_paragrafo = $repeticao_de_paragrafo;
        $this->repeticao_de_conjunto_de_texto = $repeticao_de_conjunto_de_texto;
        $this->embaralhar = $embaralhar;
        $this->repitir_conjunto_de_paragrafo();
        return $this->texto;
    }
    
    public function repitir_conjunto_de_paragrafo(){
        for($i = 0; $i < $this->repeticao_de_conjunto_de_paragrafo; $i++)
            $this->construir_paragrafo($i);
    }
    
    public function construir_paragrafo($construir_texto){
        $this->sql_retorna_paragrafo_por_chave();
        $this->preencher_array_paragrafo();
        $this->embaralhar_array();
        $this->texto .= "<h4>TEXT: ".$construir_texto."</h4> ";
        $this->montar_texto();
    }
    private function sql_retorna_paragrafo_por_chave(){
        $this->sql = "SELECT texto.KEY_TEXTO_TEX, texto.TITULO_PT_TEX, paragrafo.KEY_PARAGRAFO_PAR, paragrafo.PARAGRAFO_1_PAR ";
        $this->sql .= "from paragrafo inner join texto ON ";
        $this->sql .= "texto.KEY_TEXTO_TEX = paragrafo.KEY_TEXTO_PAR ";
        $this->sql .= "where texto.KEY_TEXTO_TEX = ".$this->chave_texto;
    }
    private function preencher_array_paragrafo(){
        $RespostaDaQuery = $this->link->query($this->sql);
        $this->array_paragrafo = array();
        
        while($RF = $RespostaDaQuery->fetch_assoc()) {
            $this->array_paragrafo[] = $RF['PARAGRAFO_1_PAR'];
        }
    }
    private function embaralhar_array(){
        if($this->embaralhar == true)
            shuffle($this->array_paragrafo);
    }
    private function montar_texto(){
        $quantidade_de_paragrafo = count($this->array_paragrafo);
        for($i = 0;$i < $quantidade_de_paragrafo;$i++){
            $this->texto .= "<h4>PARAGRAFO: ".$i."</h4> ";
            for($j = 0; $j < $this->repeticao_de_paragrafo;$j++)
                $this->texto .= $this->limpar_e_estrutura_paragrafo($this->array_paragrafo[$i]);
            }
    }
    private function limpar_e_estrutura_paragrafo($paragrafo){
        $paragrafo = str_replace('<','',$paragrafo);
        $paragrafo = str_replace('>','',$paragrafo);
        return $paragrafo."<br/>";
    }
}
?>