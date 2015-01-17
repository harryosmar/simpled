var user_group_crud = {
    user_group_crud: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (crud) !== "undefined" && enable_crud == true) {
            self.crud();
        }
        /*END INIT PARENT JS*/
    }
};

user_group_crud = $.extend(crud, user_group_crud);

$(function() {
    crud.user_group_crud();
});