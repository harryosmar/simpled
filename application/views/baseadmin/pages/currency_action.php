<div class="btn-group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        Action
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <?php if (preg_match("/(edit,|edit$)/i", $privilege_action)): ?>
            <li><a href="<?php echo "{$class_url}edit/{$row->$primary_key}"; ?>">Edit</a></li>
        <?php endif; ?>
        <?php if (preg_match("/(delete,|delete$)/i", $privilege_action)): ?>
            <li><a href="javascript:;" data-name="confirmDelete" data-href="<?php echo "{$class_url}delete/{$row->$primary_key}"; ?>">Delete</a></li>
            <!--<li><a href="<?php //echo "{$class_url}remove/{$row->$primary_key}"; ?>" onClick="return confirm('Are you sure, want to delete this record ?');">Remove</a></li>-->
        <?php endif; ?>
    </ul>
</div>
<?php //echo '<pre>'; print_r($row); echo '</pre>'; ?>