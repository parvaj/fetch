/*!
 * Start Bootstrap - Grayscale Bootstrap Theme (http://startbootstrap.com)
 * Code licensed under the Apache License v2.0.
 * For details, see http://www.apache.org/licenses/LICENSE-2.0.
 */

// jQuery to collapse the navbar on scroll
$(window).scroll(function() {
    var a = $(window).width();
    //alert(a);
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
        $('.header-logo').css('display','none');
        $('.header-container').css('margin-top','20px');
        $('.sub-menu').css('display','none');
        $('.fetch-login').css('display','none');
    /* $('.intro').css('margin-top','92px'); */
    } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
        $('.header-logo').css('display','block');
        $('.header-container').css('margin-top','0px');
        $('.sub-menu').css('display','block');
       /* $('.intro').css('margin-top','155px'); */
    }
});
var fetchurl = "http://localhost/fetch/";
/*
$(function () {
    $('.fetch-menu li ul').hide().removeClass('fallback');
    $('.fetch-menu li').hover(function () {
        $('ul', this).stop().slideToggle(200);
    });
});
*/
// jQuery for page scrolling feature - requires jQuery Easing plugin

$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});

// Closes the Responsive Menu on Menu Item Click
$('.navbar-collapse ul li a').click(function() {
    $('.navbar-toggle:visible').click();
});

function showLoginForm(){
       // $('.fetch-login').css('display','block');
    $(".fetch-login").toggle();
}

function commonCombo(id){
    alert("hi");
    $("#frequency_"+id).sexyCombo({
        skin: "frequency",
        triggerSelected: true
    });
}
function addPrice(productId,groupId)
{
    var price = $( "#pprice"+productId ).html();
    $("#currentPrice_"+groupId).html('$ '+price);
}

function loadCustomeCombo(groupId)
{
    $("#frequency_"+groupId).sexyCombo({
        skin: "frequency",
        triggerSelected: true
    });
}
function loadDeliveryDate(item){
    $("#deliveryDate_"+item).sexyCombo({
        skin: "frequency",
        triggerSelected: true
    });
}

function addLPrice(productId,groupId){
    var price = $( "#pLprice"+productId ).html();
    $("#currentPrice_"+groupId).text('$ '+price);
}
$(document).ready(function(){

    $("#loginButton").click(function(){
       //  $('.fetch-login').css('display','block');
        $(".fetch-login").toggle();
    });
    $(".fetch-login").hide();
    $(".page-scroll").click(function(){

        $(".sub-menu").toggle();
    });
 });

$(function(){
    $("#mytest").sexyCombo({
        skin: "brand",
        triggerSelected: true,
        textChangeCallback: function(){
            console.log(this);
        }
    });
});

$(function(){
    $("#pp-brand").sexyCombo({
        skin: "frequency",
        triggerSelected: true
    });
});

$(function(){
    $("#category").sexyCombo({
        skin: "frequency",
        triggerSelected: true
    });
});

$(function(){
    $("#petType").sexyCombo({
        skin: "frequency",
        triggerSelected: true
    });
});

$(function(){
    $("#frequency").sexyCombo({
        skin: "frequency",
        triggerSelected: true
    });
});


function showtab(tab)
{
    if(tab==0)
    {
        $("#aboutinfo").show();
        $("#ingrediantsinfo").hide();
        $("#guarantedinfo").hide();
    }
    else if(tab==1)
    {
        $("#aboutinfo").hide();
        $("#guarantedinfo").hide();
        $("#ingrediantsinfo").show();
    }
    else if(tab==2)
    {
        $("#aboutinfo").hide();
        $("#ingrediantsinfo").hide();
        $("#guarantedinfo").show();

    }
}
/*  check zipcode price*/
$(function() {
    $("#zip_search").focus(function () {
        $("#zip_search").val('');
    });
    $("#zip_search").blur(function () {
        var zipcode = $("#zip_search").val();

        if ($("#zip_search").val() == '') {
            $("#zip_search").val("Enter Zip Code");
            $("#deliveryInfo").hide();

        }
        else {
            if ($("#zip_search").val().length < 5) {
                $("#spnNotice").html("Zip Code must be at least 5 digits.");
                $("#zip_search").val("Enter Delivery Address ZIP CODE.");
                $("#zip_search").focus();
            }
            else {
                //var zipcode = $( "#zip_search" ).val();
                $.ajax({
                    type: "GET",
                    url: fetchurl+"signup/checkzip/",
                    data: 'zipcode=' + $("#zip_search").val(),
                    complete: function (data) {

                        strdata = JSON.parse(data.responseText);
                        if (strdata == '') {
                            $("#deliveryInfo").show();
                            $("#delivery-available").html('NO');
                            $("#delivery-fee").html('');
                            $("#minimum-order").html('');
                            $("#del-fee-minorder").html('');
                        } else {
                            $("#deliveryInfo").show();
                            $("#delivery-available").html('YES');
                            if (strdata[0].delivery_price == '0')
                                deliveryPrice = 'FREE';
                            else
                                deliveryPrice = "$ " + strdata[0].delivery_price;
                            $("#delivery-fee").html(deliveryPrice);
                            $("#minimum-order").html("$ " + strdata[0].min_order);
                            $("#del-fee-minorder").html("$ " + strdata[0].low_delivery_price);
                        }

                    }
                });
            }
        }
    });
});

