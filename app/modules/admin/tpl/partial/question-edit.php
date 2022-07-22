<?php use lighthouse\Form; ?>
<div class="card shadow mb-12 card_<?php echo $row_id; ?>">
    <div class="card-body">
        <input type="hidden" name="element_ids[<?php echo $row_id;?>][<?php echo $element['id']; ?>]">
        <div class="row">
            <div class="col-lg-6 col-xl-8 mb-12">
                <label for="" class="form-label">Question</label>
                <input type="text" class="form-control form-control-lg" id="question_<?php echo $row_id; ?>" name="question[<?php echo $row_id; ?>]"
                       placeholder="What was your contribution?" value="<?php echo $element['e_label']; ?>">
            </div>
            <div class="col_q_type col-lg-6 col-xl-4 mb-12">
                <label for="" class="form-label">Select type</label>
                <input type="hidden" class="selected_type" name="selected_type[<?php echo $row_id; ?>]" value="<?php echo $element['e_type']; ?>">
                <div class="dropdown">
                    <button class="btn btn-lg dropdown-toggle d-flex justify-content-between align-items-center text-transform-inherit fw-medium w-100 border rounded-1"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div  class="d-flex align-items-center text-dark">
                           <?php if($element['e_type'] == Form::QT_SHORT_ANSWER){ ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-align-left me-3">
                                <line x1="17" y1="10" x2="3" y2="10"></line>
                                <line x1="21" y1="6" x2="3" y2="6"></line>
                                <line x1="21" y1="14" x2="3" y2="14"></line>
                                <line x1="17" y1="18" x2="3" y2="18"></line>
                            </svg>
                            <div class="fs-4">Short answer</div>
                            <?php }else if($element['e_type'] == Form::QT_PARAGRAPH) {
                               ?>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-align-justify me-6">
                                    <line x1="21" y1="10" x2="3" y2="10"></line>
                                    <line x1="21" y1="6" x2="3" y2="6"></line>
                                    <line x1="21" y1="14" x2="3" y2="14"></line>
                                    <line x1="21" y1="18" x2="3" y2="18"></line>
                                </svg>
                                <div class="fs-4">Pragraph</div>
                                <?php
                            }else if($element['e_type'] == Form::QT_MULTIPLE_CHOICE) {
                               ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-circle me-6">
                                    <circle cx="12" cy="12" r="10"></circle>
                                </svg>
                                <div class="fs-4">Multiple choice</div>
                                <?php
                            }else if($element['e_type'] == Form::QT_CHECKBOXES) {
                               ?>
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-check-square me-6">
                                   <polyline points="9 11 12 14 22 4"></polyline>
                                   <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                               </svg>
                               <div class="fs-4">Checkboxes</div>
                                <?php
                            }else if($element['e_type'] == Form::QT_DROPDOWN) {
                               ?>
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-arrow-down-circle me-6">
                                   <circle cx="12" cy="12" r="10"></circle>
                                   <polyline points="8 12 12 16 16 12"></polyline>
                                   <line x1="12" y1="8" x2="12" y2="16"></line>
                               </svg>
                               <div class="fs-4">Dropdown</div>
                                <?php
                           }else if($element['e_type'] == Form::QT_TAGS) {
                               ?>
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-tag me-6">
                                   <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                   <line x1="7" y1="7" x2="7.01" y2="7"></line>
                               </svg>
                               <div class="fs-4">Tags</div>
                                <?php
                           }
                            ?>
                        </div>
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton1">
                        <li class="border-bottom">
                            <a class="dropdown-item d-flex align-items-center py-6 px-12 question_type" href="#" data-val="<?php echo Form::QT_SHORT_ANSWER; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-align-left me-6">
                                    <line x1="17" y1="10" x2="3" y2="10"></line>
                                    <line x1="21" y1="6" x2="3" y2="6"></line>
                                    <line x1="21" y1="14" x2="3" y2="14"></line>
                                    <line x1="17" y1="18" x2="3" y2="18"></line>
                                </svg>
                                <div class="fs-4">Short answer</div>
                            </a>
                        </li>
                        <li class="border-bottom">
                            <a class="dropdown-item d-flex align-items-center py-6 px-12 question_type" href="#" data-val="<?php echo Form::QT_PARAGRAPH; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-align-justify me-6">
                                    <line x1="21" y1="10" x2="3" y2="10"></line>
                                    <line x1="21" y1="6" x2="3" y2="6"></line>
                                    <line x1="21" y1="14" x2="3" y2="14"></line>
                                    <line x1="21" y1="18" x2="3" y2="18"></line>
                                </svg>
                                <div class="fs-4">Pragraph</div>
                            </a>
                        </li>
                        <li class="border-bottom">
                            <a class="dropdown-item d-flex align-items-center py-6  px-12 question_type" href="#" data-val="<?php echo Form::QT_MULTIPLE_CHOICE; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-circle me-6">
                                    <circle cx="12" cy="12" r="10"></circle>
                                </svg>
                                <div class="fs-4">Multiple choice</div>
                            </a>
                        </li>
                        <li class="border-bottom">
                            <a class="dropdown-item d-flex align-items-center py-6  px-12 question_type" href="#" data-val="<?php echo Form::QT_CHECKBOXES; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-check-square me-6">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                <div class="fs-4">Checkboxes</div>
                            </a>
                        </li>
                        <li class="border-bottom">
                            <a class="dropdown-item d-flex align-items-center py-6  px-12 question_type" href="#" data-val="<?php echo Form::QT_DROPDOWN; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-arrow-down-circle me-6">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="8 12 12 16 16 12"></polyline>
                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                </svg>
                                <div class="fs-4">Dropdown</div>
                            </a>
                        </li>
                        <li class="">
                            <a class="dropdown-item d-flex align-items-center py-6  px-12 question_type" href="#" data-val="<?php echo Form::QT_TAGS; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-tag me-6">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                </svg>
                                <div class="fs-4">Tags</div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="description_row">
            <?php if($element['e_type'] == Form::QT_SHORT_ANSWER){ ?>
                <div class="q_description" id="q_type_<?php echo Form::QT_SHORT_ANSWER; ?>">
                    <label for="" class="form-label">Description</label>
                    <input type="text" class="form-control form-control-lg" id="description_<?php echo $row_id; ?>" name="description[<?php echo $row_id; ?>]"
                           placeholder="Please enter the reason for this contribution" value="<?php echo $element['e_description']; ?>">
                </div>
            <?php }else if($element['e_type'] == Form::QT_PARAGRAPH) {
                ?>
                <div class="q_description" id="q_type_<?php echo Form::QT_PARAGRAPH; ?>">
                    <label for="" class="form-label">Description</label>
                    <textarea class="form-control form-control-lg" id="description_<?php echo $row_id; ?>" name="description[<?php echo $row_id; ?>]" rows="4"
                              placeholder="Please enter the reason for this contribution"><?php echo $element['e_description']; ?></textarea>
                </div>
                <?php
            }else if($element['e_type'] == Form::QT_MULTIPLE_CHOICE) {
                ?>
                <div class="q_description" id="q_type_<?php echo Form::QT_MULTIPLE_CHOICE; ?>">
                    <label for="" class="form-label">Description</label>
                    <?php
                    $descriptions = $element['e_description'];
                    $descriptions = json_decode($descriptions);
                    foreach ($descriptions as $des){
                    ?>
                    <div class="row mb-6">
                        <div class="col-10 col-xxl-11">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-circle me-6">
                                    <circle cx="12" cy="12" r="10"></circle>
                                </svg>
                                <input type="text" class="form-control form-control-lg" id="description_<?php echo $row_id; ?>" name="description[<?php echo $row_id; ?>][]"
                                       aria-describedby=""
                                       placeholder="Please enter multiple choice option" value="<?php echo $des; ?>">
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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
                    <button type="button" class="btn btn-primary">add option</button>
                </div>
                <?php
            }else if($element['e_type'] == Form::QT_CHECKBOXES) {
                ?>
                <div class="q_description" id="q_type_<?php echo Form::QT_CHECKBOXES; ?>">
                    <label for="" class="form-label">Description</label>
                    <?php
                    $descriptions = $element['e_description'];
                    $descriptions = json_decode($descriptions);
                    foreach ($descriptions as $des){
                    ?>
                    <div class="row mb-6">
                        <div class="col-10 col-xxl-11">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-square me-6">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                </svg>
                                <input type="text" class="form-control form-control-lg"  id="description_<?php echo $row_id; ?>" name="description[<?php echo $row_id; ?>][]"
                                       aria-describedby="" placeholder="Please enter checkbox option">
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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
                    <button type="button" class="btn btn-primary">add option</button>
                </div>
                <?php
            }else if($element['e_type'] == Form::QT_DROPDOWN) {
                ?>
                <div class="q_description " id="q_type_<?php echo Form::QT_DROPDOWN; ?>">
                    <label for="" class="form-label">Description</label>
                    <?php
                    $descriptions = $element['e_description'];
                    $descriptions = json_decode($descriptions);
                    foreach ($descriptions as $des){
                    ?>
                    <div class="row mb-6">
                        <div class="col-10 col-xxl-11">
                            <input type="text" class="form-control form-control-lg" id="description_<?php echo $row_id; ?>" name="description[<?php echo $row_id; ?>][]"
                                   aria-describedby="" placeholder="Please enter dropdown option">
                        </div>
                    </div>
                    <?php } ?>
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
                    <button type="button" class="btn btn-primary">add option</button>
                </div>
                <?php
            }else if($element['e_type'] == Form::QT_TAGS) {
                ?>
                <div class="q_description " id="q_type_<?php echo Form::QT_TAGS; ?>">
                    <div class="d-flex justify-content-between">
                        <label for="" class="form-label">Description</label>
                        <div class="fw-medium text-muted">Enter comma separated values</div>
                    </div>
                    <input type="text" value="<?php echo $element['e_description']; ?>" class="form-control form-control-lg" id="description_<?php echo $row_id; ?>" name="description[<?php echo $row_id; ?>]"
                           placeholder="Marketing, Sales, Development">
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <hr class="my-2">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-end">
            <a class="px-8 btn-copy" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-copy text-dark">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                </svg>
            </a>
            <a class="px-8 btn-trash delete_question" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-trash text-dark">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
            </a>
            <div class="vr"></div>
            <div class="ms-8 me-6 fw-medium text-lg">Required</div>
            <label class="switch">
                <input type="checkbox" class="form-switch-input" <?php echo ($element['e_required'] == 1)?'checked':''; ?> name="required[<?php echo $row_id; ?>]">
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <?php if(count($elements) == $row_id){ ?>
    <a role="button" id="add_item"
       class="position-absolute top-0 start-100 p-6 bg-white rounded ms-6 shadow" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
             stroke-linejoin="round" class="feather feather-plus-circle">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="16"></line>
            <line x1="8" y1="12" x2="16" y2="12"></line>
        </svg>
    </a>
    <?php } ?>
    <script>
        var row_id = '<?php echo $row_id; ?>'
    </script>
</div>