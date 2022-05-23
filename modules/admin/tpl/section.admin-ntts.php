<main>
    <aside class="left-aside">
        <div class="ms-3">
            <img src="img/logo.svg" >
        </div>
        <div class="main-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="admin-dashboard.html">
                        <svg class="feather">
                            <use href="icons/feather-sprite.svg#layers"/>
                        </svg>
                        <div class="ms-12">Dashboard</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin-approvals.html">
                        <svg class="feather">
                            <use href="icons/feather-sprite.svg#check-circle"/>
                        </svg>
                        <div class="ms-12">Approvals</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="admin-send-ntt.html">
                        <svg class="feather">
                            <use href="icons/feather-sprite.svg#move"/>
                        </svg>
                        <div class="ms-12">Send NTTs</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin-stewards.html">
                        <svg class="feather">
                            <use href="icons/feather-sprite.svg#user"/>
                        </svg>
                        <div class="ms-12">Stewards</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin-integrations.html">
                        <!-- <img src="img/icon-integrations.svg">  -->
                        <svg class="feather">
                            <use href="icons/feather-sprite.svg#terminal"/>
                        </svg>
                        <div class="ms-12">Integrations</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin-settings.html">
                        <svg class="feather">
                            <use href="icons/feather-sprite.svg#settings"/>
                        </svg>
                        <div class="ms-12">Settings</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="user-nav dropup">
            <div class="dropdown">
                <button class="btn btn-white dropdown-toggle d-flex align-items-center p-0 border-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="non-avator me-3"></div>
                    <div class="me-2 fs-5">0xd91c...4507</div>
                </button>
                <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <a class="dropdown-item" href="#">
                            <svg class="feather">
                                <use href="icons/feather-sprite.svg#refresh-ccw"/>
                            </svg>
                            <div class="ms-12">Disconnect</div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <svg class="feather">
                                <use href="icons/feather-sprite.svg#log-out"/>
                            </svg>
                            <div class="ms-12">Change Wallet</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <section class="admin-body-section">

        <div class="container-fluid h-100">

            <div class="col">
                <div class="card shadow">
                    <div class="card-body px-27 py-30">
                        <div class="display-5 fw-medium">Recognize community participation</div>
                        <div class="text-muted mt-1">Send NTTs to anyone in your community</div>
                        <div class="fs-5 fw-medium mt-20">Which wallet do you want to distribute NTTs to?</div>
                        <div class="fs-3 fw-semibold mt-3">0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507</div>
                        <a role="button" class="btn btn-light mt-3" href="#">Change Wallet</a>
                        <div class="col-6">
                            <div class="mt-16">
                                <label for="LHT" class="form-label">How many $LHT do you want to claim?</label>
                                <input type="text" class="form-control form-control-lg mb-6 fs-3" id="LHT" placeholder="100">
                                <div class="d-flex">
                                    <div class="badge bg-light d-flex align-items-center">Score Impact: <span class="text-success ms-2">24</span><img src="img/arrow-up.png"></div>
                                    <div class="badge bg-light d-flex align-items-center ms-3">Rank Impact: <span class="text-danger ms-2">2</span><img src="img/arrow-bottom.png"></div>
                                </div>
                            </div>

                            <label class="form-label fs-5 fw-medium mt-18 mb-3">What's the reason for this distribution?</label>
                            <textarea class="form-control form-control-lg fs-3" id="" rows="2" placeholder="Helpful discussion on Discourse, URL tweet etc..."></textarea>
                            <label class="fs-5 fw-medium mt-18 mb-3">Tag this distribution to query it later.</label>
                            <input type="text" class="form-control form-control-lg mb-6 fs-3" id="" placeholder="Marketing, Development, Strategy">

                        </div>
                    </div>
                    <div class="card-body border-top d-flex justify-content-end gap-3">
                        <button type="button" class="btn btn-white">Deny</button>
                        <button type="button" class="btn btn-primary">Approve</button>
                    </div>
                </div>

            </div>

        </div>
        </div>
    </section>
</main>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="img/logo-circle.svg" height="90">
                <div class="fs-2 fw-semibold mt-15">MyDAO Admin Center</div>
                <div class="fw-medium mt-3">To get started please connect a whitelisted wallet</div>
                <button type="button" class="btn btn-primary mt-20 px-10">Connect Wallet</button>
                <div class="text-danger fw-medium mt-20">This wallet does not have access to MyDAO. <br>
                    Please connect with a whitelisted wallet.</div>
            </div>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script>
    feather.replace()
</script>