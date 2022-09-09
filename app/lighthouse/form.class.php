<?php
namespace lighthouse;
use Core\Ds;
class Form{

    const QT_SHORT_ANSWER = 1;
    const QT_PARAGRAPH = 2;
    const QT_MULTIPLE_CHOICE = 3;
    const QT_CHECKBOXES = 4;
    const QT_DROPDOWN = 5;
    const QT_TAGS = 6;
    const QT_DATE = 7;
    const QT_FILE_UPLOAD = 8;

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
        $items   = $connect->query("select * from forms where id='$id' limit 1");

        if($items->num_rows > 0){
            $form_data = $items->fetch_array(MYSQLI_ASSOC);
            $form = new Form();

            $connect->close();
            return $form->load($form_data);
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

    public function getElements() {
        $elements = array();
        $connect = Ds::connect();
        $id =  $this->_data['id'];
        $results = $connect->query("SELECT * FROM form_elements WHERE is_delete=0 AND form_id='$id' ORDER by e_order");

        while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
            array_push($elements,$row);
        }

        $connect->close();
        return $elements;
    }

    public static function find($query,$objects=false)
    {
        $form_data = array();
        $connect = Ds::connect();
        $results = $connect->query($query);

        if($objects != false){
            while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
                $form = new Form();
                $form = $form->load($row);
                $form_data[$form->id] = $form;
            }
            $connect->close();
            return $form_data;
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

        $update = "UPDATE forms SET ".$update_sql." WHERE id=".$id;
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
        $insert_sql = "INSERT INTO forms (".$fields.") VALUES ('".$values."')";
        $connect->query($insert_sql);
        $id = $connect->insert_id;
        $connect->close();
        return $id;
    }
}
?>