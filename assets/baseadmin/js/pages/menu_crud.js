var menu_crud = {
    menu_crud: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (crud) !== "undefined" && enable_crud == true) {
            self.crud();
        }
        /*END INIT PARENT JS*/

        //set tag input
        $('.tags').tagsInput({
            width: 'auto',
            //'autocomplete': {'view': 'view', 'edit': 'edit', 'add': 'add', 'remove': 'remove'}
        });

        //On change Menu Link Dropdown
        $("body").delegate("#menu_link", "change", function() {
            if ($(this).val().match(/^NO$/i)) {
                $("#menu_segment").attr('disabled', true);
            } else {
                $("#menu_segment").removeAttr('disabled');
            }
        });

        $("#menu_link").trigger('change'); //init call event change for 'menu link'
    },
    on_success_submit: function(json) {
        var self = this;
        site.alert_msg({type: json.status, dom_container: $(self.crud_form), msg: json.msg, fill_type: 'prepend'}); //success msg
        if (typeof (json.insert_id) !== "undefined") {
            self.reload_menu_parent_id();
        }
    },
    reload_menu_parent_id: function() {
        var self = this;
        //process Form POST data
        $.ajax({
            url: class_url + 'reload_menu_parent_id',
            type: 'post',
            dataType: 'json',
            async: true,
            beforeSend: function() {
            },
            error: function(request) {
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line
                if (json.status.match(/^success$/i)) {
                    $("#menu_parent_id").parent(".controls").html(json.data);
                } else {
                    console.log(JSON.stringify(json));
                }
            }
        });
    }
};

menu_crud = $.extend(crud, menu_crud);

$(function() {
    crud.menu_crud();
});