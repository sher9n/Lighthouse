<main class="main-wrapper">
    <div class="container">
        <div class="d-lg-none text-center mb-8">
            <button type="button" id="btn-connect" class="btn btn-primary btn-lg text-uppercase btn-m-block ">Connect Wallet</button>
        </div>
        <div id="drops_cards" class="row"></div>
    </div>
</main>
<?php include_once app_root . '/templates/dash_foot.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        checkAccountData();


    });

    $(document).on("click",".drop_details",function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'get',
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    $('#drops_cards').html(response.html);
                }
            }
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });

</script>