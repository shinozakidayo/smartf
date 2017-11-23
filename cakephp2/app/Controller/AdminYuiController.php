<?php
App::uses('CakeEmail','Network/Email');


class AdminYuiController extends AppController {
    public $name = 'AdminYui';
    public $uses = array("YuiUser","MstPrefecture","Image","MstSubcommittee","MstCorporationType","MstAgencyType","MstArea","MstArea","MstPrefecture","MstHead","Upregist");
 //   public $helpers = array('Html', 'Form', 'Csv'); //CSVヘルパーを設定します
    
    
    public $paginate = array(
    		'YuiUser' => array(
    				'limit' =>10,						//1ページ表示できるデータ数の設定
    				'order' => array('id' => 'desc')
    		)
    );
    
    
    function beforeFilter(){
    	$this->layout = 'admin';
    	
    	// セッションキーの変更
    	AuthComponent::$sessionKey = "Auth.AdminUser";
    	
        parent::beforeFilter();
 
    }
 
    function detail() {
    	
    	$id = $this->params['pass'][0];
    	 
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
    	
    			
    		if($this->YuiUser->validates()){

    			$this->Session->setFlash('画像をアップロードしました。');

    			$this->fileUpload('iconf1',1);
    			 
    			$this->fileUpload('iconf2',2);
    			 
    		}
    	
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

    	$this->setSessionInfo($this->params['pass'][0]);
    	//		$this->set('mstPrefecture',$mstPrefecture);
    	
    	switch($this->request->data['YuiUser']['account_type']){
    		case 'pita':
    			$this->render('detail_pita');
    			break;
    		case 'kyosansp':
    			$this->render('detail_kyosan_sp');
    			break;
    		case 'kyosanco':
    			$this->render('detail_kyosan_co');
    			break;
    		case 'common':
    			$this->render('detail_common');
    			break;
    		default:
    			$this->render('detail_common');
    	}
    	 
    }
    
    function index(){
    	$this->set('userinfo',$this->user);
    	$this->set('cname',$this->name);
    	$this->set('aname',$this->action);
    	
    	$this->set('roledata',print_r($this->roledata,true));
    	 
        //データをPaginatorへセット
    	if($this->user['role'] == '' || $this->user['role'] == null){
    		// ロールが存在しない場合研究所
    		
        	$this->set('Users',$this->paginate());

    	}
    	else {
    		// ロールが存在する場合研究部会
    		
    		$condition = array();
    		$condition = array('entry_study_group' => $this->user['role']);
    		$this->set('Users',$this->paginate($condition));
    		
    	}
    }
    
