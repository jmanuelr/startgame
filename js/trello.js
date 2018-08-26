	
	var $divBoards = $('#divBoards');
	var $divCards = $('#divCards');
	var $divChecklists = $('#divChecklists');
	var $divLog = $('#divLog');

	var contadorTotal = [];
	var contadorDone = [];
	var arrListas = [];

	$(document).ready(function(){
				//-----------------------------------------
				

				var id_trello_board = $('#hdd_id_trello_board').val();
				//-----------------------------------------
				var onAuthorize = function() {
				    updateLoggedIn();
				    $("#output").empty();

				    $divLog.empty();
				    
				    Trello.members.get("me", function(member){
				        $("#fullName").text(member.fullName);
				        
				        getDadosBoard(id_trello_board);
						//--------------------
				    });

				};

				var updateLoggedIn = function() {
				    var isLoggedIn = Trello.authorized();
				    $("#loggedout").toggle(!isLoggedIn);
				    $("#loggedin").toggle(isLoggedIn);        
				};
				    
				var logout = function() {
				    Trello.deauthorize();
				    updateLoggedIn();
				};
				                          
				Trello.authorize({
				    interactive:false,
				    success: onAuthorize
				});

				$("#connectLink").click(function(){
					//alert('ok');
				    Trello.authorize({
				    	name: "apiJS",
				        type: "popup",
				        success: onAuthorize
				    })
				});
				    
				$("#disconnect").click(logout);

				

				$('#myTab a').click(function (e) {
				  e.preventDefault()
				  $(this).tab('show')
				});

				//$('.div_nestable_list').nestable();
		});


function getNewItem(itemId,itemTitle,itemContent){
	var dataId = itemId;
	dataId = dataId.replace(/([a-zA-Z]*_)/g,'');
    var newItem = '<li id="'+itemId+'" class="dd-item dd3-item" data-id="'+dataId+'">\n';
        	newItem+= '<div class="dd-handle dd3-handle"> </div>\n';
        	newItem+= '<div class="dd3-content">\n';
        	newItem+= ' '+itemTitle+' \n';
        	//newItem+= '<span class="pull-right"><a href="#" onclick="return false;"><i class="fa fa-close"></i></a></span>';
        	newItem+= '</div>\n';
        	newItem+= itemContent+'\n';
        newItem+= '</li>';
    return newItem;
}//fnc


