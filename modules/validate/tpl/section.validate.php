<main class="main-wrapper">
    <div class="container p-0">
        <div class="row">
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
                                <th scope="col">Space Name</th>
                                <th class="text-center" scope="col">Space Id</th>
                                <th class="text-center" scope="col">symbol</th>
                                <th class="text-center" scope="col">Coin Name</th>
                                <th class="text-center" scope="col">Action</th>
                            </tr>
                        </table>

                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
</main>
<div class="modal fade" id="updateSpace" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="space-UpdateForm" method="post" action="" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">Update Space</h5>
                </div>
                <div class="modal-body text-center">
                    <input hidden name="coin_id" id="update_coin_id">
                    <input hidden name="user_key" id="update_user_key">
                    <img src="<?php echo app_cdn_path; ?>img/img-ok.png" class="mb-4 mt-3">
                    <p class="text-lg mb-0">Are you sure you want to update this space?</p>
                    <p class="text-lg mb-3 font-weight-medium">This action cannot be undone!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="removeSpace" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="space-deleteForm" method="post" action="" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">Update Space</h5>
                </div>
                <div class="modal-body text-center">
                    <input hidden name="coin_id" id="delete_coin_id">
                    <input hidden name="user_key" id="delete_user_key">
                    <img src="<?php echo app_cdn_path; ?>img/img-del.png" class="mb-4 mt-3">
                    <p class="text-lg mb-0">Are you sure you want to remove this space?</p>
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
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">

    var selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");

    $(document).ready(function() {

        var table = $('#coins-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "get-spaces?user_key="+selectedAccount
            },
            "drawCallback": function( settings ) {
                $('.space_coin').select2({
                    ajax: {
                        url: "coin-search",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data.items
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Select the coin',
                    minimumInputLength: 1
                });
            }
        });

        $(document).on('click','.edit_space_coin',function(event) {
            event.preventDefault();
            var element = $(this);
            var space_id = element.data('id');
            $('#update_coin_id').val($('#space-'+space_id).val());
            $('#update_user_key').val(sessionStorage.getItem("lh_sel_wallet_add"));
            $("#space-UpdateForm").attr('action',element.attr('href'));
        });

        $(document).on('click','.remove_space_coin',function(event) {
            event.preventDefault();
            var element = $(this);
            var space_id = element.data('id');
            $('#delete_coin_id').val($('#space-'+space_id).val());
            $('#delete_user_key').val(sessionStorage.getItem("lh_sel_wallet_add"));
            $("#space-deleteForm").attr('action',element.attr('href'));
        });

        $('#space-UpdateForm').validate({
            rules: {},
            submitHandler: function(form){
                $(form).ajaxSubmit({
                    type:'post',
                    dataType:'json',
                    success: function(data){
                        if(data.success == true) {
                            $('#space-'+data.space_id).parent().parent().remove();
                        }
                        $('#updateSpace').modal('toggle');;
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