    function status(){
    	$this->set('userinfo',$this->user);
    	$this->set('cname',$this->name);
    	$this->set('aname',$this->action);
    	 
    	$this->set('roledata',print_r($this->roledata,true));
    	
    	if($this->request->isPost() || $this->request->isPut()) {

    		if(!empty($this->data)) {

    			if(isset($this->request->data['csv_download'])) {

    				// CSV ダウンロード
    				$this->csvDownload();
    				
    				return;
    			}
    			else if(isset($this->request->data['csv_upload'])) {

    				// CSV アップロード
    				$this->csvUpload();

    				return;
    				
    			}
    			 
    		}
    		
    	}
    
//    	var_dump($this->request->data);
    	
    	$params = null;
    	if(!empty($this->request->data)) {
    		
    		var_dump($this->request->data);
    		
    		$params = $this->paramSelect($this->request->data["YuiUser"]);
    		
    		// 検索方法をセッションに保存
    		$this->Session->write('findparam',$this->request->data);
    	}
    	else {
    		if($this->Session->read('findparam')!=null){
    			
    			$this->request->data = $this->Session->read('findparam');
    			
    			$params = $this->paramSelect($this->request->data["YuiUser"]);
    			 
    		}
    	}
    	
    	
    	$param['id'] = $this->Session->read('yui_user_id');
    	 
            //データをPaginatorへセット
    	if($this->user['role'] != '' || $this->user['role'] != null){
    		// ロールが存在する場合研究部会
    		
    		$params['entry_study_group'] = $this->user['role'];
    		
    	}

//    	var_dump($params);
    	 
		
    	if($params != null){
    		
    		$this->set('Users',$this->paginate('YuiUser',$params,array()));
    	}
    	else {
    		
    		$this->set('Users',$this->paginate('YuiUser'));
    	}
    	
    	
    	
    	$selectTypeList =
    	array(
    	self::SELECT_TYPE_STATUS_ALL => "全件表示",
    	self::SELECT_TYPE_STATUS_GINHURI_NON => "銀行振込ステータス未設定",
    	self::SELECT_TYPE_STATUS_GINHURI_OK => "銀行振込ステータスOK",
    	self::SELECT_TYPE_STATUS_GINHURI_NG => "銀行振込ステータスNG",
    	self::SELECT_TYPE_STATUS_SHINSA_NON => "審査ステータス未設定",
    	self::SELECT_TYPE_STATUS_SHINSA_OK => "審査ステータスOK",
    	self::SELECT_TYPE_STATUS_SHINSA_NG => "審査ステータスNG",
    	self::SELECT_TYPE_STATUS_LABORATORY_SHINSA_NON => "研究所審査ステータス未設定",
    	self::SELECT_TYPE_STATUS_LABORATORY_SHINSA_OK => "研究所審査ステータスOK",
    	self::SELECT_TYPE_STATUS_LABORATORY_SHINSA_NG => "研究所審査ステータスNG"
    	);
    	
    	$this->set('selectTypeList',$selectTypeList);
    	
    	
    	$selectDataInput =
    	array(
    			"0" => "全件表示",
    			"1" => "ユーザー情報入力済み",
    			"2" => "ユーザー情報み入力",
    	);
    	
    	$this->set('selectDataInput',$selectDataInput);
    	 
    	$selectTypeOrder =
    	array(
    			"0" => "新しい順",
    			"1" => "古い順",
    	);
    	
    	$this->set('selectTypeOrder',$selectTypeOrder);
    	 
    	 
    	 
    }	 
    
    function statusUpGinhuri(){

    	$param = array();
    	 
//    	var_dump($this->params['pass'][0]);
    	
    	$param['id'] = $this->params['pass'][0];
    	
    	$yuiUser = $this->YuiUser->find('first', array('conditions' => array('id' => $param['id'])));
    	
    	if($yuiUser['YuiUser']['status_ginhuri'] == '1') {
    		
    		$param['status_ginhuri'] = '0';
    	}
    	else {
    		$param['status_ginhuri'] = '1';
    	}
    	 
    	$this->YuiUser->save($param);
    	
    	$this->redirect(array('action' => 'status'));
    	 
    }
    
    function statusUpShinsa(){
    	
    	$param = array();
    	
//    	var_dump($this->params['pass'][0]);
    	 
    	$param['id'] = $this->params['pass'][0];
    	 
    	$yuiUser = $this->YuiUser->find('first', array('conditions' => array('id' => $param['id'])));
    	 
    	if($yuiUser['YuiUser']['status_shinsa'] == '1') {
    		$param['status_shinsa'] = '0';
    	}
    	else {
    		$param['status_shinsa'] = '1';
    	}
    	
    	$this->YuiUser->save($param);
    	 
    	$this->redirect(array('action' => 'status'));
    
    }
    

