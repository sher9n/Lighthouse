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
                        </div>
                        <div class="mt-16">
                            <label for="DisplayName" class="form-label">Wallet address</label>
                            <input type="text" class="form-control form-control-lg" name="wallet_address" id="wallet_address">
                            <?php if($__page->solana == true){ ?>
                                <a role="button" id="add_wallet" onclick="getSolanaAccount()" class="btn btn-light mt-6" href="#">Add Wallet</a>
                            <?php }else{ ?>
                                <a role="button" id="add_wallet" class="add_wallet btn btn-light mt-6" href="#">Add Wallet</a>
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
    <div class="modal fade" id="NttsGetting" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content pb-16 text-center">
                <img src="<?php echo app_cdn_path; ?>img/anim-ntts-create.gif"  width="180" height="180" class="align-self-center">
                <div class="fs-2 fw-semibold text-center">Creating your NTT contracts...</div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="NttsSccess" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content pb-16 text-center">
                <img src="<?php echo app_cdn_path; ?>img/anim-please-wait.gif" width="180" height="180" class="align-self-center">
                <div class="fs-2 fw-semibold text-center">Contracts created</div>
                <div class="d-flex align-items-center justify-content-center mt-3">
                    <div id="com_address_div" class="text-break"></div>
                    <div id="copied_div" trigger="manual" data-placement="top" title="copied!"><i data-feather="copy" id="copy_address" class="ms-3 text-primary cursor-pointer"></i></div>
                </div>
                <div class="mt-16 d-flex justify-content-center gap-3">
                    <button type="button" id="btn_next" class="btn btn-dark px-10">NEXT</button>
                    <button type="button" data-image_url="" data-token="" data-symbol="" id="btn_add_metamask" class="btn btn-primary d-flex align-items-center"><img src="<?php echo app_cdn_path; ?>img/logo-fox.png" class="me-2">Add to Metamask</button>
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
            $("#wallet_address").val(selectedAccount);
            $('.add_wallet').html('CHANGE WALLET');
        }

        $(document).on("click", '.add_wallet', function(event) {
            $('#wallet').modal('show');
        });

        $(document).on("click", '#copy_address', function(event) {
            var range = document.createRange();
            range.selectNode(document.getElementById("com_address_div"));
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            document.execCommand("copy");
            window.getSelection().removeAllRanges();
            $('#copied_div').tooltip('show');
        });

        $(document).on("click", '#btn_next', function(event) {
            event.preventDefault();
            var element = $(this);
            window.location = 'distribution';
            $('#NttsSccess').modal('hide');
        });


        $(document).on("click", '#btn_add_metamask', function(event) {
            event.preventDefault();
            var element = $(this);
            addTokenFunction(element.data('token'),element.data('symbol'),element.data('image_url'));
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
                $('#NttsGetting').modal('show');
                $(form).ajaxSubmit({
                    type:'post',
                    dataType:'json',
                    success: function(data){
                        if(data.success == true){
                            if(data.blockchain == 'gnosis_chain') {
                                $('#btn_add_metamask').data('symbol',data.symbol);
                                $('#btn_add_metamask').data('image_url',data.image_url);
                                var url = "https://lighthouse-poc-seven.vercel.app/api/contractsAPI?key=<?php echo API_KEY;?>";
                                var xhr = new XMLHttpRequest();
                                xhr.open("POST", url);
                                xhr.setRequestHeader("accept", "application/json");
                                xhr.setRequestHeader("Content-Type", "application/json");
                                xhr.onreadystatechange = function () {
                                    if (xhr.readyState === 4) {
                                        if (xhr.status == 200) {
                                            obj = JSON.parse(xhr.responseText);
                                            updatecontractAddress(obj);
                                            $('#btn_add_metamask').data('token',obj.tokenAddress);
                                            $('#com_address_div').html(obj.tokenAddress);
                                            $('#NttsGetting').modal('hide');
                                            $('#NttsSccess').modal('show');
                                        }
                                    }
                                };
                                var data = `{"initialAdmin": "` + data.wallet_adr + `","contractName": "` + data.dao_domain + `","tokenName": "` + data.dao_domain + `","tokenSymbol": "` + data.symbol + `","tokenDecimals": "` + data.decimal + `","tankTopUpAmount": "`+ 0.0008 + `"}`;

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

    function copy_contract(containerid) {
        if (document.selection) {
            var range = document.body.createTextRange();
            range.moveToElementText(document.getElementById(containerid));
            range.select().createTextRange();
            document.execCommand("copy");
        } else if (window.getSelection) {
            var range = document.createRange();
            range.selectNode(document.getElementById("com_address-div"));
            window.getSelection().addRange(range);
            document.execCommand("copy");
        }
    }

    async function updatecontractAddress(obj) {
        var data = {'token_address': obj.tokenAddress,'community_address': obj.communityAddress,'gas_address':obj.gasTankInfo.address,'gas_private_key':obj.gasTankInfo.privateKey};
        $.ajax({
            url: 'update-contract-address',
            dataType: 'json',
            data: data,
            type: 'POST'
        });
    }

    async function addTokenFunction(tokenAddress,tokenSymbol,image) {
        try {
            const wasAdded = await ethereum.request({
                method: 'wallet_watchAsset',
                params: {
                    type: 'ERC20',
                    options: {
                        address: tokenAddress,
                        symbol: tokenSymbol,
                        decimals: 18,
                        image: image,
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
