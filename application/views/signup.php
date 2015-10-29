<div class="container-fluid" style="min-height: 25px;">
</div>
<div class="container-fluid" style="min-height:200px;margin:10px 10px;">
    <div class="container">
        <div class="col-md-6">
            <div class="signup-header" >
                Tell us your zip code </br></br>
            </div>
            <input type="text" class="card-info-box" maxlength="5" name="zip_search" id="zip_search" placeholder="zip code" value=""/></br>
        </div>
        <div class="col-md-6">
            <div class="signup-text text-left" id="deliveryInfo" style="display:none;">
                <span> Delivery Available: </span> <span class="signup-delivery-info" id="delivery-available"> </span><br>
                <span> Delivery Fee: </span>    <span class="signup-delivery-info" id="delivery-fee"> </span><br>
                <span> Minimum Order: </span>   <span class="signup-delivery-info" id="minimum-order"> </span> <br>
                <span> Delivery Fee: </span>    <span class="signup-delivery-info" id="del-fee-minorder"> </span> <br>
                <span style="color:#fbb03b;font-size: 12px;"> (under minimum order)</span class="signup-delivery-info" id=""> <span > </span>

            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="min-height:200px;margin:10px 10px;">
    <div class="container">

        <div class="col-md-6">
            <div class="signup-header">
                Start Shopping
            </div>
        </div>
        <div class="col-md-6 text-left" style="margin-top: 10px;">
            <div class="">
                <input type="text" class="card-info-box" name="email" id="email" placeholder="email" value=""/><span id="errprmsg" style="color:red"></span>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    /*
    $(function() {
        $( "#zip_search" ).focus(function(){
            $( "#zip_search" ).val('');
        });
        $( "#zip_search" ).blur(function(){
            var zipcode = $( "#zip_search" ).val();

            if($( "#zip_search" ).val()=='')
            {
                $( "#zip_search" ).val("Enter Zip Code");
                $( "#deliveryInfo").hide();

            }
            else
            {
                if ( $( "#zip_search" ).val().length < 5 )
                {
                    $("#spnNotice").html("Zip Code must be at least 5 digits.");
                    $("#zip_search").val("Enter Delivery Address ZIP CODE.");
                    $("#zip_search").focus();
                }
                else
                {
                    //var zipcode = $( "#zip_search" ).val();
                    $.ajax({
                        type: "GET",
                        url:'<?php //echo base_url();?>signup/checkzip',
                        data:'zipcode='+$( "#zip_search" ).val(),
                        complete:function(data){

                            strdata = JSON.parse(data.responseText);
                            if(strdata==''){
                                $( "#deliveryInfo").show();
                                $("#delivery-available" ).html('NO');
                                $("#delivery-fee" ).html('');
                                $("#minimum-order" ).html('');
                                $("#del-fee-minorder" ).html('');
                            }else{
                                $( "#deliveryInfo").show();
                                $("#delivery-available" ).html('YES');
                                if( strdata[0].delivery_price =='0')
                                    deliveryPrice = 'FREE';
                                else
                                    deliveryPrice = "$ "+strdata[0].delivery_price;
                                $("#delivery-fee" ).html(deliveryPrice);
                                $("#minimum-order" ).html("$ "+strdata[0].min_order);
                                $("#del-fee-minorder" ).html("$ "+strdata[0].low_delivery_price);
                            }

                        }
                    });
                }
            }
        });

        $( "#email" ).blur(function() {
                    var email = $( "#email").val();
                   // var zipCode = $( "#zip_search" ).val();
                if( email =='')return false;
                else {
                    $.ajax({
                        type: "GET",
                        url: "<?php //echo base_url(); ?>signup/signup_process/",
                        dataType: 'json',
                        data: {'email': email,'zipcode':'123' },
                        complete: function (data) { //alert(data);
                            userdata = JSON.parse(data.responseText);
                            if(userdata.success =='no'){
                                $( "#errprmsg" ).html('Please enter valid email address.');
                            }else{

                                $( "#errorflash").html('Your are successfully subscribed our mail list.');
                                $("#errorflash").fadeOut('slow');
                                //$( "#errprmsg" ).html('Your are successfully subscribed our mail list.');
                                window.location.href = "http://localhost/fetch/product/products/3";
                            }

                        }
                    });
                }
            });

    });


    $( "#email" ).blur(function() {
        $.ajax({
            type: "GET",
            url:'<?php //echo base_url();?>signup/signup_process',
            data:'email='+$( "#email" ).val(),'zipcode='+$( "#zip_search" ).val(),
            complete:function(data){
                newdata = JSON.parse(data.responseText);
                alert(newdata);
            }
        });

    }); */
</script>
