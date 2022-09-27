<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <div class="row">
                <form id="formApproval" method="post" action="integrations-approvals" autocomplete="off">
                    <input type="hidden" name="form_id" value="<?php echo $__page->form->id; ?>">
                        <div class="nav-right-fixed">
                            <div class="row">
                                <div class="col-lg-11">
                                    <div class="d-flex">
                                        <a role="button" class="btn btn-white text-capitalize me-auto" href="integrations-form?form_id=<?php echo $__page->form->id; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-arrow-left me-2">
                                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                                <polyline points="12 19 5 12 12 5"></polyline>
                                            </svg>
                                            Back
                                        </a>
                                        <button type="submit" id="finish" class="btn btn-primary">Finish</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-11">
                        <div class="card shadow mb-12 mt-28">
                            <div class="card-body">
                                <label for="" class="form-label">Approval type</label>
                                <div class="form-check form-check-lg">
                                    <input class="form-check-input radio_rating" value="1" <?php echo ($__page->form->approval_type != 2)?'checked':''; ?> type="radio" name="approval_type">
                                    <label class="form-check-label" for="YesNo">
                                        Yes/No
                                    </label>
                                    <div class="text-lg fst-italic mt-2">Eg: Attended a meeting</div>
                                </div>
                                <div class="form-check form-check-lg">
                                    <input class="form-check-input radio_rating" value="2" <?php echo ($__page->form->approval_type == 2)?'checked':''; ?> type="radio" name="approval_type">
                                    <label class="form-check-label" for="Rating">
                                        Rating
                                    </label>
                                    <div class="text-lg fst-italic mt-2">Eg: 4 out of 5 stars for a Github merge</div>
                                </div>
                                <div id="rating_data" class="ps-18 <?php echo ($__page->form->approval_type != 2)?'d-none':''; ?>">
                                    <label for="" class="form-label">Category</label>
                                    <div id="rating_data_row">
                                        <?php
                                        $ratings = $__page->form->rating_categories;
                                        if(strlen($ratings) >0){
                                            $ratings = json_decode($ratings);
                                            foreach ($ratings as $index => $rating){
                                                if($index == 0){
                                                    ?>
                                                    <div class="row mb-6">
                                                        <div class="col-lg-12 col-xl-5 col-xxl-6">
                                                            <input type="text" class="form-control form-control-lg" id="category1" name="category[]"
                                                                   aria-describedby="" value="<?php echo $rating; ?>">
                                                        </div>
                                                        <div class="col-auto px-xxl-0">
                                                            <div class="list-rating-scale list-rating-scale-lg mt-3 mt-xl-0">
                                                                <input type="radio" class="btn-check btn_complexity"
                                                                       name="ComplexityOptions" data-val="1" id="Complexityoption1"
                                                                       autocomplete="off">
                                                                <label class="btn btn-light ms-0" for="Complexityoption1">1</label>

                                                                <input type="radio" class="btn-check btn_complexity"
                                                                       name="ComplexityOptions" data-val="2" id="Complexityoption2"
                                                                       autocomplete="off">
                                                                <label class="btn btn-light" for="Complexityoption2">2</label>

                                                                <input type="radio" class="btn-check btn_complexity"
                                                                       name="ComplexityOptions" data-val="3" id="Complexityoption3"
                                                                       autocomplete="off">
                                                                <label class="btn btn-light" for="Complexityoption3">3</label>

                                                                <input type="radio" class="btn-check btn_complexity"
                                                                       name="ComplexityOptions" data-val="4" id="Complexityoption4"
                                                                       autocomplete="off">
                                                                <label class="btn btn-light" for="Complexityoption4">4</label>

                                                                <input type="radio" class="btn-check btn_complexity"
                                                                       name="ComplexityOptions" data-val="5" id="Complexityoption5"
                                                                       autocomplete="off">
                                                                <label class="btn btn-light me-0" for="Complexityoption5">5</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                else {
                                                    ?>
                                                    <div class="row mb-6">
                                                        <div class="col-lg-12 col-xl-5 col-xxl-6">
                                                            <input type="text" class="form-control form-control-lg" id="category2" name="category[]"
                                                                   aria-describedby=""  value="<?php echo $rating; ?>">
                                                        </div>
                                                        <div class="col-auto px-xxl-0">
                                                            <div class="d-flex mt-3 mt-xl-0">
                                                                <div class="list-rating-scale list-rating-scale-lg">
                                                                    <input type="radio" class="btn-check btn_complexity"
                                                                           name="ComplexityOptions" data-val="1" id="Complexityoption1"
                                                                           autocomplete="off">
                                                                    <label class="btn btn-light ms-0" for="Complexityoption1">1</label>

                                                                    <input type="radio" class="btn-check btn_complexity"
                                                                           name="ComplexityOptions" data-val="2" id="Complexityoption2"
                                                                           autocomplete="off">
                                                                    <label class="btn btn-light" for="Complexityoption2">2</label>

                                                                    <input type="radio" class="btn-check btn_complexity"
                                                                           name="ComplexityOptions" data-val="3" id="Complexityoption3"
                                                                           autocomplete="off">
                                                                    <label class="btn btn-light" for="Complexityoption3">3</label>

                                                                    <input type="radio" class="btn-check btn_complexity"
                                                                           name="ComplexityOptions" data-val="4" id="Complexityoption4"
                                                                           autocomplete="off">
                                                                    <label class="btn btn-light" for="Complexityoption4">4</label>

                                                                    <input type="radio" class="btn-check btn_complexity"
                                                                           name="ComplexityOptions" data-val="5" id="Complexityoption5"
                                                                           autocomplete="off">
                                                                    <label class="btn btn-light me-0" for="Complexityoption5">5</label>
                                                                </div>
                                                                <button class="btn btn-delete">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                         class="feather feather-trash">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                        else{
                                            ?>
                                            <div class="row mb-6">
                                                <div class="col-lg-12 col-xl-5 col-xxl-6">
                                                    <input type="text" class="form-control form-control-lg" id="category1" name="category[]"
                                                           aria-describedby="">
                                                </div>
                                                <div class="col-auto px-xxl-0">
                                                    <div class="list-rating-scale list-rating-scale-lg mt-3 mt-xl-0">
                                                        <input type="radio" class="btn-check btn_complexity"
                                                               name="ComplexityOptions" data-val="1" id="Complexityoption1"
                                                               autocomplete="off">
                                                        <label class="btn btn-light ms-0" for="Complexityoption1">1</label>

                                                        <input type="radio" class="btn-check btn_complexity"
                                                               name="ComplexityOptions" data-val="2" id="Complexityoption2"
                                                               autocomplete="off">
                                                        <label class="btn btn-light" for="Complexityoption2">2</label>

                                                        <input type="radio" class="btn-check btn_complexity"
                                                               name="ComplexityOptions" data-val="3" id="Complexityoption3"
                                                               autocomplete="off">
                                                        <label class="btn btn-light" for="Complexityoption3">3</label>

                                                        <input type="radio" class="btn-check btn_complexity"
                                                               name="ComplexityOptions" data-val="4" id="Complexityoption4"
                                                               autocomplete="off">
                                                        <label class="btn btn-light" for="Complexityoption4">4</label>

                                                        <input type="radio" class="btn-check btn_complexity"
                                                               name="ComplexityOptions" data-val="5" id="Complexityoption5"
                                                               autocomplete="off">
                                                        <label class="btn btn-light me-0" for="Complexityoption5">5</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        } ?>
                                    </div>
                                    <button type="button" id="add_category" class="btn btn-primary">Add Category</button>
                                </div>
                            </div>
                            <div class="border-dashed"></div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="fw-medium text-lg me-12">Setup Scoring</div>
                                    <label class="switch">
                                        <input type="checkbox" class="form-switch-input" <?php echo ($__page->form->scoring ==1)?'checked':''; ?> id="scoring" name="scoring">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div id="max_point_section" class="mt-12 <?php echo ($__page->form->scoring ==0)?'d-none':''; ?>">
                                    <label for="" class="form-label col-3">Max Tokens * 
                                        <a tabindex="0" class="text-decoration-none text-primary float-end" role="button" data-bs-toggle="popover"
                                        data-bs-html="true"
                                         
                                        data-bs-title="What are max tokens?" 
                                        data-bs-content="<div class='fw-medium'>
                                            This is the maximum number of tokens a member can receive for this type of contribution.<br><br>
                                            If you're using a Yes/No approval type, this will equal either 0 for a denied attestation or the max points for an approved one.<br><br>
                                            If you are using a rating system, the average rating across all vectors will be multiplied by the max points (e.g. 4.3/5 average rating x 100 max points = 86 points awarded).</div>">Help</a>
                                    </label>
                                    <div class="col-3">
                                        <input type="number" class="form-control form-control-lg" id="max_point" name="max_point" value="<?php echo $__page->form->max_point; ?>" aria-describedby="Help">
                                    </div>
                                    <div id="Help" class="form-text">* Any modifications to scores will only apply to future contributions.</div>
                                </div>
                            </div>            
                        </div>
                    </div>

                    <div class="col-lg-11">
                        <div class="card shadow">
                            <div class="card-body">
                                <!--<div class="mb-3">
                                    <label for="" class="form-label">Claim approval period</label>
                                    <div class="input-group">
                                        <input type="number" id="approval_days" name="approval_days" class="form-control form-control-lg" value="<?php /*echo $__page->form->approval_days; */?>" placeholder="7">
                                        <span class="input-group-text fw-medium" id="">Days</span>
                                    </div>
                                </div>-->
                                <div class="mb-3">
                                    <label for="" class="form-label">Tags</label>
                                    <select class="form-control form-control-lg" multiple="multiple" name="tags[]" id="tags" placeholder="Marketing, Sales, Development">
                                        <?php
                                        if(strlen($__page->form->tags) > 0){
                                            $tags_arry = explode(",",$__page->form->tags);
                                            foreach ($tags_arry as $tag){ ?>
                                                <option selected="selected"><?php echo $tag; ?></option>
                                                <?php
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<div id="rating_block" class="row mb-6 d-none">
    <div class="col-lg-12 col-xl-5 col-xxl-6">
        <input type="text" class="form-control form-control-lg" id="category3" name="category[]"
               aria-describedby="">
    </div>
    <div class="col-auto px-xxl-0">
        <div class="d-flex mt-3 mt-xl-0">
            <div class="list-rating-scale list-rating-scale-lg">
                <input type="radio" class="btn-check btn_complexity"
                       name="ComplexityOptions" data-val="1" id="Complexityoption1"
                       autocomplete="off">
                <label class="btn btn-light ms-0" for="Complexityoption1">1</label>

                <input type="radio" class="btn-check btn_complexity"
                       name="ComplexityOptions" data-val="2" id="Complexityoption2"
                       autocomplete="off">
                <label class="btn btn-light" for="Complexityoption2">2</label>

                <input type="radio" class="btn-check btn_complexity"
                       name="ComplexityOptions" data-val="3" id="Complexityoption3"
                       autocomplete="off">
                <label class="btn btn-light" for="Complexityoption3">3</label>

                <input type="radio" class="btn-check btn_complexity"
                       name="ComplexityOptions" data-val="4" id="Complexityoption4"
                       autocomplete="off">
                <label class="btn btn-light" for="Complexityoption4">4</label>

                <input type="radio" class="btn-check btn_complexity"
                       name="ComplexityOptions" data-val="5" id="Complexityoption5"
                       autocomplete="off">
                <label class="btn btn-light me-0" for="Complexityoption5">5</label>
            </div>
            <button class="btn btn-delete">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-trash">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/admin-foot.php'; ?>
<script>
    var row_id = 3;
    $(document).on('change', '#scoring', function(event) {
        event.preventDefault();
        if(this.checked)
            $('#max_point_section').removeClass('d-none');
        else
            $('#max_point_section').addClass('d-none');
    });


    $(document).on('click', '#add_category', function(event) {
        event.preventDefault();
        var regex = /^(.+?)(\d+)$/i;
        $('#rating_block').clone().appendTo(('#rating_data_row')).removeClass('d-none')
            .attr("id", "category" +  row_id)
            .find("*")
            .each(function() {
                var id = this.id || "";
                var match = id.match(regex) || [];
                if (match.length == 3) {
                    this.id = match[1] + (row_id);
                }
            });
        row_id++;
    });

    $(document).on('click', '.btn-delete', function(event) {
        event.preventDefault();
        $(this).closest('.row').remove();
    });

    $(document).ready(function() {

        $('[data-bs-toggle="popover"]').popover();  
        $("#tags").select2({
            tags: true,
            tokenSeparators: [',']
        });

        $('.radio_rating').change(function () {
            if (this.value == '1')
                $('#rating_data').addClass('d-none');
            else
                $('#rating_data').removeClass('d-none');
        });

        $('#formApproval').validate({
            rules: {
                "tags[]":{
                    required: true
                }
            },
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function () {
                        $('#finish').prop('disabled', true);
                    },
                    success: function (data) {
                        if (data.success == true) {
                            window.location.replace('contribution');
                        } else {
                            if (data.element) {
                                $('#' + data.element).addClass('form-control-lg error');
                                $('<label class="error">' + data.msg + '</label>').insertAfter('#' + data.element);
                            } else
                                showMessage('danger', 10000, data.msg);
                        }

                        $('#finish').prop('disabled', false);
                    }
                });
            }
        });

    });

</script>
