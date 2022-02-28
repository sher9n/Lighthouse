<?php foreach ($coins as $index => $c) { ?>
<li class="list-community-item">
    <a class="pin_coin" href="<?php echo (!isset($c['is_pin']))?'pin-coin?user_key='.$user_key.'&pin='.$c['id']:'pin-coin?user_key='.$user_key.'&unpin='.$c['id']?>">
        <div class="d-flex align-items-center">
            <div class="avator d-flex justify-content-center align-items-center me-5">
                <img src="<?php echo $c['logo']; ?>" class="rounded-circle bg-white" width="48" height="48" />
            </div>
            <div class="w-70">
                <div class="fs-3 text-truncate"><?php echo $c['c_name']; ?></div>
                <div class="text-muted lh-1"><?php echo $c['category']; ?></div>
            </div>
            <?php if(isset($c['is_pin'])){ ?>
            <div class="ms-auto">
                <img src="<?php echo app_cdn_path; ?>img/icon-pin-fill.svg" width="25" height="25" >
            </div>
            <?php } ?>
        </div>
    </a>
</li>
<?php } ?>