<?php foreach ($contributions as $contribution){ ?>
    <li class="list-history-item">
        <a class="text-decoration-none" href="#">
            <div class="d-flex align-items-center">
                <div class="fs-4 fw-semibold text-truncate d-flex align-items-center">
                    <div><?php echo $contribution['score']; ?> points</div>
                    <div class="text-muted mx-3">•</div>
                    <div><?php echo $contribution['form_title']; ?></div>
                </div>
                <div class="ms-auto fw-medium text-muted"><?php echo \Core\Utils::time_elapsed_string($contribution['c_at'],false,true); ?></div>
            </div>
            <div class="fw-medium text-truncate text-muted my-1"><?php echo $contribution['contribution_reason']?></div>
            <ul class="select2-selection__rendered d-flex gap-3">
                <!--<li class="select2-selection__choice" title="dfddsfsdf" data-select2-id="141">
                    <span class="select2-selection__choice__remove" role="presentation">×</span>dfddsfsdf</li>
                <li class="select2-selection__choice" title="dfdsfdsf" data-select2-id="142">
                    <span class="select2-selection__choice__remove" role="presentation">×</span>dfdsfdsf</li>-->
            </ul>
        </a>
    </li>
    <!-- Skeleton -->
    <div class="d-flex flex-column loading"> <!-- d-flex repace to d-none -->
        <div class="list-history-item">
            <div class="text-decoration-none">
                <div class="d-flex align-items-center my-1">
                    <div class="fs-4-text-content w-40"></div>
                    <div class="ms-auto text-content w-10"></div>
                </div>
                <div class="text-content my-3"></div>
            </div>
        </div>
        <div class="list-history-item">
            <div class="text-decoration-none">
                <div class="d-flex align-items-center my-1">
                    <div class="fs-4-text-content w-40"></div>
                    <div class="ms-auto text-content w-10"></div>
                </div>
                <div class="text-content my-3"></div>
            </div>
        </div>
        <div class="list-history-item">
            <div class="text-decoration-none">
                <div class="d-flex align-items-center my-1">
                    <div class="fs-4-text-content w-40"></div>
                    <div class="ms-auto text-content w-10"></div>
                </div>
                <div class="text-content my-3"></div>
            </div>
        </div>
        <div class="list-history-item">
            <div class="text-decoration-none">
                <div class="d-flex align-items-center my-1">
                    <div class="fs-4-text-content w-40"></div>
                    <div class="ms-auto text-content w-10"></div>
                </div>
                <div class="text-content my-3"></div>
            </div>
        </div>
        <div class="list-history-item">
            <div class="text-decoration-none">
                <div class="d-flex align-items-center my-1">
                    <div class="fs-4-text-content w-40"></div>
                    <div class="ms-auto text-content w-10"></div>
                </div>
                <div class="text-content my-3"></div>
            </div>
        </div>
        <div class="list-history-item">
            <div class="text-decoration-none">
                <div class="d-flex align-items-center my-1">
                    <div class="fs-4-text-content w-40"></div>
                    <div class="ms-auto text-content w-10"></div>
                </div>
                <div class="text-content my-3"></div>
            </div>
        </div>
        <div class="list-history-item border-bottom-0">
            <div class="text-decoration-none">
                <div class="d-flex align-items-center my-1">
                    <div class="fs-4-text-content w-40"></div>
                    <div class="ms-auto text-content w-10"></div>
                </div>
                <div class="text-content my-3"></div>
            </div>
        </div>
    </div>
    <!-- Skeleton END -->
<?php } ?>