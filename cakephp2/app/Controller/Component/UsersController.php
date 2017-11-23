<?php
App::uses('Operator', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');


class UsersController extends AppController{
 //使用モデルの指定（省略可）
 public $uses = array('User');

 
 function beforeFilter(){
 //親クラスのbeforeFilterの読み込み
 parent::beforeFilter();
 //認証不要のページの指定
 $this->Auth->allow('login', 'logout','add','index');
 
 }
 //indexアクション（認証が必要なページ）
 function index(){
 //アクセス情報をビューに渡す
 $this->set('userinfo',$this->user);
 $this->set('cname',$this->name);
 $this->set('aname',$this->action);
 
 $this->set('roledata',print_r($this->roledata,true));
 
 
 }
 //ログインアクション（認証が不要なページ）
 function login(){
 //POST送信なら
 if($this->request->is('post')) {
 	
 	debug($this->request->data['User']['password']);
 	debug($this->request->data['User']['password']);
 	
 //ログインOKなら
 if($this->Auth->login()) {
 //Auth指定のログインページへ移動
 return $this->redirect($this->Auth->redirect());
 } else { //ログインNGなら
 $this->Session->setFlash(__('ユーザ名かパスワードが違います'), 'default', array(), 'auth');
 }
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
// 	$passwordHasher = new BlowfishPasswordHasher();
 	
 	debug($this->request->data['User']['password']);
 	
 	
// $this->request->data['User']['password'] = $passwordHasher->hash($this->request->data['User']['password']);
 	
 $this->request->data['User']['role'] = 'test';
 //ユーザーの作成
 $this->User->create();
 //リクエストデータを保存できたら
 if ($this->User->save($this->request->data)) {
 $this->Session->setFlash(__('新規ユーザーを追加しました'));
 $this->redirect(array('action' => 'index'));
 } else { //保存できなかったら
 $this->Session->setFlash(__('登録できませんでした。やり直して下さい'));
 }
 
 }
 }
 
 function ac1(){
 	
 }

 function ac2(){
 
 }

 function ac3(){
 
 }

 function ac4(){
 
 }
 
 function ac5(){
 
 }

}

