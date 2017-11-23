<?php
App::uses('Operator', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

// 読み込み
App::uses('AppAccountController', 'Controller');

class AccountsController extends AppAccountController{
 public $uses = array('Account','TheEarth','YuiUser','MstSubcommittee');
 
 function beforeFilter(){
 //親クラスのbeforeFilterの読み込み
 parent::beforeFilter();
 //認証不要のページの指定
 $this->Auth->allow('index','login');
 
 }
 //indexアクション（認証が必要なページ）
 function index(){
 //アクセス情報をビューに渡す
 $this->set('userinfo',$this->user);
 
 $this->set('id',$this->Auth->user('id'));
 $this->set('cname',$this->name);
 $this->set('aname',$this->action);
 
 $this->set('roledata',print_r($this->roledata,true));
 
 
 }
 //ログインアクション
 function login(){
 	
 $this->Auth->logout();
 
 // ログイン時にユーザーの場合はパーソンモードに変更
 $User = $this->Components->load('User');
 
 $User->setUserMode(UserComponent::USER_MODE_PERSON);
 
 //POST送信なら
 if($this->request->is('post')) {
 	
// 	echo("password=" . $this->request["data"]["Account"]["password"]."<br>");
 	
// 	echo("password=" . AuthComponent::password($this->request["data"]["Account"]["password"]));
 	
// 	var_dump($this->request);
 
// 	echo("Auth->login<br>");
// 	var_dump($this->Auth->login());
// 	echo("Auth->login<br>");
 	
 //ログインOKなら
 if($this->Auth->login()) {
 	
 	$saveUser = $this->YuiUser->find('first', array('conditions' => array('YuiUser.account_id' => $this->Auth->user('id'))));

 	// 画面表示用にセッションに保存
 	$this->Session->write('yui_user_id',$saveUser['YuiUser']['id']);
 	$this->Session->write('the_earth_id',$saveUser['YuiUser']['the_earth_id']);
 	$this->Session->write('entry_sei',$saveUser['YuiUser']['entry_sei']);
 	$this->Session->write('entry_mei',$saveUser['YuiUser']['entry_mei']);
 	$this->Session->write('email',$saveUser['YuiUser']['entry_mail']);
 	$this->Session->write('phone',$saveUser['YuiUser']['entry_tel']);

 	$theEarth = $this->TheEarth->find('first', array('conditions' => array('TheEarth.id' => $saveUser['YuiUser']['the_earth_rec_id'])));
 	
 	$this->TheEarth->login2($theEarth['TheEarth']['login_id'],$theEarth['TheEarth']['md5_pass']);

 	$dataTheEarthWrk = $this->TheEarth->getUserData();
 	
 	$dataTheEarth = $dataTheEarthWrk["user"];
 	
 	$this->saveTheEarthData(null,null,null,$dataTheEarth,$dataTheEarthWrk,$saveUser['YuiUser']['the_earth_rec_id']);
 	
 	$MstSubcommitteeList = $this->MstSubcommittee->find( 'list', array('fields' => array( 'id', 'name')));
 	
 	echo("<br><br>");
 	var_dump($MstSubcommitteeList);
 	
	echo("<br><br>");
 	echo($MstSubcommitteeList[1]);
 	echo("<br><br>");
 	
	echo("<br><br>");
 	echo($MstSubcommitteeList[$saveUser['YuiUser']['entry_study_group']]);
 	echo("<br><br>");
 	
 	if($saveUser['YuiUser']['entry_study_group'] != null){
 		
 		$this->Session->write('entry_study_group_name',$MstSubcommitteeList[$saveUser['YuiUser']['entry_study_group']]);
 		
 	}
 	else {

 		$this->Session->write('entry_study_group_name',"");
 			
 	}
 	
 	echo($this->Session->read('entry_study_group_name') . "<br>");
 	
// 	echo('the_earth_id=' . $this->Session->read('the_earth_id'));
// 	echo('the_earth_id=' . $this->Session->read('entry_sei'));
//	echo('the_earth_id=' . $this->Session->read('entry_mei'));
//	echo('the_earth_id=' . $this->Session->read('email'));
//	echo('the_earth_id=' . $this->Session->read('phone'));
 	
 	return $this->redirect(array('action' => 'menu'));
 } else { //ログインNGなら
 	
// 	echo("password=" . AuthComponent::password($this->request["data"]["Account"]["password"]) ."<br>");
 	
// 	echo("test2<br>");
 	// $this->Session->setFlash(__('ユーザ名かパスワードが違います'), 'default', array(), 'auth');
// 	$id = var_dump($this->request["data"]);
 	
 	$countAccount=$this->Account->find('count', array(
 			'conditions' => array('Account.username' => $this->request["data"]["Account"]["username"])
 	));
 	
 	if($countAccount > 0){
 		$this->Session->setFlash('ログインID又はパスワードが違います1','default', array(), 'LOGIN_ERR_MSG');
		return $this->redirect(array('action' => 'index'));
 	}

 	
 	$id = $this->request["data"]["Account"]["username"]; // メールアドレス
	// MD5
 	$pass = $this->request["data"]["Account"]["password"];
 	
 	var_dump($this->request["data"]["Account"]);
 	
 	
 	
 	// ログインロジックへ移動 パスワードはMD5化する
 	if($this->TheEarth->login2($id,md5($pass))===false){
 		$this->Session->setFlash('ログインID又はパスワードが違います2','default', array(), 'LOGIN_ERR_MSG');
 		return $this->redirect(array('action' => 'index'));
 	}

 	$dataTheEarthWrk = $this->TheEarth->getUserData();
 	
 	$dataTheEarth = $dataTheEarthWrk["user"];
 	
 	$saveAccount['username']  = $id;
 	$saveAccount['password']  = $pass;
 	
 	if ($this->Account->save($saveAccount)) {
 	
 	}
 	
 	$account_id = $this->Account->getLastInsertID();
 	
 	
 	$save = array();

 	$the_earth_rec_id = $this->saveTheEarthData($id,$pass,$account_id,$dataTheEarth,$dataTheEarthWrk);

/* 	$save['te_id'] = $dataTheEarth['id'];
// 	$save['the_earth_id'] = "123";
 	$save['md5_pass'] = md5($pass);
 	$save['login_id'] = $id;
 	$save['account_id'] = $account_id;
 	$save['name'] = $dataTheEarth['name'];
 	$save['yomi'] = $dataTheEarth['yomi'];
 	$save['nickname'] = $dataTheEarth['nickname'];
 	$save['phone'] = $dataTheEarth['phone'];
 	$save['email'] = $dataTheEarth['email'];
 	$save['io'] = $dataTheEarth['io'];
 	$save['cname'] = $dataTheEarth['cname'];
 	$save['cyomi'] = $dataTheEarth['cyomi'];
 	$save['introducer'] = $dataTheEarth['introducer'];
 	$save['agent'] = $dataTheEarth['agent'];
 	$save['usetype'] = $dataTheEarth['usetype'];
 	$save['section'] = $dataTheEarth['section'];
 	
 	$save['status'] = $dataTheEarthWrk['status'];
 	
 	if(array_key_exists("message", $dataTheEarthWrk) == true) {
 		$save['message'] = $dataTheEarthWrk["message"];
 	}
 	else {
 		$save['message'] = "";
 	}
 
 	$this->TheEarth->save($save); */
 	
 	var_dump($dataTheEarth);

 	$saveUser['account_id'] = $account_id;
 	$saveUser['the_earth_id'] = $dataTheEarth['id'];
 	$saveUser['the_earth_rec_id'] = $the_earth_rec_id;
 	
 	echo("<br>test01<br>");
 	if(strpos($dataTheEarth['name']," ")===false){
 		echo("<br>test02<br>");
 		$saveUser['entry_sei'] = $dataTheEarth['name'];
 		$saveUser['entry_mei'] = "";
 	}
 	else {
 		echo("<br>test03<br>");
 			
 		$arName = explode(" ",$dataTheEarth['name']);
 		
 		if(count($arName) > 2){
 			echo("<br>test04<br>");
 			$saveUser['entry_sei'] = $dataTheEarth['name'];
 			$saveUser['entry_mei'] = "";
 		}
 		else {
 			echo("<br>test05<br>");
 			$saveUser['entry_sei'] = $arName[0];
 			$saveUser['entry_mei'] = $arName[1];
 		}
 			
 	}
 	
 	if(strpos($dataTheEarth['yomi']," ")===false){
 		
		 	$saveUser['entry_sei_kana'] = $dataTheEarth['yomi'];
			$saveUser['entry_mei_kana'] = "";
 
 	}
 	else {
 	
 		$arYomi = explode(" ",$dataTheEarth['yomi']);
 		
 		if(count($arName) > 2){
		 	$saveUser['entry_sei_kana'] = $dataTheEarth['yomi'];
			$saveUser['entry_mei_kana'];
 		}
 		else {
		 	$saveUser['entry_sei_kana'] = $arYomi[0];
			$saveUser['entry_mei_kana'] = $arYomi[1];
 		}
 	
 	}
	
	$saveUser['entry_mail'] = $dataTheEarth['email'];
 	$saveUser['entry_tel'] = $dataTheEarth['phone'];

 	var_dump($saveUser);
 	
 	$this->YuiUser->save($saveUser);
 	
 	$yui_user_id = $this->YuiUser->getLastInsertID();
 	
 	$this->Session->write('yui_user_id',$yui_user_id);
 	// 画面表示用にセッションに保存
 	$this->Session->write('the_earth_id',$saveUser['the_earth_id']);
 	$this->Session->write('entry_sei',$saveUser['entry_sei']);
 	$this->Session->write('entry_mei',$saveUser['entry_mei']);
 	$this->Session->write('email',$saveUser['entry_mail']);
 	$this->Session->write('phone',$saveUser['entry_tel']);
 	
 	
 	
 	// テーブルをリンクするためthe_earth_idを入れる
// 	$this->request->data['Account']['the_earth_id'] = $this->TheEarth->id;
 	

 	
 }
 $this->Auth->login();
 return $this->redirect(array('action' => 'menu'));
 } 
 
 }
 //ログアウトアクション（認証が不要なページ）
 function logout(){
 $this->Auth->logout();
 }
 //ユーザー追加（認証が不要なページ）
 function add(){
 //POST送信なら
 if($this->request->is('post')) {
 //パスワードのハッシュ値変換
// $this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
 	$passwordHasher = new BlowfishPasswordHasher();
 	
 	debug($this->request->data['Account']['password']);
 	
 	
 $this->request->data['User']['password'] = $passwordHasher->hash($this->request->data['User']['password']);
 	
 $this->request->data['Account']['role'] = 'test';
 //ユーザーの作成
 $this->Account->create();
 //リクエストデータを保存できたら
 if ($this->Account->save($this->request->data)) {
 $this->Session->setFlash(__('新規ユーザーを追加しました'));
 $this->redirect(array('action' => 'index'));
 } else { //保存できなかったら
 $this->Session->setFlash(__('登録できませんでした。やり直して下さい'));
 }
 
 }
 }
 
 function menu(){
 	
 	$saveUser = $this->YuiUser->find('first', array('conditions' => array('YuiUser.id' => $this->Session->read('yui_user_id'))));
// 	var_dump($saveUser);
 	
 	if($saveUser["YuiUser"]["mode"] == null){
 		$this->set('registration','0');
 	}
 	else {
 		$this->set('registration','1');
 	}
 	
 	
 	

 }
 
 function test() {

 	$id = 'fujikenmmpt@gmail.com';
// 	$id = 'fujikenmmptxxx@gmail.com';
 	$pass = md5('tandps');
 	
 	echo("<br><br>");
 	echo($pass);
 	echo("<br><br>");
 	
 	
 	
 	$this->TheEarth->login2($id,$pass);
 	
 	$dataTheEarthWrk = $this->TheEarth->getUserData();
 	
 	var_dump($dataTheEarthWrk);
 }
 
 function saveTheEarthData($id,$pass,$account_id,$dataTheEarth,$dataTheEarthWrk,$seqId=null){
 	$save = array();
 	
 	if($seqId != null){
 		$save['id'] = $seqId;
	}
 	
 	$save['te_id'] = $dataTheEarth['id'];
 	// 	$save['the_earth_id'] = "123";
 	if($pass != null){
 		$save['md5_pass'] = md5($pass);
 	}
 	if($id != null){
 		$save['login_id'] = $id;
 	}
 	if($account_id != null){
 		$save['account_id'] = $account_id;
 	}
 	$save['name'] = $dataTheEarth['name'];
 	$save['yomi'] = $dataTheEarth['yomi'];
 	$save['nickname'] = $dataTheEarth['nickname'];
 	$save['phone'] = $dataTheEarth['phone'];
 	$save['email'] = $dataTheEarth['email'];
 	$save['io'] = $dataTheEarth['io'];
 	$save['cname'] = $dataTheEarth['cname'];
 	$save['cyomi'] = $dataTheEarth['cyomi'];
 	$save['introducer'] = $dataTheEarth['introducer'];
 	$save['agent'] = $dataTheEarth['agent'];
 	$save['usetype'] = $dataTheEarth['usetype'];
 	$save['section'] = $dataTheEarth['section'];
 	
 	$save['status'] = $dataTheEarthWrk['status'];
 	
 	if(array_key_exists("message", $dataTheEarthWrk) == true) {
 		$save['message'] = $dataTheEarthWrk["message"];
 	}
 	else {
 		$save['message'] = "";
 	}
 	
 	$this->TheEarth->save($save);
 	
 	if($seqId == null){ 	
 		$the_earth_rec_id = $this->TheEarth->getLastInsertID();
 		return $the_earth_rec_id;
 	}
 	else {
 		return null;
 	}
 	
 	
 }
 
}

