<?php
namespace lighthouse;
use Core\Ds;
class Approval{
    const APPROVAL_TYPE_YES_NO=1;
    const APPROVAL_TYPE_RATING=2;

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
        $items   = $connect->query("select * from approvals where id='$id' limit 1");

        if($items->num_rows > 0){
            $data = $items->fetch_array(MYSQLI_ASSOC);
            $approval = new Approval();

            if( isset($data['is_delete']) &&  $data['is_delete']==0) {
                $connect->close();
                return $approval->load($data);
                exit();
            }
        }
        $connect->close();
        return null;
    }

    public static function getUserApprovals($contribution_type,$contribution_id,$user=null){
        $connect = Ds::connect();
        if(is_null($user))
            $items   = $connect->query("select id,approval,approval_type,approval_status from approvals where contribution_id='$contribution_id'");
        else
            $items   = $connect->query("select id,approval,approval_type,approval_status from approvals where contribution_id='$contribution_id' AND approval_by='$user'");

        $results = array();
        $tem     = array();
        $ids     = array();
        $type    = null;
        $x       = 0;

        if($items != false){

            if($contribution_type == Form::APPROVAL_TYPE_SUBJECTIVE) {

                while ($row = $items->fetch_array(MYSQLI_ASSOC)) {
                    array_push($ids, $row['id']);
                    $x++;
                    $categories = json_decode($row['approval']);
                    foreach ($categories as $cat => $val) {
                        if (isset($tem[$cat]))
                            $tem[$cat] += $val;
                        else
                            $tem[$cat] = $val;
                    }
                }

                foreach ($tem as $c => $v)
                    $results[$c] = round($v / $x);
            }
            else {
                while ($row = $items->fetch_array(MYSQLI_ASSOC)) {
                    array_push($ids, $row['id']);

                    $cat = $row['approval_status'];
                    if (isset($tem[$cat]))
                        $results[$cat] += 1;
                    else
                        $results[$cat] = 1;
                }
            }

        }

        $connect->close();
        return array('ids' => $ids, 'approvals' => $results);
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

    public static function getApprovals($contribution_id) {
        $stewards = array();
        $connect = Ds::connect();
        $results = $connect->query("SELECT approval_by FROM lighthouse.approvals where contribution_id='$contribution_id'");

        if($results != false){
            while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
                array_push($stewards,$row['approval_by']);
            }
        }
        return $stewards;
    }

    public static function find($query,$objects=false)
    {
        $approvals = array();
        $connect = Ds::connect();
        $results = $connect->query($query);

        if($objects != false){
            while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
                $approval = new Approval();
                $approval = $approval->load($row);
                $approvals[$approval->id] = $approval;
            }
        }
        else
            $approvals = $results;
        $connect->close();
        return $approvals;
    }

    public function update(array $updates = array())
    {
        $connect    = Ds::connect();
        $update_sql = "";
        $id         = $this->_data['id'];

        if(count($updates) == 0)
            $updates = $this->_data;

        unset($updates['id']);
        //$updates['m_at'] = date("Y-m-d H:i:s");
        $c=0;
        foreach ($updates as $key=>$val) {
            $c++;
            if(count($updates) != $c)
                $update_sql .= $key . "='" . $connect->real_escape_string($val) . "',";
            else
                $update_sql .= $key . "='" . $connect->real_escape_string($val) . "'";
        }
        $update = "UPDATE approvals SET ".$update_sql." WHERE id=".$id;
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
        $insert_sql = "INSERT INTO approvals (".$fields.") VALUES ('".$values."')";
        $connect->query($insert_sql);
        return $connect->insert_id;
        $connect->close();
    }
}
?>