<div class="row-fluid clearfix table-scrollable no-border">
    <table class="table table-condensed table-striped">
        <thead>
            <tr>
                <th>Menu</th>
                <th>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="all" name="checkuncheck-all" id="checkuncheck-all">&nbsp;<strong>Access Privilege</strong>
            </label>
        </div>
        </th>
        <th colspan="3" class="text-right"><button class="btn btn-primary" data-name="update-privilege-all">UPDATE ALL</button></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row): ?>
                <tr>
                    <td><ul class="list-unstyled list-inline"><?php echo $this->Menu_model->get_breadcrumb_parent($row->menu_segment); ?><li><a href="<?php echo "{$template_url}{$row->menu_segment}"; ?>"><?php echo $row->menu_name; ?></a></li></ul></td>
                    <td>
                        <?php $arr_action = explode(',', $row->menu_action); ?>
                        <div class="checkbox">
                            <?php foreach ($arr_action as $action): ?>
                                <label>
                                    <input name="checkbox-per-menu" type="checkbox" value="<?php echo $action; ?>" data-menu-id="<?php echo $row->menu_id; ?>" <?php echo preg_match("/({$action},|{$action}$)/i", $row->privilege_action) ? 'checked="checked"' : ''; ?>>&nbsp;<?php echo $action; ?>&nbsp;&nbsp;
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </td>
                    <td class="text-right"><button  data-loading-text="Loading..." class="btn btn-sm" data-name="update-privilege-per-menu" data-menu-id="<?php echo $row->menu_id; ?>">UPDATE</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2"></th>
                <th class="text-right"><button class="btn btn-primary" data-name="update-privilege-all">UPDATE ALL</button></th>
            </tr>
        </tfoot>
    </table>
</div>
