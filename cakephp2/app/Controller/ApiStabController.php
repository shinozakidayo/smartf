<?php

// 読み込み
App::uses('AppApiController', 'Controller');

class ApiStabController extends AppApiController {

	function beforeFilter(){
		//親クラスのbeforeFilterの読み込み
		parent::beforeFilter();
	
	}
	function test(){
	}
	
	function login(){
		$this->autoRender = false;
		
		if(array_key_exists('email',$this->request->data)){
			$this->log("email=" . $this->request->data['email'], LOG_DEBUG);
		}
		else {
			$this->log("email=null", LOG_DEBUG);
		}
		

		if(array_key_exists('password',$this->request->data)){
			$this->log("password=" . $this->request->data['password'], LOG_DEBUG);
		}
		else {
			$this->log("password=null", LOG_DEBUG);
		}
		
		
		$status = "ok";
		
		$login = 
				array(
					"user_id"=>1,
					"token"=>"token_test",
					"refresh"=>"refresh_test"
				);

		return json_encode(compact('status', 'login', 'error'));
	}
	
	
	public function view() {
		// 今回はJSONのみを返すためViewのレンダーを無効化
		$this->autoRender = false;
		
		if(array_key_exists('token',$this->request->data)){
			$this->log("view=" . $this->request->data['token'], LOG_DEBUG);
		}
		else {
			$this->log("view=null", LOG_DEBUG);
		}
		
		// Ajax以外の通信の場合
/*		if(!$this->request->is('ajax')) {
			throw new BadRequestException();
		} */
		/*  ここでDBアクセスなど何かの処理をする */
		
		$status = "ok";
		
		$user = array(
					"id"=>"200016",
					"name"=>"てすと 太朗",
					"yomi"=>"テスト タロウ",
					"nickname"=>"てすと たろう",
					"phone"=>"999-0136-8412",
					"email"=>"test@gmail.com",
					"io"=>1,
					"cname"=>"株式会社ディーフォレスト",
					"cyomi"=>"カブシキガイシャディーフォレスト",
					"introducer"=>200040,
					"agent"=>1,
					"usetype"=>2,
					"section"=>3
				);
		
		// 値が入っているかを確認。
		// 値によっては(bool)でキャストしてしまうのも可
//		$status = !empty($result);
		if(!$status) {
			$error = array(
					'message' => 'データがありません',
					'code' => 404
			);
		}
		// JSON形式で返却。errorが定義されていない場合はstatusとresultの配列になる。
		return json_encode(compact('status', 'user', 'error'));
	}
	
	public function refresh(){
		// JSON形式で返却。errorが定義されていない場合はstatusとresultの配列になる。
		return json_encode(compact('status', 'result', 'error'));
	}
	
	public function inf() {
		
		// 今回はJSONのみを返すためViewのレンダーを無効化
		$this->autoRender = false;
		
		return Inflector::pluralize('earth');
		
	}
		
	
}
