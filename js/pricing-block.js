jQuery(document).ready(function(){
	jQuery(".pricing-style-beta .featured-price").parent().addClass("featured-this");
	// jQuery(".pricing-style-beta .featured-price").parent().prevAll("[class^=col-]").addClass("unfeatured-prev");
	// jQuery(".pricing-style-beta .featured-price").parent().nextAll("[class^=col-]").addClass("unfeatured-next");
		
	jQuery(".pricing-style-beta .featured-price").parent()
		.next("[class^=col-]").removeClass("unfeatured-next").addClass("unfeatured-next-close");
	jQuery(".pricing-style-beta .featured-price").parent()
		.prev("[class^=col-]").removeClass("unfeatured-prev").addClass("unfeatured-prev-close");
});