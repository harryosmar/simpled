var user_datatable = {
    user_datatable: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (datatable) !== "undefined" && enable_datatable == true) {
            self.datatable();
        }
        /*END INIT PARENT JS*/
    }
};

user_datatable = $.extend(datatable, user_datatable);

$(function() {
    datatable.user_datatable();
});