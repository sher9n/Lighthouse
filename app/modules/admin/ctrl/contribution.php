<?php
use lighthouse\Auth;
use lighthouse\Community;
use lighthouse\Contribution;
use lighthouse\Log;
use Core\AmazonS3;
use Core\Utils;
use lighthouse\Form;
use lighthouse\User;
class controller extends Ctrl {
    function init() {
        $is_admin       = false;
        $sel_wallet_adr = $wallet_adr = null;
        $community      = Community::getByDomain(app_site);
        $site           = Auth::getSite();
        $user           = false;

        if($this->hasParam('ch') && strlen($this->getParam('ch'))) {
            $_SESSION['lighthouse'] = null;
            $ch     = $this->getParam('ch');
            $site   = Auth::getSite();

            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }

            if(isset($site['ch']) && $ch == $site['ch']){
                $_SESSION['lh_sel_wallet_adr'] = $site['wallet_adr'];
                $wallet_adr     = $site['wallet_adr'];
                $community->ch  = '';
                $community->update();

                $user = new User();
                $user->wallet_adr  = $wallet_adr;
                $user->comunity_id = $community->id;
                $user->new_user    = 1;
                $uid = $user->insert();
                $user->id = $uid;
            }
            else
            {
                header("Location: ".app_url.'admin');
                die();
            }
        }

        $login = Auth::attemptLogin();

        if($login != false) {
            $sel_wallet_adr = $login;
            $is_admin = $community->isAdmin($sel_wallet_adr);
        }
        else
        {
            header("Location: " . app_url.'admin');
            die();
        }

