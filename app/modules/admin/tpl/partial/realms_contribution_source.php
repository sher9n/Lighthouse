<?php
if($update == false){
    ?>
    <div id="cs_<?php echo $cs->id; ?>" class="accordion-item mb-10">
        <div class="border rounded-3">
            <div class="d-flex align-items-center p-6">
                <div class="card-logo me-8 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $cs->id; ?>" aria-expanded="true">
                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-realms.png">
                </div>
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center">
                        <div class="fs-4 fw-semibold pe-3 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $cs->id; ?>" aria-expanded="true"><?php echo ucfirst($cs->source_type); ?>: <?php echo $cs->source_name; ?></div>
                        <a data-is_active="<?php echo $cs->is_active; ?>" data-pk="<?php echo $cs->source_key; ?>" data-nm="<?php echo $cs->source_name; ?>" data-vp="<?php echo $cs->vote_points; ?>" data-ppp="<?php echo $cs->proposal_pass_points; ?>" data-pcp="<?php echo $cs->proposal_create_points; ?>" class="cs_edit text-primary text-decoration-none fw-medium" href="add-realms_contribution?cs_id=<?php echo $cs->id; ?>">Edit</a>
                    </div>
                    <?php if($cs->is_active == 1){ ?>
                        <div class="fw-medium text-blue-stone">Enabled</div>
                    <?php }else{ ?>
                        <div class="fw-medium text-blue-stone">Disabled</div>
                    <?php } ?>
                </div>
                <div class="ms-auto">                    
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $cs->id; ?>" aria-expanded="true" aria-controls="panelsStayOpen-collapse<?php echo $cs->id; ?>"></button>
                    <!--<label class="switch">
                        <input id="cs_active_<?php echo $cs->id; ?>" data-csid="<?php echo $cs->id; ?>" type="checkbox" <?php echo ($cs->is_active==1)? 'checked="checked"':'';?> class="cs_active form-switch-input">
                        <span class="slider"></span>
                    </label>-->
                </div>
            </div>
            <div id="panelsStayOpen-collapse<?php echo $cs->id; ?>" class="accordion-collapse collapse border-top p-6">
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
else{
    ?>

    <div class="border rounded-3">
        <div class="d-flex align-items-center p-6">
            <div class="card-logo me-8 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $cs->id; ?>" aria-expanded="true">
                <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-realms.png">
            </div>
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center">
                    <div class="fs-4 fw-semibold pe-3 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $cs->id; ?>" aria-expanded="true"><?php echo ucfirst($cs->source_type); ?>: <?php echo $cs->source_name; ?></div>
                    <a data-is_active="<?php echo $cs->is_active; ?>" data-pk="<?php echo $cs->source_key; ?>" data-nm="<?php echo $cs->source_name; ?>" data-vp="<?php echo $cs->vote_points; ?>" data-ppp="<?php echo $cs->proposal_pass_points; ?>" data-pcp="<?php echo $cs->proposal_create_points; ?>" class="cs_edit text-primary text-decoration-none fw-medium" href="add-realms_contribution?cs_id=<?php echo $cs->id; ?>">Edit</a>
                </div>
                <?php if($cs->is_active == 1){ ?>
                    <div class="fw-medium text-blue-stone">Enabled</div>
                <?php }else{ ?>
                    <div class="fw-medium text-blue-stone">Disabled</div>
                <?php } ?>
            </div>
            <div class="ms-auto">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $cs->id; ?>" aria-expanded="true" aria-controls="panelsStayOpen-collapse<?php echo $cs->id; ?>"></button>
                <!--<label class="switch">
                        <input id="cs_active_<?php echo $cs->id; ?>" data-csid="<?php echo $cs->id; ?>" type="checkbox" <?php echo ($cs->is_active==1)? 'checked="checked"':'';?> class="cs_active form-switch-input">
                        <span class="slider"></span>
                    </label>-->
            </div>
        </div>
        <div id="panelsStayOpen-collapse<?php echo $cs->id; ?>" class="accordion-collapse collapse border-top p-6">
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
}