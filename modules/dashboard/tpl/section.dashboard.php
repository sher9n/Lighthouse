<main>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="prepare">
                    <button class="btn btn-primary" id="btn-connect" style="position: absolute; right: 0;">Connect</button>
                </div>
                <div id="connected" style="display: none" class="justify-content-end">
                    <button class="btn btn-primary" id="btn-disconnect" style="position: absolute; right: 0;">Disconnect</button>
                    <div id="network">
                        <p><strong>Connected blockchain:</strong> <span id="network-name"></span></p>
                        <p><strong>Selected account:</strong> <span id="selected-account"></span></p>
                    </div>
                    <hr>
                    <h3>All account balances</h3>
                    <table class="table table-listing">
                        <thead>
                            <th>Address</th>
                            <th>ETH balance</th>
                        </thead>
                        <tbody id="accounts"></tbody>
                    </table>
                    <p>Please try to switch between different accounts in your wallet if your wallet supports this functonality.</p>
                    <br>
                </div>
            </div>
        </div>
        <div id="comments" style="display: none">
            <div class="row">
                <div class="col-12">
                    <ul class="nav justify-content-end nav-pills nav-tabs-trends" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo ($__page->tab == 'messages')?'active':''; ?>" id="messages-tab" data-bs-toggle="tab" data-tab="messages" data-bs-target="#messages" type="button" role="tab" aria-controls="home" aria-selected="true">Messages</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo ($__page->tab == 'erc20')?'active':''; ?>" id="erc20-tab" data-bs-toggle="tab" data-tab="erc20" data-bs-target="#erc20" type="button" role="tab" aria-controls="profile" aria-selected="false">ERC20</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo ($__page->tab == 'erc721')?'active':''; ?>" id="erc721-tab" data-bs-toggle="tab" data-tab="erc721" data-bs-target="#erc721" type="button" role="tab" aria-controls="profile" aria-selected="false">ERC721</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo ($__page->tab == 'graphql')?'active':''; ?>" id="graphql-tab" data-bs-toggle="tab" data-tab="graphql" data-bs-target="#graphql" type="button" role="tab" aria-controls="profile" aria-selected="false">GraphQL</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-4" id="myTabContent">
                        <div class="tab-pane fade <?php echo ($__page->tab == 'messages')?'show active':''; ?>" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                            <h3>Messages</h3>
                            <form id="commentForm" action="dashboard" method="post">
                                <div class="row">
                                    <input type="hidden" name="user_key" id="user_key">
                                    <div class="col-md-12">
                                        <textarea name="comments" id="comment_msg" class="form-control" rows="3" style=""></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-primary m-2" value="Submit">
                                    </div>
                                </div>
                            </form>
                            <div id="comment_list">
                                <?php foreach ($__page->commnets as $comment){ ?>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p><strong>Posted By:</strong> <?php echo $comment['user_key'];?></p>
                                            <p><strong>Message :</strong> <?php echo $comment['post'];?></p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane fade <?php echo ($__page->tab == 'erc20')?'show active':''; ?>" id="erc20" role="tabpanel" aria-labelledby="erc20-tab">
                            <table id="erc20-table" class="table table-bordered table-bordered-dashed mt-3 shadow">
                                <thead>
                                <tr>
                                    <th scope="col">Hash</th>
                                    <th class="text-center" scope="col">Date</th>
                                    <th class="text-center" scope="col">From</th>
                                    <th class="text-center" scope="col">To</th>
                                    <th class="text-center" scope="col">Token</th>
                                    <th class="text-center" scope="col">Token Symbol</th>
                                    <th class="text-center" scope="col">Contract Address</th>
                                    <th class="text-center" scope="col">Value</th>
                                    <th class="text-center" scope="col">Gas</th>
                                    <th class="text-center" scope="col">Gas Price</th>
                                </tr>
                            </table>
                        </div>
                        <div class="tab-pane fade <?php echo ($__page->tab == 'erc721')?'show active':''; ?>" id="erc721" role="tabpanel" aria-labelledby="erc721-tab">
                            <table id="erc721-table" class="table table-bordered table-bordered-dashed mt-3 shadow">
                                <thead>
                                <tr>
                                    <th scope="col">Hash</th>
                                    <th class="text-center" scope="col">Date</th>
                                    <th class="text-center" scope="col">From</th>
                                    <th class="text-center" scope="col">To</th>
                                    <th class="text-center" scope="col">Token ID</th>
                                    <th class="text-center" scope="col">Token</th>
                                    <th class="text-center" scope="col">Token Symbol</th>
                                    <th class="text-center" scope="col">Contract Address</th>
                                    <th class="text-center" scope="col">Value</th>
                                    <th class="text-center" scope="col">Gas</th>
                                    <th class="text-center" scope="col">Gas Price</th>
                                </tr>
                            </table>
                        </div>
                        <div class="tab-pane fade <?php echo ($__page->tab == 'graphql')?'show active':''; ?>" id="graphql" role="tabpanel" aria-labelledby="graphql-tab">
                            <table id="graphql-table" class="table table-bordered table-bordered-dashed mt-3 shadow">
                                <thead>
                                <tr>
                                    <th class="text-center" scope="col">Name</th>
                                    <th class="text-center" scope="col">Symbol</th>
                                    <th class="text-center" scope="col">Value</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="templates" style="display: none">
        <template id="template-balance">
            <tr>
                <th class="address"></th>
                <td class="balance"></td>
            </tr>
        </template>
    </div>
</main>
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click','#erc20-tab',function (e) {
            e.preventDefault();
            if ( ! $.fn.DataTable.isDataTable( '#erc20-table' ) ) {
                var table = $('#erc20-table').DataTable({
                    "columns": [
                        {"data": "hash"},
                        {"data": "age"},
                        {"data": "from"},
                        {"data": "to"},
                        {"data": "tokenName"},
                        {"data": "tokenSymbol"},
                        {"data": "contractAddress"},
                        {"data": "value"},
                        {"data": "gas"},
                        {"data": "gasPrice"},
                    ],
                    "scrollX": true,
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "info": false,
                    "language": {
                        processing: "<img src='<?php echo app_cdn_path; ?>images/loading.gif' width='100' height='100'>"
                    },
                    "ajax": {
                        "url": "get-erc20?user_key=" + $('#user_key').val()
                    }
                });

                $('#erc20-table_processing').removeClass('card');
                $('#erc20-table_filter').hide();
            }
        });

        $(document).on('click','#erc721-tab',function (e) {
            e.preventDefault();
            if ( ! $.fn.DataTable.isDataTable( '#erc721-table' ) ) {
                var table = $('#erc721-table').DataTable({
                    "columns": [
                        { "data": "hash" },
                        { "data": "age" },
                        { "data": "from" },
                        { "data": "to" },
                        { "data": "tokenID" },
                        { "data": "tokenName" },
                        { "data": "tokenSymbol" },
                        {"data": "contractAddress"},
                        { "data": "value" },
                        { "data": "gas" },
                        { "data": "gasPrice" },
                    ],
                    "scrollX": true,
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "info": false,
                    "language": {
                        processing: "<img src='<?php echo app_cdn_path; ?>images/loading.gif' width='100' height='100'>"
                    },
                    "ajax": {
                        "url": "get-erc721?user_key="+$('#user_key').val()
                    }
                });

                $('#erc721-table_processing').removeClass('card');
                $('#erc721-table_filter').hide();
            }
        });

        $(document).on('click','#graphql-tab',function (e) {
            e.preventDefault();
            if ( ! $.fn.DataTable.isDataTable( '#graphql-table' ) ) {
                var table = $('#graphql-table').DataTable({
                    "columns": [
                        { "data": "name" },
                        { "data": "symbol" },
                        { "data": "value" }
                    ],
                    "scrollX": true,
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "info": false,
                    "language": {
                        processing: "<img src='<?php echo app_cdn_path; ?>images/loading.gif' width='100' height='100'>"
                    },
                    "ajax": {
                        "url": "get-graphql?user_key="+$('#user_key').val()
                    }
                });

                $('#graphql-table_processing').removeClass('card');
                $('#graphql-table_filter').hide();
            }
        });

        $('#commentForm').validate({
            rules: {
                comments: {
                    required: true
                }
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    type: 'post',
                    dataType: 'json',
                    success: function(data) {
                        if (data.success == true) {
                            $('#comment_msg').val('');
                            $('#comment_list').prepend(data.comment);
                        }
                    }
                });
            }
        });
    });
</script>