//-----------------------------------------
		function getPortlet(idPortlet,titulo){
			var icon = "tasks";
			//----------------------
			switch(titulo.toLowerCase()){
				case "limbo":
					icon = "folder-open ";
				break;
				case "todo":
					icon = "tasks";
				break;
				case "test":
					icon = "bug";
				break;
				case "done":
					icon = "check";
				break;
			}//sw
			//----------------------
			var htmlPortlet = '<div class="portlet box blue-hoki">';
					htmlPortlet+= '<div class="portlet-title">';
						htmlPortlet+= '<div class="caption">';
							htmlPortlet+= '<i class="fa fa-'+icon+'"></i>'+titulo+'';
						htmlPortlet+= '</div>';
					htmlPortlet+= '</div>';
					htmlPortlet+= '<div class="portlet-body">';
						htmlPortlet+= '<div id='+idPortlet+' class="dd">';
							htmlPortlet+= '<ol id="ol_'+idPortlet+'" class="dd-list">';
								htmlPortlet+= '';
							htmlPortlet+= '</ol>';
						htmlPortlet+= '</div>';
					htmlPortlet+= '</div>';
				htmlPortlet+= '</div>';
			//----------------------
			return htmlPortlet;
		}//fnc

		

		function inicializaListaNestable(quem){
			console.log('verificando ['+quem+'] '+contadorDone[quem]+' >= '+contadorTotal[quem]);
			if(contadorDone[quem]>=contadorTotal[quem]){
				$('#list_'+quem).nestable();
				console.log('inicializa [#list_'+quem+']');
			}else{
				setTimeout("inicializaListaNestable('"+quem+"');",5000);
			}//if

		}//fnc

		function getDadosBoard(qual){

			var novoLi = "";

			Trello.get("boards/"+qual, function(board) {
				//$divBoards.empty();
				 $("<div>")
		                .attr({id:'board_'+board.id})
		                .addClass("board")
		                .addClass("col-md-12")
		                //.html("<div class='col-md-12'><strong>board: "+board.id+") "+board.name+"</strong></div>")
		                .appendTo($divBoards);

			        	Trello.get("boards/" + board.id + "/lists/", function(listas) {

			                	 $.each(listas, function(indice, lista) {

			                	 	//console.log("list: "+lista.id+") "+lista.name+"");

									contadorTotal[lista.id] = 0;
									contadorDone[lista.id] = 0;

			                	 	$("<div>")
						                //.attr({id:'list_'+lista.id})
						                .addClass("list")
						                .addClass("col-md-3")
						                .html(getPortlet('list_'+lista.id,lista.name))//"<br />list: "+lista.id+") "+lista.name+""+
						                .appendTo("#board_"+board.id);

					                	//console.log(listas);
					                	 Trello.get("lists/"+ lista.id +"/cards/", function(cards) {

					                	 	contadorTotal[lista.id] = parseInt(contadorTotal[lista.id]) + parseInt(cards.length);

								            $.each(cards, function(ix, card) {
								            	/*
								            	$("<li id='card_"+card.id+"'>")
								                .attr({href: card.url, target: "trello"})
								                .addClass("card")
								                .html("card: "+card.id+") "+card.name+"<ol id='ol_card_"+card.id+"'></ol>")
								                .appendTo("#ol_list_"+lista.id);//$divLog
								                */
								                novoLi = getNewItem("card_"+card.id,card.name,"<ol id='ol_card_"+card.id+"' class='dd-list'></ol>");
								            	$("#ol_list_"+lista.id).append(novoLi);
								                //----------------------
								                
									            //---------------- checklists
									                Trello.get("cards/" + card.id + "/checklists/", function(cheklists) {

									                	if(cheklists.length==0)$("#ol_card_"+card.id).remove();

									                	contadorTotal[lista.id] = parseInt(contadorTotal[lista.id]) + parseInt(cheklists.length);
														//$divChecklists.empty();
											            $.each(cheklists, function(ix, cheklist) {

											            	var chItns = cheklist.checkItems;

											            	/*
											            	$("<div>")
											            	.attr({id:'chk_'+cheklist.id})
											                .addClass("card")
											                .html("checklist: "+cheklist.name + "<ol id='ol_chk_"+cheklist.id+"'></ol>")
											                .appendTo("#ol_card_"+card.id);
											                */

											                contadorTotal[lista.id] = parseInt(contadorTotal[lista.id]) + parseInt(chItns.length);

											                novoLi = getNewItem('chk_'+cheklist.id,cheklist.name,"<ol id='ol_chk_"+cheklist.id+"' class='dd-list'></ol>");
											                $("#ol_card_"+card.id).append(novoLi);

											                

											            	for(var i=0; i<chItns.length; i++){
											            		checkItem = chItns[i];
											            		/*
											            		$("<li>")
												                //.attr({href: board.url, target: "trello"})
												                .addClass("card")
												                .html("item: "+checkItem.name + ": " + checkItem.state)
												                .appendTo("#ol_chk_"+cheklist.id);
												                */
												                novoLi = getNewItem('chkIt_'+checkItem.id,checkItem.name,"");
											                	$("#ol_chk_"+cheklist.id).append(novoLi);

											                	contadorDone[lista.id]++;

											            	}///for

											                contadorDone[lista.id]++;//done chks
											                //inicializaListaNestable(lista.id);
											            });  
								                    }); //checklists
								                //----------------
								                contadorDone[lista.id]++;//done cards
											    //inicializaListaNestable(lista.id);
									            //----------------------

								            });

								        });

									//$('#list_'+lista.id).nestable();
//									inicializaListaNestable(lista.id);
									//arrListas.push(lista.id);
									setTimeout("inicializaListaNestable('"+lista.id+"');",5000);
			                	});

			            });//trello get lists

			});//trello get boards
		}
		//-----------------------------------------
		function getProgressBar(qnto,total){
			var andamento = parseInt(qnto * 100 / total);
			var clase = 'danger';
			if(andamento == 100){
				clase = 'success';
			}else if(andamento > 80){
				clase = 'info';
			}else if(andamento > 20){
				clase = 'warning';
			}//if

			var retorno = '<div class="progress">';
				retorno+= '<div class="progress-bar progress-bar-'+clase+' progress-bar-striped" role="progressbar" aria-valuenow="'+andamento+'" aria-valuemin="0" aria-valuemax="100" style="width: '+andamento+'%">';
				//retorno+= '<span class="sr-only">'+andamento+'%</span>';
				retorno+= andamento+'%';
				retorno+= '</div>';
				retorno+= '</div>';
			return retorno;
		}//fnc
		//-----------------------------------------