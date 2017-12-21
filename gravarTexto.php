<?php 
class Gravar
{ 
    private $link = null;
    
    public function Gravar()
    {
        $this->link = new mysqli('localhost', 'root', '', 'idioma');
        mysqli_query($this->link,"SET NAMES 'utf8'");
        if (!$this->link) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                 . mysqli_connect_error()); 
        }
    }
    
    public function fragmentarGravar($idioma,$textoIngles,$textoPortugues,$titulo_pt,$titulo_in)    {
        $chaveDoTexto = $this->gravarTituloMostraChave($idioma,$titulo_pt,$titulo_in);
        $this->fragmentarTextoGravarParagrafos($chaveDoTexto,$textoIngles,$textoPortugues);
    }
    
    public function gravarTituloMostraChave($idioma,$titulo_pt,$titulo_in)  {
        $this->gravarTituloDoTexto($idioma,$titulo_pt,$titulo_in);
        return $this->pegarChaveDoTextoMaisRecente();
    }
    
    public function fragmentarTextoGravarParagrafos($chaveDoTexto,$textoIngles,$textoPortugues) {
        $paragrafos = $this->fragmentarTextoEmParagragos($textoIngles,$textoPortugues);
        return $this->gravarVariosParagrafor($chaveDoTexto,$paragrafos);
    }
    
    public function fragmentarParagrafoGravarFrases($chaveDoParagrafo,$paragrafo)   {
        $frase = $this->fragmentarPatagrafoEmFrases($paragrafo);
        $this->gravarVariasFrases($chaveDoParagrafo,$frase);
    }
    
    public function fragmentarFraseGravarPalavras($frase,$chaveFrase)   {
        $arrayDePalavras = $this->fragmentarFraseEmPalavras($frase,$chaveFrase);
        $this->gravarVariasPalavras($arrayDePalavras,$chaveFrase);
    }
    
    private function gravarTituloDoTexto($idioma,$titulo_pt,$titulo_in) {
        $SQL = "INSERT INTO texto(IDIOMA_TEX,TITULO_PT_TEX, TITULO_OU_TEX) VALUES('".$idioma."','".$titulo_pt."','".$titulo_in."')";
        $this->link->query($SQL);
    }
    
    private function pegarChaveDoTextoMaisRecente() {
        $SQL = "SELECT KEY_TEXTO_TEX FROM texto ORDER BY KEY_TEXTO_TEX DESC limit 1";
        $RS = $this->link->query($SQL);
        while($RF = $RS->fetch_assoc())
            return $RF["KEY_TEXTO_TEX"];
    }
    
    private function fragmentarTextoEmParagragos($textoIngles,$textoPortugues)  {
        $paragrafos = array();
        $contador = 0;
        preg_match_all('/.*/', $textoIngles, $paragrafoIngles, PREG_SET_ORDER, 0);
        preg_match_all('/.*/', $textoPortugues, $paragrafoPortugues, PREG_SET_ORDER, 0);
        
            for($i = 0; $i < count($paragrafoIngles);$i++)
            {
                if($paragrafoIngles[$i][0] != '')
                {
                   $paragrafos[$contador][0] = str_replace('<>','','<'.str_replace('.','><',$paragrafoIngles[$i][0]).'>');
                   $paragrafos[$contador][1] = str_replace('<>','','<'.str_replace('.','><',$paragrafoPortugues[$i][0]).'>');
                   $contador++;
                }
            }
        
        return $paragrafos;
    }
    
    private function gravarVariosParagrafor($chaveDoTexto,$arrayDeParagrafos)   {
        $contador = 1;
        
        foreach ($arrayDeParagrafos as &$paragrafo)
        {    
            $chaveDoParagrafo = $this->gravarParagravos($chaveDoTexto,$paragrafo,$contador++);
            $this->fragmentarParagrafoGravarFrases($chaveDoParagrafo,$paragrafo);
        }
    }
    
    private function gravarParagravos($chaveDoTexto,$paragrafos,$contador)  {   
        $SQL = "INSERT INTO paragrafo(KEY_TEXTO_PAR, CONTADOR_PAR, PARAGRAFO_1_PAR, PARAGRAFO_2_PAR) VALUES(".$chaveDoTexto.",".$contador.",'".$paragrafos[0]."','".$paragrafos[1]."')";
        $this->link->query($SQL);
        $SQL = "SELECT KEY_PARAGRAFO_PAR FROM paragrafo ORDER BY KEY_PARAGRAFO_PAR DESC limit 1";
        $RS = $this->link->query($SQL);
        while($RF = $RS->fetch_assoc())
            return $RF["KEY_PARAGRAFO_PAR"];
    }
    
    private function fragmentarPatagrafoEmFrases($paragrafo)    {
        $frases = array();
        $contador = 0;
        
        preg_match_all('/<(.*?)>/', $paragrafo[0], $frasesIngles, PREG_SET_ORDER, 0);
        preg_match_all('/<(.*?)>/', $paragrafo[1], $frasesPortugues, PREG_SET_ORDER, 0);
        
        
        for($i = 0;$i < count($frasesIngles);$i++)
        {   
            if(isset($frasesIngles[$i]) && isset($frasesPortugues[$i])){
                $frases[$contador][0] = str_replace('>','.',str_replace('<','',$frasesIngles[$i][0]));
                $frases[$contador][1] = str_replace('>','.',str_replace('<','',$frasesPortugues[$i][0]));
                $contador++;
            }
        }           
        
        return $frases;
    }
    
    private function gravarVariasFrases($chaveParagrafo,$arrayDeFrases) {
        $contador = 1;
        
        foreach ($arrayDeFrases as &$frase)
        {  
            $chaveFrase = $this->gravarFrases($chaveParagrafo,$frase,$contador++);
            $this->fragmentarFraseGravarPalavras($frase[0],$chaveFrase);
        }
    }
    
    private function gravarFrases($chaveParagrafo,$frases,$contador)  {  
        $SQL = "INSERT INTO frase(KEY_PARAGRAFO_FRA, CONTADOR_FRA, FRASE_1_FRA, FRASE_2_FRA) VALUES(".$chaveParagrafo.",".$contador.",'".$frases[0]."','".$frases[1]."')";
        $this->link->query($SQL);
        $SQL = "SELECT KEY_FRASE_FRA FROM frase ORDER BY KEY_FRASE_FRA DESC limit 1";
        $RS = $this->link->query($SQL);
        while($RF = $RS->fetch_assoc())
            return $RF["KEY_FRASE_FRA"];
    }
    
    private function fragmentarFraseEmPalavras($frase,$chaveFrase)  {
        $frase = $this->reestruturaFraseParaSeFraguimentada($frase);
        
        preg_match_all('/<(.*?)>/', $frase, $palavras, PREG_SET_ORDER, 0);
        for($i = 0;$i < count($palavras);$i++)
            $palavras[$i] = $this->limpaPalavra($palavras[$i][0]);
        
        return $palavras;
    }
    
    private function gravarVariasPalavras($arrayDePalavras,$chaveFrase) {    
        foreach ($arrayDePalavras as &$palavras)
        { 
            $chavePalavra = $this->gravarPalavraRetornarChave($palavras);
            if($chavePalavra != null)
                $this->gravarLinkagemFrasePalavra($chaveFrase,$chavePalavra);
        }
    }
    
    private function reestruturaFraseParaSeFraguimentada($frase) {
        $frase = "<".$frase.">";
        $search = array('.', ',', ';', '!', '?', '-');
        $frase = str_replace($search,'', $frase);
        $frase = str_replace(" ","><", $frase);
        return $frase;
    }
    
    private function limpaPalavra($palavras)    {
        $search  = array('>', '<');
        $palavras = str_replace($search,'',$palavras);
        return $palavras;
    }
    
    private function gravarPalavraRetornarChave($palavra)   {
        $this->gravarPalavra($palavra);
        return $this->retornarChaveDaPalavra($palavra);
    }
    
    private function gravarPalavra($palavra)   {
        $SQL = " INSERT INTO palavra (PALAVRA_PAL)";
        $SQL .= " SELECT * FROM (SELECT '".$palavra."') AS tmp";
        $SQL .= " WHERE NOT EXISTS (";
        $SQL .= " SELECT PALAVRA_PAL FROM palavra WHERE PALAVRA_PAL = '".$palavra."'";
        $SQL .= " ) LIMIT 1;";
        $this->link->query($SQL);
    }
    
    private function retornarChaveDaPalavra($palavra)   {
            $SQL = " SELECT KEY_PALAVRA_PAL FROM palavra WHERE PALAVRA_PAL = '".$palavra."' limit 1";
            $RS = $this->link->query($SQL);
            while($RF = $RS->fetch_assoc())
                return $RF["KEY_PALAVRA_PAL"];
    }
    
    private function gravarLinkagemFrasePalavra($chaveFrase,$chavePalavra)  {
        $SQL = "INSERT INTO minelmonico(KEY_FRASE_MIN, KEY_PALAVRA_MIN) VALUES(".$chaveFrase.",".$chavePalavra.")";
        $this->link->query($SQL);
    }
    
} 
?> 