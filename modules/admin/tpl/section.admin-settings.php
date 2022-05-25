<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">

        <div class="container-fluid h-100">
          <div class="row h-100"> 
            <div class="col h-100">           
              <div class="card shadow">
                <div class="card-body p-xl-20">
                  <div class="display-5 fw-medium">Community info</div>
                  <div class="text-muted mt-1">Configure details and setup your community</div>
                  <form class="mt-20">
                    <div class="row">
                      <div class="col-xl-6">
                        <label for="" class="form-label">Community name</label>
                        <input type="text" class="form-control form-control-lg mb-6" id="">
                      </div>
                      <div class="col-xl-6">
                        <label for="" class="form-label">Blockchain</label>
                        <select class="form-select form-select-lg mb-6">
                          <option selected>Gnosis Chain</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mt-xl-12">
                      <div class="col-xl-4">
                        <label for="NTTTicker" class="form-label">NTT ticker</label>
                        <div class="input-group input-group-lg mb-6">
                          <span class="input-group-text fw-medium" id="">nt</span>
                          <input type="text" class="form-control" id="NTTTicker" placeholder="MyDAO">
                        </div>
                      </div>
                      <div class="col-xl-8">
                        <label for="NTTTicker" class="form-label">NTT ticker image  (25px x 25px)</label>
                        <div class="d-flex align-items-center mb-6">
                          <div class="upload-logo me-6">
                            <svg class="feather">
                              <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#image"/>
                            </svg>
                          </div>
                          <div class="me-6">
                            <input type="file" id="upload" hidden/>
                            <label class="btn btn-light btn-upload" for="upload">Upload Image</label>
                          </div>
                          <a class="text-muted fw-medium fs-5 text-decoration-none" href="#">Remove image</a>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-xl-12">
                      <div class="col">
                        <label for="NTTTicker" class="form-label">Personalize claim form</label>
                        <div class="d-flex flex-column flex-xl-row align-items-center">
                            <div class="card bg-lighter card-image-uploads p-6 rounded-3">
                            <input type="file" name="file" id="uploadClaims" multiple hidden        onchange="javascript:updateList()" />
                                <label class="card-body d-flex flex-column align-items-center" for="uploadClaims">
                                    <div class="upload-logo my-8">
                                        <svg class="feather">
                                            <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#image"/>
                                        </svg>
                                    </div>
                                    <div id="fileList"></div>
                                    <div class="fw-medium text-hide"><span class="text-primary">Browse images</span></div>
                                    <div class="text-muted mt-2 mb-8 text-center">1060px x 1080px recommended. Max 1MB (png, jpg)</div>
                                </label>
                            </div>
                            <ul class="upload-image-view">
                              <li class="upload-image-item">
                                  <a class="image-del" href="#">
                                      <svg class="feather">
                                          <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#x"/>
                                      </svg>
                                  </a>
                                  <img src="<?php echo app_cdn_path; ?>img/claim/01.png" >
                              </li>
                              <li class="upload-image-item">
                                  <a class="image-del" href="#">
                                      <svg class="feather">
                                          <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#x"/>
                                      </svg>
                                  </a>
                                  <img src="<?php echo app_cdn_path; ?>img/claim/01.png" >
                                </li>
                            </ul>
                        </div>    
                      </div>
                    </div>
                  </form>
                </div>
                <div class="card-body border-top d-flex justify-content-end gap-3">
                  <button type="button" class="btn btn-primary disabled">Save</button>
                </div>
              </div>

              <div class="card shadow mt-12">
                <div class="card-body p-xl-20">
                  <div class="display-5 fw-medium">Gas tank</div>
                  <div class="text-muted mt-1">Send USDC (ERC-20) on the Gnosis chain to run Lighthouse gas-free for your community</div>
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
    // File upload
    updateList = function() {
      var input = document.getElementById('uploadClaims');
      var output = document.getElementById('fileList');
      var appBanners = document.getElementsByClassName('text-hide');

      output.innerHTML = '<ul>';
      for (var i = 0; i < input.files.length; ++i) {
        output.innerHTML += '<li>' + input.files.item(i).name + '</li>';
        appBanners[i].style.display = 'none';
      }
      output.innerHTML += '</ul>';
    }
</script>