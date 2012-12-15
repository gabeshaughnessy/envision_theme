jQuery(window).load(function(){
/* Isotope Activation */
// cache container
var container = jQuery('.filter-target');
// initialize isotope
if(container.length > 0){
container.isotope({
	'layoutMode' : 'fitRows'
  // options... http://isotope.metafizzy.co/docs/options.html
});


}//endif
// filter items when filter link is clicked
jQuery('.filter-menu a').click(function(){
  var selector = jQuery(this).attr('data-filter');
  jQuery(this).parent().parent('.filter-menu').nextAll('.filter-target').first().isotope({ filter: selector });
  return false;
});
//End isotope activation scripts
});