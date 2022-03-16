<?php foreach ($coins as $index => $c) { ?>
    <li class="list-community-item">
        <div class="d-flex align-items-center justify-content-between">
            <a class="d-block w-70 coin_details" data-s="<?php echo $c['symbol']; ?>" data-n="<?php echo $c['c_name']; ?>" data-t="<?php echo $c['twitter_username']; ?>" data-id="<?php echo $c['id']; ?>" data-coin_id="<?php echo $c['coin_id']; ?>" data-l="<?php echo $c['logo']; ?>" href="#">
                <div class="d-flex align-items-center">
                    <div class="avator d-flex justify-content-center align-items-center me-5">
                        <img src="<?php echo $c['logo']; ?>" class="rounded-circle bg-white" width="48" height="48" />
                    </div>
                    <div class="w-70">
                        <div class="fs-3 text-truncate"><?php echo $c['c_name']; ?></div>
                        <div class="text-muted lh-1"><?php echo ucfirst($c['category']); ?></div>
                    </div>
                </div>
            </a>
            <a class="pin_coin" href="<?php echo (!isset($c['is_pin']))?'pin-coin?user_key='.$user_key.'&pin='.$c['id']:'pin-coin?user_key='.$user_key.'&unpin='.$c['id']; ?>">
                <div class="ms-auto pin_icon">
                    <?php if(isset($c['is_pin'])){ ?>
                        <img src="<?php echo app_cdn_path; ?>img/icon-pin-fill.svg" width="25" height="25" >
                    <?php }else{ ?>
                        <img src="<?php echo app_cdn_path; ?>img/icon-pin.svg" width="25" height="25" >
                    <?php } ?>
                </div>
            </a>
        </div>
    </li>
<?php } ?>