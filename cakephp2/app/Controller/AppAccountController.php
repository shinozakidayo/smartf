<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppAccountController extends Controller {
	
	const MODE_HEAD = 'head';
	const MODE_SUB = 'subdivision';
	const MODE_INT = 'introduction';
	
	const SESSION_CNAME_MODE = 'mode';
	const SESSION_CNAME_ID = 'setId';
	
	
	protected $user;

	//使用コンポーネントの登録

	public $components = array(
			'Session',
//			'Security',
			'Auth' => array(
			        // 認証時の設定
//			        'authenticate' => array(
//			            'Form' => array(
			                // 認証時に使用するモデル
//			                'userModel' => 'Account',
//			                // 認証時に使用するモデルのユーザ名とパスワードの対象カラム
//			                'fields' => array('username' => 'username' , 'password'=>'password'),
//				            ),
//			        ),
						
					//ログイン後の移動先
					'loginRedirect' => array('controller' => 'signup', 'action' => 'menupitaco'),
					//ログアウ後の移動先
					'logoutRedirect' => array('controller' => 'signup', 'action' => 'login'),
					//ログインページのパス
					'loginAction' => array('controller' => 'signup', 'action' => 'login'),
					//未ログイン時のメッセージ
					'authError' => 'あなたのお名前とパスワードを入力して下さい。',
					'authenticate' => array(
							'Form' => array(
//									'passwordHasher' => 'Blowfish'
									'passwordHasher' => 'SimplePassword'
							)
					)
			),
	);
	
	/*	public $components = array(
	 'Session'
	 ); */
	
	
	
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		// ここに書いた処理はComponent初期化より前に実行されます
		
	}
	
	function beforeFilter(){
		
		$this->Auth->authenticate = array();
		// 'all' を使って設定を記述
		$this->Auth->authenticate = array(
				AuthComponent::ALL => array('userModel' => 'Account'),
				'Basic',
				'Form'
		);
//		$this->Security->unlockedFields = array('mode');
		
		
		//親クラスのbeforeFilterの読み込み
		parent::beforeFilter();
		
//		$this->Auth->allow('index');

//		$this->user = $this->Auth->user();
		
	}

}
