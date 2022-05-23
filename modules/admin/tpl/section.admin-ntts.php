<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body px-27 py-30">
                        <div class="display-5 fw-medium">Recognize community participation</div>
                        <div class="text-muted mt-1">Send NTTs to anyone in your community</div>
                        <div class="fw-medium mt-20">Which wallet do you want to distribute NTTs to?</div>
                        <div class="fs-3 fw-semibold mt-3">0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507</div>
                        <a role="button" class="btn btn-light mt-3" href="#">Change Wallet</a>
                        <div class="col-6">
                            <div class="mt-16">
                                <label for="LHT" class="form-label">How many $LHT do you want to claim?</label>
                                <input type="text" class="form-control form-control-lg mb-6 fs-3" id="LHT" placeholder="100">
                                <div class="d-flex">
                                    <div class="badge bg-light d-flex align-items-center">Score Impact: <span class="text-success ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-up.png"></div>
                                    <div class="badge bg-light d-flex align-items-center ms-3">Rank Impact: <span class="text-danger ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-bottom.png"></div>
                                </div>
                            </div>

                            <label class="form-label fw-medium mt-18 mb-3">What's the reason for this distribution?</label>
                            <textarea class="form-control form-control-lg fs-3" id="" rows="2" placeholder="Helpful discussion on Discourse, URL tweet etc..."></textarea>
                            <label class="fw-medium mt-18 mb-3">Tag this distribution to query it later.</label>
                            <input type="text" class="form-control form-control-lg mb-6 fs-3" id="" placeholder="Marketing, Development, Strategy">

                        </div>
                    </div>
                    <div class="card-body border-top d-flex justify-content-end gap-3">
                        <button type="button" class="btn btn-white">Deny</button>
                        <button type="button" class="btn btn-primary">Approve</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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