<?php

define('REST_SERVER', 'http://backend.local:8080');
define('REST_PORT', $_SERVER['SERVER_PORT']);

class Menu extends MY_Model {

	// constructor
	function __construct()
	{
		parent::__construct();
                $this->load->library(['curl', 'format', 'rest']);
	}

	function rules() {
		$config = [
			['field'=>'id', 'label'=>'Menu code', 'rules'=> 'required|integer'],
			['field'=>'name', 'label'=>'Item name', 'rules'=> 'required'],
			['field'=>'description', 'label'=>'Item description', 'rules'=> 'required|max_length[256]'],
			['field'=>'price', 'label'=>'Item price', 'rules'=> 'required|decimal'],
			['field'=>'picture', 'label'=>'Item picture', 'rules'=> 'required'],
			['field'=>'category', 'label'=>'Menu category', 'rules'=> 'required']
		];
		return $config;
	}
        function all()
        {
                $this->rest->initialize(array('server' => REST_SERVER));
                $this->rest->option(CURLOPT_PORT, REST_PORT);
                return $this->rest->get('/maintenance');
        }
        
        // Retrieve an existing DB record as an object
        function get($key, $key2 = null)
        {
                $this->rest->initialize(array('server' => REST_SERVER));
                $this->rest->option(CURLOPT_PORT, REST_PORT);
                return $this->rest->get('/maintenance/item/id/' . $key);
        }
        
        // Create a new data object.
        // Only use this method if intending to create an empty record and then
        // populate it.
        function create()
        {
            $names = ['id','name','description','price','picture','category'];
            $object = new StdClass;
            foreach ($names as $name)
                $object->$name = "";
            return $object;
        }
        
        // Delete a record from the DB
        function delete($key, $key2 = null)
        {
                $this->rest->initialize(array('server' => REST_SERVER));
                $this->rest->option(CURLOPT_PORT, REST_PORT);
                return $this->rest->delete('/maintenance/item/id/' . $key);
        }
        
        // Determine if a key exists
        function exists($key, $key2 = null)
        {
                $this->rest->initialize(array('server' => REST_SERVER));
                $this->rest->option(CURLOPT_PORT, REST_PORT);
                $result = $this->rest->get('/maintenance/item/id/' . $key);
                if(isset($result->error)){
                    return false;
                }
                return true;
                //return ! empty($result);
        }
        
        // Update a record in the DB
        function update($record)
        {
                $this->rest->initialize(array('server' => REST_SERVER));
                $this->rest->option(CURLOPT_PORT, REST_PORT);
                //$record['code']=(array)$record['code'];
                $retrieved = $this->rest->put('/maintenance/item/id/' . $record->id, $record);
        }
        
        // Add a record to the DB
        function add($record)
        {
                $this->rest->initialize(array('server' => REST_SERVER));
                $this->rest->option(CURLOPT_PORT, REST_PORT);
                $retrieved = $this->rest->post('/maintenance/item/id/' . $record->id, $record);
        }
}