    function statusUpLaboratoryShinsa(){
    	 
    	$this->layout = "";
    	$this->autoRender = false;
    	 
    	$param = array();
    	
    	$param['id'] = $this->params['pass'][0];
    	
    	$yuiUser = $this->YuiUser->find('first', array('conditions' => array('id' => $param['id'])));
    	
    	// メールを送る前にセッションへユーザーのデータを保存
    	$this->setSessionInfo($this->params['pass'][0]);
    	 
    	$MailSend = $this->Components->load('MailSend');
    	 
//    	var_dump($this->params['pass'][0]);
    	
        if($this->params['pass'][1] == 1){

        	$MailSend->resultOk($yuiUser['YuiUser']['entry_sei'] . " " .$yuiUser['YuiUser']['entry_mei'],$yuiUser['YuiUser']['entry_mail'],$yuiUser['YuiUser']['entry_tel']);
        	
        	$param['status_laboratory_shinsa'] = $this->params['pass'][1];
        	
        	$this->YuiUser->save($param);
    		
    	}
    	else if($this->params['pass'][1] == 2){

        	$MailSend->rejectNg($yuiUser['YuiUser']['entry_sei'] . " " .$yuiUser['YuiUser']['entry_mei'],$yuiUser['YuiUser']['entry_mail']);
        	
        	$param['status_laboratory_shinsa'] = $this->params['pass'][1];
        	
        	$this->YuiUser->save($param);
    		
    	}
    
    	$this->redirect(array('action' => 'detail',$this->params['pass'][0],$this->params['pass'][1]));
    
    }
    
    
    function statusUpLaboratoryShinsaDetail(){
    
    	// メールを送る前にセッションへユーザーのデータを保存
    	$this->setSessionInfo($this->params['pass'][0]);
    	
    	$param = array();
    
//    	var_dump($this->params['pass'][0]);
    
    	$param['id'] = $this->params['pass'][0];
    
    	$yuiUser = $this->YuiUser->find('first', array('conditions' => array('id' => $param['id'])));
    
    	$param['status_laboratory_shinsa'] = $this->params['pass'][1];
    
    	$this->YuiUser->save($param);
    	
        if($this->params['pass'][1] == 1){
        	
        	// 審査OK
        	$MailSend = $this->Components->load('MailSend');
        	
        	if($yuiUser['YuiUser']['mst_head_id'] != null) {
        		
        		$MailSend->agency_honbu_judge_ok();
        		
        	} else if ($yuiUser['YuiUser']['mst_prefecture_id'] != null){

        		$MailSend->agency_area_judge_ok();
    
        	}
    		
    	}
    	else {
    		// 審査NG
    		
    		$MailSend = $this->Components->load('MailSend');
    			
    		$MailSend->judge_ng();
    		
    	}
    
    
//    	$this->redirect(array('action' => 'status',$this->params['pass'][0]));
    
    }
    
    
    function status2(){
    	$this->set('userinfo',$this->user);
    	$this->set('cname',$this->name);
    	$this->set('aname',$this->action);
    
    	$this->set('roledata',print_r($this->roledata,true));
    
    	//データをPaginatorへセット
    	$this->set('Users',$this->paginate());
    }
    
    
    
    public function add() {
    	if($this->request->is('post')) {
    		if($this->YuiUser->save($this->request->data)) {
    			$this->Session->setFlash('入力完了');
    			$this->redirect(array('action'=>'index'));
    		}
    		else {
    			$this->Session->setFlash('入力失敗');
    			$this->redirect(array('action'=>'index'));
    		}
    	}
    }
 
    public function edit($id = null) {
    	$this->YuiUser->id = $id;
    	if($this->request->is('get')) {
    		$this->request->data=$this->YuiUser->findById($id);   //更新画面の表示
//    		$this->log($this->request->data);
//    		var_dump($this->log($this->request->data));

//    		$this->set('groups', $$this->request->data);
    		
    	}
    	else {
    		if($this->YuiUser->save($this->request->data)) {
    			$this->Session->setFlash('更新完了');
    			$this->redirect(array('action'=>'index'));
    		}
    		else {
    			$this->Sessin->setFlash('更新失敗');
    			$this->redirect(array('action'=>'index'));
    		}
    	}
    }
    
