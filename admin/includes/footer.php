</div>


<footer class="text-center" id="footer">
    &copy;copyRight 2017-2018 E-commerce
</footer>

<script>
    function updateSizes() {
    var sizeString='';
    for (var i = 1;i<=12;i++){
        if(jQuery('#size'+i).val()!=''){
            sizeString+= jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
        }
    }
    jQuery('#sizes').val(sizeString);
       }
  function getChilds(selected){

        if(typeof selected == 'undefined'){
            var selected = '';
        }
      var parentId=jQuery('#parent').val();
    jQuery.ajax({
        url:'/ecommerce/admin/parser/child_Cat.php',
        type:'POST',
        data:{parentID:parentId},
        success:function(data) {
        jQuery('#child').html(data);
        },
        error:function () {
            alert('some thing went wrong')

        }

    });
    };
    jQuery('select[name="parent"]').change(function () {
        getChilds();
    });
</script>
</body>
</html>