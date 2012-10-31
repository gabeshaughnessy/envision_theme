/*
 * Image preview script 
 * powered by jQuery (http://www.jquery.com)
 * 
 * written by Alen Grakalic (http://cssglobe.com)
 * 
 * for more info visit http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
 *
 */(function(a){this.imagePreview=function(){xOffset=-20;yOffset=-125;a("a.preview").hover(function(b){var c=a(this).data("large");this.t=this.title;this.title="";var d=this.t!=""?"<br/>"+this.t:"";a("body").append("<p id='preview'><img src='"+c+"' alt='Image preview' />"+d+"</p>");a("#preview").css("top",b.pageY-xOffset+"px").css("left",b.pageX+yOffset+"px").fadeIn("fast")},function(){this.title=this.t;a("#preview").remove()});a("a.preview").mousemove(function(b){a("#preview").css("top",b.pageY-xOffset+"px").css("left",b.pageX+yOffset+"px")})}})(window.jQuery);jQuery(document).ready(function(a){imagePreview()});