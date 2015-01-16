var privilege = {
    privilege: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        /*END INIT PARENT JS*/

        //On change dropdown user_group_id
        $("select#user_group_id").bind('change', function(e) {
            e.preventDefault();
            $user_group_id = $(this).val();
            if ($(this).val() != 0) {
                self.load_privilege($user_group_id);
            } else {
                $("#privilege-result").html('<div class="alert alert-danger text-center"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;Please Select User Group</div>');
            }
        });

        //On click update privilege per menu
        $("body").delegate("[data-name=update-privilege-per-menu]", "click", function(e) {
            e.preventDefault();
            $menu_id = $(this).attr("data-menu-id");
            $user_group_id = $("select#user_group_id").val();
            $privilege_action = new Array();
            $("input[type=checkbox][name=checkbox-per-menu][data-menu-id=" + $menu_id + "]:checked").each(function(index, value) {
                $privilege_action[index] = $(this).val();
            });
            $privilege_action = $privilege_action.join(); //implode array $privilege_action to string with delimiter ','
            self.set_privilege_per_user_group_per_menu($user_group_id, $menu_id, $privilege_action, $(this));
        });

        //On change #checkuncheck-all
        $("body").delegate("input[type=checkbox]#checkuncheck-all", "change", function(e) {
            e.preventDefault();
            if ($(this).is(':checked') == true) {
                $("input[type=checkbox][name=checkbox-per-menu]").prop('checked', true);
            } else {
                $("input[type=checkbox][name=checkbox-per-menu]").prop('checked', false);
            }
        });

        //On click button 'update-privilege-all'
        $("body").delegate('[data-name=update-privilege-all]', 'click', function(e) {
            e.preventDefault();
            $user_group_id = $("select#user_group_id").val();
            $privilege = {};
            $("[data-name=update-privilege-per-menu]").each(function(index_menu, value_menu) {
                $menu_id = $(this).attr('data-menu-id');
                $privilege_action = new Array();
                $("input[type=checkbox][name=checkbox-per-menu][data-menu-id=" + $menu_id + "]:checked").each(function(index_action, value_action) {
                    $privilege_action[index_action] = $(this).val();
                });
                $privilege_action = $privilege_action.join(); //implode array $privilege_action to string with delimiter ','
                $privilege[$menu_id] = $privilege_action;
            });
            self.set_privilege_per_user_group($user_group_id, $privilege, $(this));
        });
    },
    load_privilege: function(user_group_id) {
        var self = this;
        $.ajax({
            url: class_url + 'load_privilege',
            type: 'post',
            data: {
                user_group_id: user_group_id
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                $("#privilege-result").html('<div class="text-center loading-text"><img src="' + _assets + 'img/loading-spinner-grey.gif"> loading privilege...</div>');
            },
            error: function(request) {
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line
                if (json.status.match(/^success$/i)) {
                    //set privilege
                    $("#privilege-result").html(json.data);
                    $("#privilege-result").hide();
                    $("#privilege-result").slideDown("slow");

                    //set checkuncheck all
                    if ($("input[type=checkbox][name=checkbox-per-menu]:checked").length == $("input[type=checkbox][name=checkbox-per-menu]").length) {
                        $("input[type=checkbox]#checkuncheck-all").attr('checked', true);
                    }
                }
            }
        });
    },
    set_privilege_per_user_group_per_menu: function(user_group_id, menu_id, privilege_action, elm) {
        var self = this;
        $.ajax({
            url: class_url + 'set_privilege_per_user_group_per_menu',
            type: 'post',
            data: {
                user_group_id: user_group_id,
                menu_id: menu_id,
                privilege_action: privilege_action
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                elm.button('loading');
                $('.update-feedback').remove();
            },
            error: function(request) {
                elm.button('reset');
                elm.parent('td').prepend('<span class="glyphicon glyphicon-remove-sign text-danger update-feedback"></span>');
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line
                elm.button('reset');
                if (json.status.match(/^success$/i)) {
                    elm.parent('td').prepend('<span class="glyphicon glyphicon-ok-sign text-success update-feedback"></span>');
                } else {
                    elm.parent('td').prepend('<span class="glyphicon glyphicon-remove-sign text-danger update-feedback"></span>');
                }
            }
        });
    },
    set_privilege_per_user_group: function(user_group_id, privilege, elm) {
        var self = this;
        $.ajax({
            url: class_url + 'set_privilege_per_user_group',
            type: 'post',
            data: {
                user_group_id: user_group_id,
                privilege: privilege
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                elm.button('loading');
                $('.update-feedback').remove();
            },
            error: function(request) {
                elm.button('reset');
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line
                elm.button('reset');
                if (json.status.match(/^success$/i)) {
                    elm.parent('th').prepend('<span class="glyphicon glyphicon-ok-sign text-success update-feedback"></span>');
                } else {
                    elm.parent('th').prepend('<span class="glyphicon glyphicon-remove-sign text-danger update-feedback"></span>');
                }
            }
        });
    }
};

privilege = $.extend(site, privilege);

$(function() {
    site.privilege();
});