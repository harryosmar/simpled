 <div class="clearfix col-md-12">
 	<i class="<?php echo $breadcrumb->menu_icon; ?>" style="margin-left:0px;"></i>
 	<h3 class="clearfix">
        <?php $menu_name = ucwords(preg_replace("/_/", "", $breadcrumb->menu_name)); ?>
        <?php echo $menu_name; ?>
        <small><?php echo $breadcrumb->menu_desc; ?></small>
    </h3>
    <?php if (preg_match("/(add,|add$)/i", $privilege_action) && $this->uri->segment(3) != 'add')://if (isset($enable_crud) && $enable_crud == true && preg_match("/(add,|add$)/i", $privilege_action)): ?>
        <a href="<?php echo "{$class_url}add"; ?>" class="pull-right btn btn-primary btn-action" style="margin-top:2px;"><span class="glyphicon glyphicon-plus"></span>&nbsp;New</a>
    <?php endif; ?>
</div>
<?php //echo '<pre>'; print_r($breadcrumb); ?>