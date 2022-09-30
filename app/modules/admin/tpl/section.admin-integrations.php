<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <?php
            if($__page->user->ntt_consent_bar != 1){
                require_once app_root. "/modules/admin/tpl/partial/ntt-consent-bar.php";
            } ?>
            <div class="row h-100">
                <div class="col h-100">
                    <div class="card shadow mb-12">
                        <div class="card-body p-xl-20">
                            <div class="display-5 fw-medium">Lighthouse integrations</div>
                            <div class="text-muted mt-1">Integrate with third party data sources and applications using
                                pre-built connectors or APIs
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-12">
                        <div class="card-header px-xl-20 py-xl-6 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="h3 mb-0">Contribution Sources</div>
                                <div class="ms-auto">
                                    <div class="dropdown dropdown-add">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Add
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#modalRealms">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-realms.png" width="40" height="40">
                                                    <div class="ms-5 h4 mb-0">Realms</div>
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-squads.png" width="40" height="40">
                                                    <div class="ms-5">
                                                        <div class="h4 mb-0">Squads</div>
                                                        <div class="text-success">Coming Soon!</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-realms.png" width="40" height="40">
                                                    <div class="ms-5">
                                                        <div class="h4 mb-0">Treasury</div>
                                                        <div class="text-success">Coming Soon!</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-github.png" width="40" height="40">
                                                    <div class="ms-5">
                                                        <div class="h4 mb-0">Github</div>
                                                        <div class="text-success">Coming Soon!</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-discord.png" width="40" height="40">
                                                    <div class="ms-5">
                                                        <div class="h4 mb-0">Discord</div>
                                                        <div class="text-success">Coming Soon!</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-member-wallets.png" width="40" height="40">
                                                    <div class="ms-5">
                                                        <div class="h4 mb-0">Member Wallets</div>
                                                        <div class="text-success">Coming Soon!</div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="contribution_div" class="card-body p-xl-20">
                            <?php
                            if(count($__page->cs) > 0) {
                                foreach ($__page->cs as $cs){
                                    $ticker = $__page->ticker;
                                    $update = false;
                                    require app_root. "/modules/admin/tpl/partial/realms_contribution_source.php";
                                }
                            }
                            else{
                                ?>
                                <div class="d-flex justify-content-center empty_Contribution_block">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-realms.png" width="50" height="50" class="me-3">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-squads.png" width="50" height="50" class="me-3">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-github.png" width="50" height="50" class="me-3">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-discord.png" width="50" height="50" class="me-3">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-member-wallets.png" width="50" height="50">
                                </div>
                                <div class="text-center h4 mb-0 mt-8 fw-medium empty_Contribution_block">Integrate on-chain and off-chain contribution sources.</div>
                                <?php
                            } ?>
                        </div>
                    </div>
                    <div class="card shadow mb-12">
                        <div class="card-header px-xl-20 py-xl-6 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="h3 mb-0">Gated Access</div>
                                <div class="ms-auto">
                                    <div class="dropdown dropdown-add">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Add
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-token-based.png" width="40" height="40">
                                                    <div class="ms-5">
                                                        <div class="h4 mb-0">Token Based</div>
                                                        <div class="text-success">Coming Soon!</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-nft-based.png" width="40" height="40">
                                                    <div class="ms-5">
                                                        <div class="h4 mb-0">NFT Based</div>
                                                        <div class="text-success">Coming Soon!</div>
                                                    </div>
                                                </a>
                                            </li>                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-xl-20">
                            <div class="d-flex justify-content-center">
                                <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-token-based.png" width="50" height="50" class="me-3">
                                <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-nft-based.png" width="50" height="50">
                            </div>
                            <div class="text-center h4 mb-0 mt-8 fw-medium">Setup token-gated access to contributions.</div>
                        </div>
                    </div>
                    <div class="card shadow mb-12">
                        <div class="card-header px-xl-20 py-xl-6 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="h3 mb-0">Recognition</div>
                                <div class="ms-auto">
                                    <div class="dropdown dropdown-add">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Add
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-governance.png" width="40" height="40">
                                                    <div class="ms-5">
                                                        <div class="h4 mb-0">Governance NTTs </div>
                                                        <div class="text-success">Coming Soon!</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-civic.png" width="40" height="40">
                                                    <div class="ms-5">
                                                        <div class="h4 mb-0">Civic Pass</div>
                                                        <div class="text-success">Coming Soon!</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-evolving.png" width="40" height="40">
                                                    <div class="ms-5">
                                                        <div class="h4 mb-0">Evolving Reputation NFTs</div>
                                                        <div class="text-success">Coming Soon!</div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-xl-20 pb-xl-20">
                            <div class="border rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-7">
                                        <div class="card-logo me-8">
                                            <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-ntts.png">
                                        </div>
                                        <div class="fs-4 fw-semibold pe-2">Reputation NTTs</div>
                                        <div class="ms-auto">
                                        <label class="switch">
                                            <input type="checkbox" disabled checked="checked" class="form-switch-input">
                                            <span class="slider"></span>
                                        </label>
                                        </div>
                                    </div>
                                    <div class="fw-medium lh-lg text-gray-700">Token name</div>
                                    <div class="fw-semibold fs-lg">$rep<?php echo $__page->ticker; ?></div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Modal Add Contribution Sources -->
