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
            <div class="card shadow mb-12">
              <div class="card-body">
                    <label for="" class="form-label">Approval type</label>
                    <div class="form-check form-check-lg">
                      <input class="form-check-input" type="radio" name="ApprovalType" id="YesNo">
                      <label class="form-check-label" for="YesNo">
                        Yes/No
                      </label>
                      <div class="text-lg fst-italic mt-2">Eg: Attended a meeting</div>
                    </div>
                    <div class="form-check form-check-lg">
                      <input class="form-check-input" type="radio" name="ApprovalType" id="Rating">
                      <label class="form-check-label" for="Rating">
                        Rating
                      </label>
                      <div class="text-lg fst-italic mt-2">Eg: 4 out of 5 stars for a Github merge</div>
                    </div>
                    <div class="ps-18">
                      <label for="" class="form-label">Category</label>
                      <div class="row mb-6">
                        <div class="col-7">
                          <input type="text" class="form-control form-control-lg" id="" aria-describedby="">
                        </div>
                        <div class="col-auto px-0">
                          <div class="list-rating-scale list-rating-scale-lg">
                            <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="1" id="Complexityoption1" autocomplete="off">
                            <label class="btn btn-light ms-0" for="Complexityoption1">1</label>

                            <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="2" id="Complexityoption2" autocomplete="off">
                            <label class="btn btn-light" for="Complexityoption2">2</label>

                            <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="3" id="Complexityoption3" autocomplete="off">
                            <label class="btn btn-light" for="Complexityoption3">3</label>

                            <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="4" id="Complexityoption4" autocomplete="off">
                            <label class="btn btn-light" for="Complexityoption4">4</label>

                            <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="5" id="Complexityoption5" autocomplete="off">
                            <label class="btn btn-light me-0" for="Complexityoption5">5</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-6">
                        <div class="col-7">
                          <input type="text" class="form-control form-control-lg" id="" aria-describedby="">
                        </div>
                        <div class="col-auto px-0">
                          <div class="d-flex">
                            <div class="list-rating-scale list-rating-scale-lg">
                              <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="1" id="Complexityoption1" autocomplete="off">
                              <label class="btn btn-light ms-0" for="Complexityoption1">1</label>

                              <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="2" id="Complexityoption2" autocomplete="off">
                              <label class="btn btn-light" for="Complexityoption2">2</label>

                              <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="3" id="Complexityoption3" autocomplete="off">
                              <label class="btn btn-light" for="Complexityoption3">3</label>

                              <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="4" id="Complexityoption4" autocomplete="off">
                              <label class="btn btn-light" for="Complexityoption4">4</label>

                              <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="5" id="Complexityoption5" autocomplete="off">
                              <label class="btn btn-light me-0" for="Complexityoption5">5</label>
                            </div>
                            <button class="btn btn-delete">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                          </div>
                        </div>
                      </div>
                      <button type="button" class="btn btn-primary">Add Category</button>
                    </div>                
              </div>
            </div>
          </div>

          <div class="col-9">  
            <div class="card shadow">
              <div class="card-body">
                <label for="" class="form-label">Tags</label>
                <input type="text" class="form-control form-control-lg" id="" aria-describedby="" placeholder="Marketing, Sales, Development">
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
</main>
<?php include_once app_root . '/templates/admin-foot.php'; ?>