<main>
    <?php echo require_once 'partial/admin-leftmenu.php'?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-lg-12">
                    <div class="card shadow h-100">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 border rounded">
                                <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
                                <div class="fs-2 fw-semibold mt-20">Welcome to your dashboard!</div>
                                <div class="fw-medium text-muted mt-4">To get started, please distribute some NTTs.</div>
                                <a role="button" class="btn btn-primary mt-18" href="admin-rewards.html">Reward a new member</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Modal -->
<div class="modal fade" id="AdminCenter" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="<?php echo app_cdn_path; ?>img/logo-circle.svg" height="90">
                <div class="fs-2 fw-semibold mt-15">MyDAO Admin Center</div>
                <div class="fw-medium mt-3">To get started please connect a whitelisted wallet</div>
                <button type="button" class="btn btn-primary mt-20 px-10">Connect Wallet</button>
                <div class="text-danger fw-medium mt-20">This wallet does not have access to MyDAO. <br>
                    Please connect with a whitelisted wallet.</div>
            </div>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script>
    feather.replace()
</script>