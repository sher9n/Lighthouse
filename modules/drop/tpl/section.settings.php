<main class="main-wrapper">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8 col-xl-5">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="mb-10">
                            <div class="form-label">Upload Logo</div>
                            <div class="card-drop-area bg-light rounded p-6">
                                <div class="drag-area rounded bg-white">
                                    <div class="icon">
                                        <img src="<?php echo app_cdn_path; ?>img/icon-upload-img.svg" width="60" height="60" >
                                    </div>
                                    <div class="fw-medium text-fiord mt-12">Drag and drop image here</div>
                                    <div class="fw-medium text-fiord">or</div>
                                    <button class="btn btn-link fw-medium p-0">Browse File</button>
                                    <input type="file" hidden>
                                </div>
                            </div>
                        </div>
                        <div class="mb-10">
                            <label for="PlatformName" class="form-label">Platform Name</label>
                            <input type="text" class="form-control bg-white" id="PlatformName" placeholder="Enter platform name">
                        </div>
                        <div class="mb-10">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" class="form-control bg-white" id="Email" placeholder="Enter email">
                        </div>
                        <div class="row mb-10">
                            <div class="col-md-6">
                                <label for="PrimaryColor" class="form-label">Primary Color</label>
                                <input type="text" class="form-control bg-white" id="PrimaryColor">
                            </div>
                            <div class="col-md-6">
                                <label for="SecondaryColor" class="form-label">Secondary Color</label>
                                <input type="text" class="form-control bg-white" id="SecondaryColor">
                            </div>
                        </div>
                        <div>
                            <label for="BackBarLink" class="form-label">Back Bar Link</label>
                            <input type="text" class="form-control bg-white" id="BackBarLink" placeholder="Enter back bar link">
                        </div>
                    </div>
                    <div class="dash-divider"></div>
                    <div class="card-body py-6">
                        <div class="d-flex flex-lg-row justify-content-lg-end flex-column-reverse">                        
                            <button type="button" class="btn btn-white btn-lg btn-mw-150 text-uppercase btn-m-block ">Cancel</button>
                            <button type="button" class="btn btn-primary btn-lg btn-mw-150 text-uppercase btn-m-block ">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</main>
<?php include_once app_root . '/templates/dash_foot.php'; ?>