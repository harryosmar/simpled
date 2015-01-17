var login = {
	login : function(){
		var self = this;

		jQuery.support.placeholder = false;
		test = document.createElement('input');
		if('placeholder' in test) jQuery.support.placeholder = true;
		
		if (!$.support.placeholder) {
			$('.field').find ('label').show ();
			
		}

		$("#form-login").on('submit', function(e){
			e.preventDefault();
	        $.ajax({
	            url: class_url+"index",
	            type: 'post',
		        data: {
					email : $("#username").val(),
					password : $("#password").val()
				},
	            dataType: 'json',
	            async: true,
	            beforeSend: function() {
	            	$(".login-action").button('loading');
	            },
	            error: function(request) {
	            	$(".login-action").button('reset');
	                console.log(request.responseText);
	            },
	            success: function(json) {
	                self.on_finish_ajax(json); //always call this on the first line
	                $(".login-action").button('reset');
	            }
	        });

		});
	},
	on_finish_ajax: function(json) {
		var self = this;
		if(json.status == 'error'){
			self.alert_msg({type: json.status, dom_container: $("#form-login"), msg: json.msg, fill_type: 'prepend'});
		}

        if (typeof (json.action) !== "undefined") {
            this[json.action]();
        }
    }
}


login = $.extend(site, login);

$(function () {
	site.login();
});