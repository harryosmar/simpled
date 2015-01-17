<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>SimpLed</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    <link href="<?php echo base_url("base-admin-3.0/theme"); ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url("base-admin-3.0/theme"); ?>/css/bootstrap-responsive.min.css" rel="stylesheet">
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url("base-admin-3.0/theme"); ?>/css/font-awesome.min.css" rel="stylesheet">        
    
    <link href="<?php echo base_url("base-admin-3.0/theme"); ?>/css/ui-lightness/jquery-ui-1.10.0.custom.min.css" rel="stylesheet">
    
    <link href="<?php echo base_url("base-admin-3.0/theme"); ?>/css/base-admin-3.css" rel="stylesheet">
    <link href="<?php echo base_url("base-admin-3.0/theme"); ?>/css/base-admin-3-responsive.css" rel="stylesheet">
    
    <link href="<?php echo base_url("base-admin-3.0/theme"); ?>/css/pages/dashboard.css" rel="stylesheet">   

    <link href="<?php echo base_url("base-admin-3.0/theme"); ?>/css/custom.css" rel="stylesheet">

    <link href="<?php echo $_assets_css; ?>site.css" rel="stylesheet">
    <link href="<?php echo base_url("base-admin-3.0/theme"); ?>/js/plugins/msgGrowl/css/msgGrowl.css" rel="stylesheet">
    <link href="<?php echo base_url("base-admin-3.0/theme"); ?>/js/plugins/msgbox/jquery.msgbox.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php $this->view->load("assets_css"); ?> 
    <?php $this->view->load("global_js_var"); ?> 
  </head>
<body>

    <?php $this->view->load("navbar"); ?>   
    <?php $this->view->load("subnavbar"); ?>   
        
    <div class="main">

        <div class="container">

          <div class="row">
            <?php $this->view->load($_pages); ?>
          </div> <!-- /row -->

        </div> <!-- /container -->
        
    </div> <!-- /main -->

    <?php $this->view->load("footer"); ?>     

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url("base-admin-3.0/theme"); ?>/js/libs/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url("base-admin-3.0/theme"); ?>/js/libs/jquery-ui-1.10.0.custom.min.js"></script>
    <script src="<?php echo base_url("base-admin-3.0/theme"); ?>/js/libs/bootstrap.min.js"></script>

    <script src="<?php echo base_url("base-admin-3.0/theme"); ?>/js/Application.js"></script>

    <script src="<?php echo $_general_assets; ?>bower_components/accounting/accounting.min.js"></script>
    <script src="<?php echo $_general_assets; ?>bower_components/autoNumeric/autoNumeric.js"></script>
    <script src="<?php echo base_url("base-admin-3.0/theme"); ?>/js/plugins/msgGrowl/js/msgGrowl.js"></script>
    <script src="<?php echo base_url("base-admin-3.0/theme"); ?>/js/plugins/msgbox/jquery.msgbox.min.js"></script>
    <script src="<?php echo $_assets_js; ?>site.js"></script>
    <?php $this->view->load("assets_js"); ?>
  </body>
</html>
