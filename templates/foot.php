<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/dataTables.bootstrap5.min.js"></script>
<?php
foreach ($__page->js as $page_js) { ?>
    <script type="text/javascript" src="<?php echo $page_js; ?>"></script>
    <?php
}
?>