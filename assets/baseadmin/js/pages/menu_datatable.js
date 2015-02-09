var menu_datatable = {
    menu_datatable: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (datatable) !== "undefined" && enable_datatable == true) {
            self.datatable();
        }
        /*END INIT PARENT JS*/
    },
    show_delete_msg : function(json){
        var self = this;
        self.refresh_datatable();
        self.growl_msg(json.status, json.status, json.msg);
        $('ul.mainnav').html(json.subnavbar); //update  subnavbar
    }
};

menu_datatable = $.extend(datatable, menu_datatable);

$(function() {
    datatable.menu_datatable();
});