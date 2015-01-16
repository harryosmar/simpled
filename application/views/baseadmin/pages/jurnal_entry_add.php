<script type="text/javascript">
	var json_data = <?php echo json_encode($json_data); ?>;
</script>

<div class="col-md-12">
	<?php $this->view->load("breadcrumb"); ?>
</div>

<form id="form-jurnal-entry"> 
	<div class="col-md-12"> 
		<div class="widget stacked ">
			<div class="widget-header">
				<h3>Header</h3>
	        </div>
			<div class="widget-content">
				<div class="col-md-7">
					<div class="form-group clearfix">
					    <label for="transaction_date" class="col-sm-2 control-label">Date</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control datepicker-inline" id="transaction_date" placeholder="Jurnal Date" value="<?php echo date("Y-m-d"); ?>">
					    </div>
				  	</div>
					<div class="form-group clearfix">
					    <label for="ref_number" class="col-sm-2 control-label">Ref Number</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="ref_number" placeholder="Ref Number">
					    </div>
					</div>
					<div class="form-group clearfix">
					    <label for="remarks" class="col-sm-2 control-label">Remarks</label>
					    <div class="col-sm-10">
					      	<textarea class="form-control" id="remarks" placeholder="Remarks"></textarea>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-12"> 
		<div class="widget stacked ">
			<div class="widget-header">
				<h3>Detail</h3>
	        </div>
			<div class="widget-content">

					<div class="transaction-detail">
						<table class="table table-condensed table-bordered" id="table-transaction-detail">
							<thead>
								<tr>
									<th class="text-center" colspan="2"><h4>DR</h4> <a class="btn btn-primary pull-right" href="javascript:;" role="button" data-name="add-row-dr">Add</a></th>
									<th class="text-center" colspan="2"><h4>CR</h4> <a class="btn btn-primary pull-right" href="javascript:;" role="button" data-name="add-row-cr">Add</a></th>
								</tr>
							</thead>
							<tbody>
								<tr>	
									<td id="input-form-group-dr" class="input-form-group" data-type="DR" colspan="2"></td>
									<td id="input-form-group-cr" class="input-form-group" data-type="CR" colspan="2"></td>
								</tr>
							</tbody>
							<tfoot>
							</tfoot>
						</table>
					</div>

			</div>
		</div>
	</div>

	<div class="col-md-12"> 
		<div class="widget stacked ">
			<div class="widget-header">
				<h3>Please Check, Before Submit Any Data</h3>
	        </div>
			<div class="widget-content">

				<button class="btn btn-lg btn-block btn-submit btn-success" disabled="disabled" data-loading-text="Loading..." id="submit-new-jurnal">Submit</button>

			</div>
		</div>
	</div>

</form>