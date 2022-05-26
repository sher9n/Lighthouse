<?php
namespace lighthouse;
use Core\Ds;
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
        $results = $connect->query("SELECT id,dao_name FROM communities WHERE dao_domain='$subdomain' AND is_delete=0 LIMIT 1");

        if($results->num_rows > 0) {
            $community_data = $results->fetch_array(MYSQLI_ASSOC);
            return array('dao_domain' => $subdomain, 'dao_name' => $community_data['dao_name']);
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

    public function getTickerImage() {
        return  app_cdn_path.'instances/'.app_site.'/communities/'.$this->_data['ticker_img_url'];
    }

    public function update(array $updates = array())
    {
        $connect    = Ds::connect();
        $update_sql = "";
        $id         = $this->_data['id'];

        if(count($updates) == 0)
            $updates = $this->_data;

        unset($updates['id']);

        $c=0;
        foreach ($updates as $key=>$val) {
            $c++;
            if(count($updates) != $c)
                $update_sql .= $key . "='" . $val . "',";
            else
                $update_sql .= $key . "='" . $val . "'";
        }

        $update = "UPDATE communities SET ".$update_sql." WHERE id=".$id;
        $connect->query($update);
        $connect->close();
    }

    public function insert()
    {
        $connect = Ds::connect();
        $fields = implode(",",array_keys($this->_data));
        $values = implode("','",array_values($this->_data));
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
        $insert_sql = "INSERT INTO claim_images (comunity_id,claim_image_url) VALUES ('".$com_id."','img/claim/img-claims-2.png')";
        $connect->query($insert_sql);

        $insert_sql = "INSERT INTO claim_images (comunity_id,claim_image_url) VALUES ('".$com_id."','img/claim/img-claims-3.png')";
        $connect->query($insert_sql);
        $connect->close();
    }
}
?>