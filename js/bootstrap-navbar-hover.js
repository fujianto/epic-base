jQuery(document).ready(function($) {	
	/* Bootstrap navbar with hover */
	var mq = window.matchMedia('(min-width: 768px)');
	if (mq.matches) {
		jQuery('ul.navbar-nav > li').addClass('hovernav');
	} else {
		jQuery('ul.navbar-nav > li').removeClass('hovernav');
	};
	  /*
	  The addClass/removeClass also needs to be triggered
	  on page resize <=> 768px
	  */
	  if (matchMedia) {
	  	var mq = window.matchMedia('(min-width: 768px)');
	  	mq.addListener(WidthChange);
	  	WidthChange(mq);
	  }
	  function WidthChange(mq) {
	  	if (mq.matches) {
	  		jQuery('ul.navbar-nav > li').addClass('hovernav');
	      // Restore "clickable parent links" in navbar
	      jQuery('.hovernav a').click(function () {
	      	window.location = this.href;
	      });
	    } else {
	    	jQuery('ul.navbar-nav > li').removeClass('hovernav');
	    }
	  };
	  // Restore "clickable parent links" in navbar
	  jQuery('.hovernav a').click(function () {
	  	window.location = this.href;
	  });
});