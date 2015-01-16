var coa_type_datatable = {
    coa_type_datatable: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (datatable) !== "undefined" && enable_datatable == true) {
            self.datatable();
        }
        /*END INIT PARENT JS*/
    }
};

coa_type_datatable = $.extend(datatable, coa_type_datatable);

$(function() {
    datatable.coa_type_datatable();
});