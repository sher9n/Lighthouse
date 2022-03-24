<main class="main-wrapper">
    <div class="container p-0">
        <div class="row">
            <div class="collapse collapse-form mt-3" id="editCoin">
                <div class="card shadow">
                    <form id="coin-editForm" method="post" action="edit-coin-info" autocomplete="off" enctype="multipart/form-data">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="text-lg font-weight-medium">Edit Coin Description</div>
                                <div class="ms-auto">
                                    <a data-bs-toggle="collapse" href="#editCoin" class="btn btn-outline-dove-gray btn-sm me-1" role="button">Cancel</a>
                                    <button type="submit" class="btn btn-primary btn-sm text-white">Update</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <label for="category" class="form-label">Coin Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php if(!$__page->is_validate){ ?>
            <div id="validate" class="col-12">
                <div class="text-center empty-content-display">
                    <i class="icon icon-add-project display-2"></i>
                    <p class="mb-2 h3">406</p>
                    <p class="text-secondary text-lg mb-4">Page not access</p>
                    <p class="text-sm-center text-lg mb-4">The page you are looking for can't access or other error occurred.</p>
                    <p class="text-sm-center text-lg mb-4">Go back, and choose a new direction.</p>
                </div>
            </div>
            <?php }else{ ?>

                <div class="row">
                    <div class="col-12">
                        <table id="coins-table" class="table table-bordered table-bordered-dashed mt-3 shadow">
                            <thead>
                            <tr>
                                <th scope="col">coin name</th>
                                <th class="text-center" scope="col">Description</th>
                                <th class="text-center" scope="col">Action</th>
                            </tr>
                        </table>

                    </div>
                </div>

                <div class="modal fade" id="removeCoin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="space-deleteForm" method="post" action="" autocomplete="off">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Coins Info</h5>
                                </div>
                                <div class="modal-body text-center">
                                    <input hidden name="coin_id" id="delete_coin_id">
                                    <input hidden name="user_key" id="delete_user_key">
                                    <img src="<?php echo app_cdn_path; ?>img/img-del.png" class="mb-4 mt-3">
                                    <p class="text-lg mb-0">Are you sure you want to remove this coin info?</p>
                                    <p class="text-lg mb-3 font-weight-medium">This action cannot be undone!</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
</main>
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">

    var selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");

    $(document).ready(function() {

        var table = $('#coins-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "get-coins-info?user_key="+selectedAccount
            }
        });

        $(document).on("click", '.edit-coin', function(event) {
            event.preventDefault();
            var element = $(this);
            $('#description').html(element.parent().prev().html());
            $("#coin-editForm").attr('action',element.attr('href'));
            $('#editCoin').collapse('show');
        });

        $(document).on('click','.remove_coin_info',function(event) {
            event.preventDefault();
            var element = $(this);
            $("#space-deleteForm").attr('action',element.attr('href'));
        });

        $('#coin-editForm').validate({
            rules: {},
            submitHandler: function(form){
                $(form).ajaxSubmit({
                    type:'post',
                    dataType:'json',
                    success: function(data){
                        if(data.success == true)
                            $('#coin-'+data.coin_id).parent().parent().remove();
                        $('#editCoin').collapse('hide');
                    }
                });
            }
        });

        $('#space-deleteForm').validate({
            rules: {},
            submitHandler: function(form){
                $(form).ajaxSubmit({
                    type:'post',
                    dataType:'json',
                    success: function(data){
                        if(data.success == true) {
                            $('#space-'+data.space_id).parent().parent().remove();
                        }
                        $('#removeSpace').modal('toggle');;
                    }
                });
            }
        });
    });
</script>