jQuery(document).ready(function($) {
	/* Enable placeholder for below IE 10*/
	// if(jQuery('input, textarea').length > 0 )
	// 	jQuery('input, textarea').placeholder();
	
	/*Date time picker */
	if(jQuery.fn.datetimepicker){
		jQuery('#datetimepicker1').datetimepicker();
	}

	/* Sticky element */
	if(jQuery.fn.sticky){
  		jQuery(".primary-nav-menu").sticky({topSpacing:0});
	}

  /*Just for test */
  // jQuery(".primary-nav-menu").on('sticky-start', function() { 
  // 	console.log("START"); 
  // 	jQuery(this).animate({
  // 		height:'40px',
  // 	});

  // 	jQuery('.navbar-default').animate({
  // 		height:'40px',
  // 	});
  // });

  // jQuery(".primary-nav-menu").on('sticky-end', function() { 
  // 	console.log('END'); 
  // 	jQuery(this).animate({
  // 		height:'64px',
  // 	});
  // 	jQuery('.navbar-default').animate({
  // 		height:'64px',
  // 	});
  // });

	/* Custom Radio Tab */
	if(jQuery("#tabs-option-logo").length > 0 && jQuery("#tabs-option-logo").length > 0 && jQuery("#tabs-option-logo").length > 0) {
	  customLemonTabs('#tabs-option-logo');
	  customLemonTabs('#tabs-option-layout');
	  customLemonTabs('#tab-color-options');
	}

	/* Custom style input file */
  if(jQuery.filestyle){	
		jQuery(":file").filestyle();
	}

	/* Lightbox gallery */
	if(jQuery(".gallery-group").length > 0 ) {
		/* Popup Gallery */
		jQuery('.gallery-group').magnificPopup({
		  delegate: '.carousel-link', // child items selector, by clicking on it popup will open
		  type: 'image',
		  gallery:{
		  	enabled:true
		  }
		});
	}

	/*Chosen jquery select */
	if(jQuery.fn.chosen){
		jQuery(".chosen-select").chosen();
	}

	/*Bootstrap switch */
	if(jQuery.fn.bootstrapSwitch){	
		jQuery("[name='switch-checkbox']").bootstrapSwitch();
	}

	/* Enable responsive video with fitvids */
	if(jQuery.fn.fitVids ){
		jQuery(".embed-wrap").fitVids();
	}

	/* Make element with class same-height have matching height */
	if(jQuery.fn.matchHeight ){
		jQuery('.same-height').matchHeight();
	}

	/*Bootstrap Accordion */

	// Open The First Item in Accordion
	jQuery('.accordion .panel:first-of-type').addClass('active'); 
	jQuery('.accordion .panel:first-of-type .panel-heading .panel-title .toggler').removeClass('fa-plus').addClass('fa-minus'); 
	jQuery('.accordion .panel:first-of-type .panel-collapse').addClass('in');

	// var collapsedContent = jQuery('.accordion .panel .panel-collapse'); console.log(collapsedContent.hasClass('in'));
	// if(collapsedContent.hasClass('in')){
	// 	collapsedContent.prev().addClass('highlight');
	// }

	(function() {
		jQuery(".panel").on("show.bs.collapse hide.bs.collapse", function(e) {
			if (e.type=='show'){
				jQuery('.accordion .panel .panel-heading').removeClass('');
				jQuery(this).addClass('active');
			}else{
				jQuery(this).removeClass('active');
			}
		});  
	}).call(this);

 //    function toggleAccordion(e) {
 //        jQuery('.accordion .panel-heading').removeClass('highlight');
 //        jQuery(e.target).prev('.panel-heading').addClass('highlight');
 //    }

 //    jQuery('.accordion').on('hidden.bs.collapse', toggleAccordion);
 //    jQuery('.accordion').on('shown.bs.collapse', toggleAccordion);

    jQuery('.collapse').on('shown.bs.collapse', function(){
    	jQuery(this).parent().find(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
    }).on('hidden.bs.collapse', function(){
    	jQuery(this).parent().find(".fa-minus").removeClass("fa-minus").addClass("fa-plus");
    });
});