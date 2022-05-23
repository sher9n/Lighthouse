<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
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
                                <tr>
                                    <td class="text-center">
                                        <svg class="feather feather-lg text-muted">
                                            <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#send"/>
                                        </svg>
                                    </td>
                                    <td>0x9aBb...4380b</td>
                                    <td>8.4K</td>
                                    <td>215</td>
                                    <td>35%</td>
                                    <td class="text-truncate text-max-width">Marketing: 12, Social: 7, Community: 3, Strategy: 5, LeadGen: 1</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <svg class="feather feather-lg text-muted">
                                            <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#send"/>
                                        </svg>
                                    </td>
                                    <td>0x9aBb...4380b</td>
                                    <td>8.4K</td>
                                    <td>215</td>
                                    <td>35%</td>
                                    <td class="text-truncate text-max-width">Marketing: 12, Social: 7, Community: 3, Strategy: 5, LeadGen: 1</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <svg class="feather feather-lg text-muted">
                                            <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#send"/>
                                        </svg>
                                    </td>
                                    <td>0x9aBb...4380b</td>
                                    <td>8.4K</td>
                                    <td>215</td>
                                    <td>35%</td>
                                    <td class="text-truncate text-max-width">Marketing: 12, Social: 7, Community: 3, Strategy: 5, LeadGen: 1</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <svg class="feather feather-lg text-muted">
                                            <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#send"/>
                                        </svg>
                                    </td>
                                    <td>0x9aBb...4380b</td>
                                    <td>8.4K</td>
                                    <td>215</td>
                                    <td>35%</td>
                                    <td class="text-truncate text-max-width">Marketing: 12, Social: 7, Community: 3, Strategy: 5, LeadGen: 1</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <svg class="feather feather-lg text-muted">
                                            <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#send"/>
                                        </svg>
                                    </td>
                                    <td>0x9aBb...4380b</td>
                                    <td>8.4K</td>
                                    <td>215</td>
                                    <td>35%</td>
                                    <td class="text-truncate text-max-width">Marketing: 12, Social: 7, Community: 3, Strategy: 5, LeadGen: 1</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <svg class="feather feather-lg text-muted">
                                            <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#send"/>
                                        </svg>
                                    </td>
                                    <td>0x9aBb...4380b</td>
                                    <td>8.4K</td>
                                    <td>215</td>
                                    <td>35%</td>
                                    <td class="text-truncate text-max-width">Marketing: 12, Social: 7, Community: 3, Strategy: 5, LeadGen: 1</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <svg class="feather feather-lg text-muted">
                                            <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#send"/>
                                        </svg>
                                    </td>
                                    <td>0x9aBb...4380b</td>
                                    <td>8.4K</td>
                                    <td>215</td>
                                    <td>35%</td>
                                    <td class="text-truncate text-max-width">Marketing: 12, Social: 7, Community: 3, Strategy: 5, LeadGen: 1</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <svg class="feather feather-lg text-muted">
                                            <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#send"/>
                                        </svg>
                                    </td>
                                    <td>0x9aBb...4380b</td>
                                    <td>8.4K</td>
                                    <td>215</td>
                                    <td>35%</td>
                                    <td class="text-truncate text-max-width">Marketing: 12, Social: 7, Community: 3, Strategy: 5, LeadGen: 1</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
<!--        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#SendNTT">
            Launch demo modal
        </button>-->
    </section>
</main>
<!-- Modal -->
<div class="modal fade" id="AdminCenter" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="<?php echo app_cdn_path; ?>img/logo-circle.svg" height="90">
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
    feather.replace();

    $(document).ready(function() {
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