(function(){
    // Back to Top - by CodyHouse.co
	var shoppingCart = document.getElementsByClassName('js-cd-top1')[0],
		offset = 300, // browser window scroll (in pixels) after which the "back to top" link is shown
		offsetOpacity = 1200, //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
		scrollDuration = 700,
		scrolling = false;

	if( shoppingCart ) {
		//update back to top visibility on scrolling
		window.addEventListener("scroll", function(event) {
			if( !scrolling ) {
				scrolling = true;
				(!window.requestAnimationFrame) ? setTimeout(checkBackToTop1, 250) : window.requestAnimationFrame(checkBackToTop1);
			}
		});

		//smooth scroll to top
		// shoppingCart.addEventListener('click', function(event) {
		// 	event.preventDefault();
		// 	(!window.requestAnimationFrame) ? window.scrollTo(0, 0) : Util.scrollTo(0, scrollDuration);
		// });
	}



	function checkBackToTop1() {
		var windowTop = window.scrollY || document.documentElement.scrollTop;
		( windowTop > offset ) ? Util.addClass(shoppingCart, 'cd-top1--is-visible') : Util.removeClass(shoppingCart, 'cd-top1--is-visible cd-top1--fade-out');
		( windowTop > offsetOpacity ) && Util.addClass(shoppingCart, 'cd-top1--fade-out');
		scrolling = false;
	}
})();