<?php
if($response['status'] == 200 && isset($response['data'])) {
    $coin = $response['data']; ?>
    <div class="my-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="d-flex w-50">
                        <div class="avator border rounded-circle me-6">
                            <img src="<?php echo $coin['logo']; ?>" class="rounded-circle bg-white" width="48" height="48" />
                        </div>
                        <div class="w-60">
                            <div class="fs-3 text-truncate"><?php echo $coin['c_name']; ?></div>
                            <div class="text-muted lh-1"><?php echo \Core\Utils::coinAddressFormat($coin['platform_token_address']); ?> <img src="" class="ms-1" width="15" height="15"></div>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <ul class="list-equal-horizontal">
                            <li class="list-equal-item  py-0">
                                <div class="fs-3 lh-1">12,371</div>
                                <div class="text-muted mt-1">Members</div>
                            </li>
                            <li class="list-equal-item  py-0">
                                <div class="fs-3 lh-1">$15.65M</div>
                                <div class="text-muted mt-1">Market Cap</div>
                            </li>
                            <li class="list-equal-item  py-0">
                                <div class="fs-3 lh-1">$476K</div>
                                <div class="text-muted mt-1">Treasury</div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mt-4">
                    <ul class="list-badge">
                        <?php if(isset($coin['platform_symbol'])){ ?>
                        <li class="list-badge-item"><?php echo $coin['platform_symbol'];?></li>
                        <?php } ?>
                        <?php if(isset($coin['platform_slug'])){ ?>
                        <li class="list-badge-item"><?php echo $coin['platform_slug'];?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="card-body border-top">
                <div class=" fs-5"><?php echo $coin['description']; ?></div>
                <div class="row mt-12">
                    <?php if(isset($coin['urls']['website']) || isset($coin['urls']['twitter']) || isset($coin['urls']['chat'])){ ?>
                    <div class="col-lg-6">
                        <div class=" fs-5 text-primary mb-2">Social</div>
                        <div class="list-social-media">
                            <?php if(isset($coin['urls']['website'])){ ?>
                            <a class="list-social-media-item d-flex align-items-center" href="<?php echo $coin['urls']['website']; ?>" role="button">
                                <div class="avator d-flex justify-content-center align-items-center border rounded-circle me-6">
                                    <img src="<?php echo app_cdn_path; ?>img/icon-bank.svg" height="16" />
                                </div>
                                <div class="text-dark  fs-5"><?php echo $coin['urls']['website']; ?></div>
                            </a>
                            <?php } ?>
                            <?php if(isset($coin['urls']['twitter'])){ ?>
                            <a class="list-social-media-item d-flex align-items-center" href="<?php echo $coin['urls']['twitter'];?>" role="button">
                                <div class="avator d-flex justify-content-center align-items-center border rounded-circle me-6">
                                    <img src="<?php echo app_cdn_path; ?>img/icon-twitter.svg" height="16" />
                                </div>
                                <div class="text-dark  fs-5"><?php echo $coin['urls']['twitter'];?></div>
                            </a>
                            <?php } ?>
                            <?php if(isset($coin['urls']['chat'])){ ?>
                            <a class="list-social-media-item d-flex align-items-center" href="<?php echo $coin['urls']['chat'];?>" role="button">
                                <div class="avator d-flex justify-content-center align-items-center border rounded-circle me-6">
                                    <img src="<?php echo app_cdn_path; ?>img/icon-discord.svg" height="16" />
                                </div>
                                <div class="text-dark  fs-5"><?php echo $coin['urls']['chat'];?></div>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-lg-6 ps-lg-13">
                        <div class=" fs-5 text-primary mb-2">Activity</div>
                        <ul class="list-activity">
                            <li class="list-activity-item  fs-5">4 Open Proposals</li>
                            <li class="list-activity-item  fs-5">1,346 ended</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
else {
    ?>
    <div class="card shadow">
        <div class="card-body text-center">
            <img src="<?php echo app_cdn_path; ?>img/img-rewards.png" class="img-fluid rounded mt-16" alt=""/>
            <div class="fs-1 fw-semibold mt-12">Rewards dropping soon! </div>
            <div class="fs-5  mt-5 text-center">We’re working with communities to define <br>
                rewards for Lighthouse members. Sign up to stay tuned.</div>
            <form class="row g-6 justify-content-md-center mt-23 mb-18">
                <div class="col-6">
                    <label for="Email" class="visually-hidden">Email</label>
                    <input type="password" class="form-control form-control-lg" id="Email" placeholder="Email">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-lg px-20 text-uppercase">Get Notified</button>
                </div>
            </form>
        </div>
    </div>
    <?php
} ?>