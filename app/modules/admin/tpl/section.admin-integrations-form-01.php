<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
      <div class="container-fluid h-100">
        <div class="row">
          <div class="col-9">
            <div class="d-flex mb-6">
              <a role="button" class="btn btn-white text-capitalize me-auto" href="admin-integrations">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left me-2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> Back</a>
              <button type="button" class="btn btn-primary">Finish</button>
            </div>
          </div>

          <div class="col-9">
            <div class="card shadow mb-12">
              <div class="card-body">
                <div class="d-flex align-items-center mb-12">
                  <div class="fw-medium text-lg me-12">Setup Scoring</div>
                  <label class="switch">
                    <input type="checkbox" class="form-switch-input">
                    <span class="slider"></span>
                  </label>
                </div>
                <div class="">
                  <label for="" class="form-label">Max Points *</label>
                  <input type="text" class="form-control form-control-lg" id="" aria-describedby="Help">
                  <div id="Help" class="form-text">* Any modifications to scores will only apply to future contributions.</div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-9">
            <div class="card shadow">
              <div class="card-body">
                    <label for="" class="form-label">Approval type</label>
                    <div class="form-check">
                      <input class="form-check-input form-check-input-lg" type="radio" name="ApprovalType" id="YesNo">
                      <label class="form-check-label" for="YesNo">
                        Yes/No
                      </label>
                      <div class="text-lg fst-italic">Eg: Attended a meeting</div>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input form-check-input-lg" type="radio" name="ApprovalType" id="Rating">
                      <label class="form-check-label" for="Rating">
                        Rating
                      </label>
                    </div>
                <label for="" class="form-label">Description</label>
                <textarea class="form-control form-control-lg" id="" rows="4" placeholder="Explain your contribution here"></textarea>
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