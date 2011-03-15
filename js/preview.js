/*
 * Minimal Georgia Preview
 * 
 * This script is used to switch color schemes when previewing the theme.
 * Enqueued only if no sidebar widgets have been defined, therefore the failover
 * widgets are outputted by the theme where the color scheme picker exists.
 * 
 * This script comes in pair with a stylesheet called preview.css
 * 
 */
 
jQuery(document).ready(function($) {
	$('.color-scheme-selector a').click(function() {
		var color = $(this).attr('data');
		$('body').removeClass('mg-red mg-blue mg-green mg-gray mg-purple').addClass('mg-' + color);
		return false;
	});
});
 
