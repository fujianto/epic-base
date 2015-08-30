jQuery(document).ready(function(){
	 jQuery(".countdown-timer").each(function(index, element){
	 	var countdownTimer = jQuery(element).attr('data-countdown');
	 	jQuery(element).countdown(countdownTimer, function(event) {
	 		jQuery(this).find(".days").html(event.strftime('%D'));
	 		jQuery(this).find(".hours").html(event.strftime('%H'));
	 		jQuery(this).find(".minutes").html(event.strftime('%M'));
	 		jQuery(this).find(".seconds").html(event.strftime('%S'));
	 	});
	 });
});