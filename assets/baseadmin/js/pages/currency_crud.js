var currency_crud = {
    currency_crud: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        if (typeof (crud) !== "undefined" && enable_crud == true) {
            self.crud();
        }
        /*END INIT PARENT JS*/
    }
};

currency_crud = $.extend(crud, currency_crud);

$(function() {
    crud.currency_crud();
});