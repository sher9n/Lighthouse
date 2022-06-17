<main>
    <aside class="left-aside">
        <div>
            <img src="<?php echo app_cdn_path; ?>img/logo.png" >
        </div>
        <div class="steps-wrapper">
            <ul class="nav-steps">
                <li class="nav-steps-item active">
                    <a href="#" class="nav-steps-link">Create Your NTTs</a>
                </li>
                <li class="nav-steps-item">
                    <a href="#" class="nav-steps-link">Become the First Member</a>
                </li>
                <li class="nav-steps-item">
                    <a href="#" class="nav-steps-link">Your First Distribution</a>
                </li>
            </ul>
        </div>
    </aside>
    <section class="body-section">
        <form id="nttsForm" method="post" action="onboard" autocomplete="off">
            <div class="container-fluid">
                <div class="row justify-content-lg-center">
                    <div class="col-xl-7">
                        <div class="display-5 fw-medium mt-25">Create your NTTs</div>
                        <div class="text-muted mt-1">Make your scoring system your own</div>
                            <div class="mt-23">
                                <label for="DAOName" class="form-label">What’s your community or DAO’s name?</label>
                                <input type="text" class="form-control form-control-lg" name="dao_name" id="dao_name" placeholder="MyDAO">
                                <div class="invalid-feedback">This name is already taken. Please try a different name.</div>
                            </div>
                            <div class="mt-16">
                                <label for="DAOName" class="form-label">What would you like your subdomain to be?</label>
                                <div class="input-group input-group-lg">
                                    <input type="text" class="form-control form-control-lg" name="dao_domain" id="dao_domain" placeholder="MyDAO">
                                    <span class="input-group-text fw-medium" id="">.lighthouse.xyz</span>
                                </div>
                                <label id="dao_domain-error" class="error" style="display: none;" for="dao_domain"></label>
                            </div>
                            <div class="mt-16">
                                <label for="Blockchain" class="form-label">Which blockchain would you like to issue your NTTs on?</label>
                                <div class="dropdown">
                                    <input type="hidden" name="blockchain" id="blockchain" value="<?php echo GNOSIS_CHAIN; ?>">
                                    <button class="btn btn-white dropdown-toggle d-flex justify-content-between align-items-center text-transform-inherit fw-normal w-100" type="button" id="blockchain" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div id="selected_blockchain" class="d-flex align-items-center">
                                        <img src="<?php echo app_cdn_path; ?>img/gnosis-chain-logo.png" class="me-3">
                                        <div class="fs-3">Gnosis Chain</div>
                                    </div>
                                    </button>
                                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton1">
                                        <li class="border-bottom">
                                            <a data-val="<?php echo GNOSIS_CHAIN; ?>" class="blockchain_item dropdown-item d-flex align-items-center" href="#">
                                                <img src="<?php echo app_cdn_path; ?>img/gnosis-chain-logo.png" class="mx-3" width="40">
                                                <div class="fs-3">Gnosis Chain</div>
                                            </a>
                                        </li>
                                        <li class="border-bottom">
                                            <a data-val="<?php echo SOLANA; ?>" class="blockchain_item dropdown-item d-flex align-items-center" href="#">
                                                <img src="<?php echo app_cdn_path; ?>img/solana-sol-logo.png" class="mx-3" width="40">
                                                <div class="fs-3">Solana</div>
                                            </a>
                                        </li>
                                        <li class="border-bottom">
                                            <a data-val="<?php echo OPTIMISM ; ?>" class="blockchain_item dropdown-item d-flex align-items-center" href="#">
                                                <img src="<?php echo app_cdn_path; ?>img/optimism-logo.png" class="mx-3" width="40">
                                                <div class="fs-3">Optimism</div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mt-16">
                                <label for="NTTCurrency" class="form-label">What ticker do you want to use for your NTT?</label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text fw-medium">nt</span>
                                    <input type="text" class="form-control" name="ticker" id="ticker" placeholder="MyDAO">
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="nav-bar-bottom">
                <div class="d-flex justify-content-between">
                    <div></div>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </div>
        </form>
    </section>
</main>
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){

        $(document).on("focusout", '#dao_domain', function(event) {
            var dao_name = $(this).val();

            $.ajax({
                url: 'check-dao-domain',
                data: {'dao_name':dao_name},
                dataType: 'json',
                success: function(data) {
                    if (data.success == false){
                        $('#dao_domain-error').html(data.msg);
                        $('#dao_domain-error').show();
                    }
                    else {
                        $('#dao_domain').val(data.sub_domain);
                        $('#ticker').val(data.ticker);
                    }
                }
            });
        });

        $(document).on("keyup", '#dao_name', function(event) {
            var dao_name = $(this).val();
            dao_name = dao_name.replace(/\s+/g, '-');
            $('#dao_domain').val(dao_name.toLowerCase());
            $('#ticker').val(dao_name.toUpperCase());
        });

        $(document).on("click", '.blockchain_item', function(event) {
            sel_html = $(this).html();
            $('#blockchain').val($(this).data('val'));
            $('#selected_blockchain').html(sel_html);
        });

        $('#nttsForm').validate({
            rules: {
                dao_name:{
                    required: true
                },
                dao_domain:{
                    required: true
                }
            },
            submitHandler: function(form){
                $(form).ajaxSubmit({
                    type:'post',
                    dataType:'json',
                    success: function(data){
                        if(data.success == true){
                            window.location = data.url;
                        }
                        else{
                            if(data.element == 'dao_domain') {
                                $('#dao_domain-error').html(data.msg);
                                $('#dao_domain-error').show();
                            }
                            else {
                                $('#' + data.element).addClass('form-control-lg error');
                                $('<label class="error">' + data.msg + '</label>').insertAfter('#' + data.element);
                            }
                        }
                    }
                });
            }
        });
    });

</script>
