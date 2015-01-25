var menu = {
	menu : function(){
		$("#icon-panel-modal").modal('show');

		$(document).on('click', '#icon-panel-modal li', function(){
			var icon_class = $(this).find('i').attr('class');
		});

		$(document).on('click', '[data-name=update-menu-icon]', function(){
			
		});

		
	}
};

menu = $.extend(site, menu);

$(function() {
    site.menu();
});