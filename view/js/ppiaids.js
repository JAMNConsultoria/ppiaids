		$(document).ready(function(){
				
		   	//inicializa divs
            $("#SobreInd").hide();
            $("#ListaInd").show()
            $("#divsintese").hide();

            //submete formulario de grupo
            $('form:first').click(function() {
                $('#frmGrupo').submit();
            });
            
            //submete formulario botao Prosseguir>>>
            $('#btnEnviar').click(function() {
				if(jQuery("input:checkbox=:checked").length == 0) {
					alert("Por favor, selecione algum indicador.");
					return;
				}
                $('#frmIndicadores').submit();
            });
            
            //fecha div menu Sobre os Indicadores
		    $('#lnkfechar').click(function(){
		        $("#SobreInd").hide();
		        $("#ListaInd").show();
		    });

            //fecha div menu mapa
		    $('#fecharsintese').click(function(){
		        $("#divsintese").hide();
		    });

            //imprime a div
                  $('#lnkimprimir').click(function(){
                      window.print();                     
		    });
		
		   //utilizado em menu.php
		   $("#lnkPainel").click(function(){
		       $("#eixo1").slideToggle("slow");
		   });
		
		   $("#lnkIndicadores").click(function(){
		       $("#eixo2").slideToggle("slow");
		   });
		   
		});//fim ready()

       //checa se checkbox foram selecionados
       function checkForm(form) {
            var arrFld = new Array('tipo');
            if(!validationForm(form, arrFld)) {
            	return false;
            }
            return true;
        }
        
        function listaIndics(ind) {
 		  $("#"+ind).slideToggle("slow");
 		}  

 		
        //seleciona todos os checkboxes
		function SelAll(it) {
			var status = it.checked;
			var p = it.parentNode;
			for (i=0;i < p.childNodes.length;i++) {
				if (p.childNodes[i].nodeName == "INPUT") {
					p.childNodes[i].checked = status;
				}
			}
		}


        //seleciona todos os checkboxes
function SelAll2(controller,theElements) {
	//Programmed by Shawn Olson
	//Copyright (c) 2006-2007
	//Updated on August 12, 2007
	//Permission to use this function provided that it always includes this credit text
	//  http://www.shawnolson.net
	//Find more JavaScripts at http://www.shawnolson.net/topics/Javascript/

	//theElements is an array of objects designated as a comma separated list of their IDs
	//If an element in theElements is not a checkbox, then it is assumed
	//that the function is recursive for that object and will check/uncheck
	//all checkboxes contained in that element

     var formElements = theElements.split(',');
	 var theController = document.getElementById(controller);
	 for(var z=0; z<formElements.length;z++){
	  theItem = document.getElementById(formElements[z]);
	  if(theItem.type){
	    if (theItem.type=='checkbox') {
	    	theItem.checked=theController.checked;
	    }
	  } else {
	  	  theInputs = theItem.getElementsByTagName('input');
	  for(var y=0; y<theInputs.length; y++){
	  if(theInputs[y].type == 'checkbox' && theInputs[y].id != theController.id){
	     theInputs[y].checked = theController.checked;
	    }
	  }
	  }
    }
}




//utlizado em listamuns.php
        function listaLocs(loc) {
			$("#"+loc).slideToggle();
        }
                 
       //utilizado em Sobre os Indicadores
        function fichaSobre(obj){
	   //recebe da tag "<a href" o conteudo da propriedade name (onde coloco o link para o script)
   	    var linkIndicador='fichasobre.php?indCod='+$(obj).attr("name");
 	    $.ajax({
       	          type: "POST",
	          url: linkIndicador,
	          success: function(msg){
   	          //passa para a div "Ficha_SobreInd" o conte&uacute;do retornado de fichasobre.php
                  $("#Ficha_SobreInd").html(msg);
                  $("#ListaInd").hide();
                  $("#SobreInd").show("slow");
		}
            });
        }//fim fichasobre()


        //utilizado em Mapa
        function fichaSintese(valor){
	   //recebe da tag "<a href" o conteudo da propriedade name (onde coloco o link para o script)
            var codigo = valor;
   	    var linkIndicador='sintese.php?munId='+ codigo;
 	    $.ajax({
       	          type: "POST",
	          url: linkIndicador,
	          success: function(msg){
   	          //passa para a div "Ficha_SobreInd" o conte&uacute;do retornado de fichasobre.php
                  $("#divsintese").html(msg);
                  $("#divsintese").show("slow");
		}
            });
        }//fim fichaSintese()