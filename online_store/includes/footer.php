</div>
<br>
<br>

<footer class="col-md-2 text-center" id="footer">&copy; Copyright 2017 Online Store</footer>

<script>
    jQuery(window).scroll(function() {
        var vscroll = $(this).scrollTop();
        jQuery('#logotext').css({
            "transform": "translate(0px, " + vscroll / 2 + "px)"
        });
    });
    
    function detailsmodal(id) {
        var data = {"id" : id};
        jQuery.ajax({
            url : '/online_store/includes/detailsmodal.php',
            method : "post",
            data : data,
            success: function(data) {
                jQuery('body').prepend(data);
                jQuery('#details-modal').modal('toggle');
            },
            error: function() {
                alert("Something went wrong!");
            }
        });
    }
    
    function update_cart(mode, edit_id) {
        var data = {"mode" : mode, "edit_id" : edit_id};
        jQuery.ajax({
            url : '/online_store/admin/parsers/update_cart.php',
            method : 'POST',
            data : data,
            success : function(){location.reload();},
            error : function() {alert("Something went wrong.");},
        });
    }

    function add_to_cart() {
        jQuery('#modal_errors').html("");
        var size = jQuery('#size').val();
        var quantity = jQuery('#quantity').val();
        var available = jQuery('#available').val();
        var error = '';
        var data = jQuery('#add_product_form').serialize();
        if (size == '' || quantity == '' || quantity == 0) {
            error += '<p class="text-danger text-center">You must choose a quantity.</p>';
            jQuery('#modal_errors').html(error);
            return;
        } else if(quantity > available) {
            error += '<p class="text-danger text-center">There are only ' + available + ' available.</p>';
            jQuery('#modal_errors').html(error);
            return;
        } else {
            jQuery.ajax({
                url : '/online_store/admin/parsers/add_cart.php',
                method : 'POST',
                data : data,
                success : function() {
                    location.reload();
                },
                error : function () {alert("Something went wrong");}
            });
        }
    }

</script>
</body>

</html>
