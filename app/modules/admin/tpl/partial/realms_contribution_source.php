<?php
if($update != true){ ?>
    <div id="cs_<?php echo $cs->id; ?>" class="card-body px-xl-20 pb-xl-20">
        <div class="border rounded-3">
            <div class="card-body">
                <div class="d-flex align-items-center mb-7">
                    <div class="card-logo me-8">
                        <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-realms.png">
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="fs-4 fw-semibold pe-3"><?php echo $cs->source_name; ?></div>
                        <a data-pk="<?php echo $cs->source_key; ?>" data-nm="<?php echo $cs->source_name; ?>" data-vp="<?php echo $cs->vote_points; ?>" data-ppp="<?php echo $cs->proposal_pass_points; ?>" data-pcp="<?php echo $cs->proposal_create_points; ?>" class="cs_edit text-primary text-decoration-none fw-medium" href="add-realms_contribution?cs_id=<?php echo $cs->id; ?>">Configure > </a>
                    </div>
                    <div class="ms-auto">
                        <label class="switch">
                            <input id="cs_active_<?php echo $cs->id; ?>" data-csid="<?php echo $cs->id; ?>" type="checkbox" <?php echo ($cs->is_active==1)? 'checked="checked"':'';?> class="cs_active form-switch-input">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
                <ul class="list-card-tokan">
                    <li class="list-card-tokan-item">
                        <div class="fw-medium lh-lg text-gray-700">Pubkey</div>
                        <div class="fw-semibold fs-lg"><?php echo $cs->source_key; ?></div>
                    </li>
                    <li class="list-card-tokan-item">
                        <div class="fw-medium lh-lg text-gray-700">Points per vote</div>
                        <div class="fw-semibold fs-lg"><?php echo $cs->vote_points; ?> $rep<?php echo $ticker; ?></div>
                    </li>
                    <li class="list-card-tokan-item">
                        <div class="fw-medium lh-lg text-gray-700">Points per passed proposal</div>
                        <div class="fw-semibold fs-lg"><?php echo $cs->proposal_pass_points; ?> $rep<?php echo $ticker; ?></div>
                    </li>
                    <li class="list-card-tokan-item">
                        <div class="fw-medium lh-lg text-gray-700">Points per created proposal</div>
                        <div class="fw-semibold fs-lg"><?php echo $cs->proposal_create_points; ?> $rep<?php echo $ticker; ?></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <?php
}
else
{
    ?>
    <div class="border rounded-3">
        <div class="card-body">
            <div class="d-flex align-items-center mb-7">
                <div class="card-logo me-8">
                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-realms.png">
                </div>
                <div class="d-flex align-items-center">
                    <div class="fs-4 fw-semibold pe-3"><?php echo $cs->source_name; ?></div>
                    <a data-pk="<?php echo $cs->source_key; ?>" data-nm="<?php echo $cs->source_name; ?>" data-vp="<?php echo $cs->vote_points; ?>" data-ppp="<?php echo $cs->proposal_pass_points; ?>" data-pcp="<?php echo $cs->proposal_create_points; ?>" class="cs_edit text-primary text-decoration-none fw-medium" href="add-realms_contribution?cs_id=<?php echo $cs->id; ?>">Configure > </a>
                </div>
                <div class="ms-auto">
                    <label class="switch">
                        <input id="cs_active_<?php echo $cs->id; ?>" data-csid="<?php echo $cs->id; ?>" type="checkbox" <?php echo ($cs->is_active==1)? 'checked="checked"':'';?> class="cs_active form-switch-input">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
            <ul class="list-card-tokan">
                <li class="list-card-tokan-item">
                    <div class="fw-medium lh-lg text-gray-700">Pubkey</div>
                    <div class="fw-semibold fs-lg"><?php echo $cs->source_key; ?></div>
                </li>
                <li class="list-card-tokan-item">
                    <div class="fw-medium lh-lg text-gray-700">Points per vote</div>
                    <div class="fw-semibold fs-lg"><?php echo $cs->vote_points; ?> $rep<?php echo $ticker; ?></div>
                </li>
                <li class="list-card-tokan-item">
                    <div class="fw-medium lh-lg text-gray-700">Points per passed proposal</div>
                    <div class="fw-semibold fs-lg"><?php echo $cs->proposal_pass_points; ?> $rep<?php echo $ticker; ?></div>
                </li>
                <li class="list-card-tokan-item">
                    <div class="fw-medium lh-lg text-gray-700">Points per created proposal</div>
                    <div class="fw-semibold fs-lg"><?php echo $cs->proposal_create_points; ?> $rep<?php echo $ticker; ?></div>
                </li>
            </ul>
        </div>
    </div>
    <?php
} ?>
