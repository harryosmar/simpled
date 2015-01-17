<div id="tinymce-media-dialog" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="clearfix row">
                    <div class="form-group clearfix form-group-header">
                        <label for="action" class="col-sm-2 control-label">
                            <div class="btn-group">
                                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li id="check-all-tinymce-media-img"><a href="#"><i class="icon-check"></i>&nbsp;check all</a></li>
                                    <li id="uncheck-all-tinymce-media-img"><a href="#">uncheck all</a></li>
                                    <li id="delete-selected-tinymce-media-img"><a href="#"><i class="icon-trash"></i>&nbsp;delete selected</a></li>
                                    <li id="insert-selected-tinymce-media-img"><a href="#"><i class="icon-share"></i>&nbsp;insert selected</a></li>
                                </ul>
                            </div>
                        </label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
                                <input class="form-control" id="search-by-filename" type="text" placeholder="Search by filename">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer form-actions fluid">
                <div class="col-md-12">
                    <form id="tinymce_form_upload" action="javascript:," method="post" enctype="multipart/form-data">
                        <input name="tinymce_image" class="form-control" id="tinymce_image" type="file" multiple>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->