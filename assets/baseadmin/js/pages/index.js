var index = {
	index : function(){
		/*START INIT PARENT JS*/
        var self = this;
        self.init();
        /*END INIT PARENT JS*/
	}
};

index = $.extend(site, index);

$(function() {
    site.index();
});