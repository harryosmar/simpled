var tinymce_upload = {
    modal_id: "#tinymce-media-dialog",
    init: function() {
        var self = this;

        $('#tinymce_form_upload input[name="tinymce_image"]').bind("change", function() {
            $('#tinymce_form_upload').trigger("submit");
            $(this).val("");
        });

        $("form#tinymce_form_upload").submit(function(e) {
            e.preventDefault();
            //var formData = new FormData($(this)[0]);
            $counter = 0;
            var data = new FormData();
            jQuery.each($('#tinymce_image')[0].files, function(i, file) {
                $counter++;
                data.append('tinymce_image' + (i + 1), file);
            });
            data.append('counter', $counter);
            self.upload_process(data);
        });

        $('body').on('click', '#tinymce-media-dialog-tab a', function(e) {
            e.preventDefault();
            $(this).tab('show');
        });


        //CHECK UNCHECK ALL IMAGES
//        $('body').on('click', "#check-uncheck-all-tinymce-media-img", function(e) {
//            e.preventDefault();
//            if ($(this).attr('is_checked').match(/^no$/i)) {
//                $("input[type=checkbox][name=tinymce-media-dialog-checkbox-img]").prop("checked", true);
//                $(this).attr('is_checked', 'yes');
//                $(this).find('a').html('uncheck all');
//            } else {
//                $("input[type=checkbox][name=tinymce-media-dialog-checkbox-img]").prop("checked", false);
//                $(this).attr('is_checked', 'no');
//                $(this).find('a').html('<i class="icon-check"></i>&nbsp;check all');
//            }
//        });

        //CHECK ALL IMAGES
        $('body').on('click', "#check-all-tinymce-media-img", function(e) {
            e.preventDefault();
            $("input[type=checkbox][name=tinymce-media-dialog-checkbox-img]").prop("checked", true);
        });

        //UNCHECK ALL IMAGES
        $('body').on('click', "#uncheck-all-tinymce-media-img", function(e) {
            e.preventDefault();
            $("input[type=checkbox][name=tinymce-media-dialog-checkbox-img]").prop("checked", false);
        });

        //DELETE SELECTED IMAGES
        $('body').on('click', "#delete-selected-tinymce-media-img", function(e) {
            e.preventDefault();
            if ($("input[type=checkbox][name=tinymce-media-dialog-checkbox-img]:checkbox:checked").length == 0) {
                alert("no image selected");
                return false;
            } else {
                //delete image selected
                self.delete_process();
            }
        });

        //INSERT SELECTED IMAGES
        $('body').on('click', "#insert-selected-tinymce-media-img", function(e) {
            e.preventDefault();
            if ($("input[type=checkbox][name=tinymce-media-dialog-checkbox-img]:checkbox:checked").length == 0) {
                alert("no image selected");
                return false;
            } else {
                //insert image selected
                $("input[type=checkbox][name=tinymce-media-dialog-checkbox-img]:checked").each(function() {
                    tinymce.activeEditor.execCommand('insertHTML', false, '<img class="img-responsive" src="' + $(this).attr('img_url') + '" alt="' + $(this).attr('filename') + '">');
                });
            }
        });

        //SEARCH IMAGES
        $('body').on('keyup', "#search-by-filename", function(e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                $keyword = $(this).val();
                var regex = new RegExp($keyword, 'i');
                $(".filename-text").each(function() {
                    $title = $(this).attr('title');
                    $li = $(this).parents('li[name=tinymce-media-img-li]');
                    if ($title.match(regex)) {
                        $li.show();
                    } else {
                        $li.hide();
                    }
                });
            }
        });

        self.read_uploads_dir();

    },
    read_uploads_dir: function() {
        $.ajax({
            url: template_url + "tinymce_media_dialog/read_uploads_dir",
            type: 'post',
            dataType: 'json',
            async: true,
            error: function(request) {
                console.log(request.responseText);
            },
            success: function(json) {
                $(tinymce_upload.modal_id).find(".modal-body").html(json.map_view);
            }
        });
    },
    upload_process: function(formData) {
        $.ajax({
            url: template_url + "tinymce_media_dialog/tinymce_upload_process",
            type: 'post',
            data: formData,
            dataType: 'json',
            async: true,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            beforeSend: function() {
                $(".loading_tinymce_upload").show();
            },
            error: function(request) {
                $(".loading_tinymce_upload").hide();
                console.log(request.responseText);
            },
            success: function(json) {
                $(".loading_tinymce_upload").hide();
                if (json.status.match(/^success$/i)) {
                    //top.$('.mce-btn.mce-open').parent().find('.mce-textbox').val('%s').closest('.mce-window').find('.mce-primary').click();
                    //tinymce.activeEditor.execCommand('insertHTML', false, '<img src="'+json.upload_data.url+'">');
                    $("#tinymce-media-img-ul").prepend(json.li_img);
                } else {
                    alert(json.msg);
                }
            }
        });
    },
    delete_process: function() {
        var img = [];
        $("input[type=checkbox][name=tinymce-media-dialog-checkbox-img]:checked").each(function() {
            img.push($(this).attr("filename"));
        });

        $.ajax({
            url: template_url + "tinymce_media_dialog/tinymce_delete_process",
            type: 'post',
            data: {
                'img': img
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                $(".loading_tinymce_upload").show();
            },
            error: function(request) {
                $(".loading_tinymce_upload").hide();
                console.log(request.responseText);
            },
            success: function(json) {
                $(".loading_tinymce_upload").hide();
                if (json.status.match(/^success$/i)) {
                    $("input[type=checkbox][name=tinymce-media-dialog-checkbox-img]:checked").each(function() {
                        $(this).parents("li").remove();
                    });
                } else {
                    alert(json.msg);
                }
            }
        });

    }

};

$(function() {
    mytinymce.options.file_browser_callback = function(field_name, url, type, win) {
        console.log(field_name + ',' + type + ',' + url + ',' + win);
        if (type === 'image') {
            $(tinymce_upload.modal_id).modal("show");
            $(".mce-close").trigger('click');
        }
    };
    tinymce_upload.init();
    //$(tinymce_upload.modal_id).modal("show");
});



