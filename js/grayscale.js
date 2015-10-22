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
    $("#currentPrice_"+groupId).html('$'+price);
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

$(document).ready(function(){
    $("#loginButton").click(function(){
       //  $('.fetch-login').css('display','block');
        $(".fetch-login").toggle();
    });
    $(".fetch-login").hide();
    $(".page-scroll").click(function(){ alert('yes');

        $(".sub-menu").toggle();
    });
    //var x = "Total Width: " + screen.width;

   // $(".sub-menu").hide();
});
$(function(){
    $("#brand").sexyCombo({
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