        if($this->__lh_request->is_xmlHttpRequest) {

            if($this->__lh_request->is_post) {

                try {
                    $form_id = $wallet_to = $contribution_reason = $tags = null;
                    $post = $_POST;
                    unset($post['form_id']);
                    unset($post['wallet_address']);

                    if ($this->hasParam('form_id') && strlen($this->getParam('form_id')) > 0)
                        $form_id = $this->getParam('form_id');
                    else
                        throw new Exception("Invalid form details, please contact your admin");

                    if ($this->hasParam('wallet_address') && strlen($this->getParam('wallet_address')) > 0)
                        $wallet_to = $this->getParam('wallet_address');
                    else
                        throw new Exception("wallet_address:This field is required.");

                    $form = Form::get($form_id);
                    $elements = $form->getElements();

                    foreach ($elements as $element) {

                        if ($element['e_required'] == 1) {
                            $ele_name = $element['e_name'];

                            if (!isset($post[$ele_name]) || strlen($post[$ele_name]) < 1)
                                throw new Exception($ele_name . ":This field is required.");
                        }
                    }

                    $contribution_f_name = $form_id;
                    if(isset($_FILES) && is_array($_FILES)) {
                        $files    = $_FILES;
                        $f_e_name = array_key_first($files);
                        $contribution_f_name = $contribution_f_name.'_'.$f_e_name.'_'.time();

                            if (!empty($files[$f_e_name]) && is_array($files[$f_e_name])) {
                                $file = $files[$f_e_name];

                                if (!Utils::isValidImageSize($file['size']))
                                    throw new Exception($f_e_name.":Maximum image size exceeded. File size should be less then " . MAX_IMAGE_UPLOAD_SIZE);

                                $path      = $file['name'];
                                $ext       = pathinfo($path, PATHINFO_EXTENSION);
                                $img_name  = time();
                                $amazons3  = new AmazonS3(app_site);
                                $t_url     = $amazons3->uploadFile($file['tmp_name'], $contribution_f_name.'.'.$ext);
                                $post[$f_e_name] = $contribution_f_name.'.'.$ext;
                            }
                    }

                    $contribusion = new Contribution();
                    $contribusion->comunity_id = $community->id;
                    $contribusion->wallet_from = $sel_wallet_adr;
                    $contribusion->wallet_to   = $wallet_to;
                    $contribusion->tags        = $form->tags;
                    //update contribution approval data
                    $contribusion->form_id     = $form_id;
                    $contribusion->max_point   = $form->max_point;
                    $contribusion->scoring     = $form->scoring;
                    $contribusion->approval_type       = $form->approval_type;
                    $contribusion->approval_count      = $community->approval_count;
                    $contribusion->contribution_reason = current($post);

                    if($form->approval_type == 2)
                        $contribusion->rating_categories = $form->rating_categories;

                    $contribusion->form_data   = json_encode($post);
                    $contribusion->insert();

                    echo json_encode(array('success' => true, 'message' => 'Success! Your claim has been submitted.'));

                } catch (Exception $e) {
                    $msg = explode(':', $e->getMessage());
                    $element = 'error-msg';
                    if (isset($msg[1])) {
                        $element = $msg[0];
                        $msg = $msg[1];
                    }
                    echo json_encode(array('success' => false, 'msg' => $msg, 'element' => $element));
                }
                exit();
            }
            else {
                if(__ROUTER_PATH == '/contribution-list' ) {
                    $html = '';
                    if($this->hasParam('t')) {
                        $t              = $this->getParam('t');
                        $com_id         = $community->id;
                        $claims         = array();
                        $approval_days  = $community->approval_days;
                        $reviewed_ids   = array();

                        if($t =='Queued') {
                            $claim_all     = array();
                            $reviewed_data = Contribution::find("SELECT a.contribution_id FROM approvals a LEFT JOIN contributions c ON a.contribution_id = c.id WHERE c.is_realms=0 AND c.comunity_id=$com_id AND c.status=0 AND a.approval_by='$sel_wallet_adr'");
                            if($reviewed_data->num_rows > 0) {
                                foreach ($reviewed_data as $review) {
                                    array_push($reviewed_ids, $review['contribution_id']);
                                }

                                $id_sql = '(' . implode(",", $reviewed_ids) . ')';
                                $claim_all = Contribution::find("SELECT distinct(c.id) as c_id,c.c_at,c.status,f.form_title,c.contribution_reason,f.tags,c.form_data,c.form_id,c.proposal_id,p.proposal_state,p.is_executed,c.wallet_to  FROM contributions c LEFT JOIN forms f ON c.form_id=f.id LEFT JOIN proposals p ON c.proposal_id=p.id WHERE c.id IN ".$id_sql);
                            }

                            foreach ($claim_all as $claim) {
                                array_push($claims, $claim);
                            }
                        }
                        else if ($t == 'Claims') {
                            $claim_all     = array();
                            $reviewed_data = Contribution::find("SELECT a.contribution_id,c.form_id  FROM approvals a LEFT JOIN contributions c ON a.contribution_id = c.id WHERE c.is_realms=0 AND c.comunity_id=$com_id AND c.status=0 AND a.approval_by='$sel_wallet_adr'");
                            if($reviewed_data->num_rows > 0) {
                                foreach ($reviewed_data as $review) {
                                    array_push($reviewed_ids,$review['contribution_id']);
                                }

                                $id_sql = '('.implode(",",$reviewed_ids).')';
                                $claim_all = Contribution::find("SELECT distinct(c.id) as c_id,c.c_at,c.status,f.form_title,c.contribution_reason,f.tags,c.form_data,c.form_id,c.proposal_id,p.proposal_state,p.is_executed,c.wallet_to FROM contributions c LEFT JOIN forms f ON c.form_id=f.id LEFT JOIN proposals p ON c.proposal_id=p.id WHERE c.is_realms=0 AND c.status = 0 AND f.id <> 2 AND c.comunity_id=$com_id AND c.id NOT IN ".$id_sql);
                            }
                            else
                                $claim_all = Contribution::find("SELECT distinct(c.id) as c_id,c.c_at,c.status,f.form_title,c.contribution_reason,f.tags,c.form_data,c.form_id,c.proposal_id,p.proposal_state,p.is_executed,c.wallet_to FROM contributions c LEFT JOIN forms f ON c.form_id=f.id LEFT JOIN proposals p ON c.proposal_id=p.id WHERE c.is_realms=0 AND c.status = 0 AND f.id <> 2 AND c.comunity_id='$com_id'");

                            foreach ($claim_all as $claim) {
                                array_push($claims, $claim);
                            }
                        }
                        else {

                            if($t == 'Denied')
                                $status = 'c.status = 2';
                            else
                                $status = 'c.status = 1';

                            $claim_all = Contribution::find("SELECT distinct(c.id) as c_id,c.c_at,c.status,f.form_title,c.contribution_reason,f.tags,c.form_data,c.form_id,c.proposal_id,p.proposal_state,p.is_executed,c.wallet_to FROM contributions c LEFT JOIN forms f ON c.form_id=f.id LEFT JOIN proposals p ON c.proposal_id=p.id WHERE c.is_realms=0 AND $status AND f.id <> 2 AND  c.comunity_id=$com_id");

                            foreach ($claim_all as $claim) {
                                array_push($claims, $claim);
                            }

                        }
                        include __DIR__ . '/../tpl/partial/contribution_list.php';
                        $html = ob_get_clean();
                    }

                    echo json_encode(array('success' => true,'html'=>$html));
                    exit();
                }
                else {
                    $html = $sql = '';
                    $com_id = $community->id;

                    if ($this->hasParam('c') && intval($this->getParam('c')) > 0)
                        $sql .= ' AND complexity=' . $this->getParam('c');

                    if ($this->hasParam('i') && intval($this->getParam('i')) > 0)
                        $sql .= ' AND importance=' . $this->getParam('i');

                    if ($this->hasParam('q') && intval($this->getParam('q')) > 0)
                        $sql .= ' AND quality=' . $this->getParam('q');

                    $contributions = Contribution::find("SELECT c.contribution_reason,c.c_at FROM contributions c LEFT JOIN approvals a ON c.id=a.contribution_id where c.is_realms=0 AND comunity_id='$com_id' " . $sql);
                    if ($contributions != false && $contributions->num_rows > 0) {
                        while ($row = $contributions->fetch_array(MYSQLI_ASSOC)) {
                            $html .= '<div class="p-8 bg-lighter rounded-1 mb-6">
                        <div class="text-muted fs-sm">' . Utils::time_elapsed_string($row['c_at'], false, true) . '</div>
                        <div class="fw-medium mt-1">' . $row['contribution_reason'] . '</div></div>';
                        }
                    } else {
                        $html = '<div class="d-flex flex-column align-items-center justify-content-center py-25">
                        <img src="' . app_cdn_path . 'img/img-empty.svg" width="208">
                        <div class="fw-medium mt-4">No data found.</div></div>';
                    }

                    echo json_encode(array('success' => true, 'html' => $html));
                    exit();
                }
            }
        }
        else {

            $form           = null;
            $template       = '/../tpl/section.contribution.php';
            $view_contract  = '';

            if($community->blockchain == SOLANA)
                $view_contract = SOLANA_VIEW_LINK.'account/'.$community->community_address;

            if($this->hasParam('form') && strlen($this->getParam('form')) > 0) {
                $form_id    = $this->getParam('form');
                $form       = Form::get($form_id);
                $template   = '/../tpl/section.form_template.php';
            }

            $com_id   = $community->id;
            $forms    = Form::find("SELECT * FROM forms WHERE is_delete=0 AND active=1 AND comunity_id='$com_id'",true);
            if($user == false)
                $user = User::isExistUser($sel_wallet_adr,$community->id);

            if($user == false) {
                Auth::clearCookieWallet();
                header("Location: " . app_url.'admin');
                die();
            }

            $new_user = $user->new_user;
            if ($user->new_user != 0) {
                $user->new_user  = 0;
                $user->update();
            }

            $__page = (object)array(
                'title' => $site['site_name'],
                'form' => $form,
                'forms' => $forms,
                'site' => $site,
                'ticker' => $community->ticker,
                'community' => $community,
                'simple_claim_form' => $community->simple_claim_form,
                'logo_url' => $community->getLogoImage(),
                'community_name' => $community->dao_name,
                'is_admin' => $is_admin,
                'view_contract' => $view_contract,
                'wallet_adr' => $wallet_adr,
                'blockchain' => $community->blockchain,
                'sel_wallet_adr' => $sel_wallet_adr,
                'user' => $user,
                'new_user' => $new_user,
                'sections' => array(
                    __DIR__ . $template
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>