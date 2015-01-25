var menu = {
	menu : function(){
		var self = this;

		$(document).on('click', '#icon-panel-modal li', function(){
			var menu_icon = $(this).find('i').attr('class');
			var menu_id = $("#icon-panel-modal [name=menu_id]").val();
			self.ajax_request(class_url+"update_menu_icon", {
				menu_id : menu_id,
				menu_icon : menu_icon
			});
			$(this).addClass('active');
		});

		$(document).on('click', '[data-name=update-menu-icon]', function(){
			$("#icon-panel-modal [name=menu_id]").val($(this).attr('data-menu-id'));
			var icon = $('#icon-panel-modal li i.'+$(this).attr('data-menu-icon'));
			var li = icon.parent('li');
			$('#icon-panel-modal li').removeClass('active');
			li.addClass('active');
			$("#icon-panel-modal").modal('show');
		});
	},
	onCompleteUpdateMenu : function(json){
		var self = this;
		$('ul.mainnav').html(json.subnavbar);
		self.growl_msg(json.status, json.status, json.msg);
		menu_datatable.refresh_datatable();
	}
};

menu = $.extend(site, menu);

$(function() {
    site.menu();
});