<?php
namespace lighthouse;
use Core\Ds;
use Core\Utils;
use Core\AmazonSes;

class Email {

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

    public function send(){
        $this->insert();
        AmazonSes::send($this->_data['sender'],array($this->_data['recipient']),$this->_data['subject'],$this->_data['data']);
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
        $insert_sql = "INSERT INTO emails (".$fields.") VALUES ('".$values."')";
        $connect->query($insert_sql);
        $id = $connect->insert_id;
        $connect->close();
        return $id;
    }
}
?>