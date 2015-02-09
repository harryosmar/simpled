<?php if(!empty($ledgers)): ?>
	<div class="table-responsive">
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th colspan="6" class="clearfix">
						COA Number : <?php echo "$coa->coa_number"; ?><br/>
						Description : <?php echo $coa->description; ?><br/>
						COA Type : <?php echo $coa->crdr; ?><br/>
						CCY : <?php echo $coa->currency_label; ?>
					</th>
				</tr>
				<tr>
					<th>No</th>
					<th>Transaction Date</th>
					<th>Description</th>
					<th>DR</th>
					<th>CR</th>
					<th>Balance (<?php echo $coa->currency_label; ?>)</th>
				</tr>
			</thead>
			<tbody>
				<?php $balance = $coa->balance; ?>
				<tr class="warning">
					<td>1</td>
					<td colspan="4" class="text-center"><strong>OPENING BALANCE</strong></td>
					<td><?php echo format_number($balance); ?></td>
				</tr>
				<?php foreach($ledgers as $key=>$ledger): ?>
					<?php $balance = $coa->crdr == $ledger->crdr ? $balance + $ledger->amount : $balance - $ledger->amount; ?>
					<tr>
						<td><?php echo $key+2; ?></td>
						<td><?php echo format_date($ledger->transaction_date); ?></td>
						<td><a href="<?php echo "{$template_url}jurnal_entry/view/{$ledger->transaction_id}"; ?>" target="_blank"><?php echo $ledger->ref_number; ?></a><br/><?php echo $ledger->remarks; ?></td>
						<td><?php echo $ledger->crdr == 'DR' ? format_number($ledger->amount) : ''; ?></td>
						<td><?php echo $ledger->crdr == 'CR' ? format_number($ledger->amount) : ''; ?></td>
						<td class="<?php echo $coa->crdr == $ledger->crdr ? 'success' : 'danger'; ?>"><?php echo format_number($balance); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php else: ?>
	<div class="table-responsive">
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th colspan="6" class="clearfix">
						COA Number : <?php echo "$coa->coa_number"; ?><br/>
						Description : <?php echo $coa->description; ?><br/>
						COA Type : <?php echo $coa->crdr; ?><br/>
						CCY : <?php echo $coa->currency_label; ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-danger text-center">
						Empty Result for <strong><?php echo "{$coa->coa_number}-{$coa->description}-{$coa->crdr}"; ?></strong>.
					</td>
				</tr>
			</tbody>
		</table>
	</div>
<?php endif; ?>
				
			
