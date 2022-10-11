<!-- wallet Modal -->
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
<!--Wallet connect JS-->
<script src="https://unpkg.com/@solana/web3.js@latest/lib/index.iife.js"></script>
<script src="https://unpkg.com/@walletconnect/web3-provider@1.7.1/dist/umd/index.min.js"></script>
<script src="https://cdn.ethers.io/lib/ethers-5.2.umd.min.js" type="application/javascript"></script>

<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/wallet.connect.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/connect.solana.js"></script>
<script>
    if(sessionStorage.getItem('lh_sel_wallet_add')) {

        var APP_ID = "jr6vc5hn";
        var current_user_email = sessionStorage.getItem('lh_sel_wallet_add');
        var current_user_name = sessionStorage.getItem('lh_sel_wallet_add');
        var current_user_id = sessionStorage.getItem('lh_sel_wallet_add');

        window.intercomSettings = {
            app_id: APP_ID,
            name: current_user_name, // Full name
            email: current_user_email, // Email address
            user_id: current_user_id // current_user_id
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
</script>
