var crud = {
    crud_form: '#crud-form', //Form
    crud_btn_submit: '#crud-form [type=submit]', //Form > Modal Footer > [type=submit]
    crud: function() {
        var self = this;

        //Prepare all js & css & plugin for CRUD form
        self.prepare_crud_form();

        //When Form Submitted
        $('body').delegate(self.crud_form, 'submit', function(e) {
            e.preventDefault(e);
            $formData = new FormData($(this)[0]);
            self.process_crud_form($formData);
        });
    },
    prepare_crud_form: function() {
        //set datepicker
        $(".datepicker").datepicker({
            "dateFormat": "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "-75:+0"
        });

        //set datetimepicker
        $(".datetimepicker").datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "-75:+0"
        });

        //set RTE : Richt Text Editor, TinyMCE
        //tinymce.execCommand('mceRemoveControl', true, 'address_detail');
        mytinymce.init({selector: ".tinymce"});
    },
    process_crud_form: function(data) {
        var self = this;

        //process Form POST data
        $.ajax({
            url: class_url + $(self.crud_btn_submit).attr('data-action'),
            type: 'post',
            data: data,
            dataType: 'json',
            async: true,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            beforeSend: function() {
                $(self.crud_btn_submit).button('loading'); //loading button submit
                $(self.crud_form).find(".alert").remove(); //remove all alert msg in form

                //remove all form-group class
                $form_group = $(self.crud_form).find(".form-group");
                $form_group.removeClass("has-feedback has-success has-warning has-error");
                $form_group.find(".form-control-feedback").remove();
                $controls = $form_group.find(".controls");
                //$controls.find(".text-danger").remove();
                $form_group.find(".text-danger").remove();
            },
            error: function(request) {
                $(self.crud_btn_submit).button('reset');
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line
                
                $(self.crud_btn_submit).button('reset');
                if (json.status.match(/^success$/i)) {
                    self.on_success_submit(json);
                } else {
                    //self.alert_msg({type: json.status, dom_container: $(self.crud_form), msg: json.msg, fill_type: 'prepend'}); //error msg
                    for (var field in json.form_error) {
                        $form_group = $(self.crud_form).find(".form-group[for=" + field + "]");
                        $controls = $form_group.find(".controls");
                        if (json.form_error[field] == "") { //if field SUCCESS
                            $form_group.addClass("has-feedback has-success");
                            //$form_group.append('<span class="glyphicon glyphicon-ok form-control-feedback"></span>');
                        } else {//if field ERROR
                            $form_group.addClass("has-feedback has-error");
                            //$form_group.append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
                            //$controls.append(json.form_error[field]);
                            $form_group.prepend(json.form_error[field]);
                        }
                    }
                }

                self.scrollTop($(self.crud_form), 500, $('html, body'), 45); //scroll to top
            }
        });
    },
    on_success_submit: function(json) {
        var self = this;
        self.alert_msg({type: json.status, dom_container: $(self.crud_form), msg: json.msg, fill_type: 'prepend'}); //success msg
        //datatable.refresh_datatable();
    }
};
crud = $.extend(site, crud);

