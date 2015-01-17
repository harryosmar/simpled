var menu_datatable = {
    menu_datatable: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (datatable) !== "undefined" && enable_datatable == true) {
            self.datatable();
        }
        /*END INIT PARENT JS*/
    }
};

menu_datatable = $.extend(datatable, menu_datatable);

$(function() {
    datatable.menu_datatable();
});