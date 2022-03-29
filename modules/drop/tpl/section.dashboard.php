<main class="main-wrapper">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-lg-5">
                <div class="card shadow">
                    <div class="card-body pt-18">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="avator-semi border rounded-circle me-6">
                                <img src="<?php echo app_cdn_path; ?>img/company-dao.png" class="rounded-circle" width="80" height="80">
                            </div>
                            <div>
                                <div class="fs-3 fw-medium text-truncate">Bankless DAO</div>
                                <div class="text-muted"></div>
                            </div>
                        </div>
                        <div class="fs-5 fw-medium text-center my-17">Bankless DAO is a decentralized community to coordinate and propagate bankless media, culture, and education. Its goal is to drive adoption and awareness of truly bankless money systems like Ethereum.</div>
                        <div class="fs-1 fw-semibold text-center">20 $BANK</div>
                        <div class="fw-medium text-center text-muted mt-2">6 days left</div>
                    </div>
                    <div class="dash-divider"></div>
                    <div class="card-body">
                        <div class="fs-1 fw-semibold text-center text-primary">75% Complete</div>
                        <div class="fw-medium text-center text-muted mt-2">0x56H7...0Uw6</div>
                        <div class="row justify-content-md-center mt-12">
                            <div class="col-md-auto">
                                <div class="form-check mb-5">
                                    <input class="form-check-input" type="checkbox" value="" id="ThreeMonth">
                                    <label class="form-check-label fs-5 fw-medium" for="ThreeMonth">
                                        HODL 50 $BANK for 3 months
                                    </label>
                                </div>
                                <div class="form-check mb-5">
                                    <input class="form-check-input" type="checkbox" value="" id="OneMonth">
                                    <label class="form-check-label fs-5 fw-medium" for="OneMonth">
                                        Staked 200 $BANK for 1 month
                                    </label>
                                </div>
                                <div class="form-check mb-5">
                                    <input class="form-check-input" type="checkbox" value="" id="ProvidedBank">
                                    <label class="form-check-label fs-5 fw-medium" for="ProvidedBank">
                                        Provided $3,000 in $BANK / $USDC LP
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="TwoTweets">
                                    <label class="form-check-label fs-5 fw-medium" for="TwoTweets">
                                        Mention @BanklessDAO in at least 2 tweets
                                    </label>
                                </div>                            
                            </div>
                        </div>    
                    </div>
                    <div class="dash-divider"></div>
                    <div class="card-body text-center pt-6 pb-18">
                        <div class="fw-semibold">Complete the remaining actions and check back here.</div>
                        <button type="submit" class="btn btn-primary btn-lg px-13 text-uppercase mt-8" data-bs-toggle="modal" data-bs-target="#ClaimModal">CLAIM AIRDROP</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row align-items-center">
            <div class="col">
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