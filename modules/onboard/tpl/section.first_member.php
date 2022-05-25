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
        <a role="button" class="btn btn-back mt-3 ms-3" href="index.html"><img src="<?php echo app_cdn_path; ?>img/arrow-left.png"></a>
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
                            <a role="button" id="add_wallet" onclick="addWallet()" class="btn btn-light mt-6" href="#">Add Wallet</a>
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
        selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");
        if(selectedAccount) {
            $("#sel_wallet_address").html(selectedAccount);
            $("#wallet_address").val(selectedAccount);
            $('#add_wallet').html('CHANGE WALLET')
        }

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
</script>
