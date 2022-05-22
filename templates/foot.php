<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/bootstrap.min.js"></script>
<?php
foreach ($__page->js as $page_js) { ?>
    <script type="text/javascript" src="<?php echo $page_js; ?>"></script>
    <?php
}
?>