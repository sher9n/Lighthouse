<main>
    <!-- Modal backbround image -->
    <div class="modal-background"></div>
    <!-- Modal backbround image END -->
</main>
<!-- Modal Select Chain-->
<div class="modal fade" id="selectChain" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-01">
        <div class="modal-content">
            <div class="modal-body p-10">
                <div class="fs-2 fw-semibold mb-22 mt-3">Connect your wallet</div>
                <ui class="list-wallet">
                    <li class="list-wallet-item rounded border">
                        <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" onclick="getSolanaAccount()"  href="#">
                            <span class="fs-3">Phantom</span>
                            <img src="<?php echo app_cdn_path; ?>img/phantom-logo.svg"  width="40" height="40" class="">
                        </a>
                    </li>
                </ui>
            </div>
        </div>
    </div>
</div>
<!--<div class="modal fade" id="wallet" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content p-2">
            <a class="text-center link-modal" id="meta_click" href="#">
                <img src="<?php /*echo app_cdn_path; */?>img/metamast-logo.svg" height="42">
                <div class="modal-provider-name">MetaMask</div>
                <div type="button" class="modal-provider-description">Connect to your MetaMask Wallet</div>
            </a>
            <hr class="dropdown-divider">
            <a class="text-center link-modal" id="wallet_click" href="#">
                <img src="<?php /*echo app_cdn_path; */?>img/walletconnect-logo.svg" height="42">
                <div class="modal-provider-name">WalletConnect</div>
                <div type="button" class="modal-provider-description">Scan with WalletConnect to connect</div>
            </a>
        </div>
    </div>
</div>-->
<div class="modal fade" id="setupCommunity" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-02">
        <div class="modal-content">
            <form id="communityForm" method="post" action="onboard" autocomplete="off">
                <input type="hidden" id="blockchain_hidden" name="blockchain" value="<?php echo SOLANA; ?>">
                <input type="hidden" class="form-control form-control-lg" name="wallet_address" id="wallet_address">
                <div class="modal-body p-10">
                    <div class="fs-2 fw-semibold mb-22 mt-3">Setup your Lighthouse</div>
                    <div class="mb-16">
                        <label for="" class="form-label">Community name</label>
                        <input type="text" class="form-control form-control-lg" name="dao_name" id="dao_name" placeholder="MyDAO">
                    </div>
                    <div class="mb-16">
                        <label for="DAOName" class="form-label">Subdomain</label>
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control form-control-lg" name="dao_domain" id="dao_domain" placeholder="MyDAO">
                            <span class="input-group-text fw-medium" id="">.lighthouse.xyz</span>
                         </div>
                        <label id="dao_domain-error" class="error" style="display: none;" for="dao_domain"></label>
                    </div>
                    <div class="mb-16">
                        <label for="n_t_token" class="form-label">Non-transferrable reputation token</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text fw-medium input-group-span" id="">$rep</span>
                            <input type="text" class="form-control form-control-lg text-uppercase" name="n_t_token" id="n_t_token" placeholder="Token">
                         </div>
                        <label id="n_t_token-error" class="error" style="display: none;" for="n_t_token"></label>
                    </div>
                </div>
                <div class="modal-footer pe-10">
                    <button type="submit" id="btn_submit" class="btn btn-primary m-0">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script>
    var m1,m2,m3,m4;

    $(window).on('load', function() {
        $('#selectChain').modal('show');
    });

    $(document).on("keyup", '#dao_domain', delay(function(event) {
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
                    $('#dao_domain-error').hide();
                }
            }
        });
    },400));

    $(document).on("keyup", '#dao_name', delay(function(event) {
        var dao_name = $(this).val();
        dao_domain = dao_name.replace(/\s+/g, '-');
        dao_domain = dao_domain.toLowerCase();
        $('#dao_domain').val(dao_domain);
        $('#n_t_token').val(dao_domain);
        
            $.ajax({
                url: 'check-dao-domain',
                data: {'dao_name': dao_domain},
                dataType: 'json',
                success: function (data) {
                    if (data.success == false) {
                        $('#dao_domain-error').html(data.msg);
                        $('#dao_domain-error').show();
                    } else {
                        $('#dao_domain').val(data.sub_domain);
                        $('#dao_domain-error').hide();
                    }
                }
            });
    },400));

    $(document).on("click", '#meta_click', function(event) {
        event.preventDefault();
        blockchain =  $('#blockchain_hidden').val();
        connectToEth(blockchain);
    });

    $(document).on("click", '#wallet_click', function(event) {
        event.preventDefault();
        blockchain =  $('#blockchain_hidden').val();
        connectToWCEth(blockchain);
    });

    $(document).on("click", '#gnosis_connect', function(event) {
        event.preventDefault();
        $('#blockchain_hidden').val('<?php echo GNOSIS_CHAIN; ?>');
        $('#selectChain').modal('hide');
        $('#wallet').modal('show');
    });

    $(document).on("click", '#optimism_connect', function(event) {
        event.preventDefault();
        $('#blockchain_hidden').val('<?php echo OPTIMISM; ?>');
        $('#selectChain').modal('hide');
        $('#wallet').modal('show');
    });

    $('#communityForm').validate({
        rules: {
            dao_name:{
                required: true
            },
            dao_domain:{
                required: true
            },
            n_t_token:{
                required: true
            }
        },
        submitHandler: function(form){
            $(form).ajaxSubmit({
                type:'post',
                dataType:'json',
                beforeSend: function () {
                    $('#btn_submit').prop('disabled', true);
                    $('#dao_name').prop('disabled', true);
                    $('#dao_domain').prop('disabled', true);
                    $('#btn_submit').html('Creating...');
                    showMessage('success', 10000, 'Starting the engines..');
                   m1 = setTimeout(function() {showMessage('success', 10000, 'Initiating smart contracts...');}, 2000);
                   m2 = setTimeout(function() {showMessage('success', 10000, 'Writing transactions...');}, 6000);
                   m3 = setTimeout(function() {showMessage('success', 10000, 'Creating forms...');}, 9000);
                   m4 = setTimeout(function() {showMessage('success', 10000, 'Finalizing your community...');}, 12000);
                },
                success: function(data){
                    if(data.success == true){
                        window.location.replace(data.url);
                    }
                    else
                    {
                        clearTimeout(m1);
                        clearTimeout(m2);
                        clearTimeout(m3);
                        clearTimeout(m4);
                        $('#btn_submit').prop('disabled', false);
                        $('#dao_name').prop('disabled', false);
                        $('#dao_domain').prop('disabled', false);
                        $('#btn_submit').html('Create');
                        if(data.element) {
                            if (data.element == 'dao_domain') {
                                $('#dao_domain-error').html(data.msg);
                                $('#dao_domain-error').show();
                            } else {
                                $('#' + data.element).addClass('form-control-lg error');
                                $('<label class="error">' + data.msg + '</label>').insertAfter('#' + data.element);
                            }
                        }
                        else
                            showMessage('danger', 10000, data.msg);
                    }
                }
            });
        }
    });

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

</script>