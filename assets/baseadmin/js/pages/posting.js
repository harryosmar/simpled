var posting = {
    posting: function() {
        /*START INIT PARENT JS*/
        var self = this;
        self.init();
        /*END INIT PARENT JS*/


        $( "#from" ).datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1,
          dateFormat : 'yy-mm-dd',
          onClose: function( selectedDate ) {
            $( "#to" ).datepicker( "option", "minDate", selectedDate );
          }
        });

        $( "#to" ).datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1,
          dateFormat : 'yy-mm-dd',
          onClose: function( selectedDate ) {
            $( "#from" ).datepicker( "option", "maxDate", selectedDate );
          }
        });

        /*$(document).on('change', '[name=coa_id]', function(e){
            self.get_list_jurnal();
        });*/

        $(document).on('change', '#from', function(e){
            self.get_list_jurnal();
        });

        $(document).on('change', '#to', function(e){
            self.get_list_jurnal();
        });

        $(document).on('click', '[data-name=action]', function(e){
            $('[data-name=btn-default-label]').html($(this).html());
            $('input[name=action]').val($(this).attr('data-value'));
            self.get_list_jurnal();
        });

        $(document).on('change', '#check-uncheck-all', function(e){
            $('[name=item-checkbox]').prop('checked', $(this).is(":checked"));
            self.enabled_proceed_all();
        });

        $(document).on('change', '[name=item-checkbox]', function(e){
            $('#check-uncheck-all').prop('checked', $('[name=item-checkbox]:checked').length == $('[name=item-checkbox]').length);
            self.enabled_proceed_all();
        });

        //Single proceed item
        $(document).on('click', '[data-name=proceed-item]', function(e){
            e.preventDefault();
            self.posting_item_process($(this));
        });

        //Multiple proceed item
        $(document).on('click', '#proceed-all', function(e){
            e.preventDefault();
            self.posting_selected_item_process($(this));
        });
    },
    enabled_proceed_all : function(){
        if($('[name=item-checkbox]:checked').length > 0){
            $('#proceed-all').removeAttr('disabled');
        }else{
            $('#proceed-all').attr('disabled', 'disabled');
        }
    },
    get_list_jurnal: function() {
        var self = this;

        data = {
            'from' : $('#from').val(),
            'to' : $('#to').val(),
            //'coa_id' : $('[name=coa_id]').val(),
            'action' : $('input[name=action]').val()
        };

        if(data.from == '' && data.to == ''){
            self.growl_msg('error', 'Error', 'Tolong Pilih "Date From" - "Date To"');
            return false;
        }

        var self = this;
        $.ajax({
            url: class_url + 'get_list_jurnal',
            type: 'post',
            data: data,
            dataType: 'json',
            async: true,
            beforeSend: function() {
                $('#loading-filter').show();
            },
            error: function(request) {
                $('#loading-filter').hide();
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line
                $('#loading-filter').hide();
                if (json.status.match(/^success$/i)) {
                    $('#data-result').html(json.data);
                }else{
                    self.growl_msg(json.status, 'Error', json.msg);
                }
            }
        });
    },
    posting_item_process: function(elm) {
        var self = this;
        $.ajax({
            url: class_url + 'posting_item_process',
            type: 'post',
            data: {
                transaction_id : elm.attr('data-transaction-id'),
                action : elm.attr('data-action')
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                elm.button('loading');
            },
            error: function(request) {
                elm.button('reset');
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line
                elm.button('reset');
                if (json.status.match(/^success$/i)) {
                    elm.prepend('<span class="glyphicon glyphicon-ok-sign text-success" aria-hidden="true"></span>');
                    self.growl_msg(json.status, 'success', json.msg);
                    self.get_list_jurnal(); //reload list jurnal
                }else{
                    self.growl_msg(json.status, 'Error', json.msg);
                }
            }
        });
    },
    posting_selected_item_process : function(elm){
        var self = this;
        transactions_id = new Array();
        $('[name=item-checkbox]:checked').each(function(){
            transactions_id.push($(this).attr('data-transaction-id'));
        });

        $.ajax({
            url: class_url + 'posting_selected_item_process',
            type: 'post',
            data: {
                transactions_id : transactions_id,
                action : elm.attr('data-action')
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                $('#data-result tr').removeClass('danger');
                elm.button('loading');
            },
            error: function(request) {
                elm.button('reset');
                console.log(request.responseText);
            },
            success: function(json) {
                self.on_finish_ajax(json); //always call this on the first line
                elm.button('reset');
                if (json.status.match(/^success$/i)) {
                    elm.prepend('<span class="glyphicon glyphicon-ok-sign text-success" aria-hidden="true"></span>');
                    self.growl_msg(json.status, 'success', json.msg);
                    self.get_list_jurnal(); //reload list jurnal
                }else{
                    $('[name=item-checkbox][data-transaction-id='+json.msg+']').parents('tr').addClass('danger');
                    self.growl_msg(json.status, 'Error', 'Found Invalid Transaction');
                }
            }
        });
    }
};

posting = $.extend(site, posting);

$(function() {
    site.posting();
});