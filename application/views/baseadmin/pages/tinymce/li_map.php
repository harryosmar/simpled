<li class="col-md-3 text-center <?php echo isset($new_upload_file) ? "new-upload-file" : ""; ?>" name="tinymce-media-img-li">
    <img class="img-responsive" src="<?php echo "{$upload_url}{$file}"; ?>">
    <label class="checkbox">
        <input type="checkbox" name="tinymce-media-dialog-checkbox-img" img_url="<?php echo "{$upload_url}{$file}"; ?>" filename="<?php echo $file; ?>"><a class="filename-text prevent-default" href="#" title="<?php echo $file; ?>"><?php echo $file; ?></a>
    </label>
</li>
