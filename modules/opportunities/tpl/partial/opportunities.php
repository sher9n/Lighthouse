<?php
use Core\Utils;
if(isset($response['data'])){
    if(count($response['data']) > 0) {
        $data = $response['data'];

        usort($data, function ($a, $b) {
            return $a['user_eligibility_status'] > $b['user_eligibility_status'];
        });

        foreach ($data as $index => $drop) {
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
                                    <img src="<?php echo app_cdn_path; ?>img/<?php echo $avtar;?>" class="rounded-circle img-overlap" width="80" height="80">
                                <?php } ?>
                            </div>
                            <div class="fs-3 text-truncate fw-medium mt-10 mb-3 textOverflow" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-placement="bottom"><?php echo $drop['name'];?></div>

                            <div class="badge bg-light d-inline-flex align-items-center rounded-pill text-uppercase fw-medium mb-10 text-fiord">
                                <img src="cdn/icons/<?php echo $drop['type'];?>.svg" class="me-4" alt="airdrop icon" height="20">
                                <div class="lh-1 fs-6"><?php echo $drop['type'];?></div>
                            </div>
                            <div class="fs-1 text-truncate fw-semibold mb-3 text-uppercase text-truncate">1,361 Points</div>
                            <div class="fs-5 fw-medium mb-10">Last Active 1 Day ago</div>

                            <div class="fs-4 fw-medium text-muted text-center mb-10 three-lines-wrap">Connect two or more wallets and participate in lighthouse partner communities</div>
                            <div class="text-center">
                                <?php
                                if($drop['user_eligibility_status'] == 1){?>
                                    <a href="get-opportunities?id=<?php echo $drop['id']; ?>" class="drop_details btn btn-success text-white btn-lg px-13 text-uppercase btn-mw-200">Participating</a>
                                <?php }else{ ?>
                                    <a href="get-opportunities?id=<?php echo $drop['id']; ?>" class="drop_details btn btn-primary btn-lg px-13 text-uppercase btn-mw-200">Participate</a>
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
                <div class="fs-1 fw-semibold text-center mt-20">No opportunities found!</div>
                <div class="fs-5 fw-medium text-center text-muted mt-6">We can't find any item matching your search</div> 
            </div>
        </div>
        <?php
    }
}?>