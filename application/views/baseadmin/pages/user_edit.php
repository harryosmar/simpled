<div class="col-md-12"> 
	<div class="widget stacked ">
		<div class="widget-header">
			<?php $this->view->load("widget_header"); ?>
        </div>
		<div class="widget-content">
			<?php $this->view->load("breadcrumb"); ?>
			<div class="tabbable tabbable-custom boxless tabbable-reversed">
			    <ul class="nav nav-tabs">
			        <li class="active">
			            <a href="#tab_0" data-toggle="tab">
			                Edit Data
			            </a>
			        </li>
			        <li>
			            <a href="#tab_1" data-toggle="tab">
			                Reset Password 
			            </a>
			        </li>
			    </ul>
			    <div class="tab-content">
			        <div class="tab-pane active" id="tab_0">
			            <form action="#" name="crud-form" id="crud-form" class="form-horizontal" role="form">
			                <?php echo $columns[0]['form']; ?>                             
			                <div class="form-group" for="user_group_id">
			                    <label for="user_group_id" class="col-sm-2 control-label">User Group</label>
			                    <div class="col-sm-10 controls">
			                        <?php echo $columns[1]['form']; ?>               
			                    </div>
			                </div>
			                <div class="form-group" for="user_email">
			                    <label for="user_email" class="col-sm-2 control-label">Email</label>
			                    <div class="col-sm-10 controls">
			                        <?php echo $columns[2]['form']; ?>                 
			                    </div>
			                </div>
			                <div class="form-group" for="user_fullname">
			                    <label for="user_fullname" class="col-sm-2 control-label">Fullname</label>
			                    <div class="col-sm-10 controls">
			                        <?php echo $columns[4]['form']; ?>                 
			                    </div>
			                </div>
			                <div class="form-group" for="user_active">
			                    <label for="user_active" class="col-sm-2 control-label">User Active</label>
			                    <div class="col-sm-10 controls">
			                        <?php echo $columns[5]['form']; ?>                
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-sm-offset-2 col-sm-10">
			                        <input type="hidden" name="submit"><!--fix bug in firefox-->
			                        <button name="submit" type="submit" data-loading-text="Loading..." class="btn btn-success" data-action="edit">Save changes</button>
			                        <!--            <button type="button" class="btn default">Cancel</button>-->
			                    </div>
			                </div>
			            </form>
			        </div>
			        <div class="tab-pane" id="tab_1">
			            <form action="#" name="reset-password-form" id="reset-password-form" class="form-horizontal" role="form">
			                <?php echo $columns[0]['form']; ?>     
			                <div class="form-group" for="admin_password">
			                    <label for="admin_password" class="col-sm-2 control-label">Admin Password</label>
			                    <div class="col-sm-10 controls">
			                        <input type="password" name="admin_password" value="" id="admin_password" class="form-control" placeholder="Admin Password">            
			                    </div>
			                </div>
			                <div class="form-group" for="new_password">
			                    <label for="new_password" class="col-sm-2 control-label">New Password</label>
			                    <div class="col-sm-10 controls">
			                        <input type="password" name="new_password" value="" id="new_password" class="form-control" placeholder="New Password">            
			                    </div>
			                </div>
			                <div class="form-group" for="new_password_confirmation">
			                    <label for="new_password_confirmation" class="col-sm-2 control-label">New Password Confirmation</label>
			                    <div class="col-sm-10 controls">
			                        <input type="password" name="new_password_confirmation" value="" id="new_password_confirmation" class="form-control" placeholder="New Password Confirmation">
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-sm-offset-2 col-sm-10">
			                        <button name="submit" type="submit" data-loading-text="Loading..." class="btn btn-success" data-action="reset_password">Reset Password</button>
			                        <!--            <button type="button" class="btn default">Cancel</button>-->
			                    </div>
			                </div>
			            </form>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>

<?php
//echo '<pre>';
//print_r($row);
//print_r($columns);
//echo '</pre>';
?>
