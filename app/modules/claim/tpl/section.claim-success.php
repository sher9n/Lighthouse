<style>
    .bg-claim-image {
        background-image: url(<?php echo app_cdn_path. $__page->img_url; ?>);
    }
</style>
<div class="container-fluid g-0 h-100">
    <div class="row g-0 h-100">
        <div class="col-lg-6 bg-white">
            <form id="claimForm" method="post" action="claim-reason" autocomplete="off" class="d-flex flex-column h-100">
                <div class="px-26">
                    <div class="display-5 fw-medium mt-25">Your claim has been successfully submitted!</div>
                    <div class="fs-3 mt-12">To view nt<?php echo $__page->com->ticker; ?> in your wallet, add the contract below.</div>
                    <?php  if($__page->solana == false && strlen($__page->com->token_address) > 0){ ?>
                    <div class="mt-12">
                        <button id="btn_add_metamask" type="submit" class="btn btn-primary d-flex align-items-center"><img src="<?php echo app_cdn_path; ?>img/logo-fox.png" class="me-2">Add to Metamask</button>
                    </div>
                    <div class="mt-16">
                        <label for="claimCategorize" class="form-label">Or add ntMyDAO manually:</label>
                        <div class="d-flex align-items-center"><span class="fw-medium fs-3 text-break" id="com_address_div"><?php echo $__page->com->token_address; ?></span><div id="copied_div" trigger="manual" data-placement="top" title="copied!"><i data-feather="copy" id="copy_address" class="ms-3 text-primary"></i></div></div>
                    </div>
                    <?php } ?>
                </div>
                <div class="mt-auto border-top py-5 px-26">
                    <div class="d-flex justify-content-end">
                        <a href="<?php echo app_url; ?>" class="btn btn-dark">Submit NEW Claim</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-6 h-100 d-flex justify-content-center">
            <div class="bg-claim-image"></div> <!-- Full width image -->
            <div class="site-badge d-flex align-items-center">
                <div class="opacity-75 text-white fw-medium">Powered by</div> <img src="<?php echo app_cdn_path; ?>img/logo-text.png" class="ms-2">
            </div>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">

    $(document).ready(function() {

        if (sessionStorage.getItem('lh_claim_send')) {
            sessionStorage.removeItem('lh_claim_send');
            sendNtt();
        }

        $(document).on("click", '#copy_address', function(event) {
            var range = document.createRange();
            range.selectNode(document.getElementById("com_address_div"));
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            document.execCommand("copy");
            window.getSelection().removeAllRanges();
            $('#copied_div').tooltip('show');
        });

        <?php if(strlen($__page->com->token_address) >0){ ?>
        $(document).on("click", '#btn_add_metamask', function(event) {
            event.preventDefault();
            var element = $(this);
            addTokenFunction('<?php echo $__page->com->token_address; ?>','<?php echo $__page->com->ticker; ?>','<?php echo $__page->ticker_image_url; ?>');
        });
        <?php } ?>
    });

    function sendNtt() {
        SnackBar({
            status: "success",
            position: "br",
            icon: "	 ",
            timeout: 50000,
            message: "Success! Your claim has been sent."
        });
    }

    async function addTokenFunction(tokenAddress,tokenSymbol,image_url) {
        try {
            const wasAdded = await ethereum.request({
                method: 'wallet_watchAsset',
                params: {
                    type: 'ERC20',
                    options: {
                        address: tokenAddress,
                        symbol: tokenSymbol,
                        decimals: 18,
                        image: image_url
                    },
                },
            });

        } catch (error) {
            console.log(error);
        }
    }
</script>