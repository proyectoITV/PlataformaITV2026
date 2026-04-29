jQuery(document).ready(function ($) {

  $('#body').init(function(){
    setInterval(function () {
        moveRight();
    }, 3000);
  });
  
	var slideCount = $('#slider_ceropapel ul li').length;
	var slideWidth = $('#slider_ceropapel ul li').width();
	var slideHeight = $('#slider_ceropapel ul li').height();
	var slider_ceropapelUlWidth = slideCount * slideWidth;
	
	$('#slider_ceropapel').css({ width: slideWidth, height: slideHeight });
	
	$('#slider_ceropapel ul').css({ width: slider_ceropapelUlWidth, marginLeft: - slideWidth });
	
    $('#slider_ceropapel ul li:last-child').prependTo('#slider_ceropapel ul');

    function moveLeft() {
        $('#slider_ceropapel ul').animate({
            left: + slideWidth
        }, 200, function () {
            $('#slider_ceropapel ul li:last-child').prependTo('#slider_ceropapel ul');
            $('#slider_ceropapel ul').css('left', '');
        });
    };

    function moveRight() {
        $('#slider_ceropapel ul').animate({
            linear: - slideWidth
        }, 200, function () {
            $('#slider_ceropapel ul li:first-child').appendTo('#slider_ceropapel ul');
            $('#slider_ceropapel ul').css('left', '');
        });
    };

    $('a.control_prev').click(function () {
        moveLeft();
    });

    $('a.control_next').click(function () {
        moveRight();
    });

});