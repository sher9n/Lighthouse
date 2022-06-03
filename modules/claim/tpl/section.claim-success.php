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
                    <div class="mt-12">
                        <?php  if($__page->solana == false && strlen($__page->com->token_address) > 0){ ?>
                        <button id="btn_add_metamask" type="submit" class="btn btn-primary d-flex align-items-center"><img src="<?php echo app_cdn_path; ?>img/logo-fox.png" class="me-2">Add to Metamask</button>
                        <?php } ?>
                    </div>
                    <div class="mt-16">
                        <label for="claimCategorize" class="form-label">Or add ntMyDAO manually:</label>
                        <div class="d-flex align-items-center"><span class="fw-medium fs-3 text-break"><?php echo $__page->com->token_address; ?></span><i data-feather="copy" class="ms-3 text-primary"></i></div>
                    </div>
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

        <?php if(strlen($__page->com->token_address) >0){ ?>
        $(document).on("click", '#btn_add_metamask', function(event) {
            event.preventDefault();
            var element = $(this);
            addTokenFunction('<?php echo $__page->com->token_address; ?>','<?php echo $__page->com->ticker; ?>');
        });
        <?php } ?>
    });

    async function addTokenFunction(tokenAddress,tokenSymbol) {
        try {
            const wasAdded = await ethereum.request({
                method: 'wallet_watchAsset',
                params: {
                    type: 'ERC20',
                    options: {
                        address: tokenAddress,
                        symbol: tokenSymbol,
                        decimals: 18,
                        image: '<?php echo app_cdn_path; ?>img/token_image.jpeg',
                    },
                },
            });

            if (wasAdded) {
                console.log('Thanks for your interest!');
            } else {
                console.log('HelloWorld Coin has not been added');
            }
        } catch (error) {
            console.log(error);
        }
    }
</script>