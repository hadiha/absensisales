// Hide Header on on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 1;
var navbarHeight = $('header').outerHeight();

$(window).scroll(function(event){
	didScroll = true;
});

$(window).load(function() {
	isHome()
	setInterval(function() {
		if (didScroll) {
			hasScrolled();
			didScroll = false;
		}
	}, 250);

	function isHome(){
		if($('body').hasClass('home')){
			if ($(this).scrollTop() > $(window).height() - 56){
				$('header .navbar').css({
					'background-color': '#fff'})
				$('header .navbar li a').css({
					'color': '#444'})
				$('header .navbar-brand').css({
					'color': '#444'})
			}else{
				$('header .navbar').css({
					'background-color': 'transparent'})
				$('header .navbar li a').css({
					'color': '#fff'})
				$('header .navbar-brand').css({
					'color': '#fff'})
			}
		}
	}

	function hasScrolled() {
		var st = $(this).scrollTop();

		if(Math.abs(lastScrollTop - st) <= delta)
			return;
		if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        $('header').removeClass('nav-down').addClass('nav-up');
    } else {
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
        	$('header').removeClass('nav-up').addClass('nav-down');
        }
    }

    lastScrollTop = st;
    isHome()
}	
});