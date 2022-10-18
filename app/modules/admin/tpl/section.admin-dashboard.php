<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section id="dashboard" class="admin-body-section">
        <div class="container-fluid h-100">
            <?php
            if($__page->user->ntt_consent_bar != 1){
                require_once app_root. "/modules/admin/tpl/partial/ntt-consent-bar.php";
            } ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-column flex-xl-row mb-13">
                        <input type="text" class="form-control form-search mb-6 mb-xl-0 me-xl-auto bg-white border-light" id="dashboard_table_search"  placeholder="Search...">                        
                        <button id="sendNewNtt" type="button" class="btn btn-primary">Submit a Claim</button>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div id="table_skeleton_data" class="col-lg-12">
                    <div class="d-flex flex-column" style="min-height: 86vh;">
                        <div class="card shadow mb-8 loading">
                            <div class="card-body">
                                <table id="" class="table table-striped table-bordered skeleton-table">
                                    <thead>
                                    <tr>
                                        <th style="width: 200px"><div class="text-content w-60"></div></th>
                                        <th style="width: 200px"><div class="text-content w-40"></div></th>
                                        <th style="width: 200px"><div class="text-content w-60"></div></th>
                                        <th style="width: 200px"><div class="text-content w-60"></div></th>
                                        <th><div class="text-content w-40"></div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><div class="text-content"></div></td>
                                            <td><div class="text-content w-60"></div></td>
                                            <td><div class="text-content w-40"></div></td>
                                            <td><div class="text-content w-50"></div></td>
                                            <td><div class="text-content w-100"></div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="text-content"></div></td>
                                            <td><div class="text-content w-60"></div></td>
                                            <td><div class="text-content w-40"></div></td>
                                            <td><div class="text-content w-50"></div></td>
                                            <td><div class="text-content w-100"></div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="text-content"></div></td>
                                            <td><div class="text-content w-60"></div></td>
                                            <td><div class="text-content w-40"></div></td>
                                            <td><div class="text-content w-50"></div></td>
                                            <td><div class="text-content w-100"></div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="text-content"></div></td>
                                            <td><div class="text-content w-60"></div></td>
                                            <td><div class="text-content w-40"></div></td>
                                            <td><div class="text-content w-50"></div></td>
                                            <td><div class="text-content w-100"></div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="text-content"></div></td>
                                            <td><div class="text-content w-60"></div></td>
                                            <td><div class="text-content w-40"></div></td>
                                            <td><div class="text-content w-50"></div></td>
                                            <td><div class="text-content w-100"></div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="text-content"></div></td>
                                            <td><div class="text-content w-60"></div></td>
                                            <td><div class="text-content w-40"></div></td>
                                            <td><div class="text-content w-50"></div></td>
                                            <td><div class="text-content w-100"></div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="text-content"></div></td>
                                            <td><div class="text-content w-60"></div></td>
                                            <td><div class="text-content w-40"></div></td>
                                            <td><div class="text-content w-50"></div></td>
                                            <td><div class="text-content w-100"></div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="text-content"></div></td>
                                            <td><div class="text-content w-60"></div></td>
                                            <td><div class="text-content w-40"></div></td>
                                            <td><div class="text-content w-50"></div></td>
                                            <td><div class="text-content w-100"></div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="text-content"></div></td>
                                            <td><div class="text-content w-60"></div></td>
                                            <td><div class="text-content w-40"></div></td>
                                            <td><div class="text-content w-50"></div></td>
                                            <td><div class="text-content w-100"></div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="text-content"></div></td>
                                            <td><div class="text-content w-60"></div></td>
                                            <td><div class="text-content w-40"></div></td>
                                            <td><div class="text-content w-50"></div></td>
                                            <td><div class="text-content w-100"></div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="text-content"></div></td>
                                            <td><div class="text-content w-60"></div></td>
                                            <td><div class="text-content w-40"></div></td>
                                            <td><div class="text-content w-50"></div></td>
                                            <td><div class="text-content w-100"></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-xl-row justify-content-between">
                            <div class="skeleton-btn w-20 rounded"></div>
                            <div class="skeleton-btn w-20 rounded"></div>
                        </div>
                    </div>
                </div>
                <div id="table_data" class="col-lg-12 d-none">
                    <div class="d-flex flex-column">
                        <div class="card shadow mb-8" style="min-height: 78vh;">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dashboard_table" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width: 200px">Wallet or SNS</th>
                                            <th style="width: 200px">Score</th>
                                            <th style="width: 200px">Rank</th>
                                            <th style="width: 200px">Percentile</th>
                                            <th>Tags</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-xl-row justify-content-between">
                            <select id="dashboard_table_length" class="form-select form-length rounded border-light bg-white">
                                <option value="10">Rows per page: 10</option>
                                <option value="25">Rows per page: 25</option>
                                <option value="50">Rows per page: 50</option>
                                <option value="100">Rows per page: 100</option>
                                <option value="-1">All</option>
                            </select>
                            <ul class="pagination justify-content-xl-end justify-content-center mb-0 mt-6 mt-xl-0">
                                <li class="page-item">
                                    <a class="page-link" id="dashboard_table_prev"><img src="<?php echo app_cdn_path; ?>img/arrow-fill-gray-left.svg" class="me-2">Previous</a>
                                </li>
                                <li class="page-item">
                                <a class="page-link" id="dashboard_table_next">Next<img src="<?php echo app_cdn_path; ?>img/arrow-fill-gray-right.svg" class="ms-2"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="offcanvas offcanvas-end shadow" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-body p-0">
            <div class="px-12 py-13">
                <div class="display-6 fw-medium">History</div>
                <div id="history_wallet" class="text-break fw-medium text-muted mt-3"></div>
            </div>
            <ul id="list_history" class="list-history">
            </ul>
        </div>
    </div>
