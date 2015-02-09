<?php if(!empty($jurnals)): ?>
	<div class="table-responsive">
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th><input type="checkbox" name="check-uncheck-all" id="check-uncheck-all"></th>
					<th>No</th>
					<th>Transaction Date</th>
					<th>Ref Number</th>
					<th>Remarks</th>
					<th><button class="btn btn-primary btn-sm" data-name="proceed-all" id="proceed-all" data-loading-text="Loading..." data-action="<?php echo $action; ?>" disabled="disabled"><?php echo ucfirst($action); ?> Selected</button></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($jurnals as $key=>$jurnal): ?>
					<tr>
						<td><input type="checkbox" name="item-checkbox" data-transaction-id="<?php echo $jurnal->transaction_id; ?>"></td>
						<td><?php echo $key + 1; ?></td>
						<td><?php echo format_date($jurnal->transaction_date); ?></td>
						<td><?php echo $jurnal->ref_number; ?></td>
						<td><?php echo $jurnal->remarks; ?></td>
						<td><button class="btn btn-primary btn-sm" data-name="proceed-item" data-loading-text="Loading..." data-transaction-id="<?php echo $jurnal->transaction_id; ?>" data-action="<?php echo $action; ?>"><?php echo ucfirst($action); ?></button></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php else: ?>
	<div class="alert alert-danger text-center">Sorry, Empty Result. Please, Consider to change your filter setting.</div>
<?php endif; ?>