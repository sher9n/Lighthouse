<div id="notify_form_skeltone" class="row d-none">
    <div class="col-lg-12">
        <div class="card shadow mb-12 loading position-relative"><div class="card-body"><div class="text-center"><div class="text-content-xxxxxl w-50 m-auto"></div><div class="mt-4 text-content-xxl w-70 m-auto"></div><form  class="row g-3 justify-content-center mt-2" method="post" action="notify" autocomplete="off" novalidate="novalidate"><div class="col-4"><div class="input-lg rounded"></div></div><div class="col-md-auto"><div class="btn-content-lg mw-180 rounded"></div></div></form></div>
            </div>
        </div>
    </div>
</div>
<?php if($is_notified != true){ ?>
<div id="notify_form" class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-12">
            <div class="card-body">
                <div class="text-center">
                    <div class="fs-1 fw-semibold">
                        Your claims will be airdropped soon!
                        <img src="cdn\img\icon-clap.svg" alt="clapping icon" width="32" height="32">
                    </div>
                    <div class="text-muted mt-3 fs-4 fw-medium">
                        Check back here or leave your details to be notified once rewards are redeemable.
                    </div>
                    <form  class="row g-3 justify-content-center mt-2" id="notifyForm" method="post" action="notify" autocomplete="off" novalidate="novalidate">
                        <input type="hidden" name="user_key" value="<?php echo $user_add; ?>">
                        <div class="col-4">
                            <input type="email" name="email" class="form-control form-control-lg border-0" id="" placeholder="Email address or Telegram handle">
                        </div>
                        <div class="col-md-auto">
                            <button type="submit" class="btn btn-primary btn-lg px-13 text-uppercase btn-m-block">Get Notified</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="row">
    <?php
    if(count($claims) > 0) {
        foreach ($claims as $claim){
            $avarats = explode(",",$claim['avatars']); ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12">
                    <div class="card-body overflow-hidden pt-18">
                        <div class="text-center">
                            <div class="card-logo rounded-circle m-auto">
                                <?php foreach ($avarats as $avtar) { ?>
                                    <img src="<?php echo app_cdn_path; ?>img/<?php echo $avtar;?>" class="rounded-circle" width="80" height="80">
                                <?php } ?>
                            </div>
                            <div class="fs-3 text-truncate fw-medium mt-10 mb-3"><?php echo $claim['name']; ?></div>
                            <div class="badge bg-light rounded-pill text-uppercase fw-medium fs-5 text-fiord"><img src="cdn/img/icon-airdrop.svg" class="me-2" alt="airdrop icon"><?php echo $claim['type']; ?></div>
                            <div class="card-hr-line">
                                <hr class="my-13 mx-5">
                            </div>
                            <div class="fs-1 text-truncate fw-semibold mb-3 text-uppercase">
                                <?php echo $claim['budget']; ?> <?php echo $claim['symbol']; ?>
                            </div>
                            <div class=" fs-5 text-primary fw-medium text-uppercase">CLAIMED ON <?php echo date("F j, Y",strtotime($claim['c_at'])); ?></div>
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
                <div class="fs-1 fw-semibold text-center mt-20">No claims found!</div>
            </div>
        </div>
        <?php
    } ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#notifyForm').validate({
            rules: {
                email: {
                    required: true
                }
            },
            submitHandler: function (form) {
                $('#notify_form').addClass('d-none');
                $('#notify_form_skeltone').removeClass('d-none');
                $(form).ajaxSubmit({
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        if (data.success == true) {
                            $('#notify_form_skeltone').addClass('d-none');
                            $('#notify_form').removeClass('d-none');
                        }
                    }
                });
            }
        });
    });
</script>