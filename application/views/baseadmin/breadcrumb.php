<?php if (!empty($breadcrumb)): ?>
    <ul class="page-breadcrumb breadcrumb">
        <?php $menu_name = ucwords(preg_replace("/_/", "", $breadcrumb->menu_name)); ?>
        <?php
        $segment_arr = $this->uri->segment_array();
        $count_segment = count($segment_arr);
        ?>
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo $template_url; ?>">Home</a> <i class="fa fa-angle-right"></i> 
        </li>
        <?php echo $breadcrumb_parent; ?>
        <?php foreach ($segment_arr as $key => $val): ?>
            <?php if ($key > 1): ?>
                <li>
                    <?php if ($key == 2): ?>
                        <a href="<?php echo "{$template_url}{$breadcrumb->menu_segment}"; ?>"><?php echo $menu_name; ?></a>
                    <?php else: ?>
                        <a href="javascript:;" style="color:#333;"><?php echo ucwords(preg_replace("/_/", "", $val)); ?></a>
                    <?php endif; ?>
                    <?php echo $count_segment > $key ? ' <i class="fa fa-angle-right"></i> ' : '' ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <!-- END PAGE TITLE & BREADCRUMB--> 
<?php endif; ?>
<?php //echo '<pre>'; print_r($segment_arr); ?>