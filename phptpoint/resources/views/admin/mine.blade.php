@extends('layouts.admin')



@section('page_heading')
    Add Project
@endsection

@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis-network.min.css"> 
    <script type="text/javascript">
        var nodes, edges, network,uniNode;
        // var base_url="http://35.231.136.49:8088";
        var base_url="http://localhost:8088";

        var compute_flag= true;
        var start_file_count= 0;
        var all_files;

        function toJSON(obj) {
            return JSON.stringify(obj, null, 4);
        }

        function startcomputation(){
          //async:false;
          //if(compute_flag==true && all_files.length>0)
          //{
            addNewNode(all_files[0].value);
            all_files[0].remove();
           // console.log(all_files.length+" left");          
          //}
        }

        function pausecomputation(){
          compute_flag = false;
          alert("stopp request");
          //a("#start_computation").show();
          //$("#pause_computation").hide();
        }

       

        function addNewNode(filename='') {
            try {
                if(filename=='')
                {
                  filename=$( "#node-label-new" ).val();
                }
                
                console.log(filename);
                var data_s = [];
                $.ajax({
                    type: 'get',
                    url: base_url+'/visualisation/'+filename+".json",
                    success :function(data)
                    {                        
                        data_s=data;
                        $.each(data_s.nodes, function(i,n_node){
                          try {
                              nodes.add(n_node);
                          }
                          catch (err) {
                              // alert(err);
                              //console.log(err)
                          }        
                      });

                      $.each(data_s.edges, function(i,n_edge){
                        try {
                            edges.add(n_edge); 
                        }
                        catch (err) {
                        var item = edges.get(n_edge.id);
                        // console.log(items);
                        var e_edge;
                        e_edge=item.data;
                        $.each(n_edge.data, function(k,ed_data){
                            e_edge.push(ed_data);
                        });
                        // console.log(edt);
                        edges.update({
                            id:n_edge.id,
                            from: n_edge.from,
                            to: n_edge.to,
                            data:e_edge
                        });
                            //console.log(err)
                        } 
                        
                    });
                    
                    },
                    async:false
                }).then(function(){
                   node_weight();
                  console.log("ajax complete");
                  //startcomputation();
                  //return 1;
                  //console.log("cant reach here");
                });
                //console.log(data_s);
                

                //return 1;
               

            }
            catch (err) {
              console.log("from error ");
              //return 1;
              //startcomputation();
                //alert(err);
                //console.log(err)
            }
            //return 1;
        }

        function addNode() {
            try {
                nodes.add({
                    id: document.getElementById('node-id').value,
                    label: document.getElementById('node-label').value
                });
            }
            catch (err) {
                alert(err);
            }
        }

        function updateNode() {
            try {
                nodes.update({
                    id: document.getElementById('node-id').value,
                    label: document.getElementById('node-label').value
                });
            }
            catch (err) {
                alert(err);
            }
        }
        function removeNode() {
            try {
                nodes.remove({id: document.getElementById('node-id').value});
            }
            catch (err) {
                alert(err);
            }
        }

        function addEdge() {
            try {
                edges.add({
                    id: document.getElementById('edge-id').value,
                    from: document.getElementById('edge-from').value,
                    to: document.getElementById('edge-to').value
                });
            }
            catch (err) {
                alert(err);
            }
        }
        function updateEdge() {
            try {
                edges.update({
                    id: document.getElementById('edge-id').value,
                    from: document.getElementById('edge-from').value,
                    to: document.getElementById('edge-to').value
                });
            }
            catch (err) {
                alert(err);
            }
        }
        function removeEdge() {
            try {
                edges.remove({id: document.getElementById('edge-id').value});
            }
            catch (err) {
                alert(err);
            }
        }

        // convenience method to stringify a JSON object
        function draw() {
            if (network != null) {
                network.destroy();
                network = null;
            }
            var data_s;
            $.ajax({
                type: 'get',
                url: base_url+'/visualisation/first_graph',
                success :function(data)
                {
                    
                    data_s=data;

                },
                async:false
            });

            console.log(data_s);
            nodes = new vis.DataSet();
           /* nodes.on('*', function () {
                document.getElementById('nodes').innerHTML = JSON.stringify(nodes.get(), null, 4);
            });*/
            $.each(data_s.nodes, function(i,ndata){
                
                try {
                    nodes.add(ndata);
                }
                catch (err) {
                    ndata.id=ndata.id+i.toString();
                    nodes.add(ndata);
                } 
            });
           

            // create an array with edges
            edges = new vis.DataSet();
            /*edges.on('*', function () {
                document.getElementById('edges').innerHTML = JSON.stringify(edges.get(), null, 4);
            });*/
            $.each(data_s.edges, function(j,edata){
                try {
                    edges.add(edata); 
                }
                catch (err) {
                    // appending edge value if edge already exist
                    var items = edges.get(edata.id);
                    // console.log(items);
                    var edt;
                    edt=items.data;
                    $.each(edata.data, function(k,ed_data){
                        edt.push(ed_data);
                    });
                    // console.log(edt);
                    edges.update({
                        id:edata.id,
                        from: edata.from,
                        to: edata.to,
                        data:edt
                    });
                    // edata.id=edata.id+j.toString();
                    // edges.add(edata);
                } 
            });




            // create a network
            var container = document.getElementById('network');
            var data = {
                nodes: nodes,
                edges: edges
            };
            var options = {
              "interaction":{"hover":true},
              // "manipulation": {
              //   "enabled": true
              // },
              "nodes":{
                "fixed": false,
                "scaling": {
                  "label": true
                },
                "shadow": false
              },
              "edges": {
                "smooth": {
                  "forceDirection": "none"
                },
                "color": {
                      "color":'#848484',
                      "highlight":'red',
                      "hover": 'green',
                      "inherit": 'from',
                      "opacity":2.0
                    }
              },
              "physics": {
                        "stabilization": false,
                        /*"forceAtlas2Based": {
                          "gravitationalConstant": -404,
                          "centralGravity": 0.48,
                          "springLength": 55,
                          "springConstant": 0.145,
                          "damping": 0.37,
                          "avoidOverlap": 0.27
                        },
                        "minVelocity": 0.75*/
              },
              "configure": {
                  filter:function (option, path) {
                    if (path.indexOf('physics') !== -1) {
                      return true;
                    }
                    if (path.indexOf('smooth') !== -1 || option === 'smooth') {
                      return true;
                    }
                    return false;
                  },
                  container: document.getElementById('config')
                }
            };
            network = new vis.Network(container, data, options);
            node_weight();
            network.on("select", function (params) {
                console.log('select Event:', params);
            });
            network.on("selectNode", function (params) {
                console.log('selectNode Event:', params);
            });
            network.on("selectEdge", function (params) {
                console.log('selectEdge Event:', params);
            });
            network.on("deselectNode", function (params) {
                console.log('deselectNode Event:', params);
            });
            network.on("deselectEdge", function (params) {
                console.log('deselectEdge Event:', params);
            });
            network.on("hoverNode", function (params) {
                console.log(JSON.stringify(params, null, 4));
                console.log('hoverNode Event:', params);
            });
            network.on("hoverEdge", function (params) {
                console.log('hoverEdge Event:', params);
            });
            network.on("blurNode", function (params) {
                console.log('blurNode Event:', params);
            });
            network.on("blurEdge", function (params) {
                console.log('blurEdge Event:', params);
            });


        }
        function node_weight(){
            var node_weight = [];
              $('#node_weight_dropdown').html("");
              $.each(nodes.get(),function(i,data){
                    node_weight.push(parseInt(data.weight));
              });
              node_weight = node_weight.sort(function (a, b) {  return a - b;  });
              node_weight   = Array.from(new Set(node_weight));
              $.each(node_weight,function(i,data){
                $('#node_weight_dropdown').append("<option>"+data.toString()+"</option>");
              });
        }
        function remove_weight(){
            var node_weight = $('#node_weight_dropdown').val();
            delete_node_ids = [];
            $.each(nodes.get(),function(i,data){
                    
                    if(node_weight == data.weight)
                    {
                        nodes.remove({id:data.id});
                    }
                     
              });
            

            //console.log(node_weight);
        }
        function resetAll() {
            if (network !== null) {
                network.destroy();
                network = null;
            }
            draw();
        }
        console.log("sadhskajdhfkjshfkjd-=========");
        // network.on("select", function (params) {
        //     console.log('select Event:', params);
        // });
        // network.on("selectNode", function (params) {
        //     console.log('selectNode Event:', params);
        // });
        // network.on("selectEdge", function (params) {
        //     console.log('selectEdge Event:', params);
        // });
        // network.on("deselectNode", function (params) {
        //     console.log('deselectNode Event:', params);
        // });
        // network.on("deselectEdge", function (params) {
        //     console.log('deselectEdge Event:', params);
        // });
        // network.on("hoverNode", function (params) {
        //     console.log('hoverNode Event:', params);
        // });
        // network.on("hoverEdge", function (params) {
        //     console.log('hoverEdge Event:', params);
        // });
        // network.on("blurNode", function (params) {
        //     console.log('blurNode Event:', params);
        // });
        // network.on("blurEdge", function (params) {
        //     console.log('blurEdge Event:', params);
        // });
    </script>   
@endsection


@section('content')
    <div class="box">
        <button onclick="draw();">abc</button>
        <div class="box-header with-border">
            <h3 class="box-title">Add Project</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('projects.index') }}" class="btn btn-primary"> Project List</a>
          </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="" id="config"></div>
                <div class="col-md-12" id="network"></div>
            </div>
        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection


