<div class="col-md-12"> 
	<div class="widget stacked ">
		<div class="widget-header">
			<?php $this->view->load("widget_header"); ?>
        </div>
		<div class="widget-content">
			<?php $this->view->load("breadcrumb"); ?>
			<?php $this->view->load_path_reset("plugins/datatables/table"); ?>
			<?php $this->view->load("pages/menu/icon_panel"); ?>
		</div>
	</div>
</div>
