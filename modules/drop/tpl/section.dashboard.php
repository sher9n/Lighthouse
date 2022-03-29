<main class="main-wrapper">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-body pt-18">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="avator-semi border rounded-circle me-6">
                                <img src="<?php echo app_cdn_path; ?>img/company-lighthouse.svg" class="rounded-circle" width="80" height="80">
                            </div>
                            <div>
                                <div class="fs-3 fw-medium text-truncate mb-6">Lighthouse Eligibility Booster</div>
                                <div class="badge bg-light rounded-pill text-uppercase fw-medium fs-5 text-fiord">
                                    <img src="<?php echo app_cdn_path; ?>img/whitelist-icon.svg" class="me-2" alt="airdrop icon">Airdrop
                                </div>
                            </div>
                        </div>
                        <div class="fs-5 fw-medium text-center my-17">Lighthouse Eligibility Booster is a decentralized community to coordinate and propagate bankless media, culture, and education. Its goal is to drive adoption and awareness of truly bankless money systems like Ethereum.</div>
                        <div class="fs-1 fw-semibold text-center"><img src="<?php echo app_cdn_path; ?>img/img-party-popper.svg" class="me-2" >Congrats! You can claim 20 $BANK!</div>
                        <div class="fw-medium text-center text-muted mt-2">6 days left</div>
                        <div class="progress m-8">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="text-muted text-center mb-10">10,000 claimed / 10,000</div>                    
                        <div class="row justify-content-md-center mt-12">
                            <div class="col-md-auto">
                                <div class="form-check mb-5">
                                    <input class="form-check-input" type="checkbox" value="" id="ThreeMonth">
                                    <label class="form-check-label fs-5 fw-medium" for="ThreeMonth">
                                        Connect 2 or more wallets to Lighthouse to aggregate and supercharge your eligibility for rewards.
                                    </label>
                                </div>
                                <div class="form-check mb-5">
                                    <input class="form-check-input" type="checkbox" value="" id="OneMonth">
                                    <label class="form-check-label fs-5 fw-medium" for="OneMonth">
                                        Each wallet must have least 1 transaction that is over 180 days old
                                    </label>
                                </div>                            
                            </div>
                        </div>    
                    </div>
                    <div class="dash-divider"></div>
                    <div class="card-body text-center pt-6 pb-18">
                        <div class="fw-semibold">Connect your wallet to view eligibility.</div>
                        <button type="submit" class="btn btn-primary btn-lg px-13 text-uppercase mt-8 disabled" data-bs-toggle="modal" data-bs-target="#ClaimModal">CLAIM AIRDROP</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row align-items-center">
            <div class="col mt-30">
                <div class="text-center">
                    <img src="<?php echo app_cdn_path; ?>img/img-claim.svg" >
                </div>
                <div class="fs-1 fw-semibold text-center mt-20">Hold up!</div>
                <div class="fs-5 fw-medium text-center text-muted mt-6">This drop is no longer available, please checkout the drops section to explore more rewards.</div>
                <div class="text-center mt-18">
                    <button type="submit" class="btn btn-primary btn-lg px-18 text-uppercase">Explore Drops</button>
                </div>
            </div>            
        </div>

        <div class="row align-items-center">
            <div class="col mt-30">
                <div class="text-center">
                    <img src="<?php echo app_cdn_path; ?>img/img-claim.svg" >
                </div>
                <div class="fs-1 fw-semibold text-center mt-20">Hold up!</div>
                <div class="fs-5 fw-medium text-center text-muted mt-6">Connect your wallet to see your claims here.</div>
                <div class="text-center mt-18">
                    <button type="submit" class="btn btn-primary btn-lg px-18 text-uppercase">Connect Wallet</button>
                </div>
            </div>            
        </div>

        <div class="row align-items-center">
            <div class="col mt-30">
                <div class="text-center">
                    <img src="<?php echo app_cdn_path; ?>img/img-no-claim.png" height="160" >
                </div>
                <div class="fs-1 fw-semibold text-center mt-20">No claims yet!</div>
                <div class="fs-5 fw-medium text-center text-muted mt-6">Please complete some challenges to unlock rewards.<br>Claimed rewards will appear here.</div>
            </div>            
        </div>

    </div>
</main>
<!-- Claim Modal -->
<div class="modal fade" id="ClaimModal" tabindex="-1" aria-labelledby="ClaimModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body py-30">
        <div class="text-center">
            <img src="<?php echo app_cdn_path; ?>img/img-claim-popup.svg" >
        </div>  
        <div class="fs-1 fw-semibold text-center mt-20">Claim successful!</div>
        <div class="fs-5 fw-medium text-center text-muted mt-6">This reward will be airdropped to you soon</div>
        <div class="text-center mt-18">
            <button type="submit" class="btn btn-primary btn-lg px-18 text-uppercase">COntinue</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once app_root . '/templates/dash_foot.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        checkAccountData();
    });
</script>