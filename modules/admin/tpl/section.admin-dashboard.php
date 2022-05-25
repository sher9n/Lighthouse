<?php use Core\Utils; ?>
<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <?php if($__page->first_admin_view == true){ ?>
        <section class="admin-body-section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between mb-13">
                            <input type="text" class="form-control form-search" id="" placeholder="Search...">
                            <button type="button" class="btn btn-primary">Send NTTs to a new member</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Send NTTs</th>
                                        <th>Wallet or SNS</th>
                                        <th>Score</th>
                                        <th>Rank</th>
                                        <th>Percentile</th>
                                        <th>Tags</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($__page->claims as $claim) { ?>
                                        <tr>
                                            <td class="text-center">
                                                <svg class="feather feather-lg text-muted">
                                                    <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#send"/>
                                                </svg>
                                            </td>
                                            <td><?php echo Utils::WalletAddressFormat($claim['wallet_adr']); ?></td>
                                            <td>8.4K</td>
                                            <td>215</td>
                                            <td>35%</td>
                                            <td class="text-truncate text-max-width"><?php echo $claim['clm_tags']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php }else{ ?>
        <section class="admin-body-section">
            <div class="container-fluid h-100">
                <div class="row h-100">
                    <div class="col-lg-12">
                        <div class="card shadow h-100">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center justify-content-center h-100 border rounded">
                                    <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
                                    <div class="fs-2 fw-semibold mt-20">Welcome to your dashboard!</div>
                                    <div class="fw-medium text-muted mt-4">To get started, please distribute some NTTs.</div>
                                    <a role="button" class="btn btn-primary mt-18" href="admin-dashboard">Reward a new member</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
</main>
<?php include_once app_root . '/templates/foot.php'; ?>
<script>
    feather.replace();

    $(document).ready(function() {

        if('<?php echo $__page->sel_wallet_adr; ?>' != sessionStorage.getItem("lh_sel_wallet_add"))
            window.location = 'admin';

        var table = $('#example').DataTable({
            dom: "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-4'l><'col-sm-8'p>>",
            'language': {
                'paginate': {
                    'previous': '<div><img src="<?php echo app_cdn_path; ?>img/arrow-fill-gray-left.svg" class="me-2">Previous</div>',
                    'next': '<div>Next<img src="<?php echo app_cdn_path; ?>img/arrow-fill-gray-right.svg" class="ms-2"></div>'
                },
                "lengthMenu": '<select class="form-select">'+
                    '<option value="10">Rows per page: 10</option>'+
                    '<option value="20">Rows per page: 20</option>'+
                    '<option value="30">Rows per page:30</option>'+
                    '<option value="40">Rows per page: 40</option>'+
                    '<option value="50">Rows per page: 50</option>'+
                    '<option value="-1">All</option>'+
                    '</select>'
            }
        });
    } );
</script>