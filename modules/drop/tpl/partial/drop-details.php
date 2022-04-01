<?php
use Core\Utils;
if(isset($response['data']) && count($response['data'])){
    $drop = current($response['data']);
    $per_use_claim = (int)$drop['per_user_claim'];
    $user_claims = (int)$drop['user_claims'];
    $user_eligibilities = $drop['user_eligibilities'];
    $claim =  (is_array($user_eligibilities) && (count($user_eligibilities) == array_sum($user_eligibilities)));
    ?>
    <div class="row justify-content-md-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body pt-18">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="avator-semi border rounded-circle me-6">
                            <img src="<?php echo app_cdn_path; ?>img/company-lighthouse.svg" class="rounded-circle" width="80" height="80">
                        </div>
                        <div>
                            <div class="fs-3 fw-medium text-truncate mb-6"><?php echo $drop['name']; ?></div>
                            <div class="badge bg-light rounded-pill text-uppercase fw-medium fs-5 text-fiord">
                                <img src="<?php echo app_cdn_path; ?>img/whitelist-icon.svg" class="me-2" alt="airdrop icon"><?php echo $drop['type']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="fs-5 fw-medium text-center my-17"><?php echo $drop['description']; ?></div>
                    <!--<div class="fs-1 fw-semibold text-center"><img src="<?php /*echo app_cdn_path; */?>img/img-party-popper.svg" class="me-2" >Congrats! You can claim 20 $BANK!</div>-->
                    <div class="fs-1 fw-semibold text-center"><?php echo $drop['budget']; ?> <?php echo $drop['symbol']; ?></div>
                    <div class="fw-medium text-center text-muted mt-2"><?php echo Utils::expireDateCounts($drop['end_date']); ?></div>
                    <div class="progress m-8">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ($user_claims/$per_use_claim)*100;?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="text-muted text-center mb-10"><?php echo number_format($user_claims)?> claimed / <?php echo number_format($per_use_claim)?></div>
                    <div class="row justify-content-md-center mt-12">
                        <div class="col-md-auto">
                            <?php foreach ( $drop['eligibilities'] as $index =>  $eligibility) { ?>
                            <div class="form-check mb-5">
                                <input class="form-check-input" type="checkbox" <?php echo ($user_eligibilities[$index] == 1)?'checked':''; ?> value="" id="ThreeMonth">
                                <label class="form-check-label fs-5 fw-medium" for="ThreeMonth">
                                    <?php echo $eligibility; ?>
                                </label>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="dash-divider"></div>
                <div class="card-body text-center pt-6 pb-18">
                    <div class="fw-semibold">Connect your wallet to view eligibility.</div>
                    <?php if(is_null($user_add)){ ?>
                        <button type="button" onclick="onConnect('get-drops?id=<?php echo $drop_id;?>')" class="btn btn-primary btn-lg px-13 text-uppercase mt-8">CONNECT WALLET</button>
                    <?php }else{ ?>
                        <button type="submit" class="wallet_connected btn btn-primary btn-lg px-13 text-uppercase mt-8 <?php echo ($claim != true)?'disabled':'';?>" data-bs-toggle="modal" data-bs-target="#ClaimModal">CLAIM AIRDROP</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php
} ?>