</main>
<?php include_once app_root . '/templates/admin-foot.php'; ?>
<script>
    var dashboard_table ;

    $(document).ready(function() {

        dataLoad();

        $("#claim_tags").select2({
            tags: true,
            tokenSeparators: [','],
            selectOnClose: true,
            closeOnSelect: false
        });

        $(document).on("click", '#copy_claim_link', function(event) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val("<?php echo app_url; ?>").select();
            document.execCommand("copy");
            $temp.remove();
            $('#copy_claim_link').tooltip('show');
        });

        $(document).on("click", '#sendNewNtt, #startSendNewNtt, #retryNewNtt', function(event) {
            event.preventDefault();
            window.location.replace("contribution");
        });

        $(document).on("click", '.contribution_history', function(event) {
            event.preventDefault();
            var adr = $(this).data('adr');
            $('#history_wallet').html(adr);
            $.ajax({
                url: 'contribution-history?wallet='+adr,
                dataType: 'json',
                type: 'GET',
                beforeSend: function() {
                    $('#list_history').html('<div class="d-flex flex-column loading">\n' +
                        '        <div class="list-history-item">\n' +
                        '            <div class="text-decoration-none">\n' +
                        '                <div class="d-flex align-items-center my-1">\n' +
                        '                    <div class="fs-4-text-content w-40"></div>\n' +
                        '                    <div class="ms-auto text-content w-10"></div>\n' +
                        '                </div>\n' +
                        '                <div class="text-content my-3"></div>\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="list-history-item">\n' +
                        '            <div class="text-decoration-none">\n' +
                        '                <div class="d-flex align-items-center my-1">\n' +
                        '                    <div class="fs-4-text-content w-40"></div>\n' +
                        '                    <div class="ms-auto text-content w-10"></div>\n' +
                        '                </div>\n' +
                        '                <div class="text-content my-3"></div>\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="list-history-item">\n' +
                        '            <div class="text-decoration-none">\n' +
                        '                <div class="d-flex align-items-center my-1">\n' +
                        '                    <div class="fs-4-text-content w-40"></div>\n' +
                        '                    <div class="ms-auto text-content w-10"></div>\n' +
                        '                </div>\n' +
                        '                <div class="text-content my-3"></div>\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="list-history-item">\n' +
                        '            <div class="text-decoration-none">\n' +
                        '                <div class="d-flex align-items-center my-1">\n' +
                        '                    <div class="fs-4-text-content w-40"></div>\n' +
                        '                    <div class="ms-auto text-content w-10"></div>\n' +
                        '                </div>\n' +
                        '                <div class="text-content my-3"></div>\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="list-history-item">\n' +
                        '            <div class="text-decoration-none">\n' +
                        '                <div class="d-flex align-items-center my-1">\n' +
                        '                    <div class="fs-4-text-content w-40"></div>\n' +
                        '                    <div class="ms-auto text-content w-10"></div>\n' +
                        '                </div>\n' +
                        '                <div class="text-content my-3"></div>\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="list-history-item">\n' +
                        '            <div class="text-decoration-none">\n' +
                        '                <div class="d-flex align-items-center my-1">\n' +
                        '                    <div class="fs-4-text-content w-40"></div>\n' +
                        '                    <div class="ms-auto text-content w-10"></div>\n' +
                        '                </div>\n' +
                        '                <div class="text-content my-3"></div>\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="list-history-item border-bottom-0">\n' +
                        '            <div class="text-decoration-none">\n' +
                        '                <div class="d-flex align-items-center my-1">\n' +
                        '                    <div class="fs-4-text-content w-40"></div>\n' +
                        '                    <div class="ms-auto text-content w-10"></div>\n' +
                        '                </div>\n' +
                        '                <div class="text-content my-3"></div>\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '    </div>');
                },
                success: function (response) {
                    $('#list_history').html(response.html);
                }
            });
        });

        $('#dashboard_table_prev').click(function(){
            $("#table_skeleton_data").removeClass('d-none');
            $("#table_data").addClass('d-none');
            dashboard_table.page( 'previous' ).draw( 'page' );
        });

        $('#dashboard_table_next').click(function(){
            $("#table_skeleton_data").removeClass('d-none');
            $("#table_data").addClass('d-none');
            dashboard_table.page( 'next' ).draw( 'page' );
        });

        $('#dashboard_table_length').change(function(){
            $("#table_skeleton_data").removeClass('d-none');
            $("#table_data").addClass('d-none');
            dashboard_table.page.len($(this).val()).draw();
        });

        $('#dashboard_table_search').on( 'keyup', function () {
            dashboard_table.table().search(this.value).draw();
        });
    } );

    function dataLoad(){
        dashboard_table = $('#dashboard_table').DataTable({
            "sDom": "t",
            "autoWidth": false,
            "responsive": true,
            "bLengthChange": false,
            "ordering": false,
            "info": false,
            "processing": true,
            "serverSide": true,
            "rowCallback": function( row, data ) {
                $("#table_skeleton_data").addClass('d-none');
                $("#table_data").removeClass('d-none');
            },
            "ajax": "get-ntts"
        });
    }
</script>