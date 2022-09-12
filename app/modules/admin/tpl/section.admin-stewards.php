<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card shadow" style="min-height: calc(100vh - 60px);">
                        <div class="card-body p-xl-20">
                            <div class="display-5 fw-medium">Manage stewards</div>
                            <div class="text-muted mt-1">Add or remove stewards and set multisig parameters</div>
                            <div class="fw-medium mt-16">Quorum</div>
                            <button type="button" id="percentage_change" class="btn btn-primary mt-6" data-bs-toggle="modal" data-bs-target="#ModalChange">Propose new quorum</button>
                            <div class="d-flex align-items-center mt-4">
                                <div id="steward_percentage" class="d-flex align-items-center fw-medium text-gray-700">
                                    <div class="fs-1"><?php echo $__page->approval_count.'</div><div class="fs-2">/'.$__page->stewardCount; ?></div>
                                </div>
                            </div>
                            <div class="fw-medium mt-16">Stewards</div>
                            <a type="button" class="btn btn-primary mt-6" href="#" data-bs-toggle="modal" data-bs-target="#addMember">Propose new steward</a>
                            <?php if($__page->blockchain == SOLANA){ ?>
                                <div class="mt-26" id="pending_steward_list">
                                    <?php
                                    foreach ($__page->stewards as $steward){
                                        if($steward['praposal_passed'] == 0){ ?>
                                        <div class="mb-8">
                                            <div class="stew-<?php echo $steward['id']; ?> fw-medium text-muted"><?php echo $steward['name']; ?> </div>
                                            <div class="stew-<?php echo $steward['id']; ?> d-flex align-items-center mt-1">
                                                <div>
                                                    <div class="fs-3 fw-semibold me-6"><?php echo $steward['wallet_adr']; ?></div>
                                                    <script>

                                                        var countDownDate_<?php echo $steward['id']; ?> = new Date("<?php echo date('Y-m-d H:i:s',strtotime($steward['c_at'] .' +'.($__page->maxVotingTime/86400).' days')); ?>").getTime();

                                                        var x_<?php echo $steward['id']; ?> = setInterval(function() {

                                                            var now = new Date().getTime();
                                                            var distance_<?php echo $steward['id']; ?> = countDownDate_<?php echo $steward['id']; ?> - now;
                                                            var hours_<?php echo $steward['id']; ?> = Math.floor((distance_<?php echo $steward['id']; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                            var minutes_<?php echo $steward['id']; ?> = Math.floor((distance_<?php echo $steward['id']; ?> % (1000 * 60 * 60)) / (1000 * 60));
                                                            var seconds_<?php echo $steward['id']; ?> = Math.floor((distance_<?php echo $steward['id']; ?> % (1000 * 60)) / 1000);

                                                            if (countDownDate_<?php echo $steward['id']; ?> < now) {
                                                                clearInterval(x_<?php echo $steward['id']; ?>);
                                                                $(".end_time_<?php echo $steward['id']; ?>").html("EXPIRED");
                                                            }
                                                            else {
                                                                $(".end_time_<?php echo $steward['id']; ?>").html("Approval period ends in " + hours_<?php echo $steward['id']; ?> + "h "
                                                                    + minutes_<?php echo $steward['id']; ?> + "m " + seconds_<?php echo $steward['id']; ?> + "s ");
                                                            }
                                                        }, 1000);
                                                    </script>
                                                    <div class="d-flex align-items-center text-blue-stone">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                        <div class="fw-medium ms-2 end_time_<?php echo $steward['id']; ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <?php $praposal_adr = $steward['praposal_adr']; ?>
                                                    <a type="button" class="btn btn-primary" target="_blank" href="https://solscan.io/account/<?php echo $praposal_adr; ?>">View Proposal</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }
                                    } ?>
                                </div>
                                <div class="mt-26" id="steward_list">
                                    <?php
                                    foreach ($__page->stewards as $steward){
                                        if($steward['praposal_passed'] == 1){ ?>
                                        <div class="mb-8">
                                            <div class="stew-<?php echo $steward['id']; ?> fw-medium text-muted"><span><?php echo $steward['name']; ?></span><a class="fw-medium text-decoration-none text-primary ms-3 edit_steward" data-sadr="<?php echo $steward['wallet_adr']; ?>" data-sid="<?php echo $steward['id']; ?>" data-sname="<?php echo $steward['name']; ?>" data-bs-toggle="modal" data-bs-target="#editSteward"href="#">Edit > </a></div>
                                            <div class="stew-<?php echo $steward['id']; ?> d-flex align-items-center">
                                                <div class="fs-3 fw-semibold me-6"><?php echo $steward['wallet_adr']; ?></div>
                                                <!-- <a class="del_steward" href="delete-stewards?id=<?php echo $steward['id'];?>&adr=<?php echo $steward['wallet_adr']; ?>" data-bs-toggle="modal" data-bs-target="#delMember">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                </a> -->
                                            </div>
                                        </div>
                                        <?php }
                                    }?>
                                </div>
                            <?php }else{ ?>
                                <div class="mt-26" id="steward_list">
                                    <?php
                                    foreach ($__page->stewards as $steward){ ?>
                                            <div class="mb-8">
                                                <div class="stew-<?php echo $steward['id']; ?> fw-medium text-muted"><span><?php echo $steward['name']; ?></span><a class="fw-medium text-decoration-none text-primary ms-3 edit_steward" data-sadr="<?php echo $steward['wallet_adr']; ?>" data-sid="<?php echo $steward['id']; ?>" data-sname="<?php echo $steward['name']; ?>" data-bs-toggle="modal" data-bs-target="#editSteward" href="#">Edit > </a></div>
                                                <div class="stew-<?php echo $steward['id']; ?> d-flex align-items-center">
                                                    <div class="fs-3 fw-semibold me-6"><?php echo $steward['wallet_adr']; ?></div>
                                                    <!-- <a class="del_steward" href="delete-stewards?id=<?php echo $steward['id'];?>&adr=<?php echo $steward['wallet_adr']; ?>" data-bs-toggle="modal" data-bs-target="#delMember">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                </a> -->
                                                </div>
                                            </div>
                                        <?php
                                    } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Modal Add new member -->
<div class="modal fade" id="addMember" tabindex="-1" aria-labelledby="addMemberLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="addStewardsForm" method="post" action="add-stewards" autocomplete="off">
                <div class="modal-body">
                    <div class="fs-2 fw-semibold mb-15">Propose new steward </div>
                    <label for="Nickname" class="form-label">Display name</label>
                    <input type="text" class="form-control form-control-lg" name="nickname" id="nickname" placeholder="Bob">
                    <label for="WalletAddress" class="form-label mt-16">Wallet address</label>
                    <input type="text" class="form-control form-control-lg" name="wallet_address" id="wallet_address" placeholder="0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507">
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_cancel" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="btn_save"  class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Edit steward -->
<div class="modal fade" id="editSteward" tabindex="-1" aria-labelledby="editStewardLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editStewardForm" method="post" action="edit-steward" autocomplete="off">
                <div class="modal-body">
                    <div class="fs-2 fw-semibold mb-15">Edit steward</div>
                    <label for="displayName" class="form-label">Display name</label>
                    <input type="hidden" name="e_steward_id" id="e_steward_id">
                    <input type="text" class="form-control form-control-lg" name="e_display_name" id="e_display_name" placeholder="Bob">
                    <label for="walletAddress" class="form-label mt-16">Wallet address</label>
                    <input type="text" class="form-control form-control-lg" readonly name="e_wallet_address" id="e_wallet_address" placeholder="0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507">
                </div>
                <div class="modal-footer">
                    <button type="button" id="e_btn_cancel" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="e_btn_save"  class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal delete member -->
<div class="modal fade" id="delMember" tabindex="-1" aria-labelledby="delMemberLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
          <form id="user-deleteForm" method="post" action="#" autocomplete="off">
            <div class="fs-2 fw-semibold mb-3">Hey, wait!</div>
            <div class="fw-medium mb-16">Are you sure you want to delete this wallet address?</div>
            <button type="button" class="btn btn-white me-1" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
      </div>      
    </div>
  </div>
</div>
<!-- Modal Change -->
<div class="modal fade" id="ModalChange" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <form id="stewardForm" method="post" action="steward-percentage" autocomplete="off">
          <div class="modal-body">
            <div class="fs-2 fw-semibold mb-15">Select quorum</div>            
            <label for="basic-url" class="form-label">Quorum</label>
            <div class="col-6">
                <div class="input-group">
                    <input type="text" id="steward_range" name="range" class="form-control form-control-lg" value="<?php echo $__page->approval_count; ?>" aria-describedby="max_label" max="<?php echo $__page->stewardCount; ?>">
                    <span class="input-group-text" id="max_label">of <?php echo $__page->stewardCount; ?></span>
                </div>
                <label id="steward_range-error" class="error" style="display: none;" for="steward_range"></label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
    </div>
  </div>
</div>

<?php include_once app_root . '/templates/admin-foot.php'; ?>
<script>

    $(document).on('click', '.edit_steward', function(event) {
        event.preventDefault();
        var element = $(this);
        $('#e_steward_id').val(element.data('sid'));
        $('#e_display_name').val(element.data('sname'));
        $('#e_wallet_address').val(element.data('sadr'));
    });

    $(document).on('click', '.del_steward', function(event) {
        event.preventDefault();
        var element = $(this);
        $("#user-deleteForm").attr('action', element.attr('href'));
    });

    $('#editStewardForm').validate({
        rules: {
            nickname:{
                e_display_name: true
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                type: 'post',
                dataType: 'json',
                beforeSend: function () {
                    $('#e_btn_cancel').prop('disabled', true);
                    $('#e_btn_save').prop('disabled', true);
                    showMessage('success', 10000, 'Updating...');
                },
                success: function(data) {
                    $('#editSteward').modal('toggle');
                    if (data.success == true) {
                        $('#e_btn_cancel').prop('disabled', false);
                        $('#e_btn_save').prop('disabled', false);
                        $('.stew-'+data.e_steward_id+' a').data('sname',data.e_display_name);
                        $('.stew-'+data.e_steward_id+' span').text(data.e_display_name);
                        showMessage('success',10000,'Success! Steward has been updated.');
                    }
                    else
                        showMessage('danger',10000,'Error! Could not update the quorum, please try again later.');
                }
            });
        }
    });

    $('#stewardForm').validate({
        rules: {},
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#ModalChange').modal('toggle');
                    if (data.success == true) {
                        $('#steward_percentage').html(data.percentage);
                        $("#steward_range").attr({"max" : data.max});
                        $("#max_label").html(data.max);
                        if(data.max > 1)
                            $('#percentage_change').removeClass('d-none');
                        else
                            $('#percentage_change').addClass('d-none');
                        showMessage('success',10000,'Success! The quorum has been updated.');
                    }
                    else
                        showMessage('danger',10000,'Error! Could not update the quorum, please try again later.');
                }
            });
        }
    });

    $('#user-deleteForm').validate({
        rules: {},
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#delMember').modal('toggle');
                    if (data.success == true) {
                        $('.stew-'+data.stew_id).remove();
                        $('#steward_percentage').html(data.percentage);
                        $("#steward_range").attr({"max" : data.max});
                        $("#max_label").html(data.max);
                        if(data.max > 1)
                            $('#percentage_change').removeClass('d-none');
                        else
                            $('#percentage_change').addClass('d-none');
                        showMessage('success',10000,'Success! A steward has been deleted from your community.');
                    }
                    else
                        showMessage('danger',10000,'Error! Could not update the steward list, please try again later.');
                }
            });
        }
    });

    $('#addStewardsForm').validate({
        rules: {
            nickname:{
                required: true
            },
            wallet_address:{
                required: true
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                type: 'post',
                dataType: 'json',
                beforeSend: function () {
                    $('#btn_cancel').prop('disabled', true);
                    $('#btn_save').prop('disabled', true);
                    $('#nickname').prop('disabled', true);
                    $('#wallet_address').prop('disabled', true);
                    showMessage('success', 10000, 'Initializing wallet signing process...');
                },
                success: function(data) {
                    $('#addMember').modal('toggle');
                    $('#btn_cancel').prop('disabled', false);
                    $('#btn_save').prop('disabled', false);
                    $('#nickname').prop('disabled', false);
                    $('#wallet_address').prop('disabled', false);
                    if (data.success == true) {
                        if(data.blockchain == 'solana') {
                            const response =  realmProposalTransaction(data.api_response);
                            const r_data   = data;
                            response.then(function (data){
                                $('#pending_steward_list').append(r_data.html);
                               // $('#steward_percentage').html(data.percentage);
                                $("#steward_range").attr({"max": r_data.max});
                                $("#max_label").html(r_data.max);
                                if (r_data.max > 1)
                                    $('#percentage_change').removeClass('d-none');
                                else
                                    $('#percentage_change').addClass('d-none');

                                $('#nickname').val('');
                                $('#wallet_address').val('');
                                showMessage('success', 10000, 'Success! A proposal for a new steward has been added.');
                            });
                        }
                        else {
                            $('#steward_list').append(data.html);
                            $('#steward_percentage').html(data.percentage);
                            $("#steward_range").attr({"max": data.max});
                            $("#max_label").html(data.max);
                            if (data.max > 1)
                                $('#percentage_change').removeClass('d-none');
                            else
                                $('#percentage_change').addClass('d-none');

                            $('#nickname').val('');
                            $('#wallet_address').val('');
                            showMessage('success', 10000, 'Success! A steward has been added to your community.');
                        }


                    }
                    else
                        showMessage('danger',10000,'Error! Could not update the steward list, please try again later.');
                }
            });
        }
    });
</script>