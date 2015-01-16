<div class="col-md-12"> 
    <div class="widget stacked ">
        <div class="widget-header">
            <?php $this->view->load("widget_header"); ?>
        </div>
        <div class="widget-content">
            <?php $this->view->load("breadcrumb"); ?>
            <form action="#" name="crud-form" id="crud-form" class="form-horizontal col-md-7" role="form">
                <fieldset>
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
                    <div class="form-group" for="user_password">
                        <label for="user_password" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 controls">
                            <?php echo $columns[3]['form']; ?>               
                        </div>
                    </div>
                    <div class="form-group" for="password_confirmation">
                        <label for="password_confirmation" class="col-sm-2 control-label">Password Confirmation</label>
                        <div class="col-sm-10 controls">
                            <input type="password" name="password_confirmation" value="" id="password_confirmation" class="form-control" placeholder="Password Confirmation">
                        </div>
                    </div>
                    <div class="form-group" for="user_fullname">
                        <label for="user_fullname" class="col-sm-2 control-label">Fullname</label>
                        <div class="col-sm-10 controls">
                            <?php echo $columns[4]['form']; ?> 
                        </div>
                    </div>
                    <div class="form-group" for="user_active">
                        <label for="user_active" class="col-sm-2 control-label">Active</label>
                        <div class="col-sm-10 controls">
                            <?php echo $columns[5]['form']; ?>                
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="hidden" name="submit"><!--fix bug in firefox-->
                            <button name="submit" type="submit" data-loading-text="Loading..." class="btn btn-success" data-action="add">Submit</button>
                            <!--            <button type="button" class="btn default">Cancel</button>-->
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>


<?php
//echo '<pre>';
//print_r($columns);
//echo '</pre>';
?>