<?php
App::uses('Component', 'Controller');

class UserComponent extends Component{

	public $components = array('Session');
	
	const USER_MODE_ADMIN = "ADMIN";

	const USER_MODE_PERSON = "PERSON";
	
	public function setUserMode($userMode){

		$this->Session->write('userMode',$userMode);

	}

	public function getUserMode(){
	
		return $this->Session->read('userMode');
	
	}
	
	
}

