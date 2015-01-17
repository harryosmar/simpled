var index = function(_site){
	function indexinit(){
		_site.site_init();
	}

	_site['indexinit'] = indexinit;
	return _site; 
}(site || {});

$(function () {
	index.indexinit();
});