<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">

        <div class="container-fluid h-100">
          <div class="row h-100"> 
            <div class="col h-100">           
              <div class="card shadow">
                <div class="card-body p-xl-20">
                  <div class="display-5 fw-medium">Lighthouse integrations</div>
                  <div class="text-muted mt-1">Integrate with third party data sources and applications using pre-built connectors or APIs</div>
                  <div class="fs-2 fw-medium mt-14" id="Forms">Forms</div>
                  <div class="fw-medium">Design forms to collect contributions from your community</div>
                  <form class="mt-10 col-xxl-10">
                    <div class="row">
                      <div class="col-xl-6">
                        <div class="card border rounded-3 mb-12 mb-lg-0">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-7">
                                <div class="card-logo me-8">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-simple.png">
                                </div>
                                <div class="fs-4 fw-semibold">Simple claim form</div>
                                <div class="ms-auto">
                                    <label class="switch">
                                        <input type="checkbox" class="form-switch-input">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="fw-medium lh-lg two-lines-wrap text-gray-700">This form can be used by community members to
request attestations for any purpose.</div>
                          </div>
                          <div class="border-top card-body text-end">
                            <a href="#" class="fw-medium text-decoration-none text-primary">Active</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-6">
                        <a class="card border-dashed rounded-3 mb-12 mb-lg-0 h-100 text-decoration-none" role="button" data-bs-toggle="modal" data-bs-target="#modalForm"> 
                          <div class="d-flex align-items-center justify-content-center flex-column h-100">                         
                            <img src="<?php echo app_cdn_path; ?>img/icon-add.png">
                            <div class="fw-medium mt-4">New form</div>   
                          </div>                       
                        </a>
                      </div>
                    </div>

                    <div class="fs-2 fw-medium mt-14" id="Interactions">Interactions</div>
                    <div class="fw-medium">Capture interactions from community members across apps, dapps and blockchains</div>
                    <div class="row mt-10">
                      <div class="col-xl-6">
                        <div class="card border rounded-3 mb-12 mb-lg-0">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-7">
                                <div class="card-logo me-8">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-discord.png">
                                </div>
                                <div class="fs-4 fw-semibold">MEE6 - The Discord bot</div>
                                <div class="ms-auto">
                                    <label class="switch">
                                        <input type="checkbox" class="form-switch-input">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="fw-medium lh-lg two-lines-wrap text-gray-700">Configure moderation, leveling, twitch alerts,
and much more.</div>
                          </div>
                          <div class="border-top card-body text-end">
                            <a href="#" class="fw-medium text-decoration-none text-primary">Coming Soon!</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-6">
                        <a class="card border-dashed rounded-3 mb-12 mb-lg-0 h-100 text-decoration-none" role="button" data-bs-toggle="modal" data-bs-target="#modalInteraction"> 
                          <div class="d-flex align-items-center justify-content-center flex-column h-100">                         
                            <img src="<?php echo app_cdn_path; ?>img/icon-add.png">
                            <div class="fw-medium mt-4">New Interaction</div>   
                          </div>                       
                        </a>
                      </div>
                    </div>

                    <div class="fs-2 fw-medium mt-14" id="Identity">Identity</div>
                    <div class="fw-medium">Enable identity verification to increase security, trust and transparency in your community</div>
                    <div class="row mt-10">
                      <div class="col-xl-6">
                        <div class="card border rounded-3 mb-12 mb-lg-0">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-7">
                                <div class="card-logo me-8">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-grape.png">
                                </div>
                                <div class="fs-4 fw-semibold">Grape protocol</div>
                                <div class="ms-auto">
                                    <label class="switch">
                                        <input type="checkbox" class="form-switch-input">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="fw-medium lh-lg two-lines-wrap text-gray-700">Direct proof of "Skin in the Game" for every community 
member.</div>
                          </div>
                          <div class="border-top card-body text-end">
                            <a href="#" class="fw-medium text-decoration-none text-primary">Coming Soon!</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-6">
                        <div class="card border rounded-3 mb-12 mb-lg-0">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-7">
                                <div class="card-logo me-8">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-civic.png">
                                </div>
                                <div class="fs-4 fw-semibold">Civic pass</div>
                                <div class="ms-auto">
                                    <label class="switch">
                                        <input type="checkbox" class="form-switch-input">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="fw-medium lh-lg two-lines-wrap text-gray-700">An integrated permissioning tool that helps businesses
control access to their dApps.</div>
                          </div>
                          <div class="border-top card-body text-end">
                            <a href="#" class="fw-medium text-decoration-none text-primary">Coming Soon!</a>
                          </div>
                        </div>
                      </div>                      
                    </div>

                    <div class="fs-2 fw-medium mt-14" id="Apps">Apps</div>
                    <div class="fw-medium">Activate and expand your decentralized community</div>
                    <div class="row mt-10">
                      <div class="col-xl-6">
                        <div class="card border rounded-3 mb-12">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-7">
                                <div class="card-logo me-8">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-ntts.png">
                                </div>
                                <div class="fs-4 fw-semibold">NTTs </div>
                                <div class="ms-auto">
                                    <label class="switch">
                                        <input type="checkbox" class="form-switch-input">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="fw-medium lh-lg two-lines-wrap text-gray-700">Mint and distribute non-transferrable tokens to your 
