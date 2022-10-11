<?php
if($update == false){
    ?>
    <div id="ga_<?php echo $ga->id; ?>" class="accordion-item mb-10">
        <div class="border rounded-3">
            <div class="d-flex align-items-center p-6">
                <div class="card-logo me-8 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $ga->id; ?>" aria-expanded="true">
                    <?php if($ga->gated_type == \lighthouse\GatedAccess::TOKEN_BASED_GATED){ ?>
                        <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-token-based.png">
                    <?php }else{ ?>
                        <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-nft-based.png">
                    <?php } ?>
                </div>
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center">
                        <div class="fs-4 fw-semibold pe-3 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $ga->id; ?>" aria-expanded="true"><?php echo ucfirst($ga->gated_type); ?>: <?php echo $ga->ga_name; ?></div>
                        <?php if($ga->gated_type == \lighthouse\GatedAccess::TOKEN_BASED_GATED){ ?>
                            <a data-is_active="<?php echo $ga->is_active; ?>" data-nm="<?php echo $ga->ga_name; ?>" data-contract="<?php echo $ga->contract; ?>" data-min_amount="<?php echo $ga->min_amount; ?>" data-gated_type="<?php echo $ga->gated_type; ?>" class="ga_edit text-primary text-decoration-none fw-medium" href="add-token-gated_access?ga_id=<?php echo $ga->id; ?>">Edit</a>
                        <?php }else{ ?>
                            <a data-is_active="<?php echo $ga->is_active; ?>" data-nm="<?php echo $ga->ga_name; ?>" data-contract="<?php echo $ga->contract; ?>" data-min_amount="<?php echo $ga->min_amount; ?>" data-gated_type="<?php echo $ga->gated_type; ?>" class="ga_edit text-primary text-decoration-none fw-medium" href="add-nft-gated_access?ga_id=<?php echo $ga->id; ?>">Edit</a>
                        <?php } ?>
                    </div>
                    <?php if($ga->is_active == 1){ ?>
                        <div class="fw-medium text-blue-stone">Enabled</div>
                    <?php }else{ ?>
                        <div class="fw-medium text-blue-stone">Disabled</div>
                    <?php } ?>
                </div>
                <div class="ms-auto">                    
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $ga->id; ?>" aria-expanded="true" aria-controls="panelsStayOpen-collapse<?php echo $ga->id; ?>"></button>
                </div>
            </div>
            <div id="panelsStayOpen-collapse<?php echo $ga->id; ?>" class="accordion-collapse collapse border-top p-6">
                <ul class="list-card-tokan">
                <li class="list-card-tokan-item">
                    <div class="fw-medium lh-lg text-gray-700"><?php echo ($ga->gated_type == \lighthouse\GatedAccess::TOKEN_BASED_GATED)?'Token contract':'NFT contract'; ?></div>
                    <div class="fw-semibold fs-lg"><?php echo $ga->contract; ?></div>
                </li>
                <li class="list-card-tokan-item">
                    <div class="fw-medium lh-lg text-gray-700">Min amount</div>
                    <div class="fw-semibold fs-lg"><?php echo $ga->min_amount; ?></div>
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
            <div class="card-logo me-8 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $ga->id; ?>" aria-expanded="true">
                <?php if($ga->gated_type == \lighthouse\GatedAccess::TOKEN_BASED_GATED){ ?>
                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-token-based.png">
                <?php }else{ ?>
                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-nft-based.png">
                <?php } ?>
            </div>
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center">
                    <div class="fs-4 fw-semibold pe-3 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $ga->id; ?>" aria-expanded="true"><?php echo ucfirst($ga->gated_type); ?>: <?php echo $ga->ga_name; ?></div>
                    <?php if($ga->gated_type == \lighthouse\GatedAccess::TOKEN_BASED_GATED){ ?>
                        <a data-is_active="<?php echo $ga->is_active; ?>" data-nm="<?php echo $ga->ga_name; ?>" data-contract="<?php echo $ga->contract; ?>" data-min_amount="<?php echo $ga->min_amount; ?>" data-gated_type="<?php echo $ga->gated_type; ?>" class="ga_edit text-primary text-decoration-none fw-medium" href="add-token-gated_access?ga_id=<?php echo $ga->id; ?>">Edit</a>
                    <?php }else{ ?>
                        <a data-is_active="<?php echo $ga->is_active; ?>" data-nm="<?php echo $ga->ga_name; ?>" data-contract="<?php echo $ga->contract; ?>" data-min_amount="<?php echo $ga->min_amount; ?>" data-gated_type="<?php echo $ga->gated_type; ?>" class="ga_edit text-primary text-decoration-none fw-medium" href="add-nft-gated_access?ga_id=<?php echo $ga->id; ?>">Edit</a>
                    <?php } ?>
                </div>
                <?php if($ga->is_active == 1){ ?>
                    <div class="fw-medium text-blue-stone">Enabled</div>
                <?php }else{ ?>
                    <div class="fw-medium text-blue-stone">Disabled</div>
                <?php } ?>
            </div>
            <div class="ms-auto">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $ga->id; ?>" aria-expanded="true" aria-controls="panelsStayOpen-collapse<?php echo $ga->id; ?>"></button>
            </div>
        </div>
        <div id="panelsStayOpen-collapse<?php echo $ga->id; ?>" class="accordion-collapse collapse border-top p-6">
            <ul class="list-card-tokan">
                <li class="list-card-tokan-item">
                    <div class="fw-medium lh-lg text-gray-700"><?php echo ($ga->gated_type == \lighthouse\GatedAccess::TOKEN_BASED_GATED)?'Token contract':'NFT contract'; ?></div>
                    <div class="fw-semibold fs-lg"><?php echo $ga->contract; ?></div>
                </li>
                <li class="list-card-tokan-item">
                    <div class="fw-medium lh-lg text-gray-700">Min amount</div>
                    <div class="fw-semibold fs-lg"><?php echo $ga->min_amount; ?></div>
                </li>
            </ul>
        </div>
    </div>

    <?php
}