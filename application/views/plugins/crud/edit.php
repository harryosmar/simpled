<form action="#" name="crud-form" id="crud-form" class="form-horizontal col-md-7" role="form"><fieldset>
    <fieldset>
        <?php foreach ($columns as $index_field => $field): ?>
            <?php if ($field['db'] == $primary_key): ?>
                <?php echo $field['form']; ?>
            <?php else: ?>
                <div class="form-group" for="<?php echo $field['db']; ?>">
                    <label for="<?php echo $field['db']; ?>" class="col-sm-2 control-label"><?php echo $field['label']; ?></label>
                    <div class="col-sm-10 controls">
                        <?php echo $field['form']; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="submit"><!--fix bug in firefox-->
                <button name="submit" type="submit" data-loading-text="Loading..." class="btn btn-success" data-action="edit">Save changes</button>
    <!--            <button type="button" class="btn default">Cancel</button>-->
            </div>
        </div>
    </fieldset>
</form>

<?php
//echo '<pre>';
//print_r($row);
//print_r($columns);
//echo '</pre>';
?>