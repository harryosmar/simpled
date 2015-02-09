<div class="filter-ledger clearfix">
	<input name="from" id="from" type="text" class="form-control datepicker" placeholder="Date From">
	<input name="to" id="to" type="text" class="form-control datepicker" placeholder="Date To">
	<input type="hidden" id="action" name="action" value="posting">
	<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span data-name="btn-default-label">Posting</span> <span class="caret"></span></button>
	        <ul class="dropdown-menu" role="menu">
				<li><a href="javascript:;" data-name="action" data-value="posting">Posting</a></li>
				<li><a href="javascript:;" data-name="action" data-value="unposting">Unposting</a></li>
	        </ul>
    </div>
    <img src="<?php echo $_assets; ?>img/loading-spinner-grey.gif" id="loading-filter">
</div>