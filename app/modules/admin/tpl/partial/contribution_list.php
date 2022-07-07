<?php
use Core\Utils;
if($claims != false && $claims->num_rows > 0 ){
    ?>
    <ul class="list-approvals">
    <?php
    foreach ($claims as $claim) {
        ?>
        <li data-item_id="<?php echo $claim['c_id']; ?>" class="list-approvals-item-two c_items" id="ca_item_<?php echo $claim['c_id']; ?>">
            <a class="text-decoration-none" href="#">
                <div class="d-flex align-items-center">
                    <div class="fs-4 fw-semibold text-truncate d-flex align-items-center">
                        <div><?php echo $claim['form_title']; ?></div>
                    </div>
                    <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                </div>
                <div class="fw-medium text-truncate text-muted my-1"><?php echo $claim['contribution_reason']; ?></div>
                    <ul class="select2-selection__rendered d-flex gap-3">
                        <?php
                        if(isset($claim['tags']) && strlen($claim['tags']) > 0){
                            $tags_arry = explode(",",$claim['tags']);
                            foreach ($tags_arry as $tag){ ?>
                                <li class="select2-selection__choice" title="<?php echo $tag; ?>" data-select2-id="141"><?php echo $tag; ?></li>
                                <?php
                            }
                        } ?>
                    </ul>
            </a>
        </li>
        <!-- Skeleton -->
        <div class="d-flex flex-column loading"> <!-- d-flex repace to d-none -->
            <div class="list-approvals-item-two">
                <div class="text-decoration-none">
                    <div class="d-flex align-items-center my-1">
                        <div class="fs-4-text-content w-40"></div>
                        <div class="ms-auto text-content w-10"></div>
                    </div>
                    <div class="text-content my-3"></div>
                    <div class="skeleton-btn-gray rounded"></div>
                </div>
            </div>
            <div class="list-approvals-item-two">
                <div class="text-decoration-none">
                    <div class="d-flex align-items-center my-1">
                        <div class="fs-4-text-content w-40"></div>
                        <div class="ms-auto text-content w-10"></div>
                    </div>
                    <div class="text-content my-3"></div>
                    <div class="skeleton-btn-gray rounded"></div>
                </div>
            </div>
            <div class="list-approvals-item-two">
                <div class="text-decoration-none">
                    <div class="d-flex align-items-center my-1">
                        <div class="fs-4-text-content w-40"></div>
                        <div class="ms-auto text-content w-10"></div>
                    </div>
                    <div class="text-content my-3"></div>
                    <div class="skeleton-btn-gray rounded"></div>
                </div>
            </div>
            <div class="list-approvals-item-two">
                <div class="text-decoration-none">
                    <div class="d-flex align-items-center my-1">
                        <div class="fs-4-text-content w-40"></div>
                        <div class="ms-auto text-content w-10"></div>
                    </div>
                    <div class="text-content my-3"></div>
                    <div class="skeleton-btn-gray rounded"></div>
                </div>
            </div>
            <div class="list-approvals-item-two border-bottom-0">
                <div class="text-decoration-none">
                    <div class="d-flex align-items-center my-1">
                        <div class="fs-4-text-content w-40"></div>
                        <div class="ms-auto text-content w-10"></div>
                    </div>
                    <div class="text-content my-3"></div>
                    <div class="skeleton-btn-gray rounded"></div>
                </div>
            </div>
        </div>
        <!-- Skeleton END -->
        <?php
    }
    ?>
    </ul>
<?php
}
else {
    ?>
    <div class="d-flex flex-column align-items-center justify-content-center h-100">
        <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
        <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a claim,<br>it will show up here</div>
    </div>
    <?php
}
?>
