</div>


<footer class="text-center" id="footer">
    &copy;copyRight 2017-2018 E-commerce
</footer>


<script>
    $(window).scroll(function () {
        var scroll=$(this).scrollTop();
        $("#text").css( {
            "transform":"translate(0px,"+scroll/2+"px)"
        })
    });

    function modaldetail(x) {
        var data ={"id" : x};
        jQuery.ajax({url:"/ecommerce/includes/details_modal.php",
            method:"POST",
            data:data,
            success:function (data) {
                jQuery('body').prepend(data);
                jQuery('#details-modal').modal('toggle');

            },
            error:function () {
                alert("some wrongs");
            }

        });

    };


    function addTocart() {
        jQuery('#modal_errors').html("");
        var quantity=jQuery('#quantity').val();
        var size =jQuery('#size').val();
        var available=jQuery('#available').val();
        var error='';
        var data =jQuery('#add_product_form').serialize();
        if (size=='' || quantity == '' ||quantity==0 ){
            error+='<p class="text-danger text-center"> You must choose size an quantity</p>';
            jQuery('#modal_errors').html(error);
            return;
        }else if (quantity > available){
            error+='<p class="text-danger text-center"> there are only available '+available+' item</p>';
            jQuery('#modal_errors').html(error);
            return;
        }else {
            jQuery.ajax({
                url: '/ecommerce/admin/parser/add_to_cart.php',
                method:'POST',
                data:data,
                success:function () {
                    location.reload();},
            error:function(){alert('some thing went wrong');}

        });


        }
    }

</script>
</body>
</html>