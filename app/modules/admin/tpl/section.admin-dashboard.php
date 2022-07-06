<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section id="dashboard" class="admin-body-section">
        <div class="container-fluid h-100">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-column flex-xl-row mb-13">
                        <input type="text" class="form-control form-search mb-6 mb-xl-0 me-xl-auto" id="dashboard_table_search"  placeholder="Search...">                        
                        <button id="sendNewNtt" type="button" class="btn btn-primary">Submit Contribution</button>
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
                            <select id="dashboard_table_length" class="form-select form-length rounded border-light">
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
                                <a class="page-link" href="#" id="dashboard_table_next">Next<img src="<?php echo app_cdn_path; ?>img/arrow-fill-gray-right.svg" class="ms-2"></a>
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
    <!-- Modal Send some NTTs -->
    <div class="modal fade" id="sendNewNttPop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="nttsNewForm" method="post" action="send-ntts" autocomplete="off">
                    <div class="modal-body">
                        <div class="display-5 fw-medium">Send some NTTs</div>
                        <div class="fs-5 fw-medium mt-20">Which wallet do you want to distribute NTTs to?</div>
                        <input type="text" name="wallet_address" id="wallet_address" class="form-control form-control-lg">
                        <div class="fs-3 fw-semibold mb-3 text-break"></div>
                        <?php if($__page->blockchain == SOLANA){ ?>
                            <a role="button" id="add_wallet" onclick="changeSolanaAccount()" class="btn btn-light" href="#">Add Wallet</a>
                        <?php }else{ ?>
                            <a role="button" id="add_wallet" class="add_wallet btn btn-light" href="#">Change Wallet</a>
                        <?php } ?>
                        <div class="fs-5 fw-medium mt-18 mb-3">How many NTTs do you want to send?</div>
                        <div class="container-fluid">
                            <div class="row gap-3">
                                <input type="text" class="form-control form-control-lg mb-6 fs-3" name="ntts" id="ntts"  placeholder="100">
                                <div class="col bg-light rounded-3 py-3 px-7">
                                    <div class="fs-3">4.5K</div>
                                    <div class="d-flex align-items-center">Score Impact: <span class="text-success ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-up.png"></div>
                                </div>
                                <div class="col bg-light rounded-3 py-3 px-7">
                                    <div class="fs-3">2.32K</div>
                                    <div class="d-flex align-items-center">Rank Impact: <span class="text-danger ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-bottom.png"></div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-5 fw-medium mt-18 mb-3">What's the reason for this distribution?</div>
                        <textarea class="form-control form-control-lg fs-3" name="claim_reason" id="claim_reason" rows="2" placeholder="Helpful discussion on Discourse, URL tweet etc..."></textarea>
                        <div class="fs-5 fw-medium mt-18 mb-3">Tag this distribution to query it later.</div>
                        <select style=" width: 100% !important;" class="form-control form-control-lg" multiple="multiple" name="claim_tags[]" id="claim_tags" placeholder="Marketing, Development, Strategy"></select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include_once app_root . '/templates/admin-foot.php'; ?>
<script>
    var dashboard_table ;

    $(document).on("click", '.add_wallet', function(event) {
        $("#sendNewNttPop").modal('hide');
        $('#admin_wallet').modal('show');
    });

    $(document).ready(function() {

        <?php if(strlen($__page->wallet_adr) > 0){ ?>
            sessionStorage.setItem("lh_sel_wallet_add", '<?php echo $__page->wallet_adr; ?>');
            sessionStorage.setItem("lh_wallet_adds", JSON.stringify(['<?php echo $__page->wallet_adr; ?>']));
            showMessage('success',10000,'Success! Your community has been created. '+'<a class="text-white ms-1" target="_blank" href="<?php echo $__page->view_contract; ?>"> VIEW TRANSACTION</a>');
        <?php } ?>

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

        $(document).on("click", '.send_ntt', function(event) {
            event.preventDefault();
            var adr = $(this).data('adr');
            $('#wallet_address').val(adr);
            $('#ntts').val('');
            $('#claim_reason').val('');
            $("#claim_tags").val(null).trigger('change');
            $('#sendNewNttPop').modal('show');
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
                    $('#list_history').html('');
                },
                success: function (response) {
                    $('#list_history').html(response.html);
                }
            });
        });

        $('#nttsNewForm').validate({
            rules: {
                ntts:{
                    required: true
                },
                wallet_address:{
                    required: true
                }
            },
            submitHandler: function(form){
                $(form).ajaxSubmit({
                    type:'post',
                    dataType:'json',
                    beforeSend: function() {
                        showMessage('success',10000,'Your NTTs are being sent.');
                    },
                    success: function(data){
                        if(data.success == true){
                            dashboard_table.ajax.reload();
                            $('#sendNewNttPop').modal('hide');
                            showMessage('success', 10000, data.message);
                        }
                        else{
                            if(data.message) {
                                $('#sendNewNttPop').modal('hide');
                                showMessage('danger', 10000, data.message);
                            }
                            else {
                                $('#' + data.element).addClass('form-control-lg error');
                                $('<label class="error">' + data.msg + '</label>').insertAfter('#' + data.element);
                            }
                        }
                    }
                });
            }
        });

        if('<?php echo $__page->sel_wallet_adr; ?>' != sessionStorage.getItem("lh_sel_wallet_add"))
            window.location = 'admin';

        $('#dashboard_table_prev').click(function(){
            dashboard_table.page( 'previous' ).draw( 'page' );
        });

        $('#dashboard_table_next').click(function(){
            dashboard_table.page( 'next' ).draw( 'page' );
        });

        $('#dashboard_table_length').change(function(){
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
            "processing": true,
            "bLengthChange": false,
            "ordering": false,
            "info": false,
            "language": {
                processing: "Loading...ssss"
            },
            "rowCallback": function( row, data ) {
                $("#table_skeleton_data").addClass('d-none');
                $("#table_data").removeClass('d-none');
            },
            "drawCallback": function( settings ) {
                feather.replace();
            },
            "ajax": "get-ntts"
        });
    }
</script>