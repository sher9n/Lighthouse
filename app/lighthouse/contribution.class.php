<?php
namespace lighthouse;
use Core\Ds;
class Contribution{

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
        $items   = $connect->query("select * from contributions where id='$id' limit 1");

        if($items->num_rows > 0){
            $data = $items->fetch_array(MYSQLI_ASSOC);
            $contribution = new Contribution();

            $connect->close();
            return $contribution->load($data);
            exit();

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
        $data = array();
        $connect = Ds::connect();
        $results = $connect->query($query);

        if($objects != false){
            while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
                $contribution = new Contribution();
                $contribution = $contribution->load($row);
                $data[$contribution->id] = $contribution;
            }
            $connect->close();
            return $data;
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
                $update_sql .= $key . "='" . $connect->real_escape_string($val) . "',";
            else
                $update_sql .= $key . "='" . $connect->real_escape_string($val) . "'";
        }

        $update = "UPDATE contributions SET ".$update_sql." WHERE id=".$id;
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
        $insert_sql = "INSERT INTO contributions (".$fields.") VALUES ('".$values."')";
        $connect->query($insert_sql);
        $id = $connect->insert_id;
        $connect->close();
        return $id;
    }
}
?>