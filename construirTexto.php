<?php 
class Construir
{ 
    private $link = null;
    private $frases_ou_palavras = true;  //  alterna entre as frases e as palavras 
    
    public function Construir() {
        $this->link = new mysqli('localhost', 'root', '', 'idioma');
        mysqli_query($this->link,"SET NAMES 'utf8'");
        if (!$this->link) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error()); 
        }
    }

    public function montarBaralho($chaveTexto,$frases_ou_palavras)  {
        $cartasInglesArray = $this->montarCatoes($chaveTexto,"ingles");
        $cartasPortuguesArray = $this->montarCatoes($chaveTexto,"portugues");
        $baralhoIngles = "<div class='baralho' >";
        $baralhoPortugues = "<div class='baralho' >";
        
        $totalDeCartoes = ceil((count($cartasInglesArray))/4)*4;
        
        for($i = 1;$i <= $totalDeCartoes;$i++)
        {
            if($i <= count($cartasInglesArray)){
                if($this->frases_ou_palavras == false)
                    $j = $i;
                else
                    $j = $this->inverter_orderm_dos_cartoes_para_ajudar_na_impressao($i);
                $baralhoIngles .= $cartasInglesArray[$j];
                //$baralhoPortugues .= $cartasPortuguesArray[$j];
            }else{
                $baralhoIngles .= "<div class='cartao' ></div>";
                //$baralhoPortugues .= "<div class='cartao' ></div>";
            }
        }
        $baralhoIngles .= "</div>";
        //$baralhoPortugues .= "</div>";
        
        return "<div class='caixa' >".$baralhoIngles." ".$baralhoPortugues."</div>";
    }
    
    private function inverter_orderm_dos_cartoes_para_ajudar_na_impressao($i){
        if($i % 2 == 0)
            $i -= 1;
        else
            $i += 1;
        
        return $i;
    }
    
    public function montarCatoes($chaveTexto,$idioma)    {
        $paragrafosArray = $this->montarArrayDeParagrafos($chaveTexto,$idioma);
        $cartoes = array();
        $contador = 1;
        $pegarDoisParagrafos = true;
        
        $totalDeCartoes = ceil((count($paragrafosArray))/4)*4;
        
        for($i = 1;$i <= $totalDeCartoes;$i++)   
        {    
            //if($pegarDoisParagrafos == true && $i != count($paragrafosArray))   {
            if($i <= count($paragrafosArray)){
                $cartoes[$contador] = "<div class='cartao' >";
                $cartoes[$contador] .= $paragrafosArray[$i];
                $cartoes[$contador] .= "</div>";
            }else{
                $cartoes[$contador] = "<div class='cartao' ></div>";
            }
                //$pegarDoisParagrafos = false;
            /* }else{
                if($i == count($paragrafosArray))
                    $cartoes[$contador] = "<div class='cartao' >";
                $cartoes[$contador] .= $paragrafosArray[$i];
                $cartoes[$contador] .= "</div>";
                $pegarDoisParagrafos = true;
                $contador++;
            } */
            $contador++;
        }
        
        return $cartoes;
    }
    
    public function montarArrayDeParagrafos($chaveTexto,$idioma){
        $relacaoParagrafoFrase = $this->getRelacaoParagrafoFrase($chaveTexto);
        $quantidadeDeParagrafos = count($relacaoParagrafoFrase);
        $paragrafos = array();
        
        for($i = 1;$i <= $quantidadeDeParagrafos;$i++)
            $paragrafos[$i] = $this->montarParagrafo($relacaoParagrafoFrase[$i],$idioma);
        
        return $paragrafos;
    }
    
    private function montarParagrafo($frasesArray,$idioma) {
        $quantidadeDeFrases = count($frasesArray[1]);
        
            $paragrafos = "<div class='paragrafo' >";//$this->defineIdiomaDoParagrafo($idioma);
            for($i = 1;$i <= $quantidadeDeFrases;$i++)  {
                if($this->frases_ou_palavras == false){
                    $paragrafos .= "<div class='frase_quebra' >___________________________________________________________</div>";
                    $paragrafos .= "<div class='frase' >".$frasesArray[1][$i]."</div>";
                    $paragrafos .= "<div class='frase_quebra' >___________________________________________________________</div>";
                    $paragrafos .= "<div class='frase_traduzida' >(".$frasesArray[2][$i].")</div>";
                    $paragrafos .= "<div class='frase_traduzida' >(".$frasesArray[3][$i].")</div>";
                }
                //$paragrafos .= $this->getFrasePorIdiona($frasesArray[1][$i],$idioma);
            }
        
            $paragrafos .= "</div>";
            if($this->frases_ou_palavras == true)
                $paragrafos .= $this->getMinelmonicosReferenteAoParagrafo($frasesArray[0]);
        
        return $paragrafos;
    }
    /* private function defineIdiomaDoParagrafo($idioma)   {
        $paragrafos = '';
        
        if($idioma == "ingles")
            $paragrafos = "<div class='paragrafoIngles' >";
        else
            $paragrafos = "<div class='paragrafoPortugues' >";
        
        return $paragrafos;
    } */
    /* private function getFrasePorIdiona($fraseEmDoisIdiomas, $idioma)   {
        $frase = '';
        
        if($idioma == "portugues")
            $frase = "<div class='frase' >".$fraseEmDoisIdiomas[0]."</div>";  
        else if($idioma == "ingles")
            $frase = "<div class='frase' >".$fraseEmDoisIdiomas[1]."</div>";
        
        return $frase;
    } */
    
    public function getRelacaoParagrafoFrase($chaveTexto) {
        $SQL = $this->getSqlDoParagrafoComFrases($chaveTexto);
        return $this->getRetornaProcessamentoDoSqlEmUmArray($SQL);
    }  
    private function getSqlDoParagrafoComFrases($chaveTexto)  {
        $SQL = "SELECT texto.KEY_TEXTO_TEX, paragrafo.KEY_PARAGRAFO_PAR, paragrafo.CONTADOR_PAR, paragrafo.PARAGRAFO_1_PAR, "; 
        $SQL .= "frase.CONTADOR_FRA, frase.KEY_FRASE_FRA, frase.FRASE_1_FRA ,frase.FRASE_2_FRA  from texto inner join paragrafo inner join frase ON "; 
        $SQL .= "texto.KEY_TEXTO_TEX = paragrafo.KEY_TEXTO_PAR && paragrafo.KEY_PARAGRAFO_PAR = frase.KEY_PARAGRAFO_FRA where ";
        $SQL .= "KEY_TEXTO_TEX = ".$chaveTexto." ORDER BY paragrafo.CONTADOR_PAR, frase.CONTADOR_FRA";
        return $SQL;
    }
    private function getRetornaProcessamentoDoSqlEmUmArray($SQL)  {
        $RelacaoParagrafoAsFrase = array();
        
        $RespostaDaQuery = $this->link->query($SQL);
        while($RF = $RespostaDaQuery->fetch_assoc()) {
            $RelacaoParagrafoAsFrase[$RF["CONTADOR_PAR"]][0] = $RF["KEY_PARAGRAFO_PAR"];
            $RelacaoParagrafoAsFrase[$RF["CONTADOR_PAR"]][1][$RF["CONTADOR_FRA"]] = $this->getFrasePalavras($RF["KEY_FRASE_FRA"]);
            $RelacaoParagrafoAsFrase[$RF["CONTADOR_PAR"]][2][$RF["CONTADOR_FRA"]] = $RF["FRASE_1_FRA"];
            $RelacaoParagrafoAsFrase[$RF["CONTADOR_PAR"]][3][$RF["CONTADOR_FRA"]] = $RF["FRASE_2_FRA"];
        }
        return $RelacaoParagrafoAsFrase;
    }
    
    private function getFrasePalavras($chaveFrase)  {
        $SQL = $this->retornarSqlDaFraseComPalavras($chaveFrase);
        $relacaoParagrafoAsFrase = $this->retornaRelacaoFraseComPalavra($SQL);
        return $this->monstadoFraseDaRelacaoFraseComPalavra($relacaoParagrafoAsFrase);
    }    
    private function retornarSqlDaFraseComPalavras($chaveFrase)   {
        $SQL = "SELECT  frase.KEY_FRASE_FRA, palavra.KEY_PALAVRA_PAL,palavra.KEY_PALAVRA_PAL, palavra.MINELMONICO_2_PAL, palavra.MINELMONICO_1_PAL, palavra.PALAVRA_PAL, palavra.TRADUCAO_PAL,  palavra.FRASE_PAL ";
        $SQL .= "from palavra inner join minelmonico inner join frase ON ";
        $SQL .= "palavra.KEY_PALAVRA_PAL = minelmonico.KEY_PALAVRA_MIN && minelmonico.KEY_FRASE_MIN = frase.KEY_FRASE_FRA ";
        $SQL .= "where frase.KEY_FRASE_FRA = ".$chaveFrase;
        
        return $SQL;
    } 
    private function retornaRelacaoFraseComPalavra($SQL)  {
        $relacaoFrasePalavra = array();
        
        $respostaDaQuery = $this->link->query($SQL);
        while($RF = $respostaDaQuery->fetch_assoc()) 
            $relacaoFrasePalavra[] = "<div class='palavra' id='".$RF['KEY_PALAVRA_PAL']."'><div class='palavra_ingles'>".$RF['PALAVRA_PAL']."</div><div class='palavra_portugues' >".$RF['TRADUCAO_PAL']."</div></div>";
        
        return $relacaoFrasePalavra;
    }   
    private function monstadoFraseDaRelacaoFraseComPalavra($arrayFraseComPalavra)  {
        $frase = '';
        
        foreach($arrayFraseComPalavra as $key => $palavra)
            $frase .= " ".$palavra." ";
        
        return $frase;
    }
    
    public function getMinelmonicosReferenteAoParagrafo($paragrafo){
        $SQL = $this->getSqlDoMinelmonicoReferenteAoParagrafo($paragrafo);
        return $this->montarOsMinelmonicoReferenteAoParagrafo($SQL);
    }
    private function getSqlDoMinelmonicoReferenteAoParagrafo($paragrafo){
        $SQL = "SELECT  paragrafo.KEY_PARAGRAFO_PAR, palavra.KEY_PALAVRA_PAL, palavra.FRASE_PAL, palavra.TRADUCAO_PAL ";
        $SQL .= "from paragrafo inner join frase inner join minelmonico inner join palavra ON ";
        $SQL .= "paragrafo.KEY_PARAGRAFO_PAR = frase.KEY_PARAGRAFO_FRA && ";
        $SQL .= " frase.KEY_FRASE_FRA = minelmonico.KEY_FRASE_MIN && ";
        $SQL .= " minelmonico.KEY_PALAVRA_MIN = palavra.KEY_PALAVRA_PAL ";
        $SQL .= " where paragrafo.KEY_PARAGRAFO_PAR = ".$paragrafo." && palavra.FRASE_PAL != 'null' ";
        
        return $SQL;
    }
    private function montarOsMinelmonicoReferenteAoParagrafo($SQL){
        $relacaoMinelmonicoParagrafo = "<div class='paragrafoPortugues' >";
        
        $respostaDaQuery = $this->link->query($SQL);
        while($RF = $respostaDaQuery->fetch_assoc()) 
            $relacaoMinelmonicoParagrafo .= "<div class='minelmonico' > ".$RF['TRADUCAO_PAL']." - ".$RF['FRASE_PAL']."</div>";
        
        $relacaoMinelmonicoParagrafo .= "</div>";
        
        return $relacaoMinelmonicoParagrafo;
    } 
    
}
?>