<?php

// 読み込み
App::uses('Operator', 'Model');
App::uses('AppAccountController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('CakeEmail','Network/Email');

class SignupController extends AppAccountController {
	
	public $helpers = array('Html','Form', 'Session');
	public $name = 'Signup';
	public $uses = array('YuiUser','MstArea','MstAgencyType','Account','TheEarth','Head','MstCorporationType','MstHead','MstPrefecture','Image','Contact','MstSubcommittee');

//	var $components = array('MailSend');
			
	
	public function isAuthorized($user) {
		return true;
		
		if ($this->action === 'index') {
			return true;
		}
		
		return parent::isAuthorized($user);
	}
	
	public function beforeFilter() {
		parent::beforeFilter();
//		$this->Auth->allow('*'); // このController全て認証不要

		//認証不要のページの指定
		$this->Auth->allow('index','login');
		
//		$this->Security->blackHoleCallback = 'blackhole';
	}
	
	

	public function index(){
		
		if(!$this->request->data){
			$this->render();
			return;
		}

		//入力データをセット
		$this->YuiUser->set($this->request->data);

		//入力内容を検査
		if($this->YuiUser->validates()){

			//モデルの状態をリセット
			$this->YuiUser->create();

			//入力済みデータをモデルにセット
			$user = array('YuiUser' => $this->request->data['YuiUser']);

			//データを保存
			$this->YuiUser->save($user);

			//サンクス画面を表示
			$this->render('thanks');

		}

	}
	
	public function menu(){
		
	}
	
	
	public function table(){
		
		$the_earth_id = $this->Session->read('the_earth_id');
		$entry_sei = $this->Session->read('entry_sei');
		$entry_mei = $this->Session->read('entry_mei');
		$email = $this->Session->read('email');
		$phone = $this->Session->read('phone');
		
		
		$Email = new CakeEmail();
		
$text = <<<EOT
○○様

このたびは、国際取引総合戦略研究所◯◯研究部会の
活動代理店都道府県本部へお申し込みをいただき、
誠にありがとうございます。

以下のとおりお申し込みをお受けしました。

活動代理店の登録費用については、申込日より５日以内に入金のうえ、
下記URLの入金通知フォームよりご連絡をお願いいたします。
登録費用の入金が確認され次第、登録審査を開始いたします。
http://miyamoto-international-law.com/index.php?form-credit-advice

【払込取扱場所】
　金融機関名：みずほ銀行
　支店名：駒沢支店（店番号544）
　口座番号：普通　1059096
　名義人：宮本外国法事務弁護士事務所 宮本敏和


当研究部会の代理店登録が完了いたしましたら、ご連絡いたします。


今後とも国際取引総合戦略研究所をよろしくお願い申し上げます。


----------お申込内容----------

入力内容を記載


----------------------------------
○○様が同意した規約は以下のとおりとなります。
----------------------------------

活動代理店都道府県本部規約
活動代理店都道府県本部取扱商品・サービス目録
活動代理店都道府県本部募集要項


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールは配信専用です。本Eメールアドレスに返信はできません。
※電話によるお問い合せは受け付けていません。
　お問い合わせは下記の【お問い合わせフォーム】よりご連絡ください。
（お問合せ先）：http://miyamoto-international-law.com/index.php?contactus
※本Eメールの無断転載・転用はご遠慮ください。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールの内容にお心当たりのない場合は、お手数ですが、
http://miyamoto-international-law.com/index.php?contactus　までご連絡ください。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

宮本外国法事務弁護士事務所
国際取引総合戦略研究所
◯◯研究部会
http://miyamoto-international-law.com/

EOT;
		
		$Email->from(array('shinozakidayo@nifty.com' => 'My Site'))
		->to('shinozakidayo@nifty.com')
		->subject('活動代理店都道府県本部の登録申し込み確認について')
		->send($text);
		
	}
	
	public function mailTest(){
		$MailSend = $this->Components->load('MailSend');
		
		$MailSend->agency_honbu();
		
	}
	
	
	public function table2(){
	
	}

	public function pref(){
		
		$this->Session->write(self::SESSION_CNAME_MODE,self::MODE_SUB);
		
		$mstPrefecture = $this->MstPrefecture->find('all');
		
		$this->set('mstPrefecture',$mstPrefecture);
		
		
		
		$this->render('pref2');
		
		
	}
	

	public function sample(){
	
	}

	public function target(){
		$pass =$this->params['pass'][0];
		
		$head = $this->Head->find('all',
				array('conditions' => array('Head.mst_head_id' => $pass)
		));
		
		// var_dump($head);
		$this->set('head',$head);
		
	}

	public function honbu(){
		
		$this->Session->write(self::SESSION_CNAME_MODE,self::MODE_HEAD);
		
		/*		var_dump($this->request->data);
		 var_dump($this->data);
		 var_dump($this->params['data']);
		 var_dump($this->params['form']);
		 var_dump($_POST['agencyselect']); */
		
		$this->Session->write('entry_study_group',$this->data['corporation_type']);
		
		if(array_key_exists(self::SESSION_CNAME_MODE, $this->data) && $this->data[self::SESSION_CNAME_MODE] != $this->action){
			return $this->redirect(array('action' => $this->data[self::SESSION_CNAME_MODE]));
		}
		
		
		$mstHead = $this->MstHead->find('all');
		
		//		var_dump($mstHead);
		
		
		
		//		$findList = $this->User->find('list', $params);
		
		$fields = array(
				'Head.level4',
		);
		
		
		/*		$conditions = array('Head');
		 $params = array(
		 'conditions' => $conditions,
		 'fields' => $fields,
		 ); */
		
		$head = $this->Head->find('list');
		
		
		foreach($mstHead as $mstHeadKey => $mstHeadVal){
		
		}
		
		$yuiUserList=$this->YuiUser->find('list',array('fields' => array('YuiUser.mst_head_id','YuiUser.id')));
		
		var_dump($yuiUserList);
		
		// var_dump($head);
		$this->set('head',$head);
		$this->set('mstHead',$mstHead);
		$this->set('yuiUserList',$yuiUserList);
		
		
		$this->render('honbu2');
		
	}
	
	
	public function honbu2(){
	
	
		/*		var_dump($this->request->data);
			var_dump($this->data);
			var_dump($this->params['data']);
			var_dump($this->params['form']);
			var_dump($_POST['agencyselect']); */
	
	
	
		$this->Session->write('entry_study_group',$this->data['corporation_type']);
	
		if(array_key_exists(self::SESSION_CNAME_MODE, $this->data) && $this->data[self::SESSION_CNAME_MODE] != $this->action){
			return $this->redirect(array('action' => $this->data[self::SESSION_CNAME_MODE]));
		}
	
		
		$mstHead = $this->MstHead->find('all');
		
//		var_dump($mstHead);


		
//		$findList = $this->User->find('list', $params);
		
		$fields = array(
				'Head.level4',
		);
		
		
/*		$conditions = array('Head');
		$params = array(
				'conditions' => $conditions,
				'fields' => $fields,
		); */
		
		$head = $this->Head->find('list');
		

		foreach($mstHead as $mstHeadKey => $mstHeadVal){
				
		}
		
		// var_dump($head);
		$this->set('head',$head);
		$this->set('mstHead',$mstHead);
	}
	
	
	public function end(){
	
	}
	
	public function agency(){
		
//		var_dump($this->params['pass']);
		
		$this->Session->write('entry_study_group',$this->params['pass']);
		
//		$this->set('agency_type',$this->MstAgencyType->find("list"));

		$this->set('corporation_type',$this->MstCorporationType->find("list"));
		
		$this->set('agency_type',$this->MstAgencyType->find("list"));
	}
	
	public function Area($id=null){
		$this->Session->write('mst_prefecture_id',$this->params['pass']);
		
		$yuiUserList=$this->YuiUser->find('list',array('fields' => array('YuiUser.mst_area_id','YuiUser.id')));
		
		var_dump($yuiUserList);
		
		// var_dump($head);
		$this->set('yuiUserList',$yuiUserList);
		
		
		$this->set('area',$this->MstArea->findAllByProvinceCd($id));		
	}
	

	public function blackhole($type) {

		$this->Session->setFlash('不正なリクエストが行われました');
		$this->redirect(array('controller' => 'signup', 'action' => $this->action));

	}
	
	public function subcommittee() {
		//POST送信なら
		if($this->request->is('post')) {
			$this->fileUpload('iconf1',3);

			$this->render('subcommitteeend');
				
		}
		
	}
	
	public function contact() {
		//POST送信なら
		if($this->request->is('post')) {
            //モデルの状態をリセット
            $this->Contact->create();
            
            $contact = $this->request->data["Contact"]; 
            
            $this->Contact->save($contact);
            
			$this->render('contacteend');
			
			
			$MailSend = $this->Components->load('MailSend');
			
			$MailSend->contact();
			
			$MailSend->contactNotice($this->request->data["Contact"]["title"],$this->request->data["Contact"]["main_txt"]);
			
				
		}
		
	}

	public function update() {
	
	}

	public function researchgroup() {
	
	}
	
	public function kouzaimage() {

		echo(self::SESSION_CNAME_ID . "=". $this->Session->read(self::SESSION_CNAME_ID));
		
		echo(self::SESSION_CNAME_MODE . "=". $this->Session->read(self::SESSION_CNAME_MODE));
		
		
		//POST送信なら
		if($this->request->is('post')) {
		
			// POST配列を移植
			$param = $this->request->data["YuiUser"];
			
			$param['id'] = $this->Session->read('yui_user_id');
			
			switch($this->Session->read(self::SESSION_CNAME_MODE)) {
				case self::MODE_HEAD:
					// 最後の画面から渡されたIDが本部のID
					$param['mst_head_id'] = $this->Session->read(self::SESSION_CNAME_ID);
					break;
				case self::MODE_SUB:
					// 最後の画面から渡されたIDが支部のID
					$param['mst_area_id'] = $this->Session->read(self::SESSION_CNAME_ID);
					break;
				case self::MODE_INT:
					break;
			}
			
			$param['mode'] = $this->Session->read(self::SESSION_CNAME_MODE);

//			var_dump($param);

			if($this->Session->read('entry_study_group')==true){
				
				$param['entry_study_group'] = $this->Session->read('entry_study_group');
					
				$MstSubcommitteeList = $this->MstSubcommittee->find( 'list', array('fields' => array( 'id', 'name')));
				
				$this->Session->write('entry_study_group_name',$MstSubcommitteeList[$param['entry_study_group']]);
				
			}
			
			$this->YuiUser->save($param);
			
			$this->request->data["YuiUser"]["introducer_no"];
			$this->request->data["YuiUser"]["introducer_sei"];
			$this->request->data["YuiUser"]["introducer_mei"];
			$this->request->data["YuiUser"]["zip_code1"];
			$this->request->data["YuiUser"]["zip_code2"];
			$this->request->data["YuiUser"]["prefectures_name"];
			$this->request->data["YuiUser"]["city_name"];
			$this->request->data["YuiUser"]["street_address"];
			$this->request->data["YuiUser"]["bank_code"];
			$this->request->data["YuiUser"]["bank_account_type"];
			$this->request->data["YuiUser"]["bank_branch_no"];
			$this->request->data["YuiUser"]["bank_account_no"];
			$this->request->data["YuiUser"]["bank_account_name"];
			$this->request->data["YuiUser"]["bank_account_name_kana"];
		
			
			
//			$param = $this->request->data;
//			$param['id'] = $this->Session->read('yui_user_id');
				
			$this->YuiUser->set($this->request->data);
				
			
			$this->Session->setFlash('画像をアップロードしました。');
			
			$this->fileUpload('iconf1',1);
			
			$this->fileUpload('iconf2',2);
			
			$MailSend = $this->Components->load('MailSend');
			
			
			switch($this->Session->read(self::SESSION_CNAME_MODE)) {
				case self::MODE_HEAD:
					
					$Common = $this->Components->load('Common');
					
					$InputText = $Common->makeInputText($this->request->data);
					
					$MailSend->agency_honbu($InputText);
					
					// 最後の画面から渡されたIDが本部のID
					$MailSend->agency_honbu();
					break;
				case self::MODE_SUB:

					$Common = $this->Components->load('Common');
						
					$InputText = $Common->makeInputText($this->request->data);
						
					
					// 最後の画面から渡されたIDが支部のID
					$MailSend->agency_area($Common);
					break;
				case self::MODE_INT:
					break;
			}
			
			
			return $this->redirect(array('controller'=>'accounts','action' => 'menu'));
 				
		}
		else {

			// とりあえずPOSTされない前提
			// どうやら直接画面にきたみたいだし、代理店紹介者だね
			if(array_key_exists(0,$this->params['pass'])== false){
				$this->Session->write(self::SESSION_CNAME_MODE,self::MODE_INT);
				$this->Session->write(self::SESSION_CNAME_ID,null);
			}
			
			// ここが前の画面から渡された情報を保存
			if(array_key_exists(0,$this->params['pass'])== true){
				$this->Session->write(self::SESSION_CNAME_ID,$this->params['pass'][0]);
			}
			
		}
		
		$mstPrefecture = $this->MstPrefecture->find('all');
		
		$this->set( 'mstPrefecture', $this->MstPrefecture->find( 'list', array(
				'fields' => array( 'name', 'name')
		)));
		
		
//		$this->set('mstPrefecture',$mstPrefecture);
		
	}
	
	public function contents() {
		$this->layout = false;
		
//echo($filename);
		
		$image = $this->Image->findByFilename($this->params['pass']);
		header('Content-type: ' . $image['Image']['filetype'] );
		echo $image['Image']['contents'];
		
//		var_dump($image);
		
/*		if (empty($image)) {
			$this->cakeError('error404');
		}
		header('Content-type: ' . $image['Image']['filetype'] );
		echo $image['Image']['contents']; */
	}
	
	private function fileUpload($fname,$imageType){

			// $_FILES['upfile']['error'] の値を確認
		switch ($this->data['YuiUser'][$fname]['error']) {
			case UPLOAD_ERR_OK: // OK
				break;
			case UPLOAD_ERR_NO_FILE:   // ファイル未選択
				$this->Session->setFlash('ファイルが選択されていません。');
				$this->redirect(array('action' => 'kouzaimage'));
			case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
				$this->Session->setFlash('10MB以内の画像が登録可能です。');
				$this->redirect(array('action' => 'kouzaimage'));
			case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過 (設定した場合のみ)
				$this->Session->setFlash('10MB以内の画像が登録可能です。');
				$this->redirect(array('action' => 'kouzaimage'));
			default:
				$this->Session->setFlash('ファイルに異常があります。');
				$this->redirect(array('action' => 'kouzaimage'));
		}
		
		$limit = 1024 * 1024*10;
//		var_dump($this->data);
			
		// 画像の容量チェック
		if ($this->data['YuiUser'][$fname]['size'] > $limit){
			$this->Session->setFlash('10MB以内の画像が登録可能です。');
			$this->redirect(array('action' => 'kouzaimage'));
		}
		// アップロードされた画像か
		if (!is_uploaded_file($this->data['YuiUser'][$fname]['tmp_name'])){
			$this->Session->setFlash('アップロードされた画像ではありません。');
			$this->redirect(array('action' => 'kouzaimage'));
		}
			
		$name = explode('.', $this->data['YuiUser'][$fname]['name']);
			
		$extension = end($name);
		
/*		if($fname == 'iconf1'){
			$imageType = 1;
		} else {
			$imageType = 2;
		} */
		// 保存
		$image = array(
				'Image' => array(
						'filename' => md5(microtime()) . '.' . $extension,
//						'yui_user_id' => $this->Auth->user('id'),
						'yui_user_id' => $this->Session->read('yui_user_id'),
						'image_type' => $imageType,
						'contents'      => file_get_contents($this->data['YuiUser'][$fname]['tmp_name']),
						'moto_filename' => $this->data['YuiUser'][$fname]['name'],
						'filetype'      => $this->data['YuiUser'][$fname]['type'],
						'filesize'      => $this->data['YuiUser'][$fname]['size'],
				)
		);
		$this->Image->create();
		$this->Image->save($image);

	}
	
	function detail() {
		 
		$id = $this->Session->read('yui_user_id');
	
		//POST送信なら
		if($this->request->is('put')) {
			 
			// POST配列を移植
			$param = $this->request->data["YuiUser"];
			 
			$param['id'] = $id;
			 
			$this->YuiUser->save($param);
			 
			/*			$this->request->data["YuiUser"]["introducer_no"];
			 $this->request->data["YuiUser"]["introducer_sei"];
			 $this->request->data["YuiUser"]["introducer_mei"];
			 $this->request->data["YuiUser"]["zip_code1"];
			 $this->request->data["YuiUser"]["zip_code2"];
			 $this->request->data["YuiUser"]["prefectures_name"];
			 $this->request->data["YuiUser"]["city_name"];
			 $this->request->data["YuiUser"]["street_address"];
			 $this->request->data["YuiUser"]["bank_code"];
			 $this->request->data["YuiUser"]["bank_account_type"];
			 $this->request->data["YuiUser"]["bank_branch_no"];
			 $this->request->data["YuiUser"]["bank_account_no"];
			 $this->request->data["YuiUser"]["bank_account_name"];
			 $this->request->data["YuiUser"]["bank_account_name_kana"]; */
			 
			$this->YuiUser->set($this->request->data);
			 
			 
			$this->Session->setFlash('画像をアップロードしました。');
			 
//			$this->fileUpload('iconf1',1);
			 
//			$this->fileUpload('iconf2',2);
			 
		}
	
		 
	
		if($this->user['role'] == '' || $this->user['role'] == null){
			 
			$this->request->data=$this->YuiUser->findById($id);   //更新画面の表示
			 
		}
		else {
			 
			$this->request->data=$this->YuiUser->findByIdAndEntryStudyGroup($id,$this->user['role']);   //更新画面の表示
				
		}
	
		 
		$mstPrefecture = $this->MstPrefecture->find('all');
		 
		$this->set( 'mstPrefecture', $this->MstPrefecture->find( 'list', array(
				'fields' => array( 'name', 'name')
		)));
		 
		$this->set('id',$id);
		 
		$this->set('status_laboratory_shinsa',$this->request->data['YuiUser']['status_laboratory_shinsa']);
		 
		 
		$MstCorporationTypeList=$this->MstCorporationType->find("list");
		 
		$MstAgencyTypeList=$this->MstAgencyType->find("list");
	
		$MstAreatList=$this->MstArea->find("list");
		 
		$MstPrefectureList=$this->MstPrefecture->find("list");
		 
		$MstHeadList=$this->MstHead->find("list");
		 
	
		 
		if($this->request->data['YuiUser']['mst_head_id'] != null) {
	
			$this->set('disp_target',$MstHeadList[$this->request->data['YuiUser']['mst_head_id']]);
	
		} else if ($this->request->data['YuiUser']['mst_prefecture_id'] != null) {
	
			$this->set('disp_target',$MstPrefectureList[$this->request->data['YuiUser']['mst_prefecture_id']]);
	
		} else {
	
			$this->set('disp_target',"");
	
		}
//	xxxxx
//		$this->setSessionInfo($this->params['pass'][0]);
		//		$this->set('mstPrefecture',$mstPrefecture);
		 
	}
	
}
