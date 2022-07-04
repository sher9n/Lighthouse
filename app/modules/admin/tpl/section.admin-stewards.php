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
                                <div class="fw-medium mt-26">Percentage to approve</div>
                                <div class="d-flex align-items-center mt-6">
                                    <div id="steward_percentage" class="display-4 fw-medium text-gray-700"><?php echo round(($__page->community->approval_count/count($__page->stewards)) * 100); ?>%</div>
                                    <button type="button" class="btn btn-primary ms-12" data-bs-toggle="modal" data-bs-target="#ModalChange">Change</button>
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
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
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
            <div class="fs-2 fw-semibold mb-15">Select members to approve</div>
            <div class="range-wrap mb-3">
                <input type="range" name="range" class="range form-range" min="1" max="<?php echo count($__page->stewards) + 1; ?>" step="1">
                <div class="d-flex justify-content-between mt-1">
                    <div class="fs-3 fw-semibold">1</div>
                    <div class="fs-3 fw-semibold">7</div>
                </div>
                <output class="bubble"></output>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btn_cancel" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
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
                        showMessage('success',10000,'Success! Steward percentage has been updated.');
                    }
                    else
                        showMessage('danger',10000,'Error! Steward percentage have not been updated.');
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
                        showMessage('success',10000,'Success! Steward has been deleted.');
                    }
                    else
                        showMessage('danger',10000,'Error! Steward have not been deleted.');
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
                success: function(data) {
                    $('#addMember').modal('toggle');
                    if (data.success == true) {
                        $('#frm_stewards').append(data.html);
                        feather.replace();
                        showMessage('success', 10000, 'Success! A New steward has been added.');
                    }
                    else
                        showMessage('danger',10000,'Error! A New steward have not been added.');
                }
            });
        }
    });

    // Range 
    const allRanges = document.querySelectorAll(".range-wrap");
    allRanges.forEach(wrap => {
    const range = wrap.querySelector(".range");
    const bubble = wrap.querySelector(".bubble");

    range.addEventListener("input", () => {
        setBubble(range, bubble);
    });
    setBubble(range, bubble);
    });

    function setBubble(range, bubble) {
        if(range.value == range.min || range.value == range.max)
            bubble.style.visibility = "hidden";
        else
            bubble.style.visibility = "visible";

    const val = range.value;
    const min = range.min ? range.min : 0;
    const max = range.max ? range.max : 100;
    const newVal = Number(((val - min) * 100) / (max - min));
    bubble.innerHTML = val;

    // Sorta magic numbers based on size of the native UI thumb
    bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
    }
</script>