/* Collapse sidebar */
	$(document).ready(function () {
	    $('#sidebarCollapse').on('click', function () {
	        $('#sidebar').toggleClass('active');
	        $('.top-nav').toggleClass('active');
	        $(this).toggleClass('active');
	    });
	});
/*MAke current sidbar nav link active*/	
	jQuery(function($) {
     var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
     $('ul a').each(function() {
      if (this.href === path) {
       $(this).addClass('active');
      }
     });
    });