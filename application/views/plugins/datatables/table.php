<?php echo $this->session->flashdata("msg") ? $this->session->flashdata("msg") : ""; ?>
<script type="text/javascript">
    var datatable_setting = <?php echo json_encode($datatable_setting); ?>;
    var class_bootsrap_component = <?php echo json_encode("success"); ?>;
</script>
<div class="row-fluid clearfix table-scrollable datatable-container no-border" id="datatable-container">
    <table id="datatable-cms" class="display" cellspacing="0" width="100%">
        <thead>
            <tr class="filter">
                <?php foreach ($datatable_setting['columnDefs'] as $column): ?>
                    <th><?php echo $column['label']; ?></th>
                <?php endforeach; ?>
                <?php if ($datatable_setting['visible_actions'] === TRUE): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
            <tr class="heading">
                <?php foreach ($datatable_setting['columnDefs'] as $column): ?>
                    <th><?php echo $column['label']; ?></th>
                <?php endforeach; ?>
                <?php if ($datatable_setting['visible_actions'] === TRUE): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
    </table>
</div>

<?php //echo "<pre>"; print_r($datatable_setting); ?>