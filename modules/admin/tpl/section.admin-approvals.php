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
                    <a class="nav-link active" href="admin-approvals.html">
                        <svg class="feather">
                            <use href="icons/feather-sprite.svg#check-circle"/>
                        </svg>
                        <div class="ms-12">Approvals</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin-send-ntt.html">
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
            <div class="row h-100">
                <div class="col-lg-6">
                    <div class="card shadow h-100">
                        <div class="card-header border-bottom">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-queue-tab" data-bs-toggle="pill" data-bs-target="#pills-queue" type="button" role="tab" aria-controls="pills-queue" aria-selected="true">Queue</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-approved-tab" data-bs-toggle="pill" data-bs-target="#pills-approved" type="button" role="tab" aria-controls="pills-approved" aria-selected="false">Approved</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-reviewed-tab" data-bs-toggle="pill" data-bs-target="#pills-reviewed" type="button" role="tab" aria-controls="pills-reviewed" aria-selected="false">Reviewed</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-denied-tab" data-bs-toggle="pill" data-bs-target="#pills-denied" type="button" role="tab" aria-controls="pills-denied" aria-selected="false">Denied</button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content h-100" id="pills-tabContent">
                            <div class="tab-pane fade h-100 show active" id="pills-queue" role="tabpanel" aria-labelledby="pills-queue-tab">
                                <ul class="list-approvals">
                                    <li class="list-approvals-item">
                                        <a class="d-flex text-decoration-none" href="#">
                                            <div class="d-flex align-items-center px-4 gap-3">
                                                <img src="img/icon-like.svg" width="40" height="40">
                                                <img src="img/icon-dislike.svg" width="40" height="40">
                                            </div>
                                            <div class="ms-8 col-8">
                                                <div class="fs-4 fw-semibold text-truncate">120 $LHP</div>
                                                <div class="fw-medium text-truncate">0xbnwegiow923h9ig2nioopg24g247</div>
                                                <div class="fw-medium text-muted mt-1">Last claim 3 days ago</div>
                                            </div>
                                            <div class="ms-auto fw-medium text-muted">45m ago</div>
                                        </a>
                                    </li>
                                    <li class="list-approvals-item active">
                                        <a class="d-flex text-decoration-none" href="#">
                                            <div class="d-flex align-items-center px-4 gap-3">
                                                <img src="img/icon-like.svg" width="40" height="40">
                                                <img src="img/icon-dislike.svg" width="40" height="40">
                                            </div>
                                            <div class="ms-8 col-8">
                                                <div class="fs-4 fw-semibold text-truncate">87 $LHP</div>
                                                <div class="fw-medium text-truncate">0xbnwegiow923h9ig2nioopg24g247</div>
                                                <div class="fw-medium text-muted mt-1">Last claim 3 days ago</div>
                                            </div>
                                            <div class="ms-auto fw-medium text-muted">1h 25m ago</div>
                                        </a>
                                    </li>
                                    <li class="list-approvals-item">
                                        <a class="d-flex text-decoration-none" href="#">
                                            <div class="d-flex align-items-center px-4 gap-3">
                                                <img src="img/icon-like.svg" width="40" height="40">
                                                <img src="img/icon-dislike.svg" width="40" height="40">
                                            </div>
                                            <div class="ms-8 col-8">
                                                <div class="fs-4 fw-semibold text-truncate">89 $LHP</div>
                                                <div class="fw-medium text-truncate">0xbnwegiow923h9ig2nioopg24g247</div>
                                                <div class="fw-medium text-muted mt-1">Last claim 3 days ago</div>
                                            </div>
                                            <div class="ms-auto fw-medium text-muted">2h ago</div>
                                        </a>
                                    </li>
                                    <li class="list-approvals-item">
                                        <a class="d-flex text-decoration-none" href="#">
                                            <div class="d-flex align-items-center px-4 gap-3">
                                                <img src="img/icon-like.svg" width="40" height="40">
                                                <img src="img/icon-dislike.svg" width="40" height="40">
                                            </div>
                                            <div class="ms-8 col-8">
                                                <div class="fs-4 fw-semibold text-truncate">89 $LHP</div>
                                                <div class="fw-medium text-truncate">0xbnwegiow923h9ig2nioopg24g247</div>
                                                <div class="fw-medium text-muted mt-1">Last claim 3 days ago</div>
                                            </div>
                                            <div class="ms-auto fw-medium text-muted">2h ago</div>
                                        </a>
                                    </li>
                                    <li class="list-approvals-item">
                                        <a class="d-flex text-decoration-none" href="#">
                                            <div class="d-flex align-items-center px-4 gap-3">
                                                <img src="img/icon-like.svg" width="40" height="40">
                                                <img src="img/icon-dislike.svg" width="40" height="40">
                                            </div>
                                            <div class="ms-8 col-8">
                                                <div class="fs-4 fw-semibold text-truncate">89 $LHP</div>
                                                <div class="fw-medium text-truncate">0xbnwegiow923h9ig2nioopg24g247</div>
                                                <div class="fw-medium text-muted mt-1">Last claim 3 days ago</div>
                                            </div>
                                            <div class="ms-auto fw-medium text-muted">2h ago</div>
                                        </a>
                                    </li>
                                    <li class="list-approvals-item">
                                        <a class="d-flex text-decoration-none" href="#">
                                            <div class="d-flex align-items-center px-4 gap-3">
                                                <img src="img/icon-like.svg" width="40" height="40">
                                                <img src="img/icon-dislike.svg" width="40" height="40">
                                            </div>
                                            <div class="ms-8 col-8">
                                                <div class="fs-4 fw-semibold text-truncate">89 $LHP</div>
                                                <div class="fw-medium text-truncate">0xbnwegiow923h9ig2nioopg24g247</div>
                                                <div class="fw-medium text-muted mt-1">Last claim 3 days ago</div>
                                            </div>
                                            <div class="ms-auto fw-medium text-muted">2h ago</div>
                                        </a>
                                    </li>
                                    <li class="list-approvals-item">
                                        <a class="d-flex text-decoration-none" href="#">
                                            <div class="d-flex align-items-center px-4 gap-3">
                                                <img src="img/icon-like.svg" width="40" height="40">
                                                <img src="img/icon-dislike.svg" width="40" height="40">
                                            </div>
                                            <div class="ms-8 col-8">
                                                <div class="fs-4 fw-semibold text-truncate">89 $LHP</div>
                                                <div class="fw-medium text-truncate">0xbnwegiow923h9ig2nioopg24g247</div>
                                                <div class="fw-medium text-muted mt-1">Last claim 3 days ago</div>
                                            </div>
                                            <div class="ms-auto fw-medium text-muted">2h ago</div>
                                        </a>
                                    </li>
                                    <li class="list-approvals-item">
                                        <a class="d-flex text-decoration-none" href="#">
                                            <div class="d-flex align-items-center px-4 gap-3">
                                                <img src="img/icon-like.svg" width="40" height="40">
                                                <img src="img/icon-dislike.svg" width="40" height="40">
                                            </div>
                                            <div class="ms-8 col-8">
                                                <div class="fs-4 fw-semibold text-truncate">89 $LHP</div>
                                                <div class="fw-medium text-truncate">0xbnwegiow923h9ig2nioopg24g247</div>
                                                <div class="fw-medium text-muted mt-1">Last claim 3 days ago</div>
                                            </div>
                                            <div class="ms-auto fw-medium text-muted">2h ago</div>
                                        </a>
                                    </li>
                                    <li class="list-approvals-item">
                                        <a class="d-flex text-decoration-none" href="#">
                                            <div class="d-flex align-items-center px-4 gap-3">
                                                <img src="img/icon-like.svg" width="40" height="40">
                                                <img src="img/icon-dislike.svg" width="40" height="40">
                                            </div>
                                            <div class="ms-8 col-8">
                                                <div class="fs-4 fw-semibold text-truncate">89 $LHP</div>
                                                <div class="fw-medium text-truncate">0xbnwegiow923h9ig2nioopg24g247</div>
                                                <div class="fw-medium text-muted mt-1">Last claim 3 days ago</div>
                                            </div>
                                            <div class="ms-auto fw-medium text-muted">2h ago</div>
                                        </a>
                                    </li>
                                    <li class="list-approvals-item">
                                        <a class="d-flex text-decoration-none" href="#">
                                            <div class="d-flex align-items-center px-4 gap-3">
                                                <img src="img/icon-like.svg" width="40" height="40">
                                                <img src="img/icon-dislike.svg" width="40" height="40">
                                            </div>
                                            <div class="ms-8 col-8">
                                                <div class="fs-4 fw-semibold text-truncate">89 $LHP</div>
                                                <div class="fw-medium text-truncate">0xbnwegiow923h9ig2nioopg24g247</div>
                                                <div class="fw-medium text-muted mt-1">Last claim 3 days ago</div>
                                            </div>
                                            <div class="ms-auto fw-medium text-muted">2h ago</div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade h-100" id="pills-approved" role="tabpanel" aria-labelledby="pills-approved-tab">
                                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                    <img src="img/img-empty.svg" width="208">
                                    <div class="fs-2 fw-semibold mt-20">Hurray, there's nothing in your approved!</div>
                                    <div class="fw-medium text-muted mt-4">When someone makes a claim, it will show up here. </div>
                                </div>
                            </div>
                            <div class="tab-pane fade h-100" id="pills-reviewed" role="tabpanel" aria-labelledby="pills-reviewed-tab">...</div>
                            <div class="tab-pane fade h-100" id="pills-denied" role="tabpanel" aria-labelledby="pills-denied-tab">...</div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-body px-27 py-30">
                            <div class="display-5 fw-medium">Claim details</div>
                            <div class="fs-5 fw-medium mt-20">Wallet or SNS</div>
                            <div class="fs-3 fw-semibold mt-3">0xbnwegiow923h9ig2nioopg24g247</div>
                            <div class="fs-5 fw-medium mt-18 mb-3">Claim amount</div>
                            <div class="container-fluid px-4">
                                <div class="row gap-3">
                                    <div class="col border rounded-3 py-3 px-7 fs-3 d-flex align-items-center">120</div>
                                    <div class="col bg-light rounded-3 py-3 px-7">
                                        <div class="fs-3">4.5K</div>
                                        <div class="d-flex align-items-center">Score Impact: <span class="text-success ms-2">24</span><img src="img/arrow-up.png"></div>
                                    </div>
                                    <div class="col bg-light rounded-3 py-3 px-7">
                                        <div class="fs-3">2.32K</div>
                                        <div class="d-flex align-items-center">Rank Impact: <span class="text-danger ms-2">2</span><img src="img/arrow-bottom.png"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="fs-5 fw-medium mt-18 mb-3">Reason</div>
                            <textarea class="form-control form-control-lg fs-3 fw-medium" id="" rows="2" placeholder=""></textarea>
                            <div class="fs-5 fw-medium mt-18 mb-3">Tags</div>
                            <textarea class="form-control form-control-lg" id="" rows="2" placeholder=""></textarea>
                        </div>
                        <div class="card-body border-top d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-white">Deny</button>
                            <button type="button" class="btn btn-primary">Approve</button>
                        </div>
                    </div>

                    <div class="card shadow h-100">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                <img src="img/img-empty.svg" width="208">
                            </div>
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