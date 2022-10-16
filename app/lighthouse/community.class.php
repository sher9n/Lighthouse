<?php
namespace lighthouse;
use Core\Ds;
use Core\AmazonS3;
class Community{

    private $_data = array();

    public function __construct() {
        $this->_data = array();
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->_data))
            return $this->_data[$key];
    }

    public function __set($name, $value)
    {
       // if (array_key_exists($name, $this->_data))
            $this->_data[$name] = $value;
    }

    public function checkGatedAccess($user) {
        $response      = array();
        $access        = true;
        $com_id        = $this->_data['id'];
        $gated_acesses = GatedAccess::find("SELECT * FROM gated_access WHERE comunity_id=$com_id AND is_delete=0 AND is_active=1",true);

        foreach ($gated_acesses as $gated_acess){

            $api_response =  API::tokenGated(
                constant(strtoupper(SOLANA) . "_API"),
                $user,
                $gated_acess->min_amount,
                $gated_acess->contract,
                strtoupper($gated_acess->gated_type),
                $gated_acess->cluster
            );

            if (!isset($api_response->error)) {
                if($api_response->allowed == false) {
                    $gated_acess->gated = 0;
                    $access = false;
                }
                else
                   $gated_acess->gated = 1;
                array_push($response,$gated_acess);
            }
        }

        return array('access'=>$access,'gated' =>$response);
    }

    public function getAdminProposals($type=null){
        $com_id    = $this->_data['id'];
        if(!is_null($type))
            return Proposal::find("SELECT p.*,s.display_name,s.wallet_adr as modified_admin,s.c_at FROM proposals p LEFT JOIN stewards s ON p.object_id = s.id WHERE p.proposal_state<>'' AND p.proposal_type='$type' AND p.is_executed=0 AND p.comunity_id=$com_id AND p.object_name='admin'",true);
        else
            return Proposal::find("SELECT p.*,s.display_name,s.wallet_adr as modified_admin,s.c_at FROM proposals p LEFT JOIN stewards s ON p.object_id = s.id WHERE p.proposal_state<>'' AND p.is_executed=0 AND p.comunity_id=$com_id AND p.object_name='admin'",true);
    }

    public function getQuorumProposals(){
        $com_id    = $this->_data['id'];
        return Proposal::find("SELECT * FROM proposals WHERE is_executed=0 AND comunity_id=$com_id AND object_name='quorum'",true);
    }

    public function isAdmin($adr,$withProposal = false) {
        $adr = strtolower($adr);
        $connect = Ds::connect();
        $com_id  = $this->_data['id'];
        if($withProposal == false) {
            $items = $connect->query("select id from stewards where comunity_id='$com_id' AND lower(wallet_adr)='$adr' AND is_delete=0 AND active=1");
            if ($items->num_rows > 0)
                return true;
            else
                return false;
        }
        else {

            $items = $connect->query("select id,active from stewards where comunity_id='$com_id' AND lower(wallet_adr)='$adr' AND is_delete=0");

            if ($items->num_rows > 0) {
                $sids  = array();
                $retun = false;
                foreach ($items as $item) {
                    if ($item['active'] == 1){
                        $retun =  true;
                        break;
                    }
                    else
                        array_push($sids, $item['id']);
                }

                if($retun == false) {
                    $str = implode("','",$sids);

                    $proposals = $connect->query("SELECT id FROM proposals where comunity_id=212 AND object_id IN ('".$str."') AND proposal_type='ADD' AND object_name='admin' AND proposal_state<>'' AND is_delete=0");
                    if ($proposals->num_rows > 0)
                        return true;
                    else
                        return false;
                }
                else
                    return true;
            }
            else
                return false;
        }
    }

    public function getAdmin() {
        $comId = $this->_data['comunity_id'];
        $items = Steward::find("SELECT * FROM stewards WHERE comunity_id = '$comId' AND is_delete=0 AND active=1 LIMIT 1",true);
        if(count($items) > 0)
            return array_pop($items);
        else
            return null;
    }

    public function getStewards($count=false) {
        $com_id   = $this->_data['id'];

        if($count==true){
            $stewards = 0;
            $items = Steward::find("SELECT count(id) c FROM stewards WHERE comunity_id=" . $com_id . " AND is_delete=0 AND active=1");
            if ($items->num_rows > 0) {
                $response = $items->fetch_array(MYSQLI_ASSOC);
                $stewards = $response['c'];
            }
            return $stewards;
        }
        else {
            $stewards_data = Steward::find("SELECT * FROM stewards WHERE comunity_id=" . $com_id . " AND is_delete=0 AND active=1");
            foreach ($stewards_data as $steward) {
                $stewards[strtolower($steward['wallet_adr'])] = array(
                    'id' => $steward['id'],
                    'name' => $steward['display_name'],
                    'wallet_adr' => $steward['wallet_adr'],
                    'initial_admin' => $steward['initial_admin']
                );
            }
        }
        return $stewards;
    }

    public function getClaimImages($random=false) {
        $connect = Ds::connect();
        $id      = $this->_data['id'];
        $response = array();

        if($random == true) {
            $items = $connect->query("select claim_image_url from claim_images where comunity_id='$id' AND is_delete=0 ORDER BY RAND() LIMIT 1");

            if ($items->num_rows > 0)
                $response =  $items->fetch_array(MYSQLI_ASSOC);
        }
        else
        {
            $items = $connect->query("select id,claim_image_url from claim_images where comunity_id='$id' AND is_delete=0");
            if($items != false){
                while ($row = $items->fetch_array(MYSQLI_ASSOC)) {
                    $response[$row['id']] = $row['claim_image_url'];
                }
            }
        }
        $connect->close();
        return $response;
    }

    public static function getByDomain($subdomain) {
        $connect = Ds::connect();
        $items   = $connect->query("select * from communities where dao_domain='$subdomain' limit 1");

        if($items->num_rows > 0){
            $community_data = $items->fetch_array(MYSQLI_ASSOC);
            $community = new Community();

            if( isset($community_data['is_delete']) &&  $community_data['is_delete']==0) {
                $connect->close();
                return $community->load($community_data);
                exit();
            }
        }
        $connect->close();
        return null;
    }

    public static function get($id){
        $connect = Ds::connect();
        $items   = $connect->query("select * from communities where id='$id' limit 1");

        if($items->num_rows > 0){
            $community_data = $items->fetch_array(MYSQLI_ASSOC);
            $community = new Community();

            if( isset($community_data['is_delete']) &&  $community_data['is_delete']==0) {
                $connect->close();
                return $community->load($community_data);
                exit();
            }
        }
        $connect->close();
        return null;
    }

    public function load(array $item)
    {
        foreach($item as $k => $v)
        {
           // if(array_key_exists($k, $this->_data))
                $this->_data[$k] = $v;
        }
        return $this;
    }

    public static function isExistsCommunity($subdomain) {
        $subdomain = strtolower(preg_replace("/\s+/", "", $subdomain));
        $connect = Ds::connect();
        $results = $connect->query("SELECT c.id,c.dao_name,c.blockchain,c.ch,s.wallet_adr FROM communities c JOIN stewards s ON c.id=s.comunity_id WHERE c.dao_domain='$subdomain' AND c.is_delete=0 LIMIT 1");

        if($results->num_rows > 0) {
            $community_data = $results->fetch_array(MYSQLI_ASSOC);
            return array('dao_domain' => $subdomain,
                'dao_name' => $community_data['dao_name'],
                'blockchain' => $community_data['blockchain'],
                'ch' => $community_data['ch'],
                'wallet_adr' => $community_data['wallet_adr']
            );
        }
        else
            return FALSE;
    }

    public static function find($query,$objects=false)
    {
        $community_data = array();
        $connect = Ds::connect();
        $results = $connect->query($query);

        if($objects != false){
            while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
                $community = new Community();
                $community = $community->load($row);
                $community_data[$community->id] = $community;
            }
            $connect->close();
            return $community_data;
        }
        $connect->close();
        return $results;
    }

    public function getLogoImage() {
        $log_image = $this->_data["logo_img_url"];
        if(strlen($log_image) > 0)
            return app_cdn_path.'img/logo.png';
            //return app_cdn_path.'instances/'.$this->_data['dao_domain'].'/logo/'.$log_image;
        else
            return app_cdn_path.'img/logo.png';
    }

    public function update(array $updates = array())
    {
        $connect    = Ds::connect();
        $update_sql = "";
        $id         = $this->_data['id'];

        if(count($updates) == 0)
            $updates = $this->_data;

        unset($updates['id']);
        $updates['m_at'] = date("Y-m-d H:i:s");
        $c=0;
        foreach ($updates as $key=>$val) {
            $c++;
            if(count($updates) != $c)
                $update_sql .= $key . "='" . $connect->real_escape_string($val) . "',";
            else
                $update_sql .= $key . "='" . $connect->real_escape_string($val) . "'";
        }

        $update = "UPDATE communities SET ".$update_sql." WHERE id=".$id;
        $connect->query($update);
        $connect->close();
    }

    public function insert()
    {
        $connect = Ds::connect();
        $data = array();
        foreach ($this->_data as $key => $val) {
            $data[$key] = $connect->real_escape_string($val);
        }
        $fields = implode(",",array_keys($data));
        $values = implode("','",array_values($data));
        $insert_sql = "INSERT INTO communities (".$fields.") VALUES ('".$values."')";
        $connect->query($insert_sql);
        $id = $connect->insert_id;
        $this->addDefaultClaimImages($id);
        $connect->close();
        return $id;
    }

    public static function deleteClaimImage($image_id){
        $connect = Ds::connect();
        $update = "UPDATE claim_images SET is_delete='1' WHERE id='$image_id'";
        $connect->query($update);
        $connect->close();
    }

    public static function addClaimImages($com_id,$url){
        $connect = Ds::connect();
        $insert_sql = "INSERT INTO claim_images (comunity_id,claim_image_url) VALUES ('".$com_id."','".$url."')";
        $connect->query($insert_sql);
        $connect->close();
    }

    public function addDefaultClaimImages($com_id){
        $connect = Ds::connect();
        try {
            $doman = $this->_data['dao_domain'];
            $amazons3 = new AmazonS3($doman);
            $response = $amazons3->copyFile('https://lighthouse-cdn.s3.amazonaws.com/img/token_image.jpeg', 'instances/' . $doman . '/ticker/token_image.jpeg');
            $ticker_img_url = 'token_image.jpeg';

            $insert_sql = "UPDATE communities SET ticker_img_url='$ticker_img_url' WHERE id='$com_id'";
            $connect->query($insert_sql);
        }
        catch (\Exception $e){
            error_log($e->getMessage());
        }

        $insert_sql = "INSERT INTO claim_images (comunity_id,claim_image_url) VALUES ('".$com_id."','img/claim/img-claims-2.png')";
        $connect->query($insert_sql);

        $insert_sql = "INSERT INTO claim_images (comunity_id,claim_image_url) VALUES ('".$com_id."','img/claim/img-claims-3.png')";
        $connect->query($insert_sql);
        $connect->close();
    }
}
?>