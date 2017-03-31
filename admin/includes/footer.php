</div><br><br>
<footer class="text-center"  id ="footer">&copy;KALA CHASMA</footer>
<script>
  function updateSizes(){
    var sizeString = '';
    for(i=1;i<=12;i++){
      if(jQuery('#size'+i).val()!= ''){
        sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
      }
    }
    jQuery('#sizes').val(sizeString);
  }
  function get_child_options(){
    var parentID = jQuery('#parent').val();
    jQuery.ajax({
      url: '/tutorial/admin/parsers/child_categories.php',
      type: 'POST',
      data: {parentID : parentID},
      success: function(data){
        jQuery('#child').html(data);
      },
      error: function(){alert("something went wrong with the child options")},
    });
  }
  jQuery('select[name="parent"]').change(get_child_options);
</script>
</body>
</html>
