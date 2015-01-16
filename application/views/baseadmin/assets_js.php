<!-- Load Js for current page -->
<?php if (isset($page_js)): ?>
    <?php if (is_array($page_js)): ?>
        <?php foreach ($page_js as $js): ?>
            <script src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php else: ?>
        <script src="<?php echo $js; ?>"></script>
    <?php endif; ?>
<?php endif; ?>