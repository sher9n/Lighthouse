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
        <!-- <div class="d-flex justify-content-between"> -->
            <div class="fs-2 fw-semibold mb-22 mt-3">Select the chain you want<br> to launch on</div>
            <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> -->
        <ui class="list-wallet">
            <li class="list-wallet-item rounded border">
                <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" onclick="getSolanaAccount()" id="solana_connect" href="#">
                    <span class="fs-3">Solana</span>
                    <img src="<?php echo app_cdn_path; ?>img/solana-sol-logo.png"  width="40" height="40" class="">
                </a>
            </li>
            <li class="list-wallet-item rounded border">
                <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" id="gnosis_connect" href="#">
                    <span class="fs-3">Gnosis</span>
                    <img src="<?php echo app_cdn_path; ?>img/gnosis-chain-logo.png"  width="40" height="40" class="">
                </a>
            </li>
        </ui>       
      </div>
    </div>
  </div>
</div>
<!-- Modal Connect Wallet-->
<div class="modal fade" id="connectWallet" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-size-01">
    <div class="modal-content">
      <div class="modal-body p-10">
        <!--<div class="d-flex justify-content-between"> -->
            <div class="fs-2 fw-semibold mb-22 mt-3">Connect your wallet</div>
            <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>  -->
        <ui class="list-wallet">
            <li class="list-wallet-item rounded border">
                <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" href="#">
                    <span class="fs-3">MetaMask</span>
                    <img src="<?php echo app_cdn_path; ?>img/metamast-logo.svg"  width="40" height="40" class="">
                </a>
            </li>
            <li class="list-wallet-item rounded border">
                <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" href="#">
                    <span class="fs-3">WalletConnect</span>
                    <img src="<?php echo app_cdn_path; ?>img/walletconnect-logo.svg"  width="40" height="40" class="">
                </a>
            </li>
        </ui>
      </div>
    </div>
  </div>
</div>
<!-- Modal Connect Wallet Phantom -->
<!--<div class="modal fade" id="connectWalletPhantom" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-size-01">
    <div class="modal-content">        
      <div class="modal-body p-10">
        <div class="fs-2 fw-semibold mb-22 mt-3">Connect your wallet</div>
        <ui class="list-wallet">
            <li class="list-wallet-item rounded border">
                <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" href="#">
                    <span class="fs-3">Phantom</span>
                    <img src="<?php /*echo app_cdn_path; */?>img/phantom-logo.svg"  width="40" height="40" class="">
                </a>
            </li>
        </ui>       
      </div>
    </div>
  </div>
</div>-->
<!-- Modal Setup community -->
<div class="modal fade" id="setupCommunity" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-02">
        <div class="modal-content">
            <form id="communityForm" method="post" action="onboard" autocomplete="off">
                <input type="hidden" id="blockchain_hidden" name="blockchain" value="<?php echo SOLANA; ?>">
                <input type="hidden" class="form-control form-control-lg" name="wallet_address" id="wallet_address">
                <div class="modal-body p-10">
                    <div class="fs-2 fw-semibold mb-22 mt-3">Setup your community</div>
                    <div class="mb-16">
                        <label for="" class="form-label">Community name?</label>
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
                </div>
                <div class="modal-footer pe-10">
                    <button type="submit" class="btn btn-primary m-0">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script>
    $(window).on('load', function() {
        $('#selectChain').modal('show');
    });

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
                }
            }
        });
    });

    $(document).on("keyup", '#dao_name', function(event) {
        var dao_name = $(this).val();
        dao_name = dao_name.replace(/\s+/g, '-');
        $('#dao_domain').val(dao_name.toLowerCase());
    });

    $(document).on("click", '#gnosis_connect', function(event) {
        event.preventDefault();
        $('#blockchain_hidden').val('<?php echo GNOSIS_CHAIN; ?>');
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
            }
        },
        submitHandler: function(form){
            $(form).ajaxSubmit({
                type:'post',
                dataType:'json',
                success: function(data){
                    if(data.success == true){
                        window.location.replace(data.url);
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
</script>