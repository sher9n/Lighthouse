<main>
    <aside class="left-aside">
        <div>
            <img src="img/logo.svg" >
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
        <form id="nttsForm" method="post" action="onboard" autocomplete="off">
            <div class="container-fluid">
                <div class="row justify-content-lg-center">
                    <div class="col-lg-7">
                        <div class="display-5 fw-medium mt-25">Become the first member</div>
                        <div class="text-muted mt-1">Add the first member that can distribute NTTs and approve claims</div>
                        <div class="mt-23">
                            <label for="DisplayName" class="form-label">Display name</label>
                            <input type="text" class="form-control form-control-lg mb-6" id="DisplayName" placeholder="Bob">
                            <div class="fs-3 fw-semibold mb-3 fade"></div>
                            <a role="button" class="btn btn-light" href="#">Add Wallet</a>
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
