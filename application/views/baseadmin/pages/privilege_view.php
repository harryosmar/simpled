<div class="col-md-12"> 
    <div class="widget stacked ">
        <div class="widget-header">
            <?php $this->view->load("widget_header"); ?>
        </div>
        <div class="widget-content">
            <?php $this->view->load("breadcrumb"); ?>
            <form action="#" name="crud-form" id="crud-form" class="form-horizontal" role="form">
                <div class="form-group" for="user_group_id">
                    <label for="user_group_id" class="col-sm-2 control-label">User Group</label>
                    <div class="col-sm-10 controls">
                        <select class="form-control" name="user_group_id" id="user_group_id">
                            <option value="0">Please Select</option>
                            <?php foreach ($user_groups as $user_group): ?>
                                <?php if (($session_user->user_group_type == 'DEVELOPER' && $user_group->user_group_type == $session_user->user_group_type) || $user_group->user_group_type != 'DEVELOPER'): ?>
                                    <option value="<?php echo $user_group->user_group_id; ?>"><?php echo $user_group->user_group_type; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>          
                    </div>
                </div>
            </form>
            <div id="privilege-result"></div>
        </div>
    </div>
</div>
