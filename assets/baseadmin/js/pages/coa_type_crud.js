var coa_type_crud = {
    coa_type_crud: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (crud) !== "undefined" && enable_crud == true) {
            self.crud();
        }
        /*END INIT PARENT JS*/
    }
};

coa_type_crud = $.extend(crud, coa_type_crud);

$(function() {
    crud.coa_type_crud();
});