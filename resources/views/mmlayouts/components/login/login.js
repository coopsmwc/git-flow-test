function showPassword() {    
    var key_attr = $('#passkey').attr('type');	    
	    if(key_attr != 'text') {	        
	        $('.checkbox').addClass('show');
	        $('#passkey').attr('type', 'text');        
    } else {        
        $('.checkbox').removeClass('show');
        $('#passkey').attr('type', 'password');        
    }    
};
$(".checkbox2").click(function() {
	$(this).toggleClass('show');
});
