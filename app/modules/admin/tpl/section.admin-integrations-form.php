<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="d-flex py-6">
        <a role="button" class="btn btn-white me-auto" href="admin-integrations"><i data-feather="arrow-left" class="me-2"></i> Back</a>
        <button type="button" class="btn btn-primary me-2">Preview</button>
        <button type="button" class="btn btn-primary">SAVE</button>
      </div>
    </div>

    <div class="col-12">
      <div class="card shadow p-6 mb-12">
        <div class="card-body border rounded-1">
          <input class="form-control form-control-xxl" type="text" placeholder="Untitled form">
          <input class="form-control form-control-lg border-0 min-h-0 py-0" type="text" placeholder="Enter form description">
        </div>
      </div>
    </div>

    <div class="col-12">
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
                    <i data-feather="align-left" class="me-3"></i>
                    <div class="fs-4">Short answer</div>
                  </div>
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton1">
                  <li class="border-bottom">
                    <a class="dropdown-item d-flex align-items-center py-6  px-12" href="#">
                      <i data-feather="align-left" class="me-6"></i>
                      <div class="fs-4">Short answer</div>
                    </a>
                  </li>
                  <li class="border-bottom">
                    <a class="dropdown-item d-flex align-items-center py-6  px-12" href="#">
                      <i data-feather="align-justify" class="me-6"></i>
                      <div class="fs-4">Pragraph</div>
                    </a>
                  </li>
                  <li class="border-bottom">
                    <a class="dropdown-item d-flex align-items-center py-6  px-12" href="#">
                      <i data-feather="circle" class="me-6"></i>
                      <div class="fs-4">Multiple choice</div>
                    </a>
                  </li>
                  <li class="border-bottom">
                    <a class="dropdown-item d-flex align-items-center py-6  px-12" href="#">
                      <i data-feather="check-square" class="me-6"></i>
                      <div class="fs-4">Checkboxes</div>
                    </a>
                  </li>
                  <li class="border-bottom">
                    <a class="dropdown-item d-flex align-items-center py-6  px-12" href="#">
                      <i data-feather="arrow-down-circle" class="me-6"></i>
                      <div class="fs-4">Dropdown</div>
                    </a>
                  </li>
                  <li class="">
                    <a class="dropdown-item d-flex align-items-center py-6  px-12" href="#">
                      <i data-feather="upload" class="me-6"></i>
                      <div class="fs-4">File upload</div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <label for="" class="form-label">Description</label>
          <textarea class="form-control form-control-lg" id="" rows="4" placeholder="Explain your contribution here"></textarea>
        </div>
        <hr class="my-2">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-end">
            <button class="btn min-w-auto py-0"><i data-feather="copy" class="text-dark"></i></button>
            <button class="btn min-w-auto py-0"><i data-feather="trash" class="text-dark"></i></button>
            <div class="vr"></div>
            <div class="ms-8 me-6 fw-medium text-lg">Required</div>
            <label class="switch">
              <input type="checkbox" class="form-switch-input">
              <span class="slider"></span>
            </label>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<?php include_once app_root . '/templates/admin-foot.php'; ?>
<script>
    feather.replace()
</script>