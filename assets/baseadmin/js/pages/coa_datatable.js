var coa_datatable = {
    coa_datatable: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (datatable) !== "undefined" && enable_datatable == true) {
            self.datatable();
        }
        /*END INIT PARENT JS*/
    }
};

coa_datatable = $.extend(datatable, coa_datatable);

$(function() {
    datatable.coa_datatable();
});