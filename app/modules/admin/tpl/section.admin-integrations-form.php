<?php use lighthouse\Form; ?>
<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <div class="row">
                <form id="createForm" method="post" action="integrations-form" autocomplete="off">
                    <?php if(!is_null($__page->form)){ ?>
                        <input type="hidden" name="form_id" value="<?php echo $__page->form->id; ?>">
                        <div class="col-lg-10">
                            <div class="d-flex mb-6">
                                <a role="button" class="btn btn-white text-capitalize me-auto" href="integrations">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-arrow-left me-2">
                                        <line x1="19" y1="12" x2="5" y2="12"></line>
                                        <polyline points="12 19 5 12 12 5"></polyline>
                                    </svg>
                                    Back</a>
                                <button type="button" id="btn_cancel" class="btn btn-blue-stone me-2">Preview</button>
                                <button type="submit" id="btn_save" class="btn btn-primary" href="integrations-form">SAVE</button>
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="card shadow p-6 mb-12">
                                <div class="card-body border rounded-1">
                                    <input class="form-control form-control-xxl" type="text" placeholder="Untitled form" id="form_title" name="form_title" value="<?php echo $__page->form->form_title; ?>">
                                    <input class="form-control form-control-lg border-0 min-h-0 py-0" type="text" id="form_description" name="form_description"
                                           placeholder="Enter form description" value="<?php echo $__page->form->form_description; ?>">
                                </div>
                            </div>
                        </div>
                        <div id="elements" class="col-lg-10">
                            <?php
                            $elements = $__page->form->getElements();
                            foreach ($elements as $index => $element) {
                                $row_id = ($index + 1);
                                require 'partial/question-edit.php';
                            }
                            ?>
                        </div>
                    <?php }else{ ?>
                        <div class="col-lg-10">
                            <div class="d-flex mb-6">
                                <a role="button" class="btn btn-white text-capitalize me-auto" href="integrations">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-arrow-left me-2">
                                        <line x1="19" y1="12" x2="5" y2="12"></line>
                                        <polyline points="12 19 5 12 12 5"></polyline>
                                    </svg>
                                    Back</a>
                                <button type="button" id="btn_cancel" class="btn btn-blue-stone me-2">Preview</button>
                                <button type="submit" id="btn_save" class="btn btn-primary" href="integrations-form">SAVE</button>
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="card shadow p-6 mb-12">
                                <div class="card-body border rounded-1">
                                    <input class="form-control form-control-xxl" type="text" placeholder="Untitled form" id="form_title" name="form_title">
                                    <input class="form-control form-control-lg border-0 min-h-0 py-0" type="text" id="form_description" name="form_description"
                                           placeholder="Enter form description">
                                </div>
                            </div>
                        </div>
                        <div id="elements" class="col-lg-10">
                            <?php
                            $row_id = $__page->row_id;
                            require_once 'partial/question.php';
                            ?>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </section>
</main>
<!-- Short answer -->
<div class="q_description d-none" id="q_type_<?php echo Form::QT_SHORT_ANSWER; ?>">
    <label for="" class="form-label">Description</label>
    <input type="text" class="form-control form-control-lg" id="description_1" name="description[]"
           placeholder="Please enter the reason for this contribution">
</div>
<!-- Short answer END -->
<!-- Multiple choice -->
<div class="q_description d-none" id="q_type_<?php echo Form::QT_MULTIPLE_CHOICE; ?>">
    <label for="" class="form-label">Description</label>
    <div class="row mb-6">
        <div class="col-10 col-xxl-11">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-circle me-6">
                    <circle cx="12" cy="12" r="10"></circle>
                </svg>
                <input type="text" class="form-control form-control-lg" id="description_1" name="description[][]"
                       aria-describedby=""
                       placeholder="Please enter multiple choice option">
            </div>
        </div>
    </div>
    <div class="row mb-6">
        <div class="col-10 col-xxl-11">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-circle me-6">
                    <circle cx="12" cy="12" r="10"></circle>
                </svg>
                <input type="text" class="form-control form-control-lg" id="description_1" name="description[][]"
                       aria-describedby=""
                       placeholder="Please enter multiple choice option">
            </div>
        </div>
        <!--<div class="col px-0">
            <button class="btn btn-delete ms-0 h-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-trash">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
            </button>
        </div>-->
    </div>
</div>
<!-- Multiple choice END -->
<!-- Checkboxes -->
<div class="q_description d-none" id="q_type_<?php echo Form::QT_CHECKBOXES; ?>">
    <label for="" class="form-label">Description</label>
    <div class="row mb-6">
        <div class="col-10 col-xxl-11">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-square me-6">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                </svg>
                <input type="text" class="form-control form-control-lg"  id="description_1" name="description[][]"
                       aria-describedby="" placeholder="Please enter checkbox option">
            </div>
        </div>
    </div>
    <div class="row mb-6">
        <div class="col-10 col-xxl-11">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-square me-6">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                </svg>
                <input type="text" class="form-control form-control-lg"  id="description_1" name="description[][]"
                       aria-describedby="" placeholder="Please enter checkbox option">
            </div>
        </div>
        <!--<div class="col px-0">
            <button class="btn btn-delete ms-0 h-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-trash">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
            </button>
        </div>-->
    </div>
</div>
<!-- Checkboxes END -->
<!-- Dropdown -->
<div class="q_description d-none" id="q_type_<?php echo Form::QT_DROPDOWN; ?>">
    <label for="" class="form-label">Description</label>
    <div class="row mb-6">
        <div class="col-10 col-xxl-11">
            <input type="text" class="form-control form-control-lg" id="description_1" name="description[][]"
                   aria-describedby="" placeholder="Please enter dropdown option">
        </div>
    </div>
    <div class="row mb-6">
        <div class="col-10 col-xxl-11">
            <input type="text" class="form-control form-control-lg" id="description_1" name="description[][]"
                   aria-describedby="" placeholder="Please enter dropdown option">
        </div>
        <!--<div class="col px-0">
            <button class="btn btn-delete ms-0 h-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-trash">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
            </button>
        </div>-->
    </div>
    <button type="button" class="btn btn-primary">add option</button>
</div>
<!-- Dropdown END -->
<!-- Tags -->
<div class="q_description d-none" id="q_type_<?php echo Form::QT_TAGS; ?>">
    <div class="d-flex justify-content-between">
        <label for="" class="form-label">Description</label>
        <div class="fw-medium text-muted">Enter comma separated values</div>
    </div>
    <input type="text" class="form-control form-control-lg" id="description_1" name="description[]"
           placeholder="Marketing, Sales, Development">
</div>
<!-- Tags END -->
<!-- Pragraph -->
<div class="q_description d-none" id="q_type_<?php echo Form::QT_PARAGRAPH; ?>">
    <label for="" class="form-label">Description</label>
    <textarea class="form-control form-control-lg" id="description_1" name="description[]" rows="4"
              placeholder="Please enter the reason for this contribution"></textarea>
</div>
<!-- Pragraph END -->
<?php include_once app_root . '/templates/admin-foot.php'; ?>
<script type="text/javascript">

    $(document).ready(function() {

        $('#createForm').validate({
            rules: {
                form_title: {
                    required: true
                },
                question: {
                    required: true
                }
            },
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function () {
                        $('#btn_cancel').prop('disabled', true);
                        $('#btn_save').prop('disabled', true);
                    },
                    success: function (data) {
                        if (data.success == true) {
                            window.location.replace('integrations-approvals?form_id='+data.form_id);
                        } else {
                            if (data.element) {
                                $('#' + data.element).addClass('form-control-lg error');
                                $('<label class="error">' + data.msg + '</label>').insertAfter('#' + data.element);
                            } else
                                showMessage('danger', 10000, data.msg);
                        }
                        $('#btn_cancel').prop('disabled', false);
                        $('#btn_save').prop('disabled', false);
                    }
                });
            }
        });

    });

    $(document).on('click', '#add_item', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'get-form-question?rid='+row_id,
            dataType: 'json',
            success: function(data) {
                if (data.success == true){
                    row_id = data.row_id;
                    $('#add_item').remove();
                    $('#elements').append(data.html);
                }
            }
        });
    });

    $(document).on("click", '.question_type', function(event) {
        sel_html = $(this).html();
        var type = $(this).data('val');
        var regex = /^(.+?)(\d+)$/i;
        $(this).closest(".row").next().html('');
        $("#q_type_"+type).clone().appendTo($(this).closest(".row").next()).removeClass('d-none')
            .attr("id", "description_" +  row_id)
            .find("*")
            .each(function() {
                var id = this.id || "";
                var match = id.match(regex) || [];
                if (match.length == 3) {
                    this.id = match[1] + (row_id);
                }
            })
            .attr("name", "description["+ row_id +"]")
            .find("*")
            .each(function() {
                var id = this.name || "";
                var match = id.match(regex) || [];
                console.log(match);
                if (match.length == 3) {
                    this.name = match[1] + (row_id);
                }
            })
            .attr("name", "description["+ row_id +"][]")
            .find("*")
            .each(function() {
                var id = this.name || "";
                var match = id.match(regex) || [];
                console.log(match);
                if (match.length == 3) {
                    this.name = match[1] + (row_id);
                }
            });

        $(this).parent().parent().prev().children().html(sel_html);
        $(this).closest(".col_q_type").children('.selected_type').val(type);

    });

    $(document).on("click", '.delete_question', function(event) {
        $(this).closest('.card').remove();
        $('#add_item').remove();
        $('#elements').children().last().append('<a role="button" id="add_item" class="position-absolute top-0 start-100 p-6 bg-white rounded ms-6 shadow" href="#">' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"> ' +
            '<circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></a>');
    });

</script>
