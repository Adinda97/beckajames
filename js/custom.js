var ageCheck = sessionStorage.getItem('ageCheck');
    
if (ageCheck === '1'){
    $('.age__check').hide();
} else{
    $('.age__check').show();
}

$().ready(()=> {

    $('#ageCheckForm').submit((e)=>{
        e.preventDefault();
        var ageVal =  $('#birthday').val();
        var age = new Date(ageVal);
        var monthDiff = Date.now() - age.getTime();
        console.log(ageVal)
        var age_dt = new Date(monthDiff);
        var year = age_dt.getUTCFullYear();

        var ageString = Math.abs(year - 1970);
        console.log(ageString);

        if(ageString > 18){
            $('.age__check').hide();
            sessionStorage.setItem('ageCheck', 1);
        } else{
            alert('sorry je moet 18 jaar of ouder zijn om deze website te bekijken')
        }
    });

        ;
    ( function ( $ ) {
    "use strict";
    // Define the PHP function to call from here
    var data = {
    'action': 'mode_theme_update_mini_cart'
    };
    $.post(
    woocommerce_params.ajax_url, // The AJAX URL
    data, // Send our PHP function
    function(response){
        $('#mode-mini-cart').html(response); // Repopulate the specific element with the new content
    }
    );
    // Close anon function.
    }( jQuery ) );

    $('.page-transition').addClass('page-transition-anim');

    $('.mini-cart').click((e)=>{
        $('.mini-cart-container').toggleClass('active_mini_cart');
        $('.mini-cart__container').toggleClass('active_mini_cart_container');
    });

    $('.add_to_cart_button').click((e)=>{
        $('.mini-cart-container').addClass('active_mini_cart');
        $('.mini-cart__container').addClass('active_mini_cart_container');
        // return false;
    });

    $('.mini-cart__container').click((e)=>{
        e.preventDefault();
        $('.mini-cart-container').removeClass('active_mini_cart');
        $('.mini-account-container').removeClass('active_mini_cart');
        $('.mini-cart__container').removeClass('active_mini_cart_container');
    });

    $('.my-account-btn').click((e)=>{
        e.preventDefault();
        $('.mini-account-container').toggleClass('active_mini_cart');
        $('.mini-cart__container').toggleClass('active_mini_cart_container');
    });

    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
      });
    $('.slider-nav').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        arrows: false,
        centerMode: true,
        focusOnSelect: true,
        infinite: true,
        adaptiveHeight: false,
        autoplay: true,
        autoplaySpeed: 3000,
      });

    $(".clickable").click(function(e) {
        e.preventDefault();
        window.location = $(this).find('a').attr('href');
    });

    $(".menu-item").click(function(e) {
        e.preventDefault();
        window.location = $(this).find('a').attr('href');
    });


    $(".menu-toggle").click(function(e) {
        $(".mobile__menu--container").toggleClass('mobile-active')
    });
    $(".search-toggle").click(function(e) {
        $(".mobile__search--container").toggleClass('mobile-active')
    });

    // $(".menu-close").click(function(e) {
    //     $(".mobile__menu--container").css('right', '110%');
    // });

    $("#toggleFilter").click(function(e) {
            $("#filters").toggleClass('activeFilter');
    })

	$('#filter').submit(function(){
		var filter = $('#filter');
		$.ajax({
			url:filter.attr('action'),
			data:filter.serialize(), // form data
			type:filter.attr('method'), // POST
			beforeSend:function(xhr){
				filter.find('button').text('Processing...'); // changing the button label
			},
			success:function(data){
				filter.find('button').text('Filter toepassen'); // changing the button label back
				$('#response').html(data); // insert data
			}
		});
		return false;
	});
	
	var currentGfgStep, nextGfgStep, previousGfgStep;
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;
  
    setProgressBar(current);
  
    $(".checkout-button").click(function () {
        currentGfgStep = $(this).parent();
        nextGfgStep = $(this).parent().next();
  
        $("#progressbar li").eq($("fieldset")
            .index(nextGfgStep)).addClass("active");
  
        nextGfgStep.show();
        currentGfgStep.animate({ opacity: 0 }, {
            step: function (now) {
                opacity = 1 - now;
  
                currentGfgStep.css({
                    'display': 'none',
                    'position': 'relative'
                });
                nextGfgStep.css({ 'opacity': opacity });
            },
            duration: 500
        });
        setProgressBar(++current);
    });
  
    $(".previous-step").click(function () {
  
        currentGfgStep = $(this).parent();
        previousGfgStep = $(this).parent().prev();
  
        $("#progressbar li").eq($("fieldset")
            .index(currentGfgStep)).removeClass("active");
  
        previousGfgStep.show();
  
        currentGfgStep.animate({ opacity: 0 }, {
            step: function (now) {
                opacity = 1 - now;
  
                currentGfgStep.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previousGfgStep.css({ 'opacity': opacity });
            },
            duration: 500
        });
        setProgressBar(--current);
    });
  
    function setProgressBar(currentStep) {
        var percent = parseFloat(100 / steps) * current;
        percent = percent.toFixed();
        $(".progress-bar")
            .css("width", percent + "%")
    }
  
    $(".submit").click(function () {
        return false;
    })


    
function getAge(birthDateString) {
    var today = new Date();
    var birthDate = new Date(birthDateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

if(getAge("27/06/1989") >= 18) {
    alert("You have 18 or more years old!");
} 	
});


