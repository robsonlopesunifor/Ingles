
 var Gravar = function()
    {
        var self = this;
        
        // CONSTRUTOR /////////////////////////////////////////////////////////////
        self.setGravar = function()
        {
            $.ajax({
                type: "POST",
                url: "acaoTexto.php",
                data: {
                    acao: "gravar",
                    idioma: getIdioma(),
                    textoIngles: getTextoIngles(),
                    textoPortugues: getTextoPortugues(),
                    tituloIngles:getTituloIngles(),
                    tituloPortugues:getTituloPortugues()  
                },
                success: function( texto ) { 
                    //self.roteiro = JSON.parse(texto); 
                    //montarHtml();
                    alert(texto);
                }
            });
        } 
        
        self.retornarListaDePalavras = function()
        {
            $.ajax({
                type: "GET",
                url: "acaoTraducao.php",
                data: {
                    acao: "retornarPalavras",
                    palavras: null,
                    chave: null,
                    frase: 'null'
                },
                success: function( texto ) { 
                    $("#listaDePalavrasNaoTraduzidas").val(texto);
                }
            });
        } 
        
        self.gravarListaDePalavrasTraduzidas = function()
        {
            $.ajax({
                type: "GET",
                url: "acaoTraducao.php",
                data: {
                    acao: "gravarPalavras",
                    palavras: getListaDePalavrasTraduzidas(),
                    chave: null,
                    frase: 'null'
                },
                success: function( texto ) { 
                    $("#listaDePalavrasNaoTraduzidas").val(texto);
                }
            });
        } 
        
        var getIdioma = function(){
            var idioma = $("#idioma").val();
            alert(idioma);
            return idioma;
        }
        
        var getTextoIngles = function(){
            var textoIngles = $("#textoIngles").val();
            alert(textoIngles);
            return textoIngles;
        }
        
        var getTextoPortugues = function(){
            var textoPortugues = $("#textoPortugues").val();
            alert(textoPortugues);
            return textoPortugues;
        }
        
        var getTituloIngles = function(){
            var tituloIngles = $("#tituloIngles").val();
            alert(tituloIngles);
            return tituloIngles;
        }
        
        var getTituloPortugues = function(){
            var tituloPortugues = $("#tituloPortugues").val();
            alert(tituloPortugues);
            return tituloPortugues;
        }
        
        var getListaDePalavrasTraduzidas = function(){
            var listaDePalavrasTraduzidas = $("#listaDePalavrasTraduzidas").val();
            alert(listaDePalavrasTraduzidas);
            return listaDePalavrasTraduzidas;
        }
    }
 
 
 //------------------------------------------------------------------
 
 var gravar = new Gravar();
 
 $("#submeter").click(function(){
     
     gravar.setGravar();
     
 });

$("#retornarListaDePalavras").click(function(){
     
     gravar.retornarListaDePalavras();
     
 });

$("#gravarListaDePalavrasTraduzidas").click(function(){
     
     gravar.gravarListaDePalavrasTraduzidas();
     
 });

