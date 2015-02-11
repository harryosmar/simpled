<div class="filter-ledger clearfix">
	<?php echo $dropdown_coa; ?>
	<input name="from" id="from" type="text" class="form-control datepicker" placeholder="Date From">
	<input name="to" id="to" type="text" class="form-control datepicker" placeholder="Date To">
    

    <div class="btn-group" role="group" style="display:none;" id="export-btn">
	    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	      Export
	      <span class="caret"></span>
	    </button>
	    <ul class="dropdown-menu" role="menu">
	      <li><a href="javascript:;" data-href="<?php echo "{$class_url}get_list_ledger/PDF"; ?>" target="_blank">PDF</a></li>
	      <!-- <li><a href="javascript:;">XLS</a></li> -->
	    </ul>
  </div>

  <img src="<?php echo $_assets; ?>img/loading-spinner-grey.gif" id="loading-filter">
</div>