<ul class="nav nav-tabs" id="tinymce-media-dialog-tab">
    <li class="active"><a href="#img"><i class="icon-picture"></i>&nbsp;Image</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active row" id="img">
        <div>
            <ul id="tinymce-media-img-ul">
                <?php foreach ($map as $file): ?>
                    <?php if ($file != "index.html"): ?>
                        <?php $this->view->load("pages/tinymce/li_map", array("upload_url" => $upload_url, "file" => $file)); ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</div>