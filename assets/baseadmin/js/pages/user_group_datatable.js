var user_group_datatable = {
    user_group_datatable: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (datatable) !== "undefined" && enable_datatable == true) {
            self.datatable();
        }
        /*END INIT PARENT JS*/
    }
};

user_group_datatable = $.extend(datatable, user_group_datatable);

$(function() {
    datatable.user_group_datatable();
});