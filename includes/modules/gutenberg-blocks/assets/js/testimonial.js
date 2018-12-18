(function($) {
	"use strict"

	// Listen for events.
	// in case the document is already rendered
	if (document.readyState!="loading") gutenberg_blocks_content_timeline_init()
	// modern browsers
	else if (document.addEventListener) document.addEventListener("DOMContentLoaded", gutenberg_blocks_content_timeline_init)
	// IE <= 8
	else document.attachEvent("onreadystatechange", function(){
	    if (document.readyState=="complete") gutenberg_blocks_content_timeline_init()
	})

	// Callback function for all event listeners.
	function gutenberg_blocks_content_timeline_init() {
			var testimonial            = $(".gutenberg_blocks_testimonial");
			testimonial.each(function() {
                var slider_data     = $(this).data("slider"),
					data            = slider_data,
					block_id        = data.block_id,
					columns         = data.columns,
					autoplaySpeed   = data.autoplaySpeed,
					autoplay        = data.autoplay,
					infiniteLoop    = data.infiniteLoop,
					pauseOnHover    = data.pauseOnHover,
					transitionSpeed = data.transitionSpeed,
					tcolumns        = data.tcolumns,
					arrowSize       = data.arrowSize,
					arrowColor 	    = data.arrowColor,
					mcolumns        = data.mcolumns

				var settings = {
					slidesToShow : columns,
					slidesToScroll : 1,
					autoplaySpeed : autoplaySpeed,
					autoplay : autoplay,
					infinite : infiniteLoop,
					pauseOnHover : pauseOnHover,
					speed : transitionSpeed,
					arrows : true,
					dots : true,
					rtl : false,
					prevArrow: "<button type=\"button\" data-role=\"none\" class=\"slick-prev\" aria-label=\"Previous\" tabindex=\"0\" role=\"button\" style=\"border-color: "+arrowColor+"\"><span class=\"fas fa-angle-left\" style= \"font-size:"+arrowSize+"px;color: "+arrowColor+"\"></span></button>",
					nextArrow: "<button type=\"button\" data-role=\"none\" class=\"slick-next\" aria-label=\"Next\" tabindex=\"0\" role=\"button\" style=\"border-color: "+arrowColor+"\"><span class=\"fas fa-angle-right\" style= \"font-size:"+arrowSize+"px;color: "+arrowColor+"\" ></span></button>",
					responsive : [
						{
							breakpoint : 1024,
							settings : {
								slidesToShow : tcolumns,
								slidesToScroll : 1,
							}
						},
						{
							breakpoint : 767,
							settings : {
								slidesToShow : mcolumns,
								slidesToScroll : 1,
							}
						}
					]
				}
				$(".gutenberg_blocks_testimonial").find( ".is-carousel" ).slick( settings )

		})
	}

})(jQuery)
