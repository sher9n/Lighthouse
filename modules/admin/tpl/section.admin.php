<main>
    <!-- Modal backbround image -->
    <div class="modal-background"></div>
    <!-- Modal backbround image END -->
</main>
<!-- Modal -->
<div class="modal show" id="AdminCenter" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="<?php echo app_cdn_path; ?>img/logo-circle.svg" height="90">
                <div class="fs-2 fw-semibold mt-15">MyDAO Admin Center</div>
                <div class="fw-medium mt-3">To get started please connect a whitelisted wallet</div>
                <button type="button" id="add_wallet" onclick="addWallet()" class="btn btn-primary mt-20 px-10">Connect Wallet</button>
                <!--<div class="text-danger fw-medium mt-20">This wallet does not have access to MyDAO. <br>
                    Please connect with a whitelisted wallet.</div>-->
            </div>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script>
    feather.replace();

    $(window).on('load', function() {
        $('#AdminCenter').modal('show');
    });

    $(document).ready(function() {

        var table = $('#example').DataTable({
            dom: "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-4'l><'col-sm-8'p>>",
            'language': {
                'paginate': {
                    'previous': '<div><img src="<?php echo app_cdn_path; ?>img/arrow-fill-gray-left.svg" class="me-2">Previous</div>',
                    'next': '<div>Next<img src="<?php echo app_cdn_path; ?>img/arrow-fill-gray-right.svg" class="ms-2"></div>'
                },
                "lengthMenu": '<select class="form-select">'+
                    '<option value="10">Rows per page: 10</option>'+
                    '<option value="20">Rows per page: 20</option>'+
                    '<option value="30">Rows per page:30</option>'+
                    '<option value="40">Rows per page: 40</option>'+
                    '<option value="50">Rows per page: 50</option>'+
                    '<option value="-1">All</option>'+
                    '</select>'
            }
        });
    } );
</script>