    public function csvUpload() {
    	
    	//パラメータよりファイル名取得
    	$csvFileInputName = $this->params['form']['csvFileInput'];
    	
//    	var_dump($this->params['form']['csvFileInput']);
    	
    	$dataYuiUser = $this->YuiUser->saveCsv($this->params['form']['csvFileInput']['tmp_name']);
    	
    }
    
    public function csvDownload(){
    	Configure::write('debug', 0); // 警告を出さない
    	
    	$this->layout = "";
    	$this->autoRender = false;
    	
    	//Content-Typeを指定

    	$this->response->type('csv');

    	 
    	$filename = 'user_' . date('YmdHis'); // 任意のファイル名

    	$this->response->download($filename);

    	 
    	//CSVをエクセルで開くことを想定して文字コードをSJISへ変換する設定を行う
    	stream_filter_append($fp, 'convert.iconv.UTF-8/CP932', STREAM_FILTER_WRITE);

    	 
/*    	$th = "'No','申込者会員番号','申込者氏名(姓）','申込者氏名(名）'," .
    	"'申込者氏名（姓）（フリガナ）','申込者氏名（名）（フリガナ）'," .
    	"'申込者メールアドレス','申込者携帯電話番号','登録研究部会'," .
    	"'申込地域','代理店種別','申込市区町村（半角数字）','紹介者会員番号'," .
    	"'紹介者名前（姓）','紹介者名前（名）','会社名','郵便番号','都道府県'," .
    	"'市区町村','住所','申込者の銀行口座情報','金融機関コード（半角数字）'," .
    	"'支店名','支店名（全角カナ）','支店番号（半角数字）','口座種別'," .
    	"'口座番号（半角数字）','口座名義（漢字）','口座名義（全角カナ）'," .
    	"'備考','活動代理店（都道府県本部）個人申込','活動代理店（都道府県本部）　法人申込'," . 
    	"'活動代理店（市区町村支部）　個人申込','活動代理店（市区町村支部）　法人申込'," . 
    	"'代理店紹介者　個人申込','代理店紹介者　法人申込','普及代理店　個人申込'," .
    	"'普及代理店　法人申込','代理店承認'"; */
    	
//    	$dataYuiUser = $this->YuiUser->find('all');

    	$dataYuiUser = $this->YuiUser->getAllData();
    	 
    	
//    	var_dump($dataYuiUser);
    	
    	foreach ($dataYuiUser as $recYuiUser){
    		echo("'" . implode("','", $recYuiUser["YuiUser"]) . "'\r\n");
    	}
    	
//    	var_dump($td);
    	
    	
//    	$this->set(compact('filename', null, 'th', 'td'));
    }
    
    public function delete($id=null) {
    	$this->YuiUser->id = $id;
    	if($this->YuiUser->delete($id)){
    		$this->Session->setFlash('削除完了');
    		$this->redirect(array('action'=>'index'));
    	}
    	else {
    		$this->Session->setFlash('削除失敗');
    	}
    }
    

