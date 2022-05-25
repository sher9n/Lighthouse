<div class="card shadow">
    <div class="card-body p-xl-20 mb-xl-20">
        <div class="display-5 fw-medium">Claim details</div>
        <label for="" class="form-label mt-20">Wallet or SNS</label>
        <div class="fs-3 fw-semibold"><?php echo $claim->wallet_adr; ?></div>
        <label for="" class="form-label mt-18 mb-3">Claim amount</label>
        <div>
            <div class="row g-6">
                <div class="col-xl-3">
                    <input type="number" class="form-control rounded-3 py-9 px-7 fs-3 h-100" readonly value="<?php echo $claim->ntts; ?>" placeholder="120">
                </div>
                <div class="col-xl">
                    <div class="bg-light rounded-3 py-3 px-7">
                        <div class="fs-3">4.5K</div>
                        <div class="d-flex align-items-center">Score Impact: <span class="text-success ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-up.png"></div>
                    </div>
                </div>
                <div class="col-xl">
                    <div class="bg-light rounded-3 py-3 px-7">
                        <div class="fs-3">2.32K</div>
                        <div class="d-flex align-items-center">Rank Impact: <span class="text-danger ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-bottom.png"></div>
                    </div>
                </div>
            </div>
        </div>
        <label for="" class="form-label mt-18 mb-3">Reason</label>
        <textarea class="form-control form-control-lg fs-3" id="" rows="2" placeholder=""><?php echo $claim->clm_reason; ?></textarea>
        <label for="" class="form-label mt-18 mb-3">Tags</label>
        <textarea class="form-control form-control-lg" id="" rows="2" placeholder=""><?php echo $claim->clm_tags; ?></textarea>
    </div>
    <?php if($claim->status == 0){ ?>
    <div class="action_buttons card-body border-top d-flex justify-content-end gap-3">
        <button type="button" data-claim_id="<?php echo $claim_id; ?>" class="btn btn-white claim_deny">Deny</button>
        <button type="button" data-claim_id="<?php echo $claim_id; ?>" class="btn btn-primary claim_approve">Approve</button>
    </div>
    <?php } ?>
</div>