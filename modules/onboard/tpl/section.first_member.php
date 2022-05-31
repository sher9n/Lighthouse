<main>
    <aside class="left-aside">
        <div>
            <img src="<?php echo app_cdn_path; ?>img/logo.png" >
        </div>
        <div class="steps-wrapper">
            <ul class="nav-steps">
                <li class="nav-steps-item">
                    <a href="#" class="nav-steps-link">Create Your NTTs</a>
                </li>
                <li class="nav-steps-item active">
                    <a href="#" class="nav-steps-link">Become the First Member</a>
                </li>
                <li class="nav-steps-item">
                    <a href="#" class="nav-steps-link">Your First Distribution</a>
                </li>
            </ul>
        </div>
    </aside>
    <section class="body-section">
        <a role="button" class="btn btn-back mt-3 ms-3" href="/"><img src="<?php echo app_cdn_path; ?>img/arrow-left.png"></a>
        <form id="nttsForm" method="post" action="first-member" autocomplete="off">
            <div class="container-fluid">
                <div class="row justify-content-lg-center">
                    <div class="col-xl-7">
                        <div class="display-5 fw-medium mt-25">Become the first member</div>
                        <div class="text-muted mt-1">Add the first member that can distribute NTTs and approve claims</div>
                        <div class="mt-23">
                            <label for="DisplayName" class="form-label">Display name</label>
                            <input type="text" class="form-control form-control-lg" name="display_name" id="display_name" placeholder="Bob">
                            <input type="hidden" class="form-control form-control-lg" name="wallet_address" id="wallet_address">
                            <div id="sel_wallet_address" class="fs-3 fw-semibold mt-6 text-break"></div>
                            <?php if($__page->solana == true){ ?>
                                <a role="button" id="add_wallet" onclick="getSolanaAccount()" class="btn btn-light mt-6" href="#">Add Wallet</a>
                            <?php }else{ ?>
                                <a role="button" id="add_wallet" onclick="addWallet()" class="btn btn-light mt-6" href="#">Add Wallet</a>
                            <?php } ?>
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
    <div class="modal show" id="NttsGetting" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="<?php echo app_cdn_path; ?>img/anim-please-wait.gif" height="180">
                    <div class="fs-2 fw-semibold mt-15">Please wait...</div>
                    <div class="fw-medium mt-3">Your NTTs are getting created.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal show" id="NttsSccess" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="<?php echo app_cdn_path; ?>img/amin-ntts-sent.gif" height="180">
                    <div class="fs-2 fw-semibold mt-15">Yay!</div>
                    <div class="fw-medium mt-3">Your NTT contract has been created.</div>
                    <a type="button" id="btn_success" href="#" class="btn btn-primary mt-20 px-10">Okay</a>
                    <a type="button" data-token="" data-symbol="" id="btn_add_metamask" href="#" class="btn btn-primary mt-20 px-10">Add to MetaMask</a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");
        if(selectedAccount) {
            $("#sel_wallet_address").html(selectedAccount);
            $("#wallet_address").val(selectedAccount);
            $('#add_wallet').html('CHANGE WALLET');
        }

        $(document).on("click", '#btn_success', function(event) {
            event.preventDefault();
            var element = $(this);
            window.location = 'distribution';
            $('#NttsSccess').modal('hide');
        });

        $(document).on("click", '#btn_add_metamask', function(event) {
            event.preventDefault();
            var element = $(this);
            addTokenFunction(element.data('token'),element.data('symbol'));
        });

        $('#nttsForm').validate({
            rules: {
                display_name:{
                    required: true
                },
                wallet_address:{
                    required: true
                }
            },
            submitHandler: function(form){

                $(form).ajaxSubmit({
                    type:'post',
                    dataType:'json',
                    success: function(data){
                        if(data.success == true){
                            if(data.blockchain == 'gnosis_chain') {
                                $('#btn_add_metamask').data('token',data.wallet_adr);
                                $('#btn_add_metamask').data('symbol',data.symbol);
                                $('#NttsGetting').modal('show');
                                var url = "https://lighthouse-poc-seven.vercel.app/api/contractsAPI?key=8ccbb99eba0d3d12ca9ed97c6142f411db813064f5593cdf407bc7cb4ae6d4a8";
                                var xhr = new XMLHttpRequest();
                                xhr.open("POST", url);
                                xhr.setRequestHeader("accept", "application/json");
                                xhr.setRequestHeader("Content-Type", "application/json");
                                xhr.onreadystatechange = function () {
                                    if (xhr.readyState === 4) {
                                        if (xhr.status == 200) {
                                            obj = JSON.parse(xhr.responseText);
                                            updatecontractAddress(obj.contractAddress);
                                            $('#NttsGetting').modal('hide');
                                            $('#NttsSccess').modal('show');
                                        }
                                    }
                                };
                                var data = `{"initialAdmin": "` + data.wallet_adr + `","contractName": "` + data.dao_domain + `","tokenName": "` + data.dao_domain + `","tokenSymbol": "` + data.symbol + `","tokenDecimals": "` + data.decimal + `"}`;
                                xhr.send(data);
                            }
                            else
                                window.location = data.url;
                        }
                        else{
                            $('#'+data.element).addClass('form-control-lg error');
                            $('<label class="error">'+data.msg+'</label>').insertAfter('#'+data.element);
                        }
                    }
                });
            }
        });
    });

    async function updatecontractAddress(adr) {
        var data = {'adr': adr};
        $.ajax({
            url: 'update-contract-address',
            dataType: 'json',
            data: data,
            type: 'POST'
        });
    }

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
