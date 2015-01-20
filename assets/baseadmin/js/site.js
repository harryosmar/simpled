// First, checks if it isn't implemented yet.
if (!String.prototype.format) {
  String.prototype.format = function() {
    var args = arguments;
    return this.replace(/{(\d+)}/g, function(match, number) { 
      return typeof args[number] != 'undefined'
        ? args[number]
        : match
      ;
    });
  };
}

var site = {
    init: function() {
        var self = this;
        GET = self.searchToObject();
        query_string = $.isEmptyObject(GET) ? '' : '?'+$.param(GET);
        $("body").delegate(".prevent-default", "click", function(e) {
            e.preventDefault();
        });
        self.check_active_subnavbar_menu();
    },
    searchToObject: function(search) {
        search = typeof (search) !== "undefined" ? search : window.location.search;
        var pairs = search.substring(1).split("&"), obj = {}, pair, index;
        for (index in pairs) {
            if (pairs[index] === "")
                continue;
            pair = pairs[index].split("=");
            obj[ decodeURIComponent(pair[0]) ] = decodeURIComponent(pair[1]);
        }
        return obj;
    },
    check_active_subnavbar_menu : function(){
        var elm = $("a[data-menu-segment="+class_name+"]");
        $(".mainnav li.parentmenu").removeClass("active");
        if(elm.length != 0){
            elm.parents("li.parentmenu").addClass('active');
        }
    },
    reload: function() {
        location.reload();
    },
    forbidden_access : function(){
        alert('Sorry, but you have no access for this page.');
        location.reload();
    },
    ajax_request : function(url, data){
        //console.log(data);
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
    },
    on_finish_ajax: function(json) {
        if (typeof (json.action) !== "undefined") {
            this[json.action](json);
        }
    },
    growl_msg: function(type, title, text){
        type = typeof(type) !== "undefined" ? type : 'success';
        title = typeof(title) !== "undefined" ? title : '';
        text = typeof(text) !== "undefined" ? text : '';

        $.msgGrowl ({
            type: type, 
            title: title,
            text: text
        });
    },
    alert_msg: function(options) {
        $.extend({
            type: null,
            dom_container: null,
            title: '',
            msg: '',
            fill_type: 'replace',
            show_title: false,
            auto_close: false,
            time_to_close: 5000
        }, options);

        var alert_class;
        switch (options.type) {
            case 'warning':
                alert_class = 'alert';
                break;
            case 'success' :
                alert_class = 'alert alert-success';
                break;
            case 'error' :
                alert_class = 'alert alert-danger';
                break;
            case 'info' :
                alert_class = 'alert alert-info';
                break;
            default :
                alert_class = 'alert alert-block';
                break;
        }

        var alert_title = (typeof (options.title) === "undefined" || options.show_title == false) ? '' : '<strong>' + options.title + '</strong>';
        switch (options.fill_type) {
            case 'append':
                if (options.dom_container.children('div.alert').length > 0) {
                    options.dom_container.children('div.alert').remove();
                }
                options.dom_container.append('<div class="' + alert_class + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + alert_title + ' ' + options.msg + '</div>');
                break;
            case 'prepend' :
                if (options.dom_container.children('div.alert').length > 0) {
                    options.dom_container.children('div.alert').remove();
                }
                options.dom_container.prepend('<div class="' + alert_class + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + alert_title + ' ' + options.msg + '</div>');
                break;
            case 'replace' :
                options.dom_container.html('<div class="' + alert_class + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + alert_title + ' ' + options.msg + '</div>');
                break;
            default :
                options.dom_container.html('<div class="' + alert_class + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + options.title + ' ' + options.msg + '</div>');
                break;
        }

        if (options.auto_close === true) {
            setTimeout(function() {
                options.dom_container.find('.alert').remove();
            }, options.time_to_close);
        }
    },
    build_clean_url: function(url) {
        return url.replace(/&/g, "and").replace(/[^a-zA-Z0-9 _-]+/g, '').replace(/\s/gi, '-').replace(/--+/g, '-').toLowerCase();
    },
    scrollTop: function(dom_container, speed, parent_container, offset) {
        dom_container = (typeof (dom_container) === "undefined") ? $("body") : dom_container;
        speed = (typeof (speed) === "undefined") ? 500 : speed;
        parent_container = (typeof (parent_container) === "undefined") ? $('html, body') : parent_container;
        offset = (typeof (offset) === "undefined") ? 0 : offset;
        parent_container.animate({
            scrollTop: dom_container.offset().top - offset
        }, speed);
    },
    accounting_format: function(number, symbol, precision, thousand, decimal, format){
        symbol = typeof(symbol) !== "undefined" ? symbol : "Rp";
        precision = typeof(precision) !== "undefined" ? precision : 2;
        thousand = typeof(thousand) !== "undefined" ? thousand : ",";
        decimal = typeof(decimal) !== "undefined" ? decimal : ".";
        format = typeof(format) !== "%s%v" ? format : ".";
        return accounting.formatMoney(number, symbol, 2, thousand, decimal, format);
    }
};