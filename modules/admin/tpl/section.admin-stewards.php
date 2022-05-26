<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
          <div class="row h-100"> 
            <div class="col h-100">           
              <div class="card shadow h-100">
                <div class="card-body p-xl-20">
                  <div class="display-5 fw-medium">Manage stewards</div>
                  <div class="text-muted mt-1">Add or remove members that can distribute NTTs and approve claims</div>
                  <form class="mt-25 col-xl-6">
                    <div class="fw-medium mt-26">Whitelist members</div>                    
                    <a role="button" class="btn btn-primary mt-6" href="#" data-bs-toggle="modal" data-bs-target="#addMember">Add</a>
                      <?php foreach ($__page->stewards as $steward){ ;?>
                        <div class="fw-medium mt-22"><?php echo $steward['display_name']; ?> </div>
                        <div class="d-flex align-items-center">
                            <div class="fs-3 fw-semibold me-6"><?php echo $steward['wallet_adr']; ?></div>
                            <a class="" href="#" data-bs-toggle="modal" data-bs-target="#delMember">
                                <i data-feather="trash" class="text-danger"></i>
                            </a>
                        </div>
                      <?php } ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</main>
<!-- Modal Add new member -->
<div class="modal fade" id="addMember" tabindex="-1" aria-labelledby="addMemberLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="addStewardsForm" method="post" action="add-stewards" autocomplete="off">
                <div class="modal-body">
                    <div class="fs-2 fw-semibold mb-15">Add new member to whitelist </div>
                    <label for="Nickname" class="form-label">Nickname</label>
                    <input type="text" class="form-control form-control-lg" name="nickname" id="nickname" placeholder="Bob">
                    <label for="WalletAddress" class="form-label mt-16">Wallet address</label>
                    <input type="text" class="form-control form-control-lg" name="wallet_address" id="wallet_address" placeholder="0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal delete member -->
<div class="modal fade" id="delMember" tabindex="-1" aria-labelledby="delMemberLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <div class="fs-2 fw-semibold mb-3">Hey, wait!</div>  
        <div class="fw-medium mb-16">Are you sure you want to delete this wallet address?</div>
        <button type="button" class="btn btn-white me-1" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger">Delete</button>
      </div>      
    </div>
  </div>
</div>

<?php include_once app_root . '/templates/foot.php'; ?>
<script>
    feather.replace();


    $('#addStewardsForm').validate({
        rules: {
            nickname:{
                required: true
            },
            wallet_address:{
                required: true
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#addMember').modal('toggle');
                    window.location = data.url;
                }
            });
        }
    });
</script>