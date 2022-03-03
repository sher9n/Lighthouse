<?php
if(count($respose->data) > 0 ){
    foreach ($respose->data as $index => $obj){ ?>
        <div class="my-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="d-flex align-items-center w-70">
                            <div class="avator rounded-circle me-6">
                                <img src="<?php echo $c_logo; ?>" width="48" height="48" />
                            </div>
                            <div class="w-80">
                                <div class="fs-3 text-truncate"><?php echo $c_name; ?></div>
                                <div class="text-muted lh-1"><?php echo $type; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="fs-5 "><?php echo $obj->text; ?></div>
                </div>
            </div>
        </div>
    <?php }
}else{ ?>
    <div class="card shadow d-none">
        <div class="card-body text-center">
            <img src="<?php echo app_cdn_path; ?>img/img-myactivity.png" class="img-fluid rounded mt-16" alt=""/>
            <div class="fs-1 fw-semibold mt-12">No contributions yet!</div>
            <div class="fs-5  mt-5 text-center">Post an article link or announcement <br>
                from a DAO to start contributing</div>
            <button type="button" class="btn btn-primary btn-lg px-25 text-uppercase mt-23 mb-18">Post Now</button>
        </div>
    </div>
<?php } ?>