<?php
App::import('Vendor', 'util/geometry');

class DistanceShell extends AppShell {
	function main(){
		$utilGeometry = new Util\Geometry();
		
		$figereId = 1;
		
		$this->loadModel('FigereLatlngLocationStart');
		
		$conditions = array('conditions' => array('FigereLatlngLocationStart.figure_id'=>$figereId));
		
		$geomData=$this->FigereLatlngLocationStart->find('first',$conditions);
		
		$FigereLatlngLocationStart = $geomData['FigereLatlngLocationStart'];
		
//		$FigereLatlngLocationStart['id'];
//		$FigereLatlngLocationStart['figure_id'];
//		$FigereLatlngLocationStart['lng'];
//		$FigereLatlngLocationStart['lat'];
		

		$this->loadModel('FigereLatlngLocationTarget');
		
		$conditions = array('conditions' => array('FigereLatlngLocationTarget.figure_id'=>$figereId));
		
		$geomData=$this->FigereLatlngLocationTarget->find('first',$conditions);
		
		$FigereLatlngLocationTarget = $geomData['FigereLatlngLocationTarget'];
		
//		$FigereLatlngLocationTarget['id'];
//		$FigereLatlngLocationTarget['figure_id'];
//		$FigereLatlngLocationTarget['lng'];
//		$FigereLatlngLocationTarget['lat'];
		
		$distance = $utilGeometry->distance_a($FigereLatlngLocationStart['lat'], $FigereLatlngLocationStart['lng'], $FigereLatlngLocationTarget['lat'], $FigereLatlngLocationTarget['lng']);
		
		$this->out(print_r($distance, true));
		
	}
}