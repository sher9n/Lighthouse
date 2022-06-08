<?php
namespace lighthouse;
use Core\Ds;
class Steward{

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

    public static function deleteSteward($id,$adr,$com_id) {
        $connect = Ds::connect();
        $items   = $connect->query("UPDATE stewards SET is_delete=1 WHERE comunity_id='$com_id' AND id='$id' AND wallet_adr='$adr'");
        if($items == true)
            return true;
        else
            return false;
    }

    public static function get($id){
        $connect = Ds::connect();
        $items   = $connect->query("select * from stewards where id='$id' limit 1");

        if($items->num_rows > 0){
            $stewards_data = $items->fetch_array(MYSQLI_ASSOC);
            $steward = new Steward();

            if( isset($stewards_data['is_delete']) &&  $stewards_data['is_delete']==0) {
                $connect->close();
                return $steward->load($stewards_data);
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

    public static function find($query,$objects=false)
    {
        $stewards_data = array();
        $connect = Ds::connect();
        $results = $connect->query($query);

        if($objects != false){
            while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
                $steward = new Steward();
                $steward = $steward->load($row);
                $stewards_data[$steward->id] = $steward;
            }
            $connect->close();
            return $stewards_data;
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
        $updates['m_at'] = date("Y-m-d H:i:s");
        $c=0;
        foreach ($updates as $key=>$val) {
            $c++;
            if(count($updates) != $c)
                $update_sql .= $key . "='" . $val . "',";
            else
                $update_sql .= $key . "='" . $val . "'";
        }

        $update = "UPDATE stewards SET ".$update_sql." WHERE id=".$id;
        $connect->query($update);
        $connect->close();
    }

    public function insert()
    {
        $connect = Ds::connect();
        $fields = implode(",",array_keys($this->_data));
        $values = implode("','",array_values($this->_data));
        $insert_sql = "INSERT INTO stewards (".$fields.") VALUES ('".$values."')";
        $connect->query($insert_sql);
        $id = $connect->insert_id;
        $connect->close();
        return $id;
    }
}
?>