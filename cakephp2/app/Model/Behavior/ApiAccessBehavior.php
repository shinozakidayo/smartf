<?php
class ApiAccessBehavior extends ModelBehavior {
	
	public function ApiAccess(Model $model,$url,$prm){

		App::uses('HttpSocket', 'Network/Http');
		$HttpSocket = new HttpSocket();
		
		echo("url" . $url . "<br>");
		
		
		$results = $HttpSocket->post($url, $prm);

		return $results['body'];
	}
	
}