<?php
use lighthouse\Community;
use lighthouse\Form;

if(app_site == 'app') {
    $communities = Community::find("SELECT * FROM communities WHERE is_delete=0 AND default_forms <> 1 LIMIT 1",true);

    foreach ($communities as $community){

        if($community instanceof Community){
            Form::addDefaultForms($community->id);
            $community->default_forms = 1;
            $community->update();
        }
    }
}
?>