/* This is an echo of some data sent back via ajax                       */
      /* This data should be filtered by nodeID and return only childNodeID's. */
      /* vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv. */
      /*
      var jsonData = {
        "nodeID": {
          "1": [
            
             {"ID": "1.1",
              "childNodeType": "branch",
              "childData": [
                "1.1: column 1",
                "1.1: column 2"
                ]
            },
            {"ID": "1.2",
              "childNodeType": "leaf",
              "childData": [
                "1.2: column 1",
                "1.2: column 2"
                ]
            },
            {"ID":"1.3",
              "childNodeType": "leaf",
              "childData": [
                "1.3: column 1",
                "1.3: column 2"
                ]
            }
            
          ],
          "1.1": [

              {"ID":"1.1.1",
                "childNodeType": "leaf",
                "childData": [
                  "1.1.1: column 1",
                  "1.1.1: column 2"
                  ]
              },
              {"ID":"1.1.2",
                "childNodeType": "leaf",
                "childData": [
                  "1.1.2: column 1",
                  "1.1.2: column 2"
                  ]
              }
       
          ],
          "2": [

              {"ID":"2.1",
                "childNodeType": "leaf",
                "childData": [
                  "2.1: column 1",
                  "2.1: column 2"
                  ]
              },
              {"ID":"2.2",
                "childNodeType": "leaf",
                "childData": [
                  "2.2: column 1",
                  "2.2: column 2"
                  ]
              },
              {"ID":"2.3",
                "childNodeType": "leaf",
                "childData": [
                  "2.3: column 1",
                  "2.3: column 2"
                  ]
              }

          ],
          "3": [

              {"ID":"3.1",
                "childNodeType": "leaf",
                "childData": [
                  "3.1: column 1",
                  "3.1: column 2"
                  ]
              },
              {"ID":"3.2",
                "childNodeType": "leaf",
                "childData": [
                  "3.2: column 1",
                  "3.2: column 2"
                  ]
              },
              {"ID":"3.3",
                "childNodeType": "leaf",
                "childData": [
                  "3.3: column 1",
                  "3.3: column 2"
                  ]
              }
              
          ]
        }
      };
      */
      /* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */
      /* This is an echo of some data sent back via ajax                       */
      /* This data should be filtered by nodeID and return only childNodeID's. */



      // initialize treeTable
      $("#example-basic").treetable({
          expandable:     true,
          onNodeExpand:   nodeExpand,
          onNodeCollapse: nodeCollapse
      });


      // expand node with ID "1" by default
      //$("#example-basic").treetable("reveal", '1');//


      // Highlight a row when selected
      $("#example-basic tbody").on("mousedown", "tr", function() {
          $(".selected").not(this).removeClass("selected");
          $(this).toggleClass("selected");
      });

      function nodeExpand () {
          // alert("Expanded: " + this.id);
          getNodeViaAjax(this.id);  
      }


      function nodeCollapse () {
          // alert("Collapsed: " + this.id);
      }


      function getNodeViaAjax(parentNodeID) {
          $("#loadingImage").show();
          
          // ajax should be modified to only get childNode data from selected nodeID
          // was created this way to work in jsFiddle
          $.ajax({
            type: 'POST',
            url: 'ajax/json_node_requerimento.php',//json_node_recursivo
            dataType: 'json',
            data: '&pai='+parentNodeID,
              /*
              data: {
                  json: JSON.stringify( jsonData )
              },
              */
              success: function(data) {
                  $("#loadingImage").hide();
          
                  var childNodes = data.nodeID[parentNodeID];
                  
                  if(childNodes) {
                      var parentNode = $("#example-basic").treetable("node", parentNodeID);

                      for (var i = 0; i < childNodes.length; i++) {
                          var node = childNodes[i];

                          var nodeToAdd = $("#example-basic").treetable("node",node['ID']);

                          // check if node already exists. If not add row to parent node
                          if(!nodeToAdd) {
                              // create row to add
                              var row ='<tr data-tt-id="' + 
                                  node['ID'] + 
                                  '" data-tt-parent-id="' +
                                  parentNodeID + '" ';
                              if(node['childNodeType'] == 'branch') {
                                  row += ' data-tt-branch="true" ';
                              }

                              row += ' >';

                              // Add columns to row
                              for (var index in node['childData']) {
                                  var data_temp = node['childData'][index];
                                  //console.log(data_temp);
                                  row += "<td>" + data_temp +"</td>";
                              }

                              // End row
                              row +="</tr>";
                              
                              $("#example-basic").treetable("loadBranch", parentNode, row);
                          }



                      }
                  
                  }

              },
              error:function(error){
                  $("#loadingImage").hide();
                  alert('there was an error');  
              }
              
          });
      }