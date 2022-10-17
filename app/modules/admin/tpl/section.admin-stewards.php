<?php use Core\Utils; ?>
<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid">
            <?php
            if($__page->user->ntt_consent_bar != 1){
                require_once app_root. "/modules/admin/tpl/partial/ntt-consent-bar.php";
            } ?>
            <div class="row">
                <div class="col">
                    <div class="card shadow" style="min-height: calc(100vh - 60px);">
                        <div class="card-body p-xl-20" style="flex: inherit;">
                            <div class="display-5 fw-medium">Manage stewards</div>
                            <div class="text-muted mt-1">Add or remove stewards and set multisig parameters</div>
                            <div class="fw-medium mt-16">Quorum</div>
                            <?php
                            if($__page->is_admin != false){ ?>
                                <button type="button" id="percentage_change" class="btn btn-primary mt-6 <?php echo count($__page->quorumProposals) > 0 ?'disabled':''; ?>" data-bs-toggle="modal" data-bs-target="#ModalChange">Propose new quorum</button>
                                <?php
                            } ?>
                            <div class="d-flex align-items-center mt-4">
                                <div id="steward_percentage" class="d-flex align-items-center fw-medium text-gray-700">
                                    <div class="fs-1"><?php echo $__page->approval_count.'</div><div class="fs-2">/'.$__page->stewardCount; ?></div>
                                </div>
                            </div>
                            <div class="mt-26 <?php echo count($__page->quorumProposals) < 1?'d-none':''; ?>" id="quorum_list">
                            <?php
                            if($__page->blockchain == SOLANA){

                                foreach ($__page->quorumProposals as $qid => $proposal){

                                    if(strlen($proposal->proposal_state) > 0) {

                                        $qdata = json_decode($proposal->proposal_data);
                                        ?>
                                        <div class="prop-<?php echo $qid; ?>  d-flex align-items-center justify-content-between mt-4">
                                            <div>
                                                <div class="d-flex align-items-center fw-medium">
                                                    <a class="text-blue-stone me-2 text-decoration-none">Modify</a>
                                                    <div class="text-muted">Quorum</div>
                                                </div>
                                                <div class="d-flex align-items-center fw-medium text-gray-700">
                                                    <div class="fs-2"><?php echo $qdata->c; ?></div>
                                                    <div class="fs-3">/<?php echo $__page->stewardCount; ?></div>
                                                </div>
                                                <?php
                                                $date_count = Utils::expire_date_count(date("Y-m-d H:i:s"),date('Y-m-d H:i:s',strtotime($proposal->c_at .' +'.($__page->maxVotingTime/86400).' days')));
                                                if(!is_null($date_count)) {
                                                    ?>
                                                    <div class="d-flex align-items-center text-blue-stone">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                        <div class="fw-medium ms-2 end_time_<?php echo $qid; ?>">Approval period ends in <?php echo $date_count; ?></div>
                                                    </div>
                                                <?php
                                                }
                                                else{
                                                    ?>
                                                    <script>

                                                        var countDownDate_<?php echo $qid; ?> = new Date("<?php echo date('Y-m-d H:i:s',strtotime($proposal->c_at .' +'.($__page->maxVotingTime/86400).' days')); ?>").getTime();

                                                        var x_<?php echo $qid; ?> = setInterval(function() {

                                                            var now_<?php echo $qid; ?> = new Date().getTime();
                                                            var distance_<?php echo $qid; ?> = countDownDate_<?php echo $qid; ?> - now_<?php echo $qid; ?>;
                                                            var hours_<?php echo $qid; ?> = Math.floor((distance_<?php echo $qid; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                            var minutes_<?php echo $qid; ?> = Math.floor((distance_<?php echo $qid; ?> % (1000 * 60 * 60)) / (1000 * 60));
                                                            var seconds_<?php echo $qid; ?> = Math.floor((distance_<?php echo $qid; ?> % (1000 * 60)) / 1000);

                                                            if (countDownDate_<?php echo $qid; ?> < now_<?php echo $qid; ?>) {
                                                                clearInterval(x_<?php echo $qid; ?>);
                                                                $(".end_time_<?php echo $qid; ?>").html("EXPIRED");
                                                            }
                                                            else {
                                                                $(".end_time_<?php echo $qid; ?>").html("Approval period ends in " + hours_<?php echo $qid; ?> + "h "
                                                                    + minutes_<?php echo $qid; ?> + "m " + seconds_<?php echo $qid; ?> + "s ");
                                                            }
                                                        }, 1000);
                                                    </script>
                                                    <div class="d-flex align-items-center text-blue-stone">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                        <div class="fw-medium ms-2 end_time_<?php echo $qid; ?>"></div>
                                                    </div>
                                                    <?php
                                                } ?>
                                            </div>
                                            <div class="text-end">
                                                <div class="fw-medium text-muted mb-1"><?php echo $proposal->proposal_yes_count; ?> of <?php echo $__page->stewardCount; ?> Approved</div>
                                                <?php if($__page->is_admin != false){ ?>
                                                <div>
                                                    <?php

                                                    if(!isset($__page->user_votes[$qid])){ ?>
                                                        <a type="button" data-pid="<?php echo $qid; ?>" data-vote="NO" id="deny_<?php echo $qid; ?>" class="admin_proposal_vote btn btn-secondary me-2">Deny</a>
                                                        <a type="button" data-pid="<?php echo $qid; ?>" data-vote="YES" id="approve_<?php echo $qid; ?>" class="admin_proposal_vote btn btn-blue-stone">Approve</a>
                                                        <?php
                                                    }
                                                    if($proposal->proposal_state == \lighthouse\Proposal::PROPOSAL_STATE_SUCCEEDED ){ ?>
                                                        <a type="button" data-pid="<?php echo $qid; ?>" id="execute_<?php echo $qid; ?>" class="quorum_proposal_execute btn btn-blue-stone">execute</a>
                                                        <?php
                                                    } ?>
                                                </div>
                                                <?php } ?>
                                                <div class="d-flex align-items-center justify-content-end mt-2">
                                                    <div class="fw-semibold me-2">View Proposal</div>
                                                    <a target="_blank" href="https://solscan.io/account/<?php echo $proposal->proposal_adr ; ?>?cluster=devnet" class="text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            } ?>
                            </div>
                        </div>
                        <div class="border-dashed"></div>
                        <div class="card-body p-xl-20">
                            <div class="fw-medium">Stewards</div>
                            <?php if($__page->is_admin != false){ ?>
                            <a type="button" class="btn btn-primary mt-6 mb-26" href="#" data-bs-toggle="modal" data-bs-target="#addMember">Propose new steward</a>
                            <?php } ?>
                            <?php if($__page->blockchain == SOLANA){ ?>
                                <div id="pending_steward_list">
                                    <?php
                                    foreach ($__page->admin_Proposals as $id => $proposal){

                                        if(strlen($proposal->proposal_state) > 0) {
                                            ?>
                                            <div class="mt-6 mb-26">
                                                <div class="mb-8">
                                                    <div class="prop-<?php echo $id; ?> d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <div class="d-flex align-items-center fw-medium">
                                                                <?php if($proposal->proposal_type == 'ADD'){ ?>
                                                                <a class="text-blue-stone me-2 text-decoration-none">Add</a>
                                                                <?php }else{ ?>
                                                                <a class="text-danger me-2 text-decoration-none">Remove</a>
                                                                <?php } ?>
                                                                <div class="text-muted"><?php echo $proposal->display_name; ?></div>
                                                            </div>
                                                            <div class="fs-3 fw-semibold me-6"><?php echo $proposal->modified_admin; ?></div>
                                                            <?php
                                                            $date_count = Utils::expire_date_count(date("Y-m-d H:i:s"),date('Y-m-d H:i:s',strtotime($proposal->c_at .' +'.($__page->maxVotingTime/86400).' days')));
                                                            if(!is_null($date_count)) {
                                                                ?>
                                                                <div class="d-flex align-items-center text-blue-stone">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                                    <div class="fw-medium ms-2 end_time_<?php echo $id; ?>">Approval period ends in <?php echo $date_count; ?></div>
                                                                </div>
                                                                <?php
                                                            }
                                                            else{
                                                                ?>
                                                                <script>
                                                                    var countDownDate_<?php echo $id; ?> = new Date("<?php echo date('Y-m-d H:i:s',strtotime($proposal->c_at .' +'.($__page->maxVotingTime/86400).' days')); ?>").getTime();

                                                                    var x_<?php echo $id; ?> = setInterval(function() {

                                                                        var now_<?php echo $id; ?> = new Date().getTime();
                                                                        var distance_<?php echo $id; ?> = countDownDate_<?php echo $id; ?> - now_<?php echo $id; ?>;
                                                                        var hours_<?php echo $id; ?> = Math.floor((distance_<?php echo $id; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                        var minutes_<?php echo $id; ?> = Math.floor((distance_<?php echo $id; ?> % (1000 * 60 * 60)) / (1000 * 60));
                                                                        var seconds_<?php echo $id; ?> = Math.floor((distance_<?php echo $id; ?> % (1000 * 60)) / 1000);

                                                                        if (countDownDate_<?php echo $id; ?> < now_<?php echo $id; ?>) {
                                                                            clearInterval(x_<?php echo $id; ?>);
                                                                            $(".end_time_<?php echo $id; ?>").html("EXPIRED");
                                                                        }
                                                                        else {
                                                                            $(".end_time_<?php echo $id; ?>").html("Approval period ends in " + hours_<?php echo $id; ?> + "h "
                                                                                + minutes_<?php echo $id; ?> + "m " + seconds_<?php echo $id; ?> + "s ");
                                                                        }
                                                                    }, 1000);
                                                                </script>
                                                                <div class="d-flex align-items-center text-blue-stone">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                                    <div class="fw-medium ms-2 end_time_<?php echo $id; ?>"></div>
                                                                </div>
                                                                <?php
                                                            } ?>
                                                        </div>
                                                        <div class="text-end">
                                                            <div class="fw-medium text-muted mb-1"><?php echo $proposal->proposal_yes_count; ?> of <?php echo $__page->stewardCount; ?> Approved</div>
                                                            <?php
                                                            if($__page->is_admin != false){ ?>
                                                            <div>
                                                                <?php
                                                                if(!isset($__page->user_votes[$id])){ ?>
                                                                    <a type="button" data-pid="<?php echo $id; ?>" data-vote="NO" id="deny_<?php echo $id; ?>" class="admin_proposal_vote btn btn-secondary me-2">Deny</a>
                                                                    <a type="button" data-pid="<?php echo $id; ?>" data-vote="YES" id="approve_<?php echo $id; ?>" class="admin_proposal_vote btn btn-blue-stone">Approve</a>
                                                                    <?php
                                                                }
                                                                if($proposal->proposal_state == \lighthouse\Proposal::PROPOSAL_STATE_SUCCEEDED){ ?>
                                                                    <a type="button" data-pid="<?php echo $id; ?>" id="execute_<?php echo $id; ?>" class="admin_proposal_execute btn btn-blue-stone">execute</a>
                                                                    <?php
                                                                } ?>
                                                            </div>
                                                            <?php } ?>
                                                            <div class="d-flex align-items-center justify-content-end mt-2">
                                                                <div class="fw-semibold me-2" >View Proposal</div>
                                                                <a target="_blank" href="https://solscan.io/account/<?php echo $proposal->proposal_adr ; ?>?cluster=devnet" class="text-primary">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
                                                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                                        <polyline points="15 3 21 3 21 9"></polyline>
                                                                        <line x1="10" y1="14" x2="21" y2="3"></line>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } ?>
                                </div>
                                <div class="mt-6" id="steward_list">
                                    <?php
                                    foreach ($__page->stewards as $steward){ ?>
                                        <div class="mb-8">
                                            <div class="stew-<?php echo $steward['id']; ?> fw-medium text-muted">
                                                <span><?php echo $steward['name']; ?></span>
                                                <?php if($__page->is_admin != false){ ?>
                                                <a class="fw-medium text-decoration-none text-primary ms-3 edit_steward" data-sadr="<?php echo $steward['wallet_adr']; ?>" data-sid="<?php echo $steward['id']; ?>" data-sname="<?php echo $steward['name']; ?>" data-bs-toggle="modal" data-bs-target="#editSteward"href="#">Edit > </a>
                                                <?php } ?>
                                            </div>
                                            <div class="stew-<?php echo $steward['id']; ?> d-flex align-items-center">
                                                <div class="fs-3 fw-semibold me-6"><?php echo $steward['wallet_adr']; ?></div>
                                                <?php if(($__page->is_admin != false) && (count($__page->stewards) > 1)){ ?>
                                                <a class="del_steward" href="delete-stewards?id=<?php echo $steward['id'];?>&adr=<?php echo $steward['wallet_adr']; ?>" data-bs-toggle="modal" data-bs-target="#delMember">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash text-danger">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    </svg>
                                                </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php
                                    }?>
                                </div>
                            <?php }else{ ?>
                                <div class="mt-26" id="steward_list">
                                    <?php
                                    foreach ($__page->stewards as $steward){ ?>
                                            <div class="mb-8">
                                                <div class="stew-<?php echo $steward['id']; ?> fw-medium text-muted">
                                                    <span><?php echo $steward['name']; ?></span>
                                                    <?php if($__page->is_admin != false){ ?>
                                                    <a class="fw-medium text-decoration-none text-primary ms-3 edit_steward" data-sadr="<?php echo $steward['wallet_adr']; ?>" data-sid="<?php echo $steward['id']; ?>" data-sname="<?php echo $steward['name']; ?>" data-bs-toggle="modal" data-bs-target="#editSteward" href="#">Edit > </a>
                                                    <?php } ?>
                                                </div>
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
        <form id="quorumForm" method="post" action="steward-percentage" autocomplete="off">
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
            <button id="btn_q_cancel" type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
            <button id="btn_q_save" type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
    </div>
  </div>
</div>

<?php include_once app_root . '/templates/admin-foot.php'; ?>
<script>

    $(document).ready(function() {
        <?php foreach ($__page->quorumProposals as $id_key => $val){ ?>
        checkProposalState(<?php echo $id_key; ?>);
        <?php } ?>

        <?php foreach ($__page->admin_Proposals as $id_key => $val){ ?>
        checkProposalState(<?php echo $id_key; ?>);
        <?php } ?>
    });

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

    $(document).on('click','.admin_proposal_execute',function (e){
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: 'execute-admin-proposal?pid='+ele.data("pid"),
            dataType: 'json',
            beforeSend: function () {
                showMessage('success', 10000, 'Initializing wallet signing process...');
            },
            success: function(data) {
                if (data.success == true){
                    showMessage('success',10000,'Success! The proposal has been executed.');
                    window.location.replace('stewards');
                }
                else {
                    if(data.element) {
                        $('#' + data.element).addClass('form-control-lg error');
                        $('<label class="error">' + data.msg + '</label>').insertAfter('#' + data.element);
                    }
                    else
                        showMessage('danger', 10000, data.msg);
                }
            }
        });
    });

    $(document).on('click','.quorum_proposal_execute', function (e){
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: 'execute-quorum-proposal?pid='+ele.data("pid"),
            dataType: 'json',
            beforeSend: function () {
                showMessage('success', 10000, 'Initializing wallet signing process...');
            },
            success: function(data) {
                if (data.success == true){
                    showMessage('success',10000,'Success! The proposal has been executed.');
                    window.location.replace('stewards');
                }
                else {
                    if(data.element) {
                        $('#' + data.element).addClass('form-control-lg error');
                        $('<label class="error">' + data.msg + '</label>').insertAfter('#' + data.element);
                    }
                    else
                        showMessage('danger', 10000, data.msg);
                }
            }
        });
    });

    $(document).on('click', '.admin_proposal_vote,quorum_proposal_vote', function (e){
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: 'vote-proposal?pid='+ele.data("pid")+'&vote='+ele.data("vote"),
            dataType: 'json',
            beforeSend: function () {
                showMessage('success', 10000, 'Initializing wallet signing process...');
            },
            success: function(data) {
                if (data.success == true){
                    showMessage('warning', 10000, 'Waiting for on-chain confirmation...');
                    const response =  solanaProposalTransaction(data.api_response);
                    const r_data   = data;
                    response.then(function (data){
                        $('.prop-'+r_data.pid).html(r_data.html);
                        showMessage('success', 10000, 'Success! The vote has been submitted.');
                        checkProposalState(r_data.pid,r_data.vote);
                    });
                }
                else {
                    if(data.element) {
                        $('#' + data.element).addClass('form-control-lg error');
                        $('<label class="error">' + data.msg + '</label>').insertAfter('#' + data.element);
                    }
                    else
                        showMessage('danger', 10000, data.msg);
                }
            }
        });
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

    $('#quorumForm').validate({
        rules: {},
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                type: 'post',
                dataType: 'json',
                beforeSend: function () {
                    $('#btn_q_cancel').prop('disabled', true);
                    $('#btn_q_save').prop('disabled', true);
                    showMessage('success', 10000, 'Creating a new proposal...');
                },
                success: function(data) {
                    $('#ModalChange').modal('toggle');
                    $('#btn_q_cancel').prop('disabled', false);
                    $('#btn_q_save').prop('disabled', false);

                    if (data.success == true) {
                        if(data.blockchain == 'solana') {
                            showMessage('warning', 10000, 'Waiting for on-chain confirmation...');
                            const response =  solanaProposalTransaction(data.api_response);
                            const r_data   = data;
                            response.then(function (data){
                                checkProposalState(r_data.pid);
                                $("#quorum_list").append(r_data.html);
                                $("#quorum_list").removeClass('d-none');
                                showMessage('success', 10000, 'Success! A proposal for a new quorum has been added.');
                            });
                        }
                        else {
                            $('#steward_percentage').html(data.percentage);
                            $("#steward_range").attr({"max": data.max});
                            $("#max_label").html(data.max);

                            showMessage('success', 10000, 'Success! The quorum has been updated.');
                        }
                    }
                    else
                        showMessage('danger',10000,data.msg);
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
                beforeSend: function () {
                    //showMessage('success', 10000, 'Initializing wallet signing process...');
                    showMessage('success', 10000, 'Creating a new proposal...');
                },
                success: function(data) {
                    $('#delMember').modal('toggle');
                    if (data.success == true) {

                        if(data.blockchain == 'solana') {
                            showMessage('warning', 10000, 'Waiting for on-chain confirmation...');
                            const response =  solanaProposalTransaction(data.api_response);
                            const r_data   = data;
                            response.then(function (data){
                                checkProposalState(r_data.pid);
                                $('#pending_steward_list').append(r_data.html);
                                showMessage('success',10000,'Success! The remove steward proposal has been added.');
                            });
                        }
                        else {
                            $('.stew-' + data.stew_id).remove();
                            showMessage('success',10000,'Success! The selected steward has been removed.');
                        }
                    }
                    else
                        showMessage('danger',10000,data.msg);
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
                    /*showMessage('success', 10000, 'Initializing wallet signing process...');*/
                    showMessage('success', 10000, 'Creating a new proposal...');
                },
                success: function(data) {
                    $('#addMember').modal('toggle');
                    $('#btn_cancel').prop('disabled', false);
                    $('#btn_save').prop('disabled', false);
                    $('#nickname').prop('disabled', false);
                    $('#wallet_address').prop('disabled', false);
                    if (data.success == true) {
                        if(data.blockchain == 'solana') {
                            showMessage('warning', 10000, 'Waiting for on-chain confirmation...');
                            const response =  solanaProposalTransaction(data.api_response);
                            const r_data   = data;
                            response.then(function (data){
                                checkProposalState(r_data.pid);
                                $('#pending_steward_list').append(r_data.html);
                                $('#nickname').val('');
                                $('#wallet_address').val('');
                                $('#percentage_change').addClass('disabled');
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
                        showMessage('danger',10000,data.msg);
                }
            });
        }
    });

    function checkProposalState(pid,vote=null) {
        if(vote=='YES' || vote=='NO'){
            $.ajax({
                url: 'get-proposal?pid='+pid+'&vote='+vote,
                dataType: 'json'
            });
        }
        else {
            $.ajax({
                url: 'get-proposal?pid=' + pid,
                dataType: 'json'
            });
        }
    }

</script>