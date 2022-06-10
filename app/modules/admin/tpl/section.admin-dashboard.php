<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-column flex-xl-row mb-13">
                        <input type="text" class="form-control form-search mb-6 mb-xl-0 me-xl-auto" id="dashboard_table_search"  placeholder="Search...">
                        <button id="copy_claim_link" type="button" class="btn btn-dark me-xl-3 mb-3 mb-xl-0" trigger="manual" data-placement="top" title="Copied!">Copy Claims LINK</button>
                        <button id="sendNewNtt" type="button" class="btn btn-primary">Send NTTs</button>
                    </div>
                </div>
            </div>
            <div class="row h-100">
                <div class="col-lg-12">
                    <div class="d-flex flex-column" style="min-height: 86vh;">
                        <div class="card shadow mb-6">
                            <div class="card-body">
                                <div class="table-responsive">
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
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-xl-row justify-content-between mt-auto">
                            <select id="dashboard_table_length" class="form-select form-length">
                                <option value="10">Rows per page: 10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
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
    feather.replace();
    var dashboard_table = $('#dashboard_table');

    $(document).on("click", '.add_wallet', function(event) {
        $("#sendNewNttPop").modal('hide');
        $('#admin_wallet').modal('show');
    });

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
            $('#wallet_address').val('');
            $('#ntts').val('');
            $('#claim_reason').val('');
            $("#claim_tags").val(null).trigger('change');
            $('#sendNewNttPop').modal('show');
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

    function dataLoad(){
        dashboard_table = $('#dashboard_table').DataTable({
            "sDom": "t",
            "responsive": true,
            "processing": true,
            "bLengthChange": false,
            "ordering": false,
            "info": false,
            "language": {
                processing: "<img src='<?php echo app_cdn_path; ?>img/loading-.svg' width='100' height='100'>"
            },
            "drawCallback": function( settings ) {
                feather.replace();
            },
            "ajax": "get-ntts"
        });

        dashboard_table.ajax.reload();
        feather.replace();
    }
</script>