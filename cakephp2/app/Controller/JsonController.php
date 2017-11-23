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
 	
// 	$figereId = mt_rand(1,1000);

 	$figereId = mt_rand(1,1000);
 	
 //	$latitude = $this->request->data['latitude'];
 //	$longitude = $this->request->data['longitude'];
 
 	$latitude = mt_rand(0.01,1.00);
 	$longitude = mt_rand(0.01,1.00);

// 	var_dump($this->FigureLatlngPosition);
 	
 	$conditions = array('status'=>'1');
 	
 	if($this->FigureLatlngPosition->hasAny($conditions) == true){
 		$this->FigureLatlngPosition->add2($figereId,$latitude,$longitude);
 	}
 	else {
 		$this->FigureLatlngPosition->update($figereId,$latitude,$longitude);
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
 	
 	
 	$data = "{$latitude}lt、{$longitude}gt です";
 	$this->response->body(json_encode(compact('data')));
 	
 }
 
}

