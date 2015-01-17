var currency_datatable = {
    currency_datatable: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (datatable) !== "undefined" && enable_datatable == true) {
            self.datatable();
        }
        /*END INIT PARENT JS*/
    }
};

currency_datatable = $.extend(datatable, currency_datatable);

$(function() {
    datatable.currency_datatable();
});