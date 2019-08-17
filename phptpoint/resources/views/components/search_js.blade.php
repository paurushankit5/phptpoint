<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript">
    var availableTags

    //function to call inside ajax callback 
    function set_availableTags(data){
      availableTags = [];
      $.each(data.tutorial, function(index,value){
        availableTags.push({'label' : value.name , 'value' : value.name ,'url' : value.slug});
      });
      $.each(data.subtutorial, function(index,value){
        availableTags.push({'label' : value.name , 'value' : value.name,'url' : value.slug});
      });
      $( "#searchbox" ).autocomplete({
        source: availableTags,
        select: function(event, ui) {
          //console.log(ui.item)
          window.location.href = "/"+ui.item.url;
      }
      });
    }
    $("#searchbox").keyup(function(){
      if(this.value != ''){
        $.ajax({
          type: 'GET',
          url: '/getHints',
          data : {
            q : this.value
          },
          success: function(data){
            set_availableTags(data)
          }
        })
      }
    });
    $( "#searchbox" ).autocomplete({
      source: availableTags
    });


  </script>