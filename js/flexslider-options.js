jQuery(document).ready(function(){
	jQuery('.flexslider-home').flexslider({
		startAt: 0, 
		animation: "slide"
	});

	jQuery('.flexslider').flexslider({
		startAt: 0, 
		animation: "slide",
		controlNav: false, 
	});

	jQuery('.flexslider-carousel').flexslider({
		startAt: 0, 
		animation: "slide", 
		itemWidth: 300,
		itemMargin: 10,
		controlNav: false, 
		prevText: "",          
		nextText: "",   
	});
});