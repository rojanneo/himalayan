(function ( $ , event) {
	var validation_rules = [
		{"className":"required", "errormsg":"This field is required", "pattern":"."},
		{"className":"number-validation", "errormsg":"Only Numbers Allowed", "pattern":"[0-9]"},
		{"className":"email-validation", "errormsg":"Please Enter a valid email", "pattern":"[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?"},
	];
    $.fn.validate = function(class_of_input) {
    	var noError = true;
    // /	alert(new RegExp(pa).test(email));
    	if(this.is('form'))
    	{
    		$.each(this.find('.'+class_of_input), function(i, input)
    		{
    			if(($(input)).attr('type')  != 'submit')
    			{
	    			var classes = $(input).attr('class');
	    			classes = classes.split(' ');
	    			for(var i = 0; i<classes.length; i++)
	    			{
	    				for(var j = 0; j<validation_rules.length; j++)
	    				{
	    					var obj = validation_rules[j];
	    					if(obj.className == classes[i])
	    					{
	    						
	    						{
	    							var pattern = obj.pattern;
	    							var errormsg = obj.errormsg;
	    							var value = $(input).val();
	    							var className = obj.className;
	    							var regexp = new RegExp(pattern);
	    							var name = $(input).attr('name');
	    							// if(regexp.test(value))
	    							// {
	    							// 	$('<p class = "'+className+'">'+errormsg+'</p>').insertAfter($(input));
	    							// }
	    							// /alert(obj.pattern);
	    							if (regexp.test(value)) {
										    $('p.'+className+name).remove();
									} else {
											$('p.'+className+name).remove();
										
									    $('<p class = "'+className+name+'">'+errormsg+'</p>').insertAfter($(input));
									    noError = false;
									}
	    							
	    						}
	    					}
	    				}
	    			}
	        	}
	        });
			if(noError == true)
			{
				$(this).submit();
			}
			else
			{
				return false;
			}

    	}
    	else
    	{
    		return false;
    	}
    };
 
}( jQuery ));