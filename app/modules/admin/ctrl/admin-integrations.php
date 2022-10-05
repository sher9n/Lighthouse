<?php
use lighthouse\Auth;
use lighthouse\Community;
use lighthouse\Form;
use lighthouse\ContributionSource;
class controller extends Ctrl {
    function init() {
        $is_admin = false;
        $sel_wallet_adr = null;
        $community = Community::getByDomain(app_site);
        $com_id    = $community->id;

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
            if (__ROUTER_PATH == '/form-activation' && $this->hasParam('fid')) {
                $fid = $this->getParam('fid');
                $status = $this->hasParam('status')?$this->getParam('status'):1;
                if($fid==1){
                    $community->simple_claim_form = $status;
                    $community->update();
                }
                else {
                    $form = Form::get($fid);
                    $form->active = $status;
                    $form->update();
                }
                echo json_encode(array('success' => true));
                exit();
            }
            elseif (__ROUTER_PATH == '/cs-activation' && $this->hasParam('csid')){
                $csid   = $this->getParam('csid');
                $status = $this->hasParam('status')?(bool)$this->getParam('status'):1;

                $cs     = ContributionSource::get($csid);
                $cs->is_active = $status;
                $cs->update();

                echo json_encode(array('success' => true));
                exit();
            }
            elseif (__ROUTER_PATH =='/add-realms_contribution'){

                try {

                    $public_key = $name = '';
                    $vote_point = $pass_points = $create_point = 0;
                    $active = 0;
                    $update = false;
                    if ($this->hasParam('cs_id') && strlen($this->getParam('cs_id')) > 0) {
                        $cs = ContributionSource::get($this->getParam('cs_id'));
                        $update = true;
                    } else
                        $cs = new ContributionSource();

                    if ($this->hasParam('r_name') && strlen($this->getParam('r_name')) > 0)
                        $name = $this->getParam('r_name');
                    else
                        throw new Exception("r_name:Not a valid name");

                    if ($this->hasParam('r_public_key') && strlen($this->getParam('r_public_key')) > 0)
                        $public_key = $this->getParam('r_public_key');
                    else
                        throw new Exception("r_public_key:Not a valid public key");

                    if ($this->hasParam('r_vote_points') && $this->getParam('r_vote_points') > 0)
                        $vote_point = $this->getParam('r_vote_points');
                    else
                        throw new Exception("r_vote_points:Not a valid vote point");

                    if ($this->hasParam('r_proposal_pass_points') && $this->getParam('r_proposal_pass_points') > 0)
                        $pass_points = $this->getParam('r_proposal_pass_points');
                    else
                        throw new Exception("r_proposal_pass_points:Not a valid vote pass point");

                    if ($this->hasParam('r_proposal_create_points') && $this->getParam('r_proposal_create_points') > 0)
                        $create_point = $this->getParam('r_proposal_create_points');
                    else
                        throw new Exception("r_proposal_create_points:Not a valid vote create point");

                    if ($this->hasParam('r_enable'))
                        $active = ($this->getParam('r_enable') == 'on') ? 1 : 0;

                    $cs->source_name = $name;
                    $cs->source_key = $public_key;
                    $cs->vote_points = $vote_point;
                    $cs->source_type = ContributionSource::PROPOSAL_SOURCE_REALMS;
                    $cs->comunity_id = $community->id;
                    $cs->is_active   = $active;
                    $cs->proposal_create_points = $create_point;
                    $cs->proposal_pass_points = $pass_points;
                    if ($update == true)
                        $cs->update();
                    else {
                        $id = $cs->insert();
                        $cs->id = $id;
                    }

                    $ticker = $community->ticker;
                    include __DIR__ . '/../tpl/partial/realms_contribution_source.php';
                    $html = ob_get_clean();

                    echo json_encode(array('success' => true, 'html' => $html, 'update' => $update, 'cs_id' => $cs->id));

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
        }
        else {

            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }

            $cs = ContributionSource::find("SELECT * FROM contribution_sources WHERE comunity_id='$com_id' AND is_delete=0",true);

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'ticker' => $community->ticker,
                'is_admin' => $is_admin,
                'cs' => $cs,
                'blockchain' => $community->blockchain,
                'logo_url' => $community->getLogoImage(),
                'sel_wallet_adr' => $sel_wallet_adr,
                'user' => \lighthouse\User::isExistUser($sel_wallet_adr,$community->id),
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-integrations.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>