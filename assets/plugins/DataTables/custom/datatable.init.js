var datatable = {
    datatable_id: "#datatable-cms",
    datepicker_class: ".datatable-datepicker",
    oTable: null,
    dom: datatable_setting['dom'],
    datatable: function() {
        var self = this;

        //add "button new" to datatable container
//        if (enable_crud == true) {
//            $("#datatable-container").prepend('<a href="'+class_url+'add" class="btn btn-primary btn-action pull-right"><span class="glyphicon glyphicon-plus"></span>&nbsp;New</a>');
//        }

        // Setup - add a text input to each 'tr.filter th' cell
        $(datatable.datatable_id + ' thead tr.filter th').each(function() {
            $index = $(this).index();
            $title = $(datatable.datatable_id + ' tr.filter th').eq($(this).index()).text();
            if (typeof (datatable_setting['columnDefs'][$index]) !== "undefined" && datatable_setting['columnDefs'][$index]['searchable'] == true) { //if column from database
                $column_title = datatable_setting['columnDefs'][$index]['db'];
                if (datatable_setting['columnDefs'][$index]['type'].match(/^currency$/i)) { //currency
                    $(this).html('<input name="' + $column_title + '" data-name="start" type="text" placeholder="Start" class="form-control" style="margin-bottom:5px;"/><input type="text" name="' + $column_title + '" data-name="end" placeholder="End" class="form-control"/>');
                } else if (datatable_setting['columnDefs'][$index]['type'].match(/^enum$/i)) { //enum
                    $dropdown = '<select name="' + $column_title + '" class="form-control">';
                    for ($enum_index in datatable_setting['columnDefs'][$index]['enums']) {
                        $dropdown += '<option value="' + datatable_setting['columnDefs'][$index]['enums'][$enum_index] + '">' + $enum_index + '</option>';
                    }
                    $(this).html($dropdown);
                } else if (datatable_setting['columnDefs'][$index]['type'].match(/^datetime|date|timestamp$/i)) { //datepicker
                    $start_date = '<div class="input-group" style="max-width: 250px; margin-bottom:5px;"><input name="' + $column_title + '" data-name="start" type="text" placeholder="From" class="' + datatable.datepicker_class.substring(1) + ' form-control" disabled="TRUE"/><span class="input-group-addon datatable-datepicker-open"><span class="glyphicon glyphicon-calendar"></span></span></div>';
                    $end_date = '<div class="input-group" style="max-width: 250px;"><input type="text" name="' + $column_title + '" data-name="end"  placeholder="To" class="' + datatable.datepicker_class.substring(1) + ' form-control" disabled="TRUE"/><span class="input-group-addon datatable-datepicker-open"><span class="glyphicon glyphicon-calendar"></span></span></div>';
                    $(this).html($start_date + $end_date);
                } else { //input text
                    $(this).html('<input name="' + $column_title + '" type="text" placeholder="Search ' + $title + '" class="form-control"/>');
                }
            } else if (typeof (datatable_setting['columnDefs'][$index]) !== "undefined" && datatable_setting['columnDefs'][$index]['searchable'] == false) {
                $(this).html('');
            } else if (typeof (datatable_setting['columnDefs'][$index]) === "undefined") { //if action column
                $(this).html('<button name="do-search-single-column" class="btn btn-' + class_bootsrap_component + '" style="margin-bottom:5px; display:block;"><span class="glyphicon glyphicon-search"></span> Search</buttton><button name="do-reset-single-column" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Reset</buttton>');
            }
        });

        datatable.init_datatable_datepicker(); // Datepicker initialisation


        datatable.init_datatable(); // DataTables initialisation

        // Apply the single filter column
//        $("#example tfoot input").on('keyup change', function(e) {
//            if (e.keyCode === 13) {
//                //table.column($(this).parent().index() + ':visible').search(this.value).draw();
//            }
//        });

        // Apply the single filter column
        $('body').delegate('[name="do-search-single-column"]', 'click', function(e) {
            e.preventDefault();
            datatable.do_search_single_column();
        });

        // Reset the single filter column
        $('body').delegate('[name="do-reset-single-column"]', 'click', function(e) {
            e.preventDefault();
            datatable.do_reset_single_column();
        });

        //Apply event handler for all input filter single column
        self.set_single_column_input_filter_event();

        // Apply the global filter
//        $dataTables_filter_input = $(datatable.datatable_id).parents(".dataTables_wrapper").find("div.dataTables_filter input");
//        $dataTables_filter_input.unbind();
//        $('body').delegate($dataTables_filter_input, 'keyup', function(e) {
//            if (e.keyCode === 13) {
//                datatable.oTable.fnFilter($dataTables_filter_input.val());
//            }
//        });
        
        //On click confirmDelete
        $(document).on('click', "[data-name=confirmDelete]", function(){
            self.confirmDelete($(this));
        });
    },
    set_single_column_input_filter_event: function() {
        for (var $index in datatable_setting['columnDefs']) {
            if (typeof (datatable_setting['columnDefs'][$index]) !== "undefined" && datatable_setting['columnDefs'][$index]["visible"] === true && datatable_setting['columnDefs'][$index]['searchable'] == true) { //if column from database
                $column_name = datatable_setting['columnDefs'][$index]['db'];
                if (datatable_setting['columnDefs'][$index]['type'].match(/^(datetime|currency)$/i) && $("[name=" + $column_name + "][data-name=start]").length > 0 && $("[name=" + $column_name + "][data-name=end]").length > 0) {
                    $('body').delegate('[name=' + $column_name + '][data-name=start]', 'change', function(e) {
                        e.preventDefault();
                        datatable.do_search_single_column();
                    });
                    $('body').delegate('[name=' + $column_name + '][data-name=end]', 'change', function(e) {
                        e.preventDefault();
                        datatable.do_search_single_column();
                    });
                } else if (datatable_setting['columnDefs'][$index]['type'].match(/^(enum)$/i)) {
                    $('body').delegate('[name=' + $column_name + ']', 'change', function(e) {
                        e.preventDefault();
                        datatable.do_search_single_column();
                    });
                }
                else if ($("[name=" + $column_name + "]").length > 0) {
                    $('body').delegate('[name=' + $column_name + ']', 'keyup', function(e) {
                        e.preventDefault();
                        if (e.keyCode == 13) {
                            datatable.do_search_single_column();
                        }
                    });
                }
            }
        }
    },
    do_reset_single_column: function() {
        for (var $index in datatable_setting['columnDefs']) {
            if (typeof (datatable_setting['columnDefs'][$index]) !== "undefined" && datatable_setting['columnDefs'][$index]["visible"] === true && datatable_setting['columnDefs'][$index]['searchable'] == true) { //if column from database
                $column_title = datatable_setting['columnDefs'][$index]['db'];
                if (datatable_setting['columnDefs'][$index]['type'].match(/^enum$/i)) {
                    $('select[name="' + $column_title + '"] option').eq(0).prop('selected', true);
                } else {
                    $('.form-control[name="' + $column_title + '"]').val("");
                }
            }
        }
        datatable.do_search_single_column();
    },
    do_search_single_column: function() {
        $index_without_hide = 0;
        for (var $index in datatable_setting['columnDefs']) {
            if (typeof (datatable_setting['columnDefs'][$index]) !== "undefined" && datatable_setting['columnDefs'][$index]['visible'] == true && datatable_setting['columnDefs'][$index]['searchable'] == true) { //if column from database
                $column_title = datatable_setting['columnDefs'][$index]['db'];
                if (datatable_setting['columnDefs'][$index]['type'].match(/^datetime$/i)) {
                    datatable.oTable.column($index_without_hide + ':visible').search($('.form-control[name="' + $column_title + '"][data-name=start]').val() + " " + $('.form-control[name="' + $column_title + '"][data-name=end]').val());
                } else if (datatable_setting['columnDefs'][$index]['type'].match(/^currency$/i)) {
                    datatable.oTable.column($index_without_hide + ':visible').search($('.form-control[name="' + $column_title + '"][data-name=start]').val() + " " + $('.form-control[name="' + $column_title + '"][data-name=end]').val());
                } else {
                    datatable.oTable.column($index_without_hide + ':visible').search($('.form-control[name="' + $column_title + '"]').val());
                }
                $index_without_hide++;
            } else if (typeof (datatable_setting['columnDefs'][$index]) !== "undefined" && datatable_setting['columnDefs'][$index]['visible'] == true && datatable_setting['columnDefs'][$index]['searchable'] == false) { //for searchable false
                $index_without_hide++;
            }
        }
        datatable.oTable.draw(); // redraw datatable
//            $(datatable.datatable_id + ' thead tr.filter th').each(function() {
//                $index = $(this).index();
//                
//            });
    },
    init_datatable_datepicker: function() {
        //Set Datepicker
//        $(document).delegate(datatable.datepicker_class, 'DOMNodeInserted', function(e) {
//            //e.stopPropagation();
//            $(datatable.datepicker_class).datepicker({
//                //showOn: "button",
//                //buttonImage: _assets + "img/calendar.gif",
//                //buttonImageOnly: true,
//                "dateFormat": "yy-mm-dd",
//                changeMonth: true,
//                changeYear: true,
//                yearRange: "-75:+0"
//            });
//        });
        $('body').delegate('.datatable-datepicker-open', 'click', function(e) {
            e.preventDefault();
            $(datatable.datepicker_class).datepicker({
                "dateFormat": "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                yearRange: "-75:+0"
            });
            $(this).parent('.input-group').find(datatable.datepicker_class).datepicker("show");
        });
    },
    init_datatable: function() {
        datatable.oTable = $(datatable.datatable_id).DataTable({
            "processing": true,
            "serverSide": true,
            "dom": datatable.dom,
            "columnDefs": datatable_setting['columnDefs'],
            "lengthMenu": datatable_setting['lengthMenu'],
            "iDisplayLength": datatable_setting['iDisplayLength'],
            "stateSave": datatable_setting['stateSave'],
            "language": datatable_setting["oLanguage"],
            "order": datatable_setting["order"],
            "ajax": class_url + "datatable_server_processing"+query_string,
            "fnServerParams": function(aoData) {
                //set param ajax by GET parameter, only call for the first draw
                if (aoData.draw == 1) {
                    for ($index in datatable_setting['columnDefs']) {
                        $column_name = datatable_setting['columnDefs'][$index]['db'];
                        if (datatable_setting['columnDefs'][$index]['visible'] == true && datatable_setting['columnDefs'][$index]['searchable'] == true) {
                            if (datatable_setting['columnDefs'][$index]['type'].match(/^(datetime|currency)$/i) && (typeof (GET['start_' + $column_name]) !== "undefined" || typeof (GET['end_' + $column_name]) !== "undefined")) {
                                $start = typeof (GET['start_' + $column_name]) !== "undefined" ? GET['start_' + $column_name] : "";
                                $end = typeof (GET['end_' + $column_name]) !== "undefined" ? GET['end_' + $column_name] : "";
                                aoData['columns'][$index]['search']['value'] = $start + ' ' + $end;
                            } else if (datatable_setting['columnDefs'][$index]['type'].match(/^(datetime|currency)$/i) && typeof (GET[$column_name]) !== "undefined") {
                                aoData['columns'][$index]['search']['value'] = GET[$column_name] + ' ' + GET[$column_name];
                            } else if (typeof (GET[$column_name]) !== "undefined") {
                                aoData['columns'][$index]['search']['value'] = GET[$column_name];
                            }
                        }
                    }
                }
                //aoData.push( { "name": "more_data", "value": "my_value" } );

            },
            "fnInitComplete": function(oSettings, json) {
                //reset single column value using state save
                var cols = oSettings.aoPreSearchCols;
                for (var i = 0; i < cols.length; i++) {
                    var value = cols[i].sSearch;
                    if (typeof (datatable_setting['columnDefs'][i]) !== "undefined" && datatable_setting['columnDefs'][i]["visible"] === true && datatable_setting['columnDefs'][i]['searchable'] == true) {
                        var column_name = datatable_setting['columnDefs'][i]['db'];
                        if (datatable_setting['columnDefs'][i]['type'].match(/^(enum)$/i)) {
                            $('select[name="' + column_name + '"] option[value="' + value + '"]').prop('selected', true);
                        } else if (datatable_setting['columnDefs'][i]['type'].match(/^(currency|datetime)$/i)) {
                            value = value.split(" ");
                            $(".form-control[name=" + column_name + "][data-name=start]").val(typeof (value[0]) !== "undefined" ? value[0] : "");
                            $(".form-control[name=" + column_name + "][data-name=end]").val(typeof (value[1]) !== "undefined" ? value[1] : "");
                        } else {
                            $(".form-control[name=" + column_name + "]").val(value);
                        }
                    }
                }

                //set filter single column input value using GET query string parameter, only call for the first draw
                if (json.draw == 1) {
                    for ($index in datatable_setting['columnDefs']) {
                        $column_name = datatable_setting['columnDefs'][$index]['db'];
                        if (datatable_setting['columnDefs'][$index]['visible'] == true && datatable_setting['columnDefs'][$index]['searchable'] == true) {
                            if (datatable_setting['columnDefs'][$index]['type'].match(/^(datetime|currency)$/i) && (typeof (GET['start_' + $column_name]) !== "undefined" || typeof (GET['end_' + $column_name]) !== "undefined")) {
                                $start = typeof (GET['start_' + $column_name]) !== "undefined" ? GET['start_' + $column_name] : "";
                                $end = typeof (GET['end_' + $column_name]) !== "undefined" ? GET['end_' + $column_name] : "";
                                $("[name=" + $column_name + "][data-name=start]").val($start);
                                $("[name=" + $column_name + "][data-name=end]").val($end);
                            } else if (typeof (GET[$column_name]) !== "undefined" && datatable_setting['columnDefs'][$index]['type'].match(/^enum$/i)) {
                                $('select[name="' + $column_name + '"] option[value="' + GET[$column_name] + '"]').prop('selected', true);
                            } else if (typeof (GET[$column_name]) !== "undefined") {
                                $("[name=" + $column_name + "]").val(GET[$column_name]);
                            }
                        }
                    }
                    if (GET != "") { //if GET not empty
                        datatable.do_search_single_column(); //do search column for the first time, to handle query string paging error
                    }
                }
            }
        });
    },
    refresh_datatable: function() {
        //datatable.oTable.clearPipeline().draw();// redraw datatable
        //datatable.oTable.AjaxUpdate(oTable.settt);
        //alert(datatable.oTable.fnReloadAjax);
        datatable.oTable.fnReloadAjax();
        //location.reload();
    },
    confirmDelete : function(elm){
        var self = this;
        var href = elm.attr('data-href');
        var msg = elm.attr('data-msg');
        msg = typeof(msg) === "undefined" ? "Are you sure that you want to permanently delete the selected element?" : msg;
        if(typeof(href) === "undefined"){
            alert("Please define confirmDelete url parameter");
            return false;
        }

        $.msgbox(msg, {
          type: "confirm",
          buttons : [
            {type: "submit", value: "Yes"},
            {type: "cancel", value: "Cancel"}
          ]
        }, function(result) {
            if(result == 'Yes'){
                self.ajax_request(href);
            }
        });
    }
};

datatable = $.extend(site, datatable);
