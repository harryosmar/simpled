<script type="text/javascript">
	var json_data = <?php echo json_encode($json_data); ?>;
</script>
<div class="col-md-12"> 
	<div class="widget stacked ">
		<div class="widget-header">
			<?php $this->view->load("widget_header"); ?>
        </div>
		<div class="widget-content">
			<?php $this->view->load("breadcrumb"); ?>
			<table class="table table-bordered table-condensed table-stripped">
				<thead>
					<tr>
						<th>Transaction Date</th>
						<th><?php echo format_date($json_data['db']['head']['transaction_date']); ?></th>
					</tr>
					<tr>
						<th>Ref Number</th>
						<th><?php echo $json_data['db']['head']['ref_number']; ?></th>
					</tr>
					<tr>
						<th>Remarks</th>
						<th><?php echo $json_data['db']['head']['remarks']; ?></th>
					</tr>
					<tr>
						<th>Input By</th>
						<th><?php echo $json_data['db']['head']['input_by']; ?></th>
					</tr>
					<tr>
						<th>Input Date</th>
						<th><?php echo format_date($json_data['db']['head']['input_date']); ?></th>
					</tr>
					<tr>
						<th>Status</th>
						<th><?php echo $json_data['db']['head']['transaction_status']; ?></th>
					</tr>
				</thead>
			</table>
			<div class="">

				<div class="col-md-6">
					<table class="table table-bordered table-condensed table-stripped">
						<thead>
							<tr><th colspan="4" class="text-center">DR</th></tr>
							<tr>
								<th>COA</th>
								<th>Amount</th>
								<th>Currency</th>
								<th>Currency Rate</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($json_data['db']['detail'] as $key => $jurnal_detail): ?>
								<?php if(preg_match("/^DR$/i", $jurnal_detail['crdr'])): ?>
									<tr>
										<td><?php echo "{$jurnal_detail['coa_number']} {$jurnal_detail['description']}"; ?></td>
										<td><?php echo format_number($jurnal_detail['amount']); ?></td>
										<td><?php echo $jurnal_detail['currency_label']; ?></td>
										<td><?php echo format_number($jurnal_detail['current_currency_rate']); ?></td>
									</tr>
							<?php endif; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<div class="col-md-6">
					<table class="table table-bordered table-condensed table-stripped">
						<thead>
							<tr><th colspan="4" class="text-center">CR</th></tr>
							<tr>
								<th>COA</th>
								<th>Amount</th>
								<th>Currency</th>
								<th>Currency Rate</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($json_data['db']['detail'] as $key => $jurnal_detail): ?>
								<?php if(preg_match("/^CR$/i", $jurnal_detail['crdr'])): ?>
									<tr>
										<td><?php echo "{$jurnal_detail['coa_number']} {$jurnal_detail['description']}"; ?></td>
										<td><?php echo format_number($jurnal_detail['amount']); ?></td>
										<td><?php echo $jurnal_detail['currency_label']; ?></td>
										<td><?php echo format_number($jurnal_detail['current_currency_rate']); ?></td>
									</tr>
							<?php endif; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</div>
