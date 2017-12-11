<?php

class JsonController extends AppController{
	
// public $uses = array(‘FigureLatlngPosition’);
 
 function beforeFilter(){
 	//親クラスのbeforeFilterの読み込み
 	parent::beforeFilter();
 }

 function test(){
 	$this->autoRender = false;
 	
 	$data = array(
 		array('1','test11','test12'),
 		array('2','test21','test22'),
 		array('3','test31','test32'),
 		array('4','test41','test42'),
 		array('5','test51','test52'),
 		array('6','test61','test62'),
 		array('7','test71','test72'),
 		array('8','test81','test82')
 	);
 	
 	return json_encode($data);
 	
 }
 
 function zahyosend(){
 	
    $this->loadModel('FigureLatlngPosition');

 	// ①HTMLの表示はいらないため自動レンダリングをOFFにする
 	$this->autoRender = false;
 	// レスポンスの形式をJSONで指定
 	$this->response->type('application/json');
 	

 	// POSTデータの取得
 	$figereId = $this->request->data('figereId');
	$latitude = $this->request->data('latitude');
	$longitude = $this->request->data('longitude');
 
 	$figereId = 1;
// 	$latitude = mt_rand(0.01,1.00);
// 	$longitude = mt_rand(0.01,1.00);

 	$conditions = array('conditions' => array('FigureLatlngPosition.figure_id'=>$figereId));
 	
 	if($this->FigureLatlngPosition->find('count',$conditions) > 0){
 		$this->FigureLatlngPosition->updategeom($figereId,$latitude,$longitude);
 	}
 	else {
 		$this->FigureLatlngPosition->insertgeom($figereId,$latitude,$longitude);
 	}
 	
/* 	$data = array(
 			array('1','test11','test12'),
 			array('2','test21','test22'),
 			array('3','test31','test32'),
 			array('4','test41','test42'),
 			array('5','test51','test52'),
 			array('6','test61','test62'),
 			array('7','test71','test72'),
 			array('8','test81','test82')
 	); */
 	
// 	echo($this->getDataSource()->getLog());
 	
 	$geomData = "{$latitude}lt、{$longitude}gt です";
 	$this->response->body(json_encode(compact('geomData')));
 	
 }
 
 function figereLocationStartSend(){

 	$this->loadModel('FigereLatlngLocationStart');
 	
 	// ①HTMLの表示はいらないため自動レンダリングをOFFにする
 	$this->autoRender = false;
 	// レスポンスの形式をJSONで指定
 	$this->response->type('application/json');
 	
 	// POSTデータの取得
 	$figereId = $this->request->data('figereId');
 	$latitude = $this->request->data('latitude');
 	$longitude = $this->request->data('longitude');

	if($latitude == null || $longitude == null){
		$geomData = false;
 		$this->response->body(json_encode(compact('geomData')));
 		return true;
	}
 	
 	$conditions = array('conditions' => array('FigereLatlngLocationStart.figure_id'=>$figereId));
 	
 	if($this->FigereLatlngLocationStart->find('count',$conditions) > 0){
 		$this->FigereLatlngLocationStart->updategeom($figereId,$latitude,$longitude);
 	}
 	else {
 		$this->FigereLatlngLocationStart->insertgeom($figereId,$latitude,$longitude);
 	}
 	
 	$geomData = "{$latitude}lt、{$longitude}gt です";
 	$this->response->body(json_encode(compact('geomData')));
 	
 }

 function figereLocationTargetSend(){
 
 }

 function figereLocationStartGet(){
 
 }
 
 function figereLocationTargetGet(){
 
 }
 
 function zahyoget(){
 	
 	$this->loadModel('FigureLatlngPosition');
 	
 	// ①HTMLの表示はいらないため自動レンダリングをOFFにする
 	$this->autoRender = false;
 	// レスポンスの形式をJSONで指定
 	$this->response->type('application/json');
 	
 	// POSTデータの取得
 	$figereId = $this->request->data('figereId');

 	$figereId = 1;
 	
 	$conditions = array('conditions' => array('FigureLatlngPosition.figure_id'=>$figereId));
 	
 	
 	$geomData=$this->FigureLatlngPosition->find('first',$conditions);

 	// モデル名があるとJavaScriptで扱いづらいので消す
 	$FigureLatlngPosition = $geomData['FigureLatlngPosition'];
 	
// 	$this->response->body(print_r($geomData,true));
 	
// 	echo($this->getDataSource()->getLog());
 	
 	$this->log(json_encode($geomData));
 	
// 	$this->response->body(json_encode(array("test" => "tt")));

 	// バイナリデータはJSONエンコードできないよだから消す
 	unset($FigureLatlngPosition['latlng']);
 	
// 	$this->response->body(print_r(compact('geomData'),true));
 	$this->response->body(json_encode($FigureLatlngPosition));
 	
 }
 
 function initData(){
 	
 	$this->loadModel('FigurePerson');
 	
 	// ①HTMLの表示はいらないため自動レンダリングをOFFにする
 	$this->autoRender = false;
 	// レスポンスの形式をJSONで指定
 	$this->response->type('application/json');
 	
 	// 	$figurePersonId = $this->request->data('figurePersonId');
 	
 	// 	$figurePersonId = 1;
 	
 	// 	$conditions = array('conditions' => array('FigureLatlngPosition.figure_id'=>$figereId));
 	
 	$figurePersonData=$this->FigurePerson->find('all');
 	
 	$this->log(json_encode($figurePersonData));
 	
// 	$this->response->body(json_encode($figurePerson));
 	$this->response->body(json_encode($figurePersonData));
 	
 }
 
 
}

