<script type="text/javascript" src="https://unpkg.com/feather-icons"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/select2.full.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/js-snackbar.js"></script>
<?php
foreach ($__page->js as $page_js) { ?>
    <script type="text/javascript" src="<?php echo $page_js; ?>"></script>
    <?php
}
?>
<script>

    function showMessage(status,time,message) {
        SnackBar({
            status: status,
            position: "bl",
            icon: "	 ",
            timeout: time,
            message: message
        });
    }

    $(document).ready(function() {

        $(document).on("click", '#disconnect_wallet', function(event) {
            event.preventDefault();
            $.ajax({
                url: 'disconnect_wallet',
                dataType: 'json',
                type: 'GET',
                success: function (response) {
                    if (response.success == true) {
                        if(response.solana == true)
                            disconnectAccount();
                        else
                            onDisconnect();
                        window.location = 'admin';
                    }
                }
            });
        });
    });
</script>
