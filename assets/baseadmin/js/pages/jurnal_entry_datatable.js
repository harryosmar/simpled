var jurnal_entry_datatable = {
    jurnal_entry_datatable: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (datatable) !== "undefined" && enable_datatable == true) {
            self.datatable();
        }
        /*END INIT PARENT JS*/ 
    }
}

jurnal_entry_datatable = $.extend(datatable, jurnal_entry_datatable);

$(function() {
    datatable.jurnal_entry_datatable();
});