community.</div>
                          </div>
                          <div class="border-top card-body">
                            <div class="d-flex justify-content-between align-items-center">
                              <div class="fw-medium"><sapn class="text-gray-700">Developed by: </sapn>Lighthouse</div>
                              <a href="#" class="fw-medium text-decoration-none text-danger">Not Activated</a>
                            </div>                            
                          </div>
                        </div>
                      </div>

                      <div class="col-xl-6">
                        <div class="card border rounded-3 mb-12">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-7">
                                <div class="card-logo me-8">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-goal.png">
                                </div>
                                <div class="fs-4 fw-semibold">Goal based NFT badges</div>
                                <div class="ms-auto">
                                    <label class="switch">
                                        <input type="checkbox" class="form-switch-input">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="fw-medium lh-lg two-lines-wrap text-gray-700">Issue NFT badges when a community member reaches a
particular goal or milestone.</div>
                          </div>
                          <div class="border-top card-body">
                            <div class="d-flex justify-content-between align-items-center">
                              <div class="fw-medium"><sapn class="text-gray-700">Developed by: </sapn>Cardinal</div>
                              <a href="#" class="fw-medium text-decoration-none text-primary">Coming Soon!</a>
                            </div>                            
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-xl-6">
                        <div class="card border rounded-3 mb-12">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-7">
                                <div class="card-logo me-8">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-evolving.png">
                                </div>
                                <div class="fs-4 fw-semibold">Evolving reputation NFT</div>
                                <div class="ms-auto">
                                    <label class="switch">
                                        <input type="checkbox" class="form-switch-input">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="fw-medium lh-lg two-lines-wrap text-gray-700">Create an NFT that evolves based on contribution to your 
community.</div>
                          </div>
                          <div class="border-top card-body">
                            <div class="d-flex justify-content-between align-items-center">
                              <div class="fw-medium"><sapn class="text-gray-700">Developed by: </sapn>Cardinal</div>
                              <a href="#" class="fw-medium text-decoration-none text-primary">Coming Soon!</a>
                            </div>                            
                          </div>
                        </div>
                      </div>

                      <div class="col-xl-6">
                        <div class="card border rounded-3 mb-12">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-7">
                                <div class="card-logo me-8">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-token.png">
                                </div>
                                <div class="fs-4 fw-semibold">Token payments </div>
                                <div class="ms-auto">
                                    <label class="switch">
                                        <input type="checkbox" class="form-switch-input">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="fw-medium lh-lg two-lines-wrap text-gray-700">Airdrop tokens to your community based on active 
participation.</div>
                          </div>
                          <div class="border-top card-body">
                            <div class="d-flex justify-content-between align-items-center">
                              <div class="fw-medium"><sapn class="text-gray-700">Developed by: </sapn>Streamflow</div>
                              <a href="#" class="fw-medium text-decoration-none text-primary">Coming Soon!</a>
                            </div>                            
                          </div>
                        </div>
                      </div>

                      <div class="col-xl-6">
                        <div class="card border rounded-3 mb-12">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-7">
                                <div class="card-logo me-8">
                                    <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-streams.png">
                                </div>
                                <div class="fs-4 fw-semibold">Token streams</div>
                                <div class="ms-auto">
                                    <label class="switch">
                                        <input type="checkbox" class="form-switch-input">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="fw-medium lh-lg two-lines-wrap text-gray-700">Periodically stream tokens to your community, based on
active participation.</div>
                          </div>
                          <div class="border-top card-body">
                            <div class="d-flex justify-content-between align-items-center">
                              <div class="fw-medium"><sapn class="text-gray-700">Developed by: </sapn>Streamflow</div>
                              <a href="#" class="fw-medium text-decoration-none text-primary">Coming Soon!</a>
                            </div>                            
                          </div>
                        </div>
                      </div>

                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</main>
<!-- Modal From -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-size-02">
    <div class="modal-content">
      <div class="modal-body p-10">
        <div class="fs-2 fw-semibold mb-22 mt-3">Drop your contact details and we'll get in touch <br>
to set up your form.</div>
        <input type="text" class="form-control form-control-lg mb-16" id="" placeholder="Email / Telegram / Discord handle">
      </div> 
      <div class="modal-footer pe-10">
        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
        <a role="button" class="btn btn-primary" href="admin-integrations-form">SAVE</a>
      </div>   
    </div>
  </div>
</div>

<!-- Modal From -->
<div class="modal fade" id="modalInteraction" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-size-02">
    <div class="modal-content">
      <div class="modal-body p-10">
        <div class="fs-2 fw-semibold mb-22 mt-3">Drop your contact details and we'll get in touch<br>
to set up your integration.</div>
        <input type="text" class="form-control form-control-lg mb-16" id="" placeholder="Email / Telegram / Discord handle">
      </div> 
      <div class="modal-footer pe-10">
        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
        <a role="button" class="btn btn-primary" href="admin-integrations-form">SAVE</a>
      </div>   
    </div>
  </div>
</div>
<?php include_once app_root . '/templates/admin-foot.php'; ?>