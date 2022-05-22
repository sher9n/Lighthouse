<main>
    <aside class="left-aside">
        <div>
            <img src="img/logo.svg" >
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
                    <div class="col-lg-7">
                        <div class="display-5 fw-medium mt-25">Create your NTTs</div>
                        <div class="text-muted mt-1">Make your scoring system your own</div>
                            <div class="mt-23">
                                <label for="DAOName" class="form-label">What’s your community or DAO’s name?</label>
                                <input type="text" class="form-control form-control-lg" name="dao_name" id="dao_name" placeholder="MyDAO">
                                <div class="invalid-feedback">This name is already taken. Please try a different name.</div>
                            </div>
                            <div class="mt-16">
                                <label for="DAOName" class="form-label">What would you like your subdomain to be?</label>
                                <div class="input-group input-group-lg mb-3">
                                    <input type="text" class="form-control form-control-lg" name="dao_domain" id="dao_domain" placeholder="MyDAO">
                                    <span class="input-group-text fw-medium" id="">.lighthouse.xyz</span>
                                </div>
                                <label id="dao_domain-error" class="error" style="display: none;" for="dao_domain"></label>
                            </div>
                            <div class="mt-16">
                                <label for="Blockchain" class="form-label">Which blockchain would you like to issue your NTTs on?</label>
                                <select class="form-select form-select-lg" name="blockchain" id="blockchain">
                                    <option value="GnosisChain" selected>Gnosis Chain</option>
                                    <option value="Solana">Solana</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mt-16">
                                <label for="NTTCurrency" class="form-label">What ticker do you want to use for your NTT?</label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text fw-medium" id="">nt</span>
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
        $(document).on("focusout", '#dao_name,#dao_domain', function(event) {
            var dao_name = $(this).val();
            $.ajax({
                url: 'check-dao-domain',
                data: {'dao_name':dao_name},
                dataType: 'json',
                success: function(data) {
                    $('#dao_domain').val(data.sub_domain);
                    if (data.success == false){
                        $('#dao_domain-error').html(data.msg);
                        $('#dao_domain-error').show();
                    }
                }
            });
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
                            $('#'+data.element).addClass('form-control-lg error');
                            $('<label class="error">'+data.msg+'</label>').insertAfter('#'+data.element);
                        }
                    }
                });
            }
        });
    });
</script>
