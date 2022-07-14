<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
      <div class="container-fluid h-100">
        <div class="row">
          <div class="col-9">
            <div class="d-flex mb-6">
              <a role="button" class="btn btn-white text-capitalize me-auto" href="admin-integrations">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left me-2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> Back</a>
              <button type="button" class="btn btn-blue-stone me-2">Preview</button>
              <a role="button" class="btn btn-primary" href="admin-integrations-01">SAVE</a>
            </div>
          </div>

          <div class="col-9">
            <div class="card shadow p-6 mb-12">
              <div class="card-body border rounded-1">
                <input class="form-control form-control-xxl" type="text" placeholder="Untitled form">
                <input class="form-control form-control-lg border-0 min-h-0 py-0" type="text" placeholder="Enter form description">
              </div>
            </div>
          </div>

          <div class="col-9">
            <div class="card shadow">
              <div class="card-body">
                <div class="row mb-12">
                  <div class="col-md-8">
                    <label for="" class="form-label">Question</label>
                    <input type="text" class="form-control form-control-lg" id="" placeholder="What was your contribution? ">
                  </div>
                  <div class="col-md-4">
                    <label for="" class="form-label">Select type</label>
                    <div class="dropdown">                                    
                      <button class="btn btn-lg dropdown-toggle d-flex justify-content-between align-items-center text-transform-inherit fw-medium w-100 border rounded-1" type="button" id="" data-bs-toggle="dropdown" aria-expanded="false">
                        <div id="" class="d-flex align-items-center text-dark">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-left me-3"><line x1="17" y1="10" x2="3" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="17" y1="18" x2="3" y2="18"></line></svg>
                          <div class="fs-4">Short answer</div>
                        </div>
                      </button>
                      <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton1">
                        <li class="border-bottom">
                          <a class="dropdown-item d-flex align-items-center py-6  px-12" href="#">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-left me-6"><line x1="17" y1="10" x2="3" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="17" y1="18" x2="3" y2="18"></line></svg>
                            <div class="fs-4">Short answer</div>
                          </a>
                        </li>
                        <li class="border-bottom">
                          <a class="dropdown-item d-flex align-items-center py-6  px-12" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-justify me-6"><line x1="21" y1="10" x2="3" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="21" y1="18" x2="3" y2="18"></line></svg>
                            <div class="fs-4">Pragraph</div>
                          </a>
                        </li>
                        <li class="border-bottom">
                          <a class="dropdown-item d-flex align-items-center py-6  px-12" href="#">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle me-6"><circle cx="12" cy="12" r="10"></circle></svg>
                            <div class="fs-4">Multiple choice</div>
                          </a>
                        </li>
                        <li class="border-bottom">
                          <a class="dropdown-item d-flex align-items-center py-6  px-12" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square me-6"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                            <div class="fs-4">Checkboxes</div>
                          </a>
                        </li>
                        <li class="border-bottom">
                          <a class="dropdown-item d-flex align-items-center py-6  px-12" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down-circle me-6"><circle cx="12" cy="12" r="10"></circle><polyline points="8 12 12 16 16 12"></polyline><line x1="12" y1="8" x2="12" y2="16"></line></svg>
                            <div class="fs-4">Dropdown</div>
                          </a>
                        </li>
                        <li class="">
                          <a class="dropdown-item d-flex align-items-center py-6  px-12" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag me-6"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                            <div class="fs-4">Tags</div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>                
                <!-- Short answer -->
                <div>
                  <label for="" class="form-label">Description</label>
                  <input type="text" class="form-control form-control-lg" id="" placeholder="Please enter the reason for this contribution">
                </div>
                <!-- Short answer END -->
                <!-- Multiple choice -->
                <div class="d-none">
                  <label for="" class="form-label">Description</label>
                  <div class="row mb-6">
                    <div class="col-11">
                      <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle me-6"><circle cx="12" cy="12" r="10"></circle></svg>
                        <input type="text" class="form-control form-control-lg" id="" aria-describedby="" placeholder="Please enter multiple choice option">
                      </div>
                    </div>                  
                  </div>
                  <div class="row mb-6">
                    <div class="col-11">
                      <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle me-6"><circle cx="12" cy="12" r="10"></circle></svg>
                        <input type="text" class="form-control form-control-lg" id="" aria-describedby="" placeholder="Please enter multiple choice option">
                      </div>
                    </div>
                    <div class="col px-0">
                      <button class="btn btn-delete ms-0 h-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                      </button>
                    </div>
                  </div>
                </div>
                <!-- Multiple choice END -->
                <!-- Checkboxes -->
                <div class="d-none">
                  <label for="" class="form-label">Description</label>
                  <div class="row mb-6">
                    <div class="col-11">
                      <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-square me-6"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect></svg>
                        <input type="text" class="form-control form-control-lg" id="" aria-describedby="" placeholder="Please enter checkbox option">
                      </div>
                    </div>                  
                  </div>
                  <div class="row mb-6">
                    <div class="col-11">
                      <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-square me-6"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect></svg>
                        <input type="text" class="form-control form-control-lg" id="" aria-describedby="" placeholder="Please enter checkbox option">
                      </div>
                    </div>
                    <div class="col px-0">
                      <button class="btn btn-delete ms-0 h-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                      </button>
                    </div>
                  </div>
                </div>  
                <!-- Checkboxes END -->
                <!-- Dropdown -->
                <div class="d-none">
                  <label for="" class="form-label">Description</label>
                  <div class="row mb-6">                  
                    <div class="col-11">                    
                      <input type="text" class="form-control form-control-lg" id="" aria-describedby="" placeholder="Please enter dropdown option">
                    </div>                  
                  </div>
                  <div class="row mb-6">
                    <div class="col-11">                    
                      <input type="text" class="form-control form-control-lg" id="" aria-describedby="" placeholder="Please enter dropdown option">
                    </div>
                    <div class="col px-0">
                      <button class="btn btn-delete ms-0 h-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                      </button>
                    </div>
                  </div>
                  <button type="button" class="btn btn-primary">add option</button>
                </div>
                <!-- Dropdown END -->
                <!-- Tags -->
                <div class="d-none">
                  <div class="d-flex justify-content-between">
                    <label for="" class="form-label">Description</label>
                    <div class="fw-medium text-muted">Enter comma separated values</div>
                  </div>
                  <input type="text" class="form-control form-control-lg" id="" placeholder="Marketing, Sales, Development">
                </div>
                <!-- Tags END -->
                <!-- Pragraph -->
                <div class="d-none">
                  <label for="" class="form-label">Description</label>
                  <textarea class="form-control form-control-lg" id="" rows="4" placeholder="Please enter the reason for this contribution"></textarea>
                </div>
                <!-- Pragraph END -->
              </div>
              <hr class="my-2">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-end">
                  <a class="px-8 btn-copy" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy text-dark"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                  </a>
                  <a class="px-8 btn-trash" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash text-dark"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                  </a>
                  <div class="vr"></div>
                  <div class="ms-8 me-6 fw-medium text-lg">Required</div>
                  <label class="switch">
                    <input type="checkbox" class="form-switch-input">
                    <span class="slider"></span>
                  </label>
                </div>
              </div>
              <a role="button" class="position-absolute top-0 start-100 p-6 bg-white rounded ms-6 shadow" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
              </a>
            </div>
          </div>

        </div>
      </div>
    </section>
</main>
<?php include_once app_root . '/templates/admin-foot.php'; ?>