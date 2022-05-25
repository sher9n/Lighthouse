<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col h-100">
                    <div class="card shadow">
                        <form id="settingsForm" method="post" action="admin-settings" autocomplete="off">
                            <div class="card-body p-20">
                                <div class="display-5 fw-medium">Community info</div>
                                <div class="text-muted mt-1">Configure details and setup your community</div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="" class="form-label">Community name</label>
                                        <input type="text" class="form-control form-control-lg"
                                               value="<?php echo $__page->community->dao_name; ?>" name="dao_name"
                                               id="dao_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label">Blockchain</label>
                                        <input type="text" class="form-control" id="blockchain" name="blockchain"
                                               readonly value="<?php echo $__page->community->blockchain; ?>">
                                    </div>
                                </div>
                                <div class="row mt-18">
                                    <div class="col-md-3">
                                        <label for="NTTTicker" class="form-label">NTT ticker</label>
                                        <div class="input-group input-group-lg mb-3">
                                            <span class="input-group-text fw-medium" id="">nt</span>
                                            <input type="text" class="form-control" readonly id="ticker"
                                                   name="ticker" value="<?php echo $__page->community->ticker; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="NTTTicker" class="form-label">NTT ticker image (25px x
                                            25px)</label>
                                        <div class="d-flex align-items-center">
                                            <div class="upload-logo me-6">
                                                <svg class="feather">
                                                    <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#image"/>
                                                </svg>
                                            </div>
                                            <div class="me-6">
                                                <input type="file" id="ticker_imag" name="ticker_imag" hidden/>
                                                <label class="btn btn-light btn-upload" for="ticker_imag">Upload
                                                    Image</label>
                                            </div>
                                            <a class="text-muted fw-medium fs-5 text-decoration-none" href="#">Remove
                                                image</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-18">
                                    <div class="col">
                                        <label for="NTTTicker" class="form-label">Personalize claim form</label>
                                        <div class="d-flex align-items-center">
                                            <div class="card bg-lighter card-image-uploads p-6 rounded-3">
                                                <div class="card-body d-flex flex-column align-items-center">
                                                    <div class="upload-logo my-8">
                                                        <svg class="feather">
                                                            <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#image"/>
                                                        </svg>
                                                    </div>
                                                    <input type="file" id="background_imag" name="background_imag" hidden/>
                                                    <div class="fw-medium">Drag and drop images, or <label
                                                                for="background_imag" class="text-primary btn-upload">Browse</label>
                                                    </div>
                                                    <div class="text-muted mt-2 mb-8">1060px x 1080px recommended.
                                                        Max 1MB (png, jpg)
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="upload-image-view">
                                                <a class="image-del" href="#">
                                                    <svg class="feather">
                                                        <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#x"/>
                                                    </svg>
                                                </a>
                                                <img src="<?php echo app_cdn_path; ?>img/claim/01.png">
                                            </div>
                                            <div class="upload-image-view">
                                                <a class="image-del" href="#">
                                                    <svg class="feather">
                                                        <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#x"/>
                                                    </svg>
                                                </a>
                                                <img src="<?php echo app_cdn_path; ?>img/claim/01.png">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-top d-flex justify-content-end gap-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="card shadow mt-12">
                        <div class="card-body p-20">
                            <div class="display-5 fw-medium">Gas tank</div>
                            <div class="text-muted mt-1">Send USDC (ERC-20) on the Gnosis chain to run Lighthouse
                                gas-free for your community
                            </div>
                            <div class="mt-23">
                                <label class="form-label mb-4">Send to :</label>
                                <div class="fs-3 fw-semibold">0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507</div>
                            </div>
                            <div class="mt-16">
                                <label class="form-label mb-4">Current balance :</label>
                                <div class="fs-3 fw-semibold">$150 USDC (ERC-20)</div>
                            </div>
                            <a role="button" class="btn btn-primary mt-16" href="#">View Transactions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include_once app_root . '/templates/foot.php'; ?>
<script>
    feather.replace();

    $(document).ready(function() {
        $('#settingsForm').validate({
            rules: {
                dao_name: {
                    required: true
                }
            },
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        if (data.success == true) {

                        } else {
                            $('#' + data.element).addClass('form-control-lg error');
                            $('<label class="error">' + data.msg + '</label>').insertAfter('#' + data.element);
                        }
                    }
                });
            }
        });
    });
</script>