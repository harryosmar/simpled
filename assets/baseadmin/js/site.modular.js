var site = function () {
	function site_init(){
		var self = this;
        GET = self.searchToObject();
        query_string = $.isEmptyObject(GET) ? '' : '?'+$.param(GET);
        $("body").delegate(".prevent-default", "click", function(e) {
            e.preventDefault();
        });
	}

	function searchToObject(search){
		search = typeof (search) !== "undefined" ? search : window.location.search;
        var pairs = search.substring(1).split("&"), obj = {}, pair, index;
        for (index in pairs) {
            if (pairs[index] === "")
                continue;
            pair = pairs[index].split("=");
            obj[ decodeURIComponent(pair[0]) ] = decodeURIComponent(pair[1]);
        }
        return obj;
	}

	function reload(){
		location.reload();
	}

	function forbidden_access(){
		alert('Sorry, but you have no access for this page.');
        location.reload();
	}

	function ajax_request(url, data){
		var self = this;
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            dataType: 'json',
            async: true,
            beforeSend: function() {
            },
            error: function(request) {
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line
            }
        });
	}

	function on_finish_ajax(json){
		if (typeof (json.action) !== "undefined") {
            this[json.action]();
        }
	} 

	function build_clean_url(url){
		return url.replace(/&/g, "and").replace(/[^a-zA-Z0-9 _-]+/g, '').replace(/\s/gi, '-').replace(/--+/g, '-').toLowerCase();
	}

	function scrollTop(dom_container, speed, parent_container, offset) {
        dom_container = (typeof (dom_container) === "undefined") ? $("body") : dom_container;
        speed = (typeof (speed) === "undefined") ? 500 : speed;
        parent_container = (typeof (parent_container) === "undefined") ? $('html, body') : parent_container;
        offset = (typeof (offset) === "undefined") ? 0 : offset;
        parent_container.animate({
            scrollTop: dom_container.offset().top - offset
        }, speed);
    }

    return {
        site_init : site_init,
        searchToObject : searchToObject,
        reload : reload,
        forbidden_access : forbidden_access,
        ajax_request : ajax_request,
        on_finish_ajax : on_finish_ajax,
        build_clean_url : build_clean_url,
        scrollTop : scrollTop
    }
}();