/*  check customer email */
$(function() {
    $( "#email" ).blur(function() {
        var zipCode = $("#zip_search").val();
        var email = $( "#email").val();
        var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
        if(!pattern.test(email)){
            $( "#errprmsg" ).html('  Please enter valid email address.');
            //$("#errprmsg").fadeOut('slow');
                return false;
            }
        if( email =='') return false;
        else {
            $.ajax({
                type: "GET",
                url: fetchurl+"signup/signup_process/",
                dataType: 'json',
                data: {'email': email,'zip_code':zipCode },
                complete: function (data)
                {
                    userdata = JSON.parse(data.responseText);

                    if(userdata.success =='no'){
                        $("#errprmsg" ).html('Please enter valid email address.');
                        //$("#errorflash").fadeOut('slow');
                    }else if(userdata.success =='exist') {
                        $("#errprmsg").html('Exist this user name. Please chose another user name.');
                        //$("#errprmsg").fadeOut('slow');
                        //$( "#errprmsg" ).html('Your are successfully subscribed our mail list.');
                        //window.location.href = "http://localhost/fetch/signup/";
                    }else if(userdata.success =='yes') {
                        $("#errprmsg").html('Your have successfully subscribed our mail list.');
                        window.location.href = "http://localhost/fetch/product/pets";
                        //$("#errprmsg").fadeOut('slow');
                    }
                }
            });
        }
    });

});


function getClassList(id, classname){
    var r = $("#btn"+id).val();
    if( r != id ){
        var $input = $('<button type="submit" id="btn'+id+'" value="'+id+'" class="btn-add target_button" onclick="removeClassId('+id+');">'+classname+'</button>');
        $input.appendTo($("#addbutton"));
    }
    $("#"+id).addClass("intro-1");

}
function getBrandList(id, brandname){
    var r = $("#btn"+id).val();
    if( r != id ){
        var $input = $('<button type="submit" id="btn'+id+'" value="'+id+'" class="btn-add target_button" style="padding-left:5px;" onclick="removeBrandId('+id+');">  '+brandname+'</button>');
        $input.appendTo($("#addbutton"));
    }
    $("#"+id).addClass("intro-1");

}
function removeClassId(id){
    $("#"+id).removeClass("intro-1");
    $("button#btn"+id).remove();

}
function sendClassId(id){
    var idArray = [];
    $('.intro-1').each(function (index) {
        idArray[index] = this.id;
    });

    var t = idArray.join();
    if(!t)
    {
        alert('Please select your stuff.');
        return false;
    }
    $.ajax({
        type: "POST",
        url: fetchurl+"product/stuffs/"+id,
        data: { idArray: t, department:id },
        complete: function (data)
        {
           if(data.responseText == 1){
               window.location.href = "http://localhost/fetch/product/brands/";
           }
        }
    });
}

function sendBrandId(id){

    var idArray = [];
    $('.intro-1').each(function (index) {
        idArray[index] = this.id;
    });

    var p = idArray.join();
    if(!p)
    {
        alert('Please select your brands.');
        return false;
    }
    $.ajax({
        type: "POST",
        url: fetchurl+"product/brands/"+id,
        data: { idArray: p },
        complete: function (data)
        {

            if(data.responseText == 1){
                window.location.href = "http://localhost/fetch/product/products/";
            }
        }
    });

}
function removeBrandId(id){
    $("#"+id).removeClass("intro-1");
    $("button#btn"+id).remove();

}