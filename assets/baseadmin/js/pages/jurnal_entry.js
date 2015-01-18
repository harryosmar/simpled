var jurnal_entry = {
    jurnal_entry: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        /*END INIT PARENT JS*/

        $( ".datepicker-inline" ).datepicker({dateFormat : 'yy-mm-dd'});

        self.initialize_table();

        //On change dropdown coa_id[]
        $(document).on('change', "[name='coa_id[]']", function(){
            var coa_id = $(this).val();
            var row = $(this).parents(".row-transaction-detail");
            var form_group_amount = row.find("[for='amount[]']");

            if(coa_id != 0){
                var currency_id = json_data['coas'][coa_id]['currency_id'];
                var coa_crdr = json_data['coas'][coa_id]['crdr'];
                var currency_label = json_data['currencies'][currency_id]['currency_label'];

                form_group_amount.html(self.get_input_enable_amount(currency_id, currency_label, coa_crdr));
            }else{
                form_group_amount.html(self.get_input_disable_amount());
            }
            $("[name='amount[]']").autoNumeric('init'); 
            self.recalculate_sub_total_amount();
        });

        //On click remove-row
        $(document).on('click', "[data-name='remove-row']", function(){
            var row_transaction_detail = $(this).parents(".row-transaction-detail");
            var input_form_group_cr = $("#input-form-group-cr");
            //if(input_form_group_cr.find(".row-transaction-detail").length > 1){
                row_transaction_detail.remove();
                self.recalculate_sub_total_amount();
            //}
        });

        //On click add-row-dr
        $(document).on('click', "[data-name='add-row-dr']", function(){
            self.add_row('dr');
        });

        //On click add-row-cr
        $(document).on('click', "[data-name='add-row-cr']", function(){
            self.add_row('cr');
        });

        //On keyup add-row-cr
        $(document).on('keyup', "[name='amount[]']", function(e){
            var amount = $(this).val();
            var currency_id = $(this).attr('data-currency-id');
            var input_form_group = $(this).parents(".input-form-group");
            var data_type = input_form_group.attr('data-type');
            self.recalculate_sub_total_amount();
        });

        //On click #submit-new-jurnal
        $(document).on('click', "#submit-new-jurnal", function(e){
            e.preventDefault();
            self.submit_new_jurnal();
        });

        if(json_data['action'] == 'edit'){
            //On click #save-header-jurnal
            $(document).on('click', "#save-header-jurnal", function(e){
                e.preventDefault();
                self.save_header_jurnal();
            });

            //On click #save-detail-jurnal
            $(document).on('click', "#save-detail-jurnal", function(e){
                e.preventDefault();
                self.save_detail_jurnal();
            });
        }
    },
    check_sub_total_amount : function(_checker_arr){
        var _isMatch = true;
        var _isEmpty = 0;
        for (var currency_id in json_data['currencies']) {
            if(_checker_arr['CR'][currency_id]['amount'] != _checker_arr['DR'][currency_id]['amount']){
                _isMatch = false;
                break;
            }else if(parseFloat(_checker_arr['CR'][currency_id]['amount']) == 0){
                _isEmpty++;
            }
        }

        if(_isMatch && _isEmpty < Object.keys(json_data['currencies']).length){
            $('#submit-new-jurnal').removeAttr('disabled');
            $('#save-detail-jurnal').removeAttr('disabled');
        }else{
            $('#submit-new-jurnal').attr('disabled', 'disabled');
            $('#save-detail-jurnal').attr('disabled', 'disabled');
        }
    },
    recalculate_sub_total_amount : function(){
        var self = this;
        var data_type_arr = {CR : 'CR', DR : 'DR'};
        var _checker_arr = {};

        
        for (var data_type in data_type_arr) {   
            _checker_arr[data_type] = {};

            for (var currency_id in json_data['currencies']) {
                _checker_arr[data_type][currency_id] = {};
                        
                var sub_total_amount = 0;
                var sub_total_amount_elm = $('[data-name=sub-total-amount][data-type='+data_type+'][data-currency-id='+currency_id+']');
                
                var input_form_group = $('.input-form-group[data-type='+data_type+']');
                var input_form_group_amount = input_form_group.find('input[name="amount[]"][data-currency-id='+currency_id+']');
                input_form_group_amount.each(function(){
                    var _value = $(this).autoNumeric('get');
                    _value = isNaN(parseFloat(_value)) ? 0 : parseFloat(_value); //handle is Nan
                    sub_total_amount +=  _value;//sub_total_amount = $(this).attr('data-crdr') == data_type ? sub_total_amount +  _value : sub_total_amount - _value;
                });

                sub_total_amount_elm.attr('data-value', sub_total_amount);
                sub_total_amount_elm.html(self.accounting_format(sub_total_amount, ''));

                _checker_arr[data_type][currency_id]['amount'] = typeof(_checker_arr[data_type][currency_id]['amount']) === "undefined" ? sub_total_amount : parseFloat(_checker_arr[data_type][currency_id]['amount']) + sub_total_amount;
            }
        }

        self.check_sub_total_amount(_checker_arr);
    },
    initialize_table : function(){
        var self = this;
        //initialize table create footer
        for (var key in json_data['currencies']) {
            $("#table-transaction-detail tfoot").append(''.concat('<tr>',
                '<th class="text-right" width="45%"><span data-currency-id="{1}" data-name="sub-total-amount" data-type="DR" data-value="0">0</span></th>',
                '<th class="text-center" width="5%;">{0}</th>',
                '<th class="text-center" width="5%;">{2}</th>',
                '<th class="text-left" width="45%"><span data-currency-id="{3}" data-name="sub-total-amount" data-type="CR" data-value="0">0</span></th>',
            '</tr>').format(json_data['currencies'][key]['currency_label'], key, json_data['currencies'][key]['currency_label'], key));
        }

        if(json_data['action'] == 'add'){
            //initialize row create input for cr & dr column
            self.add_row('cr', false);
            self.add_row('dr', false);
        }else if(json_data['action'] == 'edit'){
            //initialize rows db
            for(key in json_data['db']['detail']){
                self.add_row_for_edit(json_data['db']['detail'][key]);
            }
            self.recalculate_sub_total_amount();
        }
    },
    add_row_for_edit : function(jurnal_detail){
        var self = this;
        var coa_id = jurnal_detail['coa_id'];
        var currency_id = json_data['coas'][coa_id]['currency_id'];
        var currency_label = json_data['currencies'][currency_id]['currency_label'];
        var coa_crdr = jurnal_detail['crdr'];
        var amount = jurnal_detail['amount'];

        var row = ''.concat('<div class="row-transaction-detail clearfix">',
                    '<div class="form-group inline" for="coa[]">',
                        '<label class="sr-only" for="coa[]">Coa</label>',
                        '{0}',
                    '</div>',
                        '<div class="form-group inline" for="amount[]">',
                        '<label class="sr-only" for="amount[]">Amount</label>',
                        '{1}',
                    '</div>',
                    '{2}',
                '</div>').format(json_data['dropdown_coa'], json_data['enabled_amount_with_value'].format(currency_label, currency_id, coa_crdr, amount), '<a class="btn btn-danger pull-right" href="javascript:;" role="button" data-name="remove-row"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>');

        if(jurnal_detail['crdr'].match(/^cr$/i)){
            var input_form_group_cr = $("#input-form-group-cr");
            input_form_group_cr.append(row);
            input_form_group_cr.find('.row-transaction-detail:last [name="coa_id[]"] option[value='+coa_id+']').attr("selected","selected");
        }else{
            var input_form_group_dr = $("#input-form-group-dr");
            input_form_group_dr.append(row);
            input_form_group_dr.find('.row-transaction-detail:last [name="coa_id[]"] option[value='+coa_id+']').attr("selected","selected");
        }

        $("[name='amount[]']").autoNumeric('init'); 
    },
    add_row : function(type, removable){
        var removable = typeof(removable) !== "undefined" ? removable : true;
        //var input_disable_enable = typeof(input_disable_enable) !== "undefined" ? input_disable_enable : 'disable';
        var self = this;
        if(type.match(/^cr$/i)){
            var input_form_group_cr = $("#input-form-group-cr");
            input_form_group_cr.append(self.generate_row(removable));
        }else{
            var input_form_group_dr = $("#input-form-group-dr");
            input_form_group_dr.append(self.generate_row(removable));
        }
        $("[name='amount[]']").autoNumeric('init'); 
    },
    generate_row : function(removable){
        var self = this;
        var removable = typeof(removable) !== "undefined" ? removable : true;
        //var input_disable_enable = typeof(input_disable_enable) !== "undefined" ? input_disable_enable : 'disable';
        return ''.concat('<div class="row-transaction-detail clearfix">',
                    '<div class="form-group inline" for="coa[]">',
                        '<label class="sr-only" for="coa[]">Coa</label>',
                        '{0}',
                    '</div>',
                        '<div class="form-group inline" for="amount[]">',
                        '<label class="sr-only" for="amount[]">Amount</label>',
                        '{1}',
                    '</div>',
                    '{2}',
                '</div>').format(json_data['dropdown_coa'], self.get_input_disable_amount(), removable == true ? '<a class="btn btn-danger pull-right" href="javascript:;" role="button" data-name="remove-row"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>' : '');
    },
    get_input_enable_amount : function(currency_id, currency_label, coa_crdr){
        return json_data['enabled_amount'].format(currency_label, currency_id, coa_crdr);
    },
    get_input_disable_amount : function(){
        return json_data['disabled_amount'];
    },
    submit_new_jurnal : function(){
        var self = this;
        var data = {
            'transaction_date' : $('#transaction_date').val(),
            'ref_number' : $('#ref_number').val(),
            'remarks' : $('#remarks').val(),
            'detail' : {}
        };

        var data_type_arr = {CR : 'CR', DR : 'DR'};
        //for (var data_type in data_type_arr) {   
            
            $("[name='coa_id[]']").each(function(){
                var input_form_group = $(this).parents(".input-form-group");
                var data_type = input_form_group.attr('data-type');
                var row_transaction_detail = $(this).parents(".row-transaction-detail");
                var coa_id = $(this).val();
                var amount = row_transaction_detail.find("[name='amount[]']").autoNumeric('get');
                var currency_id = json_data['coas'][coa_id]['currency_id'];
                if(!isNaN(parseFloat(amount))){
                    data['detail'][data_type] = typeof(data['detail'][data_type]) === "undefined" ? {} : data['detail'][data_type];
                    if(typeof(data['detail'][data_type][coa_id]) === "undefined"){
                        data['detail'][data_type][coa_id] = {};
                        data['detail'][data_type][coa_id]['currency_rate'] = json_data['currencies'][currency_id]['currency_rate'];
                    }
                    data['detail'][data_type][coa_id] = typeof(data['detail'][data_type][coa_id]) === "undefined" ? {} : data['detail'][data_type][coa_id];
                    data['detail'][data_type][coa_id]['amounts'] = typeof(data['detail'][data_type][coa_id]['amounts']) === "undefined" ? {} : data['detail'][data_type][coa_id]['amounts'];
                    data['detail'][data_type][coa_id]['amounts'][parseFloat(amount)] = typeof(data['detail'][data_type][coa_id]['amounts'][parseFloat(amount)]) === "undefined" ? 1 : parseInt(data['detail'][data_type][coa_id]['amounts'][parseFloat(amount)]) + 1;
                }
            });
        //}

        $.ajax({
            url: class_url + 'add',
            type: 'post',
            data: data,
            dataType: 'json',
            async: true,
            beforeSend: function() {
                $("#submit-new-jurnal").button('loading');
            },
            error: function(request) {
                $("#submit-new-jurnal").button('reset');
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line
                
                $("#submit-new-jurnal").button('reset');
                if (json.status.match(/^success$/i)) {
                    self.onsuccess_submit_new_journal(json);
                } else {
                    self.growl_msg(json.status, 'Error', json.msg);
                    //self.alert_msg({type: json.status, dom_container: $("#submit-new-jurnal").parent(".widget-content"), msg: json.msg, fill_type: 'prepend'});
                }
            }
        });
    },
    onsuccess_submit_new_journal : function(json){
        var self = this;
        self.growl_msg(json.status, 'Success', json.msg);
        $('#input-form-group-dr').html('');
        $('#input-form-group-cr').html('');
        $('#table-transaction-detail tfoot').html('');
        $('#ref_number').val('');
        $('#remarks').val('');
        $('#transaction_date').datepicker('setDate', new Date());
        $('#submit-new-jurnal').attr('disabled', 'disabled');
        self.initialize_table();
    },
    save_header_jurnal : function(){
        var self = this;
        var data = {
            'transaction_id' : $('#transaction_id').val(),
            'transaction_date' : $('#transaction_date').val(),
            'ref_number' : $('#ref_number').val(),
            'remarks' : $('#remarks').val(),
            'transaction_status' : $('#transaction_status').val()
        };

        $.ajax({
            url: class_url + 'save_header_jurnal',
            type: 'post',
            data: data,
            dataType: 'json',
            async: true,
            beforeSend: function() {
                $("#save-header-jurnal").button('loading');
            },
            error: function(request) {
                $("#save-header-jurnal").button('reset');
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line

                $("#save-header-jurnal").button('reset');
                self.growl_msg(json.status, json.status, json.msg);
                if(json.status == 'success'){
                    $('[data-placed=ref_number]').html(data.ref_number);
                }
            }
        });
    },
    save_detail_jurnal : function(){
        var self = this;
        var data = {
            'transaction_id' : $('#transaction_id').val(),
            'detail' : {}
        };

        var data_type_arr = {CR : 'CR', DR : 'DR'};
        //for (var data_type in data_type_arr) {   
        $("[name='coa_id[]']").each(function(){
            var input_form_group = $(this).parents(".input-form-group");
            var data_type = input_form_group.attr('data-type');
            var row_transaction_detail = $(this).parents(".row-transaction-detail");
            var coa_id = $(this).val();
            var amount = row_transaction_detail.find("[name='amount[]']").autoNumeric('get');
            var currency_id = json_data['coas'][coa_id]['currency_id'];
            if(!isNaN(parseFloat(amount))){
                data['detail'][data_type] = typeof(data['detail'][data_type]) === "undefined" ? {} : data['detail'][data_type];
                if(typeof(data['detail'][data_type][coa_id]) === "undefined"){
                    data['detail'][data_type][coa_id] = {};
                    data['detail'][data_type][coa_id]['currency_rate'] = json_data['currencies'][currency_id]['currency_rate'];
                }
                data['detail'][data_type][coa_id] = typeof(data['detail'][data_type][coa_id]) === "undefined" ? {} : data['detail'][data_type][coa_id];
                data['detail'][data_type][coa_id]['amounts'] = typeof(data['detail'][data_type][coa_id]['amounts']) === "undefined" ? {} : data['detail'][data_type][coa_id]['amounts'];
                data['detail'][data_type][coa_id]['amounts'][parseFloat(amount)] = typeof(data['detail'][data_type][coa_id]['amounts'][parseFloat(amount)]) === "undefined" ? 1 : parseInt(data['detail'][data_type][coa_id]['amounts'][parseFloat(amount)]) + 1;
            }
        });
        //}

        $.ajax({
            url: class_url + 'save_detail_jurnal',
            type: 'post',
            data: data,
            dataType: 'json',
            async: true,
            beforeSend: function() {
                $("#save-detail-jurnal").button('loading');
            },
            error: function(request) {
                $("#save-detail-jurnal").button('reset');
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line
                
                $("#save-detail-jurnal").button('reset');
                if (json.status.match(/^success$/i)) {
                    self.onsuccess_submit_new_journal(json);
                } else {
                    self.growl_msg(json.status, 'Error', json.msg);
                    //self.alert_msg({type: json.status, dom_container: $("#submit-new-jurnal").parent(".widget-content"), msg: json.msg, fill_type: 'prepend'});
                }
            }
        });
    }
};

jurnal_entry = $.extend(site, jurnal_entry);

$(function() {
    site.jurnal_entry();
});