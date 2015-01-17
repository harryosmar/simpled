<style type="text/css">
    .page-500 {
        text-align: center;
    }
    .page-500 .number {
        display: inline-block;
        letter-spacing: -10px;
        line-height: 128px;
        font-size: 128px;
        font-weight: 300;
        color: #ec8c8c;
        text-align: right;
    }
    .page-500 .details {
        margin-left: 40px;
        display: inline-block;
        text-align: left;
    }
</style>
<div class="col-md-12"> 
    <div class="widget stacked ">
        <div class="widget-header">
            <i class="icon-exclamation"></i>
            <h3>Error Message</h3>
        </div>
        <div class="widget-content">
            <div class="row">
                <div class="col-md-12 page-500">
                    <div class=" number">
                        500
                    </div>
                    <div class=" details">
                        <h3><?php echo isset($err_title) ? $err_title : ""; ?></h3>
                        <p>
                            <?php echo isset($err_msg) ? $err_msg : ""; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
