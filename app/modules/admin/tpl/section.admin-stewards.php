<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col h-100">
                    <div class="card shadow h-100">
                        <div class="card-body p-xl-20">
                            <div class="display-5 fw-medium">Manage stewards</div>
                            <div class="text-muted mt-1">Add or remove community elected stewards and set multisig parameters</div>
                            <form id="frm_stewards" class="mt-25 col-xl-6">
                                <div class="fw-medium mt-26">Quorum</div>
                                <div class="d-flex align-items-center mt-6">
                                    <div id="steward_percentage" class="d-flex align-items-center fw-medium text-gray-700">
                                        <div class="fs-1"><?php echo $__page->community->approval_count.'</div><div class="fs-2">/'.count($__page->stewards); ?></div></div>
                                    <button type="button" id="percentage_change" class="btn btn-primary ms-12 <?php echo (count($__page->stewards) < 2)?'d-none':''; ?>" data-bs-toggle="modal" data-bs-target="#ModalChange">Change</button>
                                </div>
                                <div class="fw-medium mt-22">Whitelist members</div>
                                <a role="button" class="btn btn-primary mt-6" href="#" data-bs-toggle="modal" data-bs-target="#addMember">Add</a>
                                <div class="fw-medium mt-22"><?php echo $__page->community->display_name; ?> </div>
                                <div class="d-flex align-items-center">
                                    <div class="fs-3 fw-semibold me-6"><?php echo $__page->community->wallet_adr; ?></div>
                                </div>
                                <?php
                                unset($__page->stewards[$__page->community->wallet_adr]);
                                foreach ($__page->stewards as $steward){ ;?>
                                <div class="stew-<?php echo $steward['id']; ?> fw-medium mt-22"><?php echo $steward['name']; ?> </div>
                                <div class="stew-<?php echo $steward['id']; ?> d-flex align-items-center">
                                    <div class="fs-3 fw-semibold me-6"><?php echo $steward['wallet_adr']; ?></div>
                                    <a class="del_steward" href="delete-stewards?id=<?php echo $steward['id'];?>&adr=<?php echo $steward['wallet_adr']; ?>" data-bs-toggle="modal" data-bs-target="#delMember">
                                        <i data-feather="trash" class="text-danger"></i>
                                    </a>
                                </div>
                                <?php } ?>
                            </form>
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
                <div class="modal-body pb-3">
                    <div class="fs-2 fw-semibold mb-15">Add new member to whitelist </div>
                    <label for="Nickname" class="form-label">Nickname</label>
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
            <div class="col-5">
                <div class="input-group">
                    <input type="text" id="steward_range" name="range" class="form-control form-control-lg" value="<?php echo $__page->community->approval_count; ?>" aria-describedby="max_label" max="<?php echo count($__page->stewards) + 1; ?>">
                    <span class="input-group-text" id="max_label">of <?php echo count($__page->stewards) + 1; ?></span>
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

    $(document).on('click', '.del_steward', function(event) {
        event.preventDefault();
        var element = $(this);
        $("#user-deleteForm").attr('action', element.attr('href'));
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
        beforeSend: function () {
            $('#btn_cancel').prop('disabled', true);
            $('#btn_save').prop('disabled', true);
            $('#nickname').prop('disabled', true);
            $('#wallet_address').prop('disabled', true);
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#addMember').modal('toggle');
                    $('#btn_cancel').prop('disabled', false);
                    $('#btn_save').prop('disabled', false);
                    $('#nickname').prop('disabled', false);
                    $('#wallet_address').prop('disabled', false);
                    if (data.success == true) {
                        $('#frm_stewards').append(data.html);
                        $('#steward_percentage').html(data.percentage);
                        $("#steward_range").attr({"max" : data.max});
                        $("#max_label").html(data.max);
                        if(data.max > 1)
                            $('#percentage_change').removeClass('d-none');
                        else
                            $('#percentage_change').addClass('d-none');
                        feather.replace();
                        showMessage('success', 10000, 'Success! A steward has been added to your community.');
                    }
                    else
                        showMessage('danger',10000,'Error! Could not update the steward list, please try again later.');
                }
            });
        }
    });
</script>