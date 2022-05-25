<?php use Core\Utils; ?>
<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <?php if($__page->first_admin_view == true){ ?>
        <section class="admin-body-section">
            <div class="container-fluid h-100">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between mb-13">
                            <input type="text" class="form-control form-search" id="" placeholder="Search...">
                            <button type="button" class="btn btn-primary">Send NTTs to a new member</button>
                        </div>
                    </div>
                </div>
                <div class="row h-100">
                    <div class="col-lg-12">
                        <div class="d-flex flex-column" style="min-height: 86vh;">
                            <div class="card shadow mb-6">
                                <div class="card-body">
                                    <table id="dashboard_table" class="table table-striped table-bordered">
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
                            <div class="mt-auto">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <select id="dashboard_table_length" class="form-select">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="-1">All</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="pagination justify-content-end mb-0">
                                            <li class="page-item">
                                                <a class="page-link" id="dashboard_table_prev"><img src="<?php echo app_cdn_path; ?>img/arrow-fill-gray-left.svg" class="me-2">Previous</a>
                                            </li>
                                            <li class="page-item">
                                            <a class="page-link" href="#" id="dashboard_table_next">Next<img src="<?php echo app_cdn_path; ?>img/arrow-fill-gray-right.svg" class="ms-2"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
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

            var dashboard_table = $('#dashboard_table');

            $(document).ready(function () {
                dashboard_table.DataTable({
                    sDom: "t"
                });
            });

            $('#dashboard_table_prev').click(function(){
                dashboard_table.dataTable().fnPageChange( 'previous' );
            });

            $('#dashboard_table_next').click(function(){
                dashboard_table.dataTable().fnPageChange( 'next' );
            });

            $('#dashboard_table_length').change(function(){
                dashboard_table.dataTable().api().page.len($(this).val()).draw();
            });

            $('#dashboard_table_search').on( 'keyup', function () {
                dashboard_table.dataTable().api().search(this.value).draw();
            });
    } );
</script>