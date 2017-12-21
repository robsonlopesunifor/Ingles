<?php
    class Tradutor
{ 
    private $link = null;
    
    public function Tradutor()
    {
        $this->link = new mysqli('localhost', 'root', '', 'idioma');
        mysqli_query($this->link,"SET NAMES 'utf8'");
        if (!$this->link) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                 . mysqli_connect_error()); 
        }
    }
    
    public function imprimir_Palavras_Nao_Traduzidas(){
        $SQL = $this->retornar_SQL_DaLista_De_Palavras_Nao_Traduzidas();
        echo $this->processarSQL_Retornar_Palavras_Nao_Traduzidas($SQL);
    }
    
    public function fragmentar_Lista_De_Palavras_e_gravar($listaDePalavras){
        $arrayDePalavras = $this->fragmentar_Lista_De_Palavras($listaDePalavras);
        $this->abrir_array_e_gravar_lista_de_palavras($arrayDePalavras);
    }
    
    public function gravar_frase($chave,$frase){
        $SQL = "UPDATE palavra SET FRASE_PAL = '".$frase."' WHERE KEY_PALAVRA_PAL = ".$chave;
        $this->link->query($SQL);
    }
    
    public function retornar_dados_da_palavra($chave) {
        $SQL = $this->retornar_sql_dos_dados_da_palavra($chave);
        return $this->processar_sql_e_retornar_dados_da_palavra($SQL);
    }
    
    private function retornar_sql_dos_dados_da_palavra($chave) {
        $SQL = "SELECT  * from  palavra where KEY_PALAVRA_PAL = ".$chave;
        return $SQL;
    }
    
    private function processar_sql_e_retornar_dados_da_palavra($SQL)    {
        $palavra = array();
        
        $RS = $this->link->query($SQL);
        while($RF = $RS->fetch_assoc()) {
            $palavra[0] = $RF['KEY_PALAVRA_PAL'];
            $palavra[1] = $RF['PALAVRA_PAL'];
            $palavra[2] = $RF['TRADUCAO_PAL'];
            $palavra[3] = $RF['MINELMONICO_1_PAL'];
            $palavra[4] = $RF['MINELMONICO_2_PAL'];
            $palavra[5] = $RF['FRASE_PAL'];
        }
        return json_encode($palavra);
    }
    
    private function retornar_SQL_DaLista_De_Palavras_Nao_Traduzidas()  {
        $SQL = "SELECT  PALAVRA_PAL, KEY_PALAVRA_PAL from  palavra where TRADUCAO_PAL = 'null' || TRADUCAO_PAL = PALAVRA_PAL";
        return  $SQL;
    }
    
    private function processarSQL_Retornar_Palavras_Nao_Traduzidas($SQL)    {
        $palavra = '';
        
        $RS = $this->link->query($SQL);
        while($RF = $RS->fetch_assoc()) 
            $palavra .= "<(".$RF['PALAVRA_PAL'].")(".$RF['KEY_PALAVRA_PAL'].")>\n";
        
        return strtolower($palavra);
    }
    
    private function fragmentar_Lista_De_Palavras($listaDePalavras)    {
        
        preg_match_all('/<(.*?)>/', $listaDePalavras, $palavras, PREG_SET_ORDER, 0);
        for($i = 0;$i < count($palavras);$i++){
            $palavras[$i] = str_replace(')','>',str_replace('(','<',$palavras[$i][1])); 
            $palavras[$i] = $this->fragmentar_Palavra_Chave($palavras[$i]);
        }
        return $palavras;
    }
    
    private function fragmentar_Palavra_Chave($palavras) {
            preg_match_all('/<(.*?)>/', $palavras, $palavraChave, PREG_SET_ORDER, 0);
            for($i = 0;$i < count($palavraChave);$i++)
                $palavraChave[$i] = $palavraChave[$i][1];
    
            return $palavraChave;
    }
    
    private function abrir_array_e_gravar_lista_de_palavras($arrayDePalavras)  {
        for($i = 0;$i < count($arrayDePalavras);$i++){
            $palavra = $arrayDePalavras[$i][0];
            $chave = $arrayDePalavras[$i][1];
            $this->gravar_palavra_traduzida_referente_a_chave($palavra,$chave);
        }    
    }
    
    private function gravar_palavra_traduzida_referente_a_chave($palavra,$chave){
        $SQL = "UPDATE palavra SET TRADUCAO_PAL = '".$palavra."' WHERE KEY_PALAVRA_PAL = ".$chave;
        $this->link->query($SQL);
    }
    
}
?>