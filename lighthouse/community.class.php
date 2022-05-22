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

    public static function getByDomain($subdomain) {
        $connect = Ds::connect();
        $items   = $connect->query("select * from communities where subdomain='$subdomain' limit 1");

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

    public function update(array $updates = array())
    {
        $connect    = Ds::connect();
        $update_sql = "";
        $id         = $this->_data['id'];

        if(count($updates) == 0)
            $updates = $this->_data;

        unset($updates['id']);

        foreach ($updates as $key=>$val)
            $update_sql .= $key."='".$val."' ";

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
        return $connect->insert_id;
        $connect->close();
    }
}
?>