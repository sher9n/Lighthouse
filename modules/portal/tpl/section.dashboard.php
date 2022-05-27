<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-white shadow mb-12">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
        <img src="<?php echo app_cdn_path; ?>img/portal-logo.png" >
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse align-items-center" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="#">All apps</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">My apps</a>
        </li>        
      </ul>
      <div class="vr align-self-center" style="height: 40px;margin: 0 1.5rem;"></div>
            <div class="dropdown">
                <button class="btn btn-white dropdown-toggle d-flex align-items-center p-0 border-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="non-avator me-3"></div>
                    <div class="me-2"><?php echo \Core\Utils::WalletAddressFormat($__page->sel_wallet_adr); ?></div>
                </button>
                <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i data-feather="refresh-ccw"></i>
                            <div class="ms-12">Disconnect</div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="admin">
                            <i data-feather="log-out"></i>
                            <div class="ms-12">Change Wallet</div>
                        </a>
                    </li>
                </ul>
            </div>
        
    </div>
  </div>
</nav>

<main>
    <div class="container-fluid">
        <div class="row">
          <div class="col">
            <div class="card shadow">
              <div class="card-body text-center p-12">
                <div class="fs-2 d-flex align-items-center justify-content-center">Welcome to the Lighthouse Developer Portal <img src="<?php echo app_cdn_path; ?>img/waving-hand.svg" class="ms-3"></div>
                <div class="text-muted mt-3">Discover applications you can adopt to work with your community or join hands with the extensive developer community to create your own!</div>
                <div class="mt-12">
                  <button type="submit" class="btn btn-dark">Read the docs</button>
                  <button type="submit" class="btn btn-primary ms-2">Connect Wallet</button>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</main>

<?php include_once app_root . '/templates/foot.php'; ?>