<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid">
            <div class="col">
                <div class="card shadow mb-12">
                    <form id="realmSettingsForm" method="post" action="realms-settings" autocomplete="off" class="d-flex flex-column" style="min-height: calc(100vh - 60px);">
                        <div class="card-body p-xl-20 mb-auto">
                            <div class="display-5 fw-medium">SPL Governance Settings</div>
                            <div class="text-muted mt-1">Configure your SPL governance integration</div>
                            <div class="col-xl-7">
                                <label class="form-label mt-10">Realms ID</label>
                                <input type="text" name="realm_id" id="realm_id" class="form-control form-control-lg">
                            </div>
                            <div class="col-xl-7">
                                <label class="form-label mt-10">Setup Scoring</label>
                                <div class="ms-auto">
                                    <label class="switch">
                                        <input type="checkbox" class="setup_scoring form-switch-input" <?php echo (1==1)?'checked':''; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="scoring col-xl-7">
                                <label class="form-label mt-10">For a vote</label>
                                <input type="number" name="for_vote" id="for_vote" class="form-control form-control-lg">
                            </div>
                            <div class="scoring col-xl-7">
                                <label class="form-label mt-10">For a passed proposal</label>
                                <input type="number" name="for_proposal" id="for_proposal" class="form-control form-control-lg">
                            </div>
                            <div class="scoring col-xl-7">
                                <label class="form-label mt-10">For any other proposal</label>
                                <input type="number" name="for_other_proposal" id="for_other_proposal" class="form-control form-control-lg">
                            </div>
                        </div>
                        <div class="border-top d-flex justify-content-end gap-3 py-6 px-18">
                            <button type="submit" id="btn_submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include_once app_root . '/templates/admin-foot.php'; ?>
<script>

    $(document).on('change', '.setup_scoring', function(event) {
        //event.preventDefault();
        if(this.checked)
            $('.scoring').removeClass('fade');
        else
            $('.scoring').addClass('fade');
    });

    $(document).ready(function() {

        $('#realmSettingsForm').validate({
            rules: {
                realm_id:{
                    required: true
                }
            },
            submitHandler: function(form){
                $(form).ajaxSubmit({
                    type:'post',
                    dataType:'json',
                    beforeSend: function() {
                        $('#btn_submit').prop('disabled', true);
                    },
                    success: function(data){
                        $('#btn_submit').prop('disabled', false);
                        if(data.success == true){
                            showMessage('success', 10000, data.message);
                            formClear();
                        }
                        else{
                            if(data.message) {
                                showMessage('danger', 10000, data.message);
                                formClear();
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
    });

    function formClear() {
        $("#contribution_reason").val('');
        $("#tags").val(null).trigger('change');
    }
</script>