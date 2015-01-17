var user_crud = {
    user_crud: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (crud) !== "undefined" && enable_crud == true) {
            self.crud();
        }
        /*END INIT PARENT JS*/

        //When Form 'Reset Password' Submitted
        $('body').delegate('form#reset-password-form', 'submit', function(e) {
            e.preventDefault(e);
            $formData = new FormData($(this)[0]);
            self.reset_password($formData);
        });
    },
    reset_password: function(data) {
        var self = this;
        $btn_submit = "[type=submit][data-action=reset_password]";
        $form = "form#reset-password-form";

        //process Form POST data
        $.ajax({
            url: class_url + 'reset_password',
            type: 'post',
            data: data,
            dataType: 'json',
            async: true,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            beforeSend: function() {
                $($btn_submit).button('loading'); //loading button submit
                $($form).find(".alert").remove(); //remove all alert msg in form

                //remove all form-group class
                $form_group = $($form).find(".form-group");
                $form_group.removeClass("has-feedback has-success has-warning has-error");
                $form_group.find(".form-control-feedback").remove();
                $controls = $form_group.find(".controls");
                $form_group.find(".text-danger").remove(); //$controls.find(".text-danger").remove();
            },
            error: function(request) {
                $($btn_submit).button('reset');
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line
                $($btn_submit).button('reset');
                if (json.status.match(/^success$/i)) {
                    self.alert_msg({type: json.status, dom_container: $($form), msg: json.msg, fill_type: 'prepend'}); //success msg
                } else {
                    //self.alert_msg({type: json.status, dom_container: $($form), msg: json.msg, fill_type: 'prepend'}); //error msg
                    for (var field in json.form_error) {
                        $form_group = $($form).find(".form-group[for=" + field + "]");
                        $controls = $form_group.find(".controls");
                        if (json.form_error[field] == "") { //if field SUCCESS
                            $form_group.addClass("has-feedback has-success");
                            //$form_group.append('<span class="glyphicon glyphicon-ok form-control-feedback"></span>');
                        } else {//if field ERROR
                            $form_group.addClass("has-feedback has-error");
                            //$form_group.append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
                            $controls.prepend(json.form_error[field]);//$controls.append(json.form_error[field]);
                        }
                    }
                }

                self.scrollTop($($form), 500, $('html, body'), 45); //scroll to top
            }
        });
    }
};

user_crud = $.extend(crud, user_crud);

$(function() {
    crud.user_crud();
});