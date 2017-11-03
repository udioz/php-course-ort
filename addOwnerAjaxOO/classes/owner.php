<?php
require_once "classes/db.php";
class Owner {
    private $_db,
            $_data;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    public function create($fields = array()) {
        if(!$this->_db->insert('owners', $fields)) {
            throw new Exception('Sorry, there was a problem creating your space;');
        }
    }

    public function update($fields = array(), $id = null) {
        if(!$this->_db->update('owners', $id, $fields)) {
            throw new Exception('There was a problem updating');
        }
    }

	public function getList() {
		$sql = "select *,(select count(*) from pets where owner_id=o.id) as pets_count
    		  from owners as o";
		$this->_db->query($sql);
		return $this->_db->results();
	}

    public function find($owner = null) {
        if($owner) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('owners', array($field, '=', $user));
            if($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    public function data(){
        return $this->_data;
    }

}
?>
