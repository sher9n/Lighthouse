<?php
use Core\Utils;
if(isset($response['data'])){
    if(count($response['data']) > 0) {
        foreach ($response['data'] as $index => $drop) {
            $per_use_claim = (int)$drop['per_user_claim'];
            $user_claims = (int)$drop['user_claims'];
            $user_eligibilities = $drop['user_eligibilities'];
            $avarats = explode(",",$drop['avatars']);
            ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12">
                    <div class="card-body py-18">
                        <div class="text-center">
                            <div class="card-logo m-auto d-flex justify-content-center">
                                <?php foreach ($avarats as $avtar) { ?>
                                    <img src="<?php echo app_cdn_path; ?>img/<?php echo $avtar;?>" class="rounded-circle" width="80" height="80">
                                <?php } ?>
                            </div>
                            <div class="fs-3 text-truncate fw-medium mt-10 mb-3 textOverflow" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-placement="bottom" ><?php echo $drop['name'];?></div>

                            <div class="badge bg-light d-inline-flex align-items-center rounded-pill text-uppercase fw-medium mb-10 text-fiord">
                                <img src="cdn/img/whitelist-icon.svg" class="me-4" alt="airdrop icon" height="20">
                                <div class="lh-1 fs-6"><?php echo $drop['type'];?></div>
                            </div>
                            <div class="fs-1 text-truncate fw-semibold mb-3 text-uppercase text-truncate">
                                <?php echo $drop['budget'];?> <?php echo $drop['symbol'];?>
                                <!-- <span class="text-truncate">50 $tLHT</span> <span class="text-truncate text-muted" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-placement="bottom" >+ 2 more</span>-->
                            </div>
                            <div class="text-muted fs-5 mb-10"><?php echo Utils::expireDateCounts($drop['end_date']); ?></div>
                            <div class="progress m-8">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ($user_claims/$per_use_claim)*100;?>%" aria-valuenow="<?php echo ($user_claims/$per_use_claim)*100;?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="text-muted text-center mb-10"><?php echo number_format($user_claims);?> claimed / <?php echo number_format($per_use_claim)?></div>
                            <div class="text-center">
                                <?php
                                if(is_array($user_eligibilities) && (count($user_eligibilities) == array_sum($user_eligibilities))){?>
                                    <a href="get-drops?id=<?php echo $drop['id']; ?>" class="drop_details btn btn-success text-white btn-lg px-13 text-uppercase btn-mw-200">Claim Now</a>
                                <?php }else{ ?>
                                    <a href="get-drops?id=<?php echo $drop['id']; ?>" class="drop_details btn btn-primary btn-lg px-13 text-uppercase btn-mw-200">CHECK ELIGIBILITY</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    }
    else {
        ?>
        <div class="row align-items-center">
            <div class="col mt-30">
                <div class="text-center">
                    <img src="<?php echo app_cdn_path ?>img/img-no-claim.png" height="160" >
                </div>
                <div class="fs-1 fw-semibold text-center mt-20">No drops found!</div>
            </div>
        </div>
        <?php
    }
}?>