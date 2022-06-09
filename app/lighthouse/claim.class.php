<?php
namespace lighthouse;
use Core\Ds;
class Claim{

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

    public static function get($id){
        $connect = Ds::connect();
        $items   = $connect->query("select * from claims where id='$id' limit 1");

        if($items->num_rows > 0){
            $claim_data = $items->fetch_array(MYSQLI_ASSOC);
            $claim = new Claim();

            if( isset($claim_data['is_delete']) &&  $claim_data['is_delete']==0) {
                $connect->close();
                return $claim->load($claim_data);
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
        $claims = array();
        $connect = Ds::connect();
        $results = $connect->query($query);

        if($objects != false){
            while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
                $claim = new Claim();
                $claim = $claim->load($row);
                $claims[$claim->id] = $claim;
            }
        }
        else
            $claims = $results;
        $connect->close();
        return $claims;
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

        $update = "UPDATE claims SET ".$update_sql." WHERE id=".$id;
        $connect->query($update);
        $connect->close();
    }

    public function insert()
    {
        $connect = Ds::connect();
        $fields = implode(",",array_keys($this->_data));
        $values = implode("','",array_values($this->_data));
        $insert_sql = "INSERT INTO claims (".$fields.") VALUES ('".$values."')";
        $connect->query($insert_sql);
        return $connect->insert_id;
        $connect->close();
    }
}
?>