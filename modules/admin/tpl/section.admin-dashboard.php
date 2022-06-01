<?php use Core\Utils; ?>
<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <?php if($__page->first_admin_view == true){ ?>
        <section class="admin-body-section">
            <div class="container-fluid h-100">
<!--                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <img src="<?php /*echo app_cdn_path; */?>img/icon-checked.png" height="20" class="me-6">
                        <div class="fw-medium">Success! Your transaction has been logged on-chain and the NTTs have been sent.</div>
                    </div>                    
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex flex-column flex-xl-row justify-content-between mb-13">
                            <input type="text" class="form-control form-search mb-6 mb-xl-0" id="dashboard_table_search"  placeholder="Search...">
                            <button id="sendNewNtt" type="button" class="btn btn-primary">Send NTTs to a new member</button>
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
                                            <tbody>
                                            <?php
                                            foreach ($__page->claims as $claim) { ?>
                                                <tr>
                                                    <td class="text-center">                                                    
                                                        <a data-adr="<?php echo $claim['adr']; ?>" href="#" class="send_ntt"><i data-feather="send" class="feather-lg text-muted"></i></a>
                                                    </td>
                                                    <td><?php echo Utils::WalletAddressFormat($claim['adr']); ?></td>
                                                    <td><?php echo $claim['score']; ?></td>
                                                    <td>215</td>
                                                    <td><?php echo $claim['perc']; ?>%</td>
                                                    <td class="text-truncate text-max-width"><?php echo $claim['tags']; ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
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
                        <?php if($__page->solana == true){ ?>
                            <a role="button" id="add_wallet" onclick="changeSolanaAccount()" class="btn btn-light" href="#">Add Wallet</a>
                        <?php }else{ ?>
                            <a role="button" id="add_wallet" onclick="changeWallet(true)" class="btn btn-light" href="#">Change Wallet</a>
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
                        <select class="form-control form-control-lg" multiple="multiple" name="claim_tags[]" id="claim_tags" placeholder="Marketing, Development, Strategy"></select>
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
<?php include_once app_root . '/templates/foot.php'; ?>
<script>
    feather.replace();

    $(document).ready(function() {

        $("#claim_tags").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        });

        $(document).on("click", '#sendNewNtt', function(event) {
            event.preventDefault();
            $('#sendNewNttPop').modal('show');
        });

        $(document).on("click", '.send_ntt', function(event) {
            event.preventDefault();
            var adr = $(this).data('adr');
            $('#wallet_address').val(adr);
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
                    success: function(data){
                        if(data.success == true){
                            <?php
                            if($__page->solana == true){
                                ?>
                                var url = "https://lighthouse-poc-seven.vercel.app/api/addSolPoints";
                                var xhr = new XMLHttpRequest();
                                xhr.open("POST", url);
                                xhr.setRequestHeader("accept", "application/json");
                                xhr.setRequestHeader("Content-Type", "application/json");
                                xhr.onreadystatechange = function () {
                                    if (xhr.readyState === 4) {
                                        if (xhr.status == 200)
                                            window.location = 'admin-dashboard';
                                        else
                                            window.location = 'admin-dashboard';
                                    }
                                };
                                var data = `{"mintAddress": "` + data.wallet_adr + `","to": "` + data.to_wallet_adr + `","amount": "` + data.amount + `"}`;
                                xhr.send(data);
                                <?php
                            }
                            else{
                                ?>
                                var url = "https://lighthouse-poc-seven.vercel.app/api/contractsAPI/"+data.dao_domain+"/addPoints?key=<?php echo API_KEY;?>";
                                var xhr = new XMLHttpRequest();
                                xhr.open("POST", url);
                                xhr.setRequestHeader("accept", "application/json");
                                xhr.setRequestHeader("Content-Type", "application/json");
                                xhr.onreadystatechange = function () {
                                    if (xhr.readyState === 4) {
                                        if (xhr.status == 200)
                                            window.location = 'admin-dashboard';
                                        else
                                            window.location = 'admin-dashboard';
                                    }};
                                var data = `{"receiver": "` + data.to_wallet_adr + `","amount": "` + data.amount + `"}`;
                                xhr.send(data);
                                <?php
                            } ?>
                        }
                        else{
                            $('#'+data.element).addClass('form-control-lg error');
                            $('<label class="error">'+data.msg+'</label>').insertAfter('#'+data.element);
                        }
                    }
                });
            }
        });

        if('<?php echo $__page->sel_wallet_adr; ?>' != sessionStorage.getItem("lh_sel_wallet_add"))
            window.location = 'admin';

            var dashboard_table = $('#dashboard_table');

            $(document).ready(function () {
                dashboard_table.DataTable({
                    sDom: "t",
                    responsive: true
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