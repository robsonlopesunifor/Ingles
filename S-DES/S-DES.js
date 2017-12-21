
 var SDES = function()
    {
        var self = this;
        self.chave = new Array(0,1,0,1,0,1,0,1,0,1);
        self.p10 = new Array();
        self.chaveM1 = new Array();
        self.chaveM2 = new Array();
        self.P8 = new Array();
        self.K1 = new Array();
        self.K2 = new Array();
        
        self.palavra = new Array(0,1,0,1,0,1,0,1);
        self.ip = new Array();
        self.r0 = new Array();
        self.r1 = new Array();
        self.ep = new Array();
        self.soma = new Array();
        self.soma_0 = new Array();
        self.soma_1 = new Array();
        self.s0 = new Array();
        self.s1 = new Array();
        self.p4 = new Array();
        self.colar8 = new Array();
        self.resultado = new Array();
        
        // CONSTRUTOR /////////////////////////////////////////////////////////////
        
        self.criptografa = function(chave_,palavra_){
            
            //self.chave = chave_.split(',');
            //self.palavra = palavra_.split(',');
            
            alert(self.chave);
            alert(self.palavra);
            
            geraChaves();
            inicio();
            
        }
        
        var geraChaves = function(){
            
            p10(self.p10,self.chave);
            
            //alert('p10'+self.p10);
            
            input("P10",self.p10);
            
            cortar(self.p10,self.chaveM1,self.chaveM2);
            
            //alert('chave m1'+self.chaveM1);
            
            //alert('chave m2'+self.chaveM2);
            
            ls(self.chaveM1);
            
            //alert('ls '+self.chaveM1);
            input("SH0",self.chaveM1);
            
            ls(self.chaveM2);
            
            //alert('ls '+self.chaveM2);
            input("SH1",self.chaveM2);
            
            colar(self.P8,self.chaveM1,self.chaveM2);
            
            //alert('colar '+self.P8);
            
            P8(self.P8,self.K1);
            
            input("P8",self.P8);
            
            //alert('k1 '+self.K1);
            input("K1",self.K1);
            
            ls(self.chaveM1);
            ls(self.chaveM1);
            
            //alert('ls '+self.chaveM1);
            input("SH20",self.chaveM1);
            
            ls(self.chaveM2);
            ls(self.chaveM2);
            
            //alert('ls '+self.chaveM2);
            input("SH21",self.chaveM2);
            
            colar(self.P8,self.chaveM1,self.chaveM2);
            
            
            //alert('colar '+self.P8);
            input("P82",self.P8);
            
            P8(self.P8,self.K2);
            
            //alert('k2 '+self.K2);
            input("K2",self.K2);
        }
        
        var inicio = function(){
            
            IP(self.ip,self.palavra);
            
            //alert("ip"+self.ip);
            input("IP",self.ip);
            
            
            cortar2(self.ip,self.r0,self.r1);
            
            //alert("ip_0"+self.r0);
            input("PR40",self.r0);
            //alert("ip_1"+self.r1);
            input("PR41",self.r1);
            
            rodada1(self.r0,self.r1,self.K1);
            
            rodada2(self.r1,self.r0,self.K2);
            
            //alert('r0: '+self.r0);
            //alert('r1: '+self.r1);
            
            colar8(self.colar8,self.r1,self.r0);
            
            IP_1(self.resultado,self.colar8);
            input("IP_1",self.resultado);
            
            alert('resultado: '+self.resultado);
            input("resposta2",self.resultado);
        }
        
        var rodada1 = function(r0,r1,k){
            
            //alert('r0: '+r0);
            //alert('r1: '+r1);
            //alert('k: '+k);
            
            EP(self.ep,r1);
            
            //alert("ep"+self.ep);
            input("EP1",self.ep);
            
            somador8(self.soma,self.ep,k);
            
            //alert('soma'+self.soma);
            input("EPXORK1",self.soma);
            
            cortar2(self.soma,self.soma_0,self.soma_1);
            
            //alert('cortar 1: '+self.soma_0);
            //alert('cortar 2: '+self.soma_1);
            
            S0(self.s0,self.soma_0);
            
            //alert('s0: '+self.s0);
            
            S1(self.s1,self.soma_1);
            
            //alert('s1: '+self.s1);
            
            p4(self.p4,self.s0,self.s1);
            
            //alert('p4: '+self.p4);
            input("P40",self.p4);
            
            //alert('r1: '+r1);
            //alert('r0: '+r0);
            
            somador4(r0,self.p4,r0);
            
            //alert('r1 '+r1);
            //alert('r0 '+r0);
            input("lxorf0",self.r0);
            
        }
        
        var rodada2 = function(r0,r1,k){
            
            //alert('r0: '+r0);
            //alert('r1: '+r1);
            //alert('k: '+k);
            
            EP(self.ep,r1);
            
            //alert("ep"+self.ep);
            input("EP2",self.ep);
            
            somador8(self.soma,self.ep,k);
            
            //alert('soma'+self.soma);
            input("EPXORK2",self.soma);
            
            cortar2(self.soma,self.soma_0,self.soma_1);
            
            //alert('cortar 1: '+self.soma_0);
            //alert('cortar 2: '+self.soma_1);
            
            S0(self.s0,self.soma_0);
            
            //alert('s0: '+self.s0);
            
            S1(self.s1,self.soma_1);
            
            //alert('s1: '+self.s1);
            
            p4(self.p4,self.s0,self.s1);
            
            //alert('p4: '+self.p4);
            input("P41",self.p4);
            
            //alert('r1: '+r1);
            //alert('r0: '+r0);
            
            somador4(r0,self.p4,r0);
            
            //alert('r1 '+r1);
            //alert('r0 '+r0);
            input("lxorf1",self.r0);
            
        }
        
        var input = function(id,array){
            
            document.getElementById(id).value = array.join(" ");
            
        }
        
        var p10 = function(p10,chave){
            p10[0] = chave[2];
            p10[1] = chave[4];
            p10[2] = chave[1];
            p10[3] = chave[6];
            p10[4] = chave[3];
            p10[5] = chave[9];
            p10[6] = chave[0];
            p10[7] = chave[8];
            p10[8] = chave[7];
            p10[9] = chave[5];
        }
        
        var cortar = function(chave,chaveM1,chaveM2){
            for(i = 0; i < 10; i++){
                if(i < 5)
                   chaveM1[i] = chave[i];
                else
                   chaveM2[i - 5] = chave[i];
            }
        }
        
        var ls = function(v){
            z = v[0];
            for(i = 0; i < 4; i++)
                v[i] = v[i + 1];
            v[4] = z;
        }
        
        var colar = function(t,m1,m2){
            for(i = 0; i < 10; i++){
                if(i < 5)
                   t[i] = m1[i];
                else
                   t[i] = m2[i - 5];
            }
        }
        
        var P8 = function(v,k){
            k[0] = v[5];
            k[1] = v[2];
            k[2] = v[6];
            k[3] = v[3];
            k[4] = v[7];
            k[5] = v[4];
            k[6] = v[9];
            k[7] = v[8];
        }
        
        
        var IP = function(ip,palavra){
            
            ip[0] = palavra[1];
            ip[1] = palavra[5];
            ip[2] = palavra[2];
            ip[3] = palavra[0];
            ip[4] = palavra[3];
            ip[5] = palavra[7];
            ip[6] = palavra[4];
            ip[7] = palavra[6];
            
        }
        
        var cortar2 = function(ip,ip_1,ip_2){
            for(i = 0; i < 8; i++){
                if(i < 4)
                   ip_1[i] = ip[i];
                else
                   ip_2[i - 4] = ip[i];
            }
            
        }
        
        var EP = function(ep, v){
            
            ep[0] = v[3];
            ep[1] = v[0];
            ep[2] = v[1];
            ep[3] = v[2];
            ep[4] = v[1];
            ep[5] = v[2];
            ep[6] = v[3];
            ep[7] = v[0];
            
            alert('ep ep: '+ep);
        }
       
        var somador8 = function(s,p1,p2){
            for(i = 0; i < 8; i++)
            {
                s[i] = p1[i] + p2[i];
                if(s[i] == 2)
                    s[i] = 0;
            }
        }
    
        var S0 = function(s0,valor){
            
            m = new Array();
            m[0] = new Array();
            m[0][0] = new Array();
            m[0][0][0] = new Array();
            m[0][0][1] = new Array();
            m[0][0][0][0] = new Array(0,1);
            m[0][0][0][1] = new Array(0,0);
            m[0][0][1][0] = new Array(1,1);
            m[0][0][1][1] = new Array(1,0);
            
            
            m[0][1] = new Array();
            m[0][1][0] = new Array();
            m[0][1][1] = new Array();
            m[0][1][0][0] = new Array(1,1);
            m[0][1][0][1] = new Array(1,0);
            m[0][1][1][0] = new Array(0,1);
            m[0][1][1][1] = new Array(0,0);
            
            
            m[1] = new Array();
            m[1][0] = new Array();
            m[1][0][0] = new Array();
            m[1][0][1] = new Array();
            m[1][0][0][0] = new Array(0,0);
            m[1][0][0][1] = new Array(1,0);
            m[1][0][1][0] = new Array(0,1);
            m[1][0][1][1] = new Array(1,1);
            
            
            m[1][1] = new Array();
            m[1][1][0] = new Array();
            m[1][1][1] = new Array();
            m[1][1][0][0] = new Array(1,1);
            m[1][1][0][1] = new Array(0,1);
            m[1][1][1][0] = new Array(1,1);
            m[1][1][1][1] = new Array(1,0);
            
            self.s0 = m[valor[0]][valor[3]][valor[1]][valor[2]];
        }
        
        var S1 = function(s1,valor){
            
            m = new Array();
            m[0] = new Array();
            m[0][0] = new Array();
            m[0][0][0] = new Array();
            m[0][0][1] = new Array();
            m[0][0][0][0] = new Array(0,0);
            m[0][0][0][1] = new Array(0,1);
            m[0][0][1][0] = new Array(1,0);
            m[0][0][1][1] = new Array(1,1);
            
            m[0][1] = new Array();
            m[0][1][0] = new Array();
            m[0][1][1] = new Array();
            m[0][1][0][0] = new Array(1,0);
            m[0][1][0][1] = new Array(0,0);
            m[0][1][1][0] = new Array(0,1);
            m[0][1][1][1] = new Array(1,1);
            
            m[1] = new Array();
            m[1][0] = new Array();
            m[1][0][0] = new Array();
            m[1][0][1] = new Array();
            m[1][0][0][0] = new Array(1,1);
            m[1][0][0][1] = new Array(0,0);
            m[1][0][1][0] = new Array(0,1);
            m[1][0][1][1] = new Array(0,0);
            
            m[1][1] = new Array();
            m[1][1][0] = new Array();
            m[1][1][1] = new Array();
            m[1][1][0][0] = new Array(1,0);
            m[1][1][0][1] = new Array(0,1);
            m[1][1][1][0] = new Array(0,0);
            m[1][1][1][1] = new Array(1,1);
            
            self.s1 = m[valor[0]][valor[3]][valor[1]][valor[2]];
        }
        
        var p4 = function(p4,s0,s1){
            
            p4[0] = s0[1];
            p4[1] = s1[1];
            p4[2] = s1[0];
            p4[3] = s0[0];
        
        }
     
        var somador4 = function(s,p1,p2){
            for(i = 0; i <= 3; i++)
            {
                s[i] = p1[i] + p2[i];
                if(s[i] == 2)
                    s[i] = 0;
            }
        }
        
        var colar8 = function(t,m1,m2){
            for(i = 0; i < 8; i++){
                if(i < 4)
                   t[i] = m1[i];
                else
                   t[i] = m2[i - 4];
            }
        }
        
        var IP_1 = function(ip,palavra){
            
            ip[0] = palavra[3];
            ip[1] = palavra[0];
            ip[2] = palavra[2];
            ip[3] = palavra[4];
            ip[4] = palavra[6];
            ip[5] = palavra[1];
            ip[6] = palavra[7];
            ip[7] = palavra[5];
            
        }
        
    }
 
 
 //------------------------------------------------------------------
 
 var gravar = new SDES();
 
 $("#botao").click(function(){
     
     var chave = document.getElementById('chave').value;
     var palavra = document.getElementById('palavra').value;
     
     gravar.criptografa(chave,palavra);
     
 });


