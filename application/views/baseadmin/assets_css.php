<!-- Load Css for current page -->
<?php if (isset($page_css)): ?>
    <?php if (is_array($page_css)): ?>
        <?php foreach ($page_css as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo $pages_css; ?>">
    <?php endif; ?>
<?php endif; ?>