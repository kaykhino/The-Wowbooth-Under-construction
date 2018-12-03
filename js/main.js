
(function ($) {
    "use strict";

    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;
      
        /*for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }*/

        if (check == true) {
        	var formData = [];
        	
        	for (var i=0; i < input.length; i++) {
        		formData[i] = {"name": input[i].name, "value": input[i].value};
        	}
        	
        	console.log(formData);
        	
        	$.ajax('http://wowbooth.local/cgi-bin/under-construction/EmailSubscriptionSubmit.php', {
        		 success: subscriptionComplete,
        		 data: formData,
        		 method: "post"
        	});
        	return false;
        }
        
        return false;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else if($(input).attr('type') == 'text' && $(input).attr('name') == 'name') {
            if($(input).val().trim().match(/^[a-z ]+$/i) == null) {
                return false;
            }
        }
        else {
        	console.log($(input).val());
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    function subscriptionComplete () {
    	console.log("submitted form");
    }
})(jQuery);