    private function fileUpload($fname,$imageType){
    
    	// $_FILES['upfile']['error'] の値を確認
    	switch ($this->data['YuiUser'][$fname]['error']) {
    		case UPLOAD_ERR_OK: // OK
    			break;
    		case UPLOAD_ERR_NO_FILE:   // ファイル未選択
    			$this->Session->setFlash('ファイルが選択されていません。');
    			return true;
    		case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
    			$this->Session->setFlash('10MB以内の画像が登録可能です。');
    			$this->redirect(array('action' => $this->action));
    		case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過 (設定した場合のみ)
    			$this->Session->setFlash('10MB以内の画像が登録可能です。');
    			$this->redirect(array('action' => $this->action));
    		default:
    			$this->Session->setFlash('ファイルに異常があります。');
    			$this->redirect(array('action' => $this->action));
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
    					'yui_user_id' => $this->Auth->user('id'),
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
    
    public function contents() {
    	$this->autoRender = false;
    	$this->autoLayout = false;
    	 
    
    	//echo($filename);
    
    	$image = $this->Image->findByFilenameAndImageType($this->params['pass'][1],$this->params['pass'][0]);
    	
    	header('Content-type: ' . $image['Image']['filetype'] );
    	
    	echo $image['Image']['contents'];
    
    	//		var_dump($image);
    
    	/*		if (empty($image)) {
    	 $this->cakeError('error404');
    		}
    		header('Content-type: ' . $image['Image']['filetype'] );
    		echo $image['Image']['contents']; */
    }
    
    public function test() {
//    	var_dump($this->params['pass']);
    	
    	
//    	$this->set('url',$html->url(’/’, true));
    	 
    }

    public function imageShow() {
    	
    	$image = $this->Image->findAllByYuiUserId($this->params['pass']);
    	
//    	var_Dump($image[0]);
    	
    	$this->set('imageList',$image);
    	 
    	
    }

    private function paramSelect($find){
//    	switch($this->request->data["selecttype"]){
    	switch($find["findparam"]){
    		case self::SELECT_TYPE_STATUS_GINHURI_NON:
    			$params['status_ginhuri'] = null;
    			break;
    		case self::SELECT_TYPE_STATUS_GINHURI_OK:
    			$params['status_ginhuri'] = '1';
    			break;
    		case self::SELECT_TYPE_STATUS_GINHURI_NG:
    			$params['status_ginhuri'] = '2';
    			break;
    		case self::SELECT_TYPE_STATUS_SHINSA_NON:
    			$params['status_shinsa'] = null;
    			break;
    		case self::SELECT_TYPE_STATUS_SHINSA_OK:
    			$params['status_shinsa'] = '1';
    			break;
    		case self::SELECT_TYPE_STATUS_SHINSA_NG:
    			$params['status_shinsa'] = '2';
    			break;
    		case self::SELECT_TYPE_STATUS_LABORATORY_SHINSA_NON:
    			$params['status_laboratory_shinsa'] = null;
    			break;
    		case self::SELECT_TYPE_STATUS_LABORATORY_SHINSA_OK:
    			$params['status_laboratory_shinsa'] = '1';
    			break;
    		case self::SELECT_TYPE_STATUS_LABORATORY_SHINSA_NG:
    			$params['status_laboratory_shinsa'] = '2';
    			break;
    		case self::SELECT_TYPE_STATUS_ALL:
    			$params= null;
    			break;
    	}
    	
    	switch($find["selectDataInput"]){
    		case '0':
    			break;
    		case '1':
    			$params[] = 'YuiUser.bank_account_type IS NOT NULL';
    			break;
    		case '2':
    			$params['bank_account_type'] = null;
    			//    			$params['bank_account_type'] = null;
    			break;
    	}
    	 
    	return $params;
    }
    
    private function paramOrder($order){
    	$params = array();
    	
    	if($order['selectTypeOrder'] == '0'){
    		return $params['id'] = 'asc';
    	} else if($order['selectTypeOrder'] == '1') {
    		return $params['id'] = 'desc';
    	} else {
    		return $params['id'] = 'asc';
    	}
    	return $params;
    }
    
    
    private function setSessionInfo($find){
    	
    	$MstPrefectureList=$this->MstPrefecture->find("list");
    	
    	$data =$this->YuiUser->findById($find);   //更新画面の表示
    	
    	if($data['YuiUser']['mst_head_id'] != null) {
    		

//    		var_dump($MstHeadList);
    		
    		$HeadData = $this->MstHead->find('first', array(
    				'conditions' => array('MstHead.id' => $data['YuiUser']['mst_head_id'])
    		));
    		
    		if($HeadData['MstHead']['level2']==""){
    			$this->Session->write('disp_target',$HeadData['MstHead']['level1']); 
    		}
    		else {
//    			$this->Session->write('disp_target',$HeadData['MstHead']['level1']); 
    			$this->Session->write('disp_target',$HeadData['MstHead']['level1'] . "（" . $HeadData['MstHead']['level2'] ."）");
    		}
    		 
    	} else if ($data['YuiUser']['mst_prefecture_id'] != null) {
    		 
    		$this->Session->write('disp_target',$MstPrefectureList[$data['YuiUser']['mst_prefecture_id']]);
    		 
    	} else {
    		 
    		$this->Session->write('disp_target',"");
    		 
    	}
    	 
    	$this->Session->write('the_earth_id',$data['YuiUser']['the_earth_id']);
    	$this->Session->write('entry_sei',$data['YuiUser']['entry_sei']);
    	$this->Session->write('entry_mei',$data['YuiUser']['entry_mei']);
    	$this->Session->write('email',$data['YuiUser']['entry_mail']);
    	$this->Session->write('phone',$data['YuiUser']['entry_tel']);
    	$this->Session->write('introducer_no',$data['YuiUser']['introducer_no']);
    	
/*    	$data['YuiUser']['action_agency_prefecture_person'];
    	$data['YuiUser']['action_agency_prefecture_corporation'];
    	$data['YuiUser']['action_agency_city_person'];
    	$data['YuiUser']['action_agency_city_corporation']; */
    	 
    	
    	
    	$this->Session->write('action_agency_prefecture_person',$data['YuiUser']['action_agency_prefecture_person']);
    	$this->Session->write('action_agency_prefecture_corporation',$data['YuiUser']['action_agency_prefecture_corporation']);
    	$this->Session->write('action_agency_city_person',$data['YuiUser']['action_agency_city_person']);
    	$this->Session->write('action_agency_city_corporation',$data['YuiUser']['action_agency_city_corporation']);
    	
    	$MstSubcommitteeList = $this->MstSubcommittee->find( 'list', array('fields' => array( 'id', 'name')));
    	
    	if(array_key_exists('entry_study_group',$data['YuiUser'])==true && array_key_exists($data['YuiUser']['entry_study_group'],$MstSubcommitteeList) == true){

    		$this->Session->write('entry_study_group_name',$MstSubcommitteeList[$data['YuiUser']['entry_study_group']]);
    		
    	}
    	else {
    		
    		$this->Session->write('entry_study_group_name','');
    	}
    	 
    }
    
    public function inputresult($id = null) {

    	$data=$this->YuiUser->findById($id);   //更新画面の表示
    	 
    	$this->set('entry_sei',$data['YuiUser']['entry_sei']);
    	$this->set('entry_mei',$data['YuiUser']['entry_mei']);
    	
    	
    	if($this->request->isPost() || $this->request->isPut()) {
    		
    		$resultText = $this->request->data["Upregist"]["resulttext"];
    		
    		$data['Upregist']['user_id'] = $data['YuiUser']['id'];
    		
    		if($this->Upregist->save($data)){
    			 
    		}
    		
    		// ユーザアクティベート(本登録)用URLの作成
    		$url =
    		DS . 'signup' .          // コントローラ
    		DS . 'update' .                       // アクション
    		DS . $this->Upregist->id .                  // ユーザID
    		DS . $this->Upregist->getActivationHash() .  // ハッシュ値
    		DS . $data['YuiUser']['account_type'];
    		$url = Router::url( $url, true);  // ドメイン(+サブディレクトリ)を付与
    		
    		
    		$MailSend = $this->Components->load('MailSend');
    		 
    		$MailSend->resultNg(
    			$data['YuiUser']['entry_sei'] . " " .$data['YuiUser']['entry_mei'],
    			$data['YuiUser']['entry_mail'],
    			$resultText,
    			$url
    		);
    		
    		$param['status_laboratory_shinsa'] = 2;
    		
    		$this->YuiUser->save($param);
    		
    	}
    		 
    }

}