<script type="text/javascript">
    var base_url = <?php echo json_encode(base_url()); ?>;
    var template_url = <?php echo json_encode($template_url); ?>;
    var class_name = <?php echo json_encode($class_name); ?>;
    var class_url = <?php echo json_encode($class_url); ?>;
    var current_url = <?php echo json_encode(current_url() . "/"); ?>;

    var _general_assets = <?php echo json_encode($_general_assets); ?>;
    var _general_assets_css = <?php echo json_encode($_general_assets_css); ?>;
    var _general_assets_js = <?php echo json_encode($_general_assets_js); ?>;

    var _assets = <?php echo json_encode($_assets); ?>;
    var _assets_css = <?php echo json_encode($_assets_css); ?>;
    var _assets_js = <?php echo json_encode($_assets_js); ?>;
    
    var enable_crud = <?php echo json_encode(isset($enable_crud) && $enable_crud == TRUE ? TRUE : FALSE); ?>;
    var enable_datatable = <?php echo json_encode(isset($enable_datatable) && $enable_datatable == TRUE ? TRUE : FALSE); ?>;

    var GET, query_string;
</script>