var mytinymce = {
    tinyMCEObj : null,
    options : {
        //selector: "textarea",
        extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align]",
        mode : "exact",
        relative_urls : false,
        convert_urls : false,
        //elements : ".tinymce",
        plugins : [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace wordcount visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste textcolor",
        "preview"
        //"moxiemanager"
        ],
        //file_browser_callback : "ajaxfilemanager",
        toolbar: "insertfile undo redo | styleselect | sizeselect | bold italic | fontselect |  fontsizeselect | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | preview",
        content_css : base_url+"assets/plugins/tinymce/tinymce.css"
    },
    init : function(option){
        $.extend(this.options, option);
        tinymce.init(this.options);
    }
};


