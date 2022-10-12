<!-- wallet Modal -->
<!--<div class="modal fade" id="admin_wallet" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content p-2">
            <a class="text-center link-modal" href="#" onclick="changeToEth()">
                <img src="<?php /*echo app_cdn_path; */?>img/metamast-logo.svg" height="42">
                <div class="modal-provider-name">MetaMask</div>
                <div type="button" class="modal-provider-description">Connect to your MetaMask Wallet</div>
            </a>
            <hr class="dropdown-divider">
            <a class="text-center link-modal" href="#" onclick="changeToWCEth()">
                <img src="<?php /*echo app_cdn_path; */?>img/walletconnect-logo.svg" height="42">
                <div class="modal-provider-name">WalletConnect</div>
                <div type="button" class="modal-provider-description">Scan with WalletConnect to connect</div>
            </a>
        </div>
    </div>
</div>-->
<!--<div class="modal fade" id="wallet" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content p-2">
            <a class="text-center link-modal" href="#" onclick="connectToEth('<?php /*echo $__page->blockchain; */?>')">
                <img src="<?php /*echo app_cdn_path; */?>img/metamast-logo.svg" height="42">
                <div class="modal-provider-name">MetaMask</div>
                <div type="button" class="modal-provider-description">Connect to your MetaMask Wallet</div>
            </a>
            <hr class="dropdown-divider">
            <a class="text-center link-modal" href="#" onclick="connectToWCEth('<?php /*echo $__page->blockchain; */?>')">
                <img src="<?php /*echo app_cdn_path; */?>img/walletconnect-logo.svg" height="42">
                <div class="modal-provider-name">WalletConnect</div>
                <div type="button" class="modal-provider-description">Scan with WalletConnect to connect</div>
            </a>
        </div>
    </div>
</div>-->
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/select2.full.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/js-snackbar.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/daterangepicker.min.js"></script>

<!--Wallet connect JS-->
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/web3/index.iife.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/web3/index.min.js"></script>
<script type="application/javascript" src="<?php echo local_cdn_path; ?>js/web3/ethers-5.2.umd.min.js" ></script>
<script src="<?php echo local_cdn_path; ?>js/web3/web3.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/wallet.connect.admin.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/connect-solana.admin.js"></script>
<script>

    if(sessionStorage.getItem('lh_sel_wallet_add')) {

        var APP_ID = "jr6vc5hn";
        var current_user_email = sessionStorage.getItem('lh_sel_wallet_add');
        var current_user_name = sessionStorage.getItem('lh_sel_wallet_add');
        var current_user_id = sessionStorage.getItem('lh_sel_wallet_add');
        var user_role = sessionStorage.getItem('lh_wallet_role');

        window.intercomSettings = {
            app_id: APP_ID,
            name: current_user_name, // Full name
            email: current_user_email, // Email address
            user_id: current_user_id, // current_user_id,
            role: user_role
        };

        /*window.intercomSettings = {
            api_base: "https://api-iam.intercom.io",
            app_id: "jr6vc5hn",
            name: sessionStorage.getItem('lh_sel_wallet_add'),
            created_at: "<?php echo time(); ?>" // Signup date as a Unix timestamp
        };*/
    }
    else {
        //Set your APP_ID
        var APP_ID = "jr6vc5hn";

        window.intercomSettings = {
            app_id: APP_ID
        };
    }

    (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/jr6vc5hn';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<?php
foreach ($__page->js as $page_js) { ?>
    <script type="text/javascript" src="<?php echo $page_js; ?>"></script>
    <?php
}
?>
<script>

    function showMessage(status,time,message) {
        SnackBar({
            status: status,
            position: "tr",
            icon: "	 ",
            timeout: time,
            message: message
        });
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function disconnectWallet() {
        $.ajax({
            url: 'disconnect_wallet',
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                if (response.success == true) {
                    if(response.solana == true)
                        disconnectAccount();
                    else
                        onDisconnect();
                    window.location = 'admin';
                }
            }
        });
    }

    $(document).on("click", '#disconnect_wallet', function(event) {
        event.preventDefault();
        disconnectWallet();
    });

    $(document).on("click", '#reputation_ntts', function(event) {
        event.preventDefault();
        $("#ModalConsent").modal('show');
    });

    $(document).on('click','.btn_consent',function (e){
        e.preventDefault();
        var ele = $(this);
        var consent = ele.data('consent');
        $.ajax({
            url: 'ntt-consent',
            dataType: 'json',
            data: {'wallet_address':selectedAccount,'consent':consent},
            type: 'post',
            beforeSend: function () {
                showMessage('success', 10000, 'Please sign the transaction to record your consent.');
            },
            success: function(data) {
                if (data.success == true){
                    $("#consent_div").addClass('d-none');

                    if(data.api_response) {
                        const response = solanaProposalTransaction(data.api_response);
                        response.then(function (data) {
                            $("#li_ntt_consent").remove();
                            showMessage('success', 10000, 'Success! You will now start receiving NTTs to your wallet.');
                        });
                    }
                }
                else
                    showMessage('danger', 10000, data.msg);
            }
        });
    });

    $(document).ready(function() {
       <?php
        if(__ROUTER_PATH != '/admin'){ ?>
            getSolanaAccount(false);
            <?php
        } ?>
    });
</script>

<!--intercom custom scripts-->
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/intercom-style.js"></script>