<div class="modal fade" id="modalRealms" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-02">
        <div class="modal-content">
            <form id="addRealmsForm" method="post" action="add-realms_contribution" autocomplete="off">
                <div class="modal-body p-10">
                    <div class="fs-2 fw-semibold mb-22 mt-3">Add Contribution Sources</div>
                    <div class="mb-12">
                        <label for="" class="form-label">Name</label>
                        <input type="text" name="r_name" class="form-control form-control-lg" id="r_name" placeholder="Primary Realms account">
                    </div>
                    <div class="mb-12">
                        <label for="" class="form-label">Public key</label>
                        <input type="text" name="r_public_key" class="form-control form-control-lg" id="r_public_key" placeholder="J5AmvzRXFCFgr8r2V2KzPJM5ygrEiA19gfqE9kaPra5L">
                    </div>
                    <div class="mb-12">
                        <label for="" class="form-label">Points per vote</label>
                        <div class="input-group">
                            <input type="number" name="r_vote_points" id="r_vote_points" class="form-control form-control-lg" placeholder="100" aria-label="" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">$rep<?php echo $__page->ticker; ?></span>
                        </div>
                        <label id="r_vote_points-error" class="error" style="display: none;" for="r_vote_points"></label>
                    </div>
                    <div class="mb-12">
                        <label for="" class="form-label">Points per passed proposal</label>
                        <div class="input-group">
                            <input type="text" name="r_proposal_pass_points" id="r_proposal_pass_points" class="form-control form-control-lg" placeholder="100" aria-label="" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">$rep<?php echo $__page->ticker; ?></span>
                        </div>
                        <label id="r_proposal_pass_points-error" class="error" style="display: none;" for="r_proposal_pass_points"></label>
                    </div>
                    <div class="mb-12">
                        <label for="" class="form-label">Points per created proposal</label>
                        <div class="input-group">
                            <input type="text" name="r_proposal_create_points" id="r_proposal_create_points" class="form-control form-control-lg" placeholder="100" aria-label="" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">$rep<?php echo $__page->ticker; ?></span>
                        </div>
                        <label id="r_proposal_create_points-error" class="error" style="display: none;" for="r_proposal_create_points"></label>
                    </div>
                </div>
                <div class="modal-footer pe-10">
                    <button id="btn_cancel" type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                    <button id="btn_add" type="submit" class="btn btn-primary">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/admin-foot.php'; ?>
<script>
    $(document).ready(function() {

        $(document).on('change', '.cs_active', function(event) {
            event.preventDefault();
            var ele = $(this);
            var activate = ele.prop('checked');
            $.ajax({
                url: 'cs-activation?csid='+ele.data("csid")+'&status='+activate,
                dataType: 'json',
                success: function(data) {
                    if (data.success == true) {

                    }
                }
            });
        })

        $('#modalRealms').on('hidden.bs.modal', function (e) {
            $("#addRealmsForm").attr('action', "add-realms_contribution");
            $('#r_name').val('');
            $('#r_public_key').val('');
            $('#r_vote_points').val('');
            $('#r_proposal_pass_points').val('');
            $('#r_proposal_create_points').val('');
        });

        $(document).on('click', '.cs_edit', function(event) {
            event.preventDefault();
            var element = $(this);
            $("#addRealmsForm").attr('action', element.attr('href'));
            $('#r_name').val(element.data('nm'));
            $('#r_public_key').val(element.data('pk'));
            $('#r_vote_points').val(element.data('vp'));
            $('#r_proposal_pass_points').val(element.data('ppp'));
            $('#r_proposal_create_points').val(element.data('pcp'));
            $('#modalRealms').modal('toggle');
        });

        $('#addRealmsForm').validate({
            rules: {
                r_name: {
                    required: true
                },
                r_public_key:{
                    required: true
                },
                r_vote_points: {
                    required: true
                },
                r_proposal_pass_points:{
                    required: true
                },
                r_proposal_create_points:{
                    required: true
                }
            },
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function () {
                        $('#btn_cancel').prop('disabled', true);
                        $('#btn_add').prop('disabled', true);
                        showMessage('success', 10000, 'Adding realm contribution...');
                    },
                    success: function (data) {
                        $('#modalRealms').modal('toggle');
                        if (data.success == true) {
                            if(data.update == true)
                                $("#cs_"+data.cs_id).html(data.html);
                            else {
                                $(".empty_Contribution_block").remove();
                                $("#contribution_div").append(data.html);
                            }
                            showMessage('success', 10000, 'Success! Realm contribution sources has been updated.');
                        }
                        else {
                            if(data.element) {
                                $('#' + data.element).addClass('form-control-lg error');
                                $('<label class="error">' + data.msg + '</label>').insertAfter('#' + data.element);
                            }
                            else
                                showMessage('danger', 10000, data.msg);
                        }
                        $('#btn_cancel').prop('disabled', false);
                        $('#btn_add').prop('disabled', false);
                    }
                });
            }
        });
    });

</script>
