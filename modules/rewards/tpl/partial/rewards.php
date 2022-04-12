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
                        Rewards are dropping soon!
                        <img src="cdn\img\icon-clap.svg" alt="clapping icon" width="32" height="32">
                    </div>
                   <!-- <div class="text-muted mt-3 fs-4 fw-medium">
                        Check back here or leave your details to be notified once rewards are redeemable.
                    </div>-->
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
            <!--<div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12">
                    <div class="card-body overflow-hidden pt-18">
                        <div class="text-center">
                            <div class="card-logo rounded-circle m-auto">
                                <?php /*foreach ($avarats as $avtar) { */?>
                                    <img src="<?php /*echo app_cdn_path; */?>img/<?php /*echo $avtar;*/?>" class="rounded-circle img-overlap" width="80" height="80">
                                <?php /*} */?>
                            </div>
                            <div class="fs-3 text-truncate fw-medium mt-10 mb-3"><?php /*echo $claim['name']; */?></div>
                            <div class="badge bg-light rounded-pill text-uppercase fw-medium fs-5 text-fiord"><img src="cdn/img/icon-airdrop.svg" class="me-2" alt="airdrop icon"><?php /*echo $claim['type']; */?></div>
                            <div class="card-hr-line">
                                <hr class="my-13 mx-5">
                            </div>
                            <div class="fs-1 text-truncate fw-semibold mb-3 text-uppercase">
                                <?php /*echo $claim['budget']; */?> <?php /*echo $claim['symbol']; */?>
                            </div>
                            <div class=" fs-5 text-primary fw-medium text-uppercase">CLAIMED ON <?php /*echo date("F j, Y",strtotime($claim['c_at'])); */?></div>
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12">
                    <div class="overflow-hidden rounded-top">
                        <img src="cdn/img/img-rewards-01.jpg" class="card-img-top card-image-blur">
                    </div>
                    <div class="card-body py-8">
                        <div class="text-center">
                            <div class="fs-3 text-truncate fw-medium mb-3 card-text-blur" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-placement="bottom">Bored Ape Yacht Club NFT</div>

                            <div class="badge bg-light d-inline-flex align-items-center rounded-pill text-uppercase fw-medium mb-10 text-fiord">
                                <img src="cdn/img/icon-tools.svg" class="me-4" alt="airdrop icon" height="20">
                                <div class="lh-1 fs-6">Utility</div>
                            </div>
                            <div class="fs-5 fw-medium mb-8">Launching August 1, 2022</div>
                            <div class="fs-4 two-lines-wrap">Awarded for selected NFT participation</div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } ?>
</div>
<div class="row">
<img src="<?php echo app_cdn_path ?>img/img-placeholder.png" class="img-fluid">
</div>
<!--<div class="row">
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12">
                    <div class="overflow-hidden rounded-top">
                        <img src="cdn/img/img-rewards-01.jpg" class="card-img-top card-image-blur">
                    </div>                    
                    <div class="card-body py-8">
                        <div class="text-center">                            
                            <div class="fs-3 text-truncate fw-medium mb-3 card-text-blur" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-placement="bottom">Bored Ape Yacht Club NFT</div>

                            <div class="badge bg-light d-inline-flex align-items-center rounded-pill text-uppercase fw-medium mb-10 text-fiord">
                                <img src="cdn/img/icon-tools.svg" class="me-4" alt="airdrop icon" height="20">
                                <div class="lh-1 fs-6">Utility</div>
                            </div>
                            <div class="fs-5 fw-medium mb-8">Launching August 1, 2022</div>
                            <div class="fs-4 two-lines-wrap">Awarded for selected NFT participation</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12 overflow-hidden">
                    <div class="card-blur noselect unselectable">
                        <div class="rounded-top">
                            <img src="cdn/img/img-rewards-01.jpg" class="card-img-top">
                        </div>                    
                        <div class="card-body py-8">
                            <div class="text-center">                            
                                <div class="fs-3 text-truncate fw-medium mb-3" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-placement="bottom">Bored Ape Yacht Club NFT</div>

                                <div class="badge bg-light d-inline-flex align-items-center rounded-pill text-uppercase fw-medium mb-10 text-fiord">
                                    <img src="cdn/img/icon-tools.svg" class="me-4" alt="airdrop icon" height="20">
                                    <div class="lh-1 fs-6">Utility</div>
                                </div>
                                <div class="fs-5 fw-medium mb-8">Launching August 1, 2022</div>
                                <div class="fs-4 two-lines-wrap">Awarded for selected NFT participation</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>-->
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
                            $('#notify_form').html('<div class="row" role="alert"> <div class="col-lg-12"><div class="card shadow mb-12"><div class="card-body position-elative"><div class="position-absolute top-10 end-1"></div><div class="text-center"><div class="fs-1 fw-semibold">Thank you for subscribing!<img src="<?php echo app_cdn_path ?>img/img-party-popper.svg" alt="clapping icon" width="32" height="32"></div><div class="text-muted mt-3 fs-4 fw-medium">We\'ll inform you once rewards are redeemable. Our Twitter (@Lighthouse_DAO)<br> is also a great place to stay current on the latest opportunities and drops.</div></div></div></div></div></div>');
                            $('#notify_form').removeClass('d-none');
                            setTimeout(function() {
                                $('#notify_form').slideUp();
                            }, 4000);
                        }
                    }
                });
            }
        });
    });
</script>