
 var Gravar = function()
    {
        var self = this;
        self.arrayDeDadosDaPalavra = new Array();
        
        self.retornarDadosGravaFrase = function(chavePalavra){
            
            retornarDadosDaPalavra(chavePalavra);
            
        }
        
        var mostraPromptPegarFrase = function(arrayDeDados){
            var mensagem = '';
            mensagem += arrayDeDados[1]+" - "+arrayDeDados[2]+"\n ";
            mensagem += arrayDeDados[3]+" - "+arrayDeDados[4]+"\n ";
            mensagem += arrayDeDados[5]+"\n ";
            var frase = prompt(mensagem);
            return frase;
        }
        
        var retornarDadosDaPalavra = function(chaveDaPalavra) {
    
                $.ajax({
                    type: "GET",
                    url: "acaoTraducao.php",
                    data: {
                        acao: "dadosDaPalavra",
                        palavras: 'null',
                        chave: chaveDaPalavra,
                        frase: 'null'
                    },
                    success: function( texto ) { 
                        var frase = mostraPromptPegarFrase(JSON.parse(texto));
                        gravarFrase(chaveDaPalavra, frase);
                    }
                });
        }
        
        var gravarFrase = function(chaveDaPalavra, frase) {
            if(frase != ''){
                $.ajax({
                    type: "GET",
                    url: "acaoTraducao.php",
                    data: {
                        acao: "gravarFrase",
                        palavras: 'null',
                        chave: chaveDaPalavra,
                        frase: frase
                    },
                    success: function( texto ) { 
                        
                    }
                });
            }
        }
        
        
    }
 
 
 //------------------------------------------------------------------
 
 var gravar = new Gravar();
 
 $(".palavra").click(function(){
     
     gravar.retornarDadosGravaFrase($(this).attr('id'));